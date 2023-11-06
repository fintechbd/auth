<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Enums\PasswordResetOption;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var ProfileRepository
     */
    private ProfileRepository $profileRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        UserRepository    $userRepository,
        ProfileRepository $profileRepository
    ) {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->userRepository->list($filters);

        //Do Business Stuff

        return $countryList;

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

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }
    }

    private function formatDataFromInput($inputs, bool $forCreate = false)
    {
        $data = $inputs;

        if ($forCreate) {
            $data['password'] = Hash::make(($inputs['password'] ?? config('fintech.auth.default_password', '123456')));
            $data['pin'] = Hash::make(($inputs['pin'] ?? config('fintech.auth.default_pin', '123456')));
        } else {
            if (isset($data['password']) && !empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            if (isset($data['pin']) && !empty($data['pin'])) {
                $data['pin'] = Hash::make($data['pin']);
            } else {
                unset($data['pin']);
            }
        }


        if (isset($inputs['roles'])) {
            $data['roles'] = empty($inputs['roles'])
                ? config('fintech.auth.customer_roles', [])
                : $inputs['roles'];
        }

        return $data;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->userRepository->find($id, $onlyTrashed);
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

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }
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

    public function import(array $filters)
    {
        return $this->userRepository->create($filters);
    }

    public function reset($user, $field)
    {

        Config::set('fintech.auth.password_reset_method', PasswordResetOption::TemporaryPassword->value);

        if ($field == 'pin') {

            $response = Auth::pinReset()->notifyUser($user);

            if (!$response['status']) {
                throw new \Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'password') {

            $response = Auth::passwordReset()->notifyUser($user);

            if (!$response['status']) {
                throw new \Exception($response['message']);
            }

            return $response;
        }

        if ($field == 'both') {

            $pinResponse = Auth::pinReset()->notifyUser($user);
            $passwordResponse = Auth::passwordReset()->notifyUser($user);

            if (!$pinResponse['status'] || !$passwordResponse['status']) {
                throw new \Exception("Failed");
            }

            return ['status' => true, 'message' => "{$pinResponse['messages']} {$passwordResponse['message']}"];

        }

        return ['status' => false, 'message' => 'No Action Selected'];

    }
}
