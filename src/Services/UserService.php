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
        UserRepository $userRepository,
        ProfileRepository $profileRepository
    )
    {
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
        try {
            $userData = $this->formatUserDataFromInput($inputs);

            $profileData = $this->formatProfileDataFromInput($inputs);

            DB::beginTransaction();

            $user = $this->userRepository->create($userData);

            $profileData['user_id'] = $user->getKey();

            $this->profileRepository->create($profileData);

            DB::commit();

            return $user;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }

    }

    private function formatUserDataFromInput($inputs)
    {
        $data['name'] = $inputs['name'] ?? null;
        $data['mobile'] = $inputs['mobile'] ?? null;
        $data['email'] = $inputs['email'] ?? null;
        $data['login_id'] = $inputs['login_id'] ?? null;
        if (isset($inputs['password'])) {
            $data['password'] = Hash::make($inputs['password'] ?? '');
        }
        if (isset($inputs['pin'])) {
            $data['pin'] = Hash::make($inputs['pin'] ?? '');
        }
        $data['parent_id'] = $inputs['parent_id'] ?? null;
        $data['app_version'] = $inputs['app_version'] ?? null;
        $data['fcm_token'] = $inputs['fcm_token'] ?? null;
        $data['language'] = $inputs['language'] ?? null;
        $data['currency'] = $inputs['currency'] ?? null;
        $data['roles'] = $inputs['roles'] ?? config('fintech.auth.customer_roles', []);

        return $data;
    }

    private function formatProfileDataFromInput($inputs)
    {
        $data['user_profile_data']['father_name'] = $inputs['father_name'] ?? null;
        $data['user_profile_data']['mother_name'] = $inputs['mother_name'] ?? null;

        if (isset($inputs['password'])) {
            $data['user_profile_data']['password_updated_at'] = now();
        }

        if (isset($inputs['pin'])) {
            $data['user_profile_data']['pin_updated_at'] = now();
        }

        $data['user_profile_data']['gender'] = $inputs['gender'] ?? null;
        $data['user_profile_data']['marital_status'] = $inputs['marital_status'] ?? null;
        $data['user_profile_data']['occupation'] = $inputs['occupation'] ?? null;
        $data['user_profile_data']['source_of_income'] = $inputs['source_of_income'] ?? null;
        $data['user_profile_data']['note'] = $inputs['note'] ?? null;
        $data['user_profile_data']['nationality'] = $inputs['nationality'] ?? null;
        $data['id_type'] = $inputs['id_type'] ?? null;
        $data['id_no'] = $inputs['id_no'] ?? null;
        $data['id_issue_country'] = $inputs['id_issue_country'] ?? null;
        $data['id_expired_at'] = $inputs['id_expired_at'] ?? null;
        $data['id_issue_at'] = $inputs['id_issue_at'] ?? null;
        $data['date_of_birth'] = $inputs['date_of_birth'] ?? null;
        $data['permanent_address'] = $inputs['permanent_address'] ?? null;
        $data['city_id'] = $inputs['city_id'] ?? null;
        $data['state_id'] = $inputs['state_id'] ?? null;
        $data['country_id'] = $inputs['country_id'] ?? null;
        $data['post_code'] = $inputs['post_code'] ?? null;
        $data['present_address'] = $inputs['present_address'] ?? null;
        $data['present_city_id'] = $inputs['present_city_id'] ?? null;
        $data['present_state_id'] = $inputs['present_state_id'] ?? null;
        $data['present_country_id'] = $inputs['present_country_id'] ?? null;
        $data['present_post_code'] = $inputs['present_post_code'] ?? null;

        return $data;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->userRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        try {
            $userData = $this->formatUserDataFromInput($inputs);

            $profileData = $this->formatProfileDataFromInput($inputs);

            DB::beginTransaction();

            $user = $this->userRepository->update($id, $userData);

            $profileData['user_id'] = $user->getKey();

            $this->profileRepository->update($user->getKey(), $profileData);

            DB::commit();

            return $user;

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
