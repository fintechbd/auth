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
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
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
            $userData = $this->formatUserDataFromInput($inputs);

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

    private function formatUserDataFromInput($inputs)
    {
        $data = [];

        if (isset($inputs['name'])) {
            $data['name'] = $inputs['name'];
        }
        if (isset($inputs['mobile'])) {
            $data['mobile'] = $inputs['mobile'];
        }
        if (isset($inputs['email'])) {
            $data['email'] = $inputs['email'];
        }
        if (isset($inputs['login_id'])) {
            $data['login_id'] = $inputs['login_id'];
        }
        if (isset($inputs['password'])) {
            $data['password'] = Hash::make($inputs['password'] ?? config('fintech.auth.default_password', '12345678'));
        }
        if (isset($inputs['pin'])) {
            $data['pin'] = Hash::make($inputs['pin'] ?? config('fintech.auth.default_pin', '123456'));
        }
        if (isset($inputs['parent_id'])) {
            $data['parent_id'] = $inputs['parent_id'];
        }
        if (isset($inputs['app_version'])) {
            $data['app_version'] = $inputs['app_version'];
        }
        if (isset($inputs['fcm_token'])) {
            $data['fcm_token'] = $inputs['fcm_token'];
        }
        if (isset($inputs['language'])) {
            $data['language'] = $inputs['language'];
        }
        if (isset($inputs['currency'])) {
            $data['currency'] = $inputs['currency'];
        }
        if (isset($inputs['wrong_password'])) {
            $data['wrong_password'] = $inputs['wrong_password'];
        }
        if (isset($inputs['wrong_pin'])) {
            $data['wrong_pin'] = $inputs['wrong_pin'];
        }
        if (isset($inputs['roles'])) {
            $data['roles'] = $inputs['roles'] ?? config('fintech.auth.customer_roles', []);
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
            $userData = $this->formatUserDataFromInput($inputs);

            logger("user data", [$userData]);

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
        return $this->userRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->userRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->userRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->userRepository->create($filters);
    }

    /**
     * @param $user
     * @param $field
     * @return array
     * @throws \Exception
     */
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
