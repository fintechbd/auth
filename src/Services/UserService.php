<?php

namespace Fintech\Auth\Services;

use Exception;
use Fintech\Auth\Events\AccountFreezed;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Enums\Auth\PasswordResetOption;
use Fintech\Core\Enums\Auth\UserStatus;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDOException;

/**
 * Class UserService
 *
 */
class UserService
{
    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        private readonly UserRepository    $userRepository,
        private readonly ProfileRepository $profileRepository
    ) {

    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->userRepository->find($id, $onlyTrashed);
    }

    public function destroy($id)
    {
        return ($this->userRepository->delete($id) && $this->profileRepository->delete($id));
    }

    public function restore($id)
    {
        return ($this->userRepository->restore($id) && $this->profileRepository->restore($id));
    }

    public function export(array $filters)
    {
        return $this->userRepository->list($filters);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->userRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->userRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        DB::beginTransaction();

        try {
            $userData = $this->formatDataFromInput($inputs, true);

            if ($user = $this->userRepository->create($userData)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }
    }

    private function formatDataFromInput($inputs, bool $forCreate = false)
    {
        $data = $inputs;

        if ($forCreate) {
            $data['password'] = Hash::make(($inputs['password'] ?? config('fintech.auth.default_password', '123456')));
            $data['pin'] = Hash::make(($inputs['pin'] ?? config('fintech.auth.default_pin', '123456')));
        } else {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            if (!empty($data['pin'])) {
                $data['pin'] = Hash::make($data['pin']);
            } else {
                unset($data['pin']);
            }
        }

        $data['roles'] = $inputs['roles'] ?? config('fintech.auth.customer_roles', []);

        $data['status'] = $data['status'] ?? UserStatus::Registered->value;

        return $data;
    }

    public function reset($user, $field)
    {

        Config::set('fintech.auth.password_reset_method', PasswordResetOption::TemporaryPassword->value);

        if ($field == 'pin') {

            $response = Auth::pinReset()->notifyUser($user);

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'password') {

            $response = Auth::passwordReset()->notifyUser($user);

            if (!$response['status']) {
                throw new Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'both') {

            $pinResponse = Auth::pinReset()->notifyUser($user);
            $passwordResponse = Auth::passwordReset()->notifyUser($user);

            if (!$pinResponse['status'] || !$passwordResponse['status']) {
                throw new Exception("Failed");
            }

            return ['status' => true, 'message' => "{$pinResponse['messages']} {$passwordResponse['message']}"];

        }

        return ['status' => false, 'message' => 'No Action Selected'];

    }

    /**
     * @param array $inputs
     * @param string $guard
     * @return User|BaseModel|null
     * @throws Exception
     */
    public function login(array $inputs, string $guard = 'web')
    {
        $passwordField = config('fintech.auth.password_field', 'password');

        $password = null;

        if (isset($inputs[$passwordField])) {
            $password = $inputs[$passwordField];
            unset($inputs[$passwordField]);
        }

        $attemptUser = $this->list($inputs);

        if ($attemptUser->isEmpty()) {
            throw new Exception(__('auth::messages.failed'));
        }

        $attemptUser = $attemptUser->first();

        if ($attemptUser->wrong_password > config('fintech.auth.password_threshold', 10)) {

            $this->update($attemptUser->getKey(), [
                'status' => UserStatus::Suspended->value,
            ]);

            event(new AccountFreezed($attemptUser));

            throw new Exception(__('auth::messages.lockup'));
        }


        if (!Hash::check($password, $attemptUser->{$passwordField})) {

            $wrongPasswordCount = $attemptUser->wrong_password + 1;

            $this->updateRaw($attemptUser->getKey(), [
                'wrong_password' => $wrongPasswordCount,
            ]);

            throw new Exception(__('auth::messages.warning', [
                'attempt' => $wrongPasswordCount,
                'threshold' => config('fintech.auth.threshold.password', 10),
            ]));
        }

        \Illuminate\Support\Facades\Auth::guard($guard)->login($attemptUser);

        $attemptUser->tokens->each(fn ($token) => $token->delete());

        return $attemptUser;

    }

    public function update($id, array $inputs = [])
    {
        DB::beginTransaction();

        try {
            $userData = $this->formatDataFromInput($inputs);

            if ($user = $this->userRepository->update($id, $userData)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }
    }

    public function updateRaw($id, array $inputs = [])
    {
        DB::beginTransaction();

        try {

            if ($user = $this->userRepository->update($id, $inputs)) {

                DB::commit();

                return $user;
            }

            return null;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }
    }

    public function logout()
    {

    }
}
