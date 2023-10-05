<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Auth\Interfaces\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 *
 * @property-read UserRepository $userRepository
 * @property-read ProfileRepository $profileRepository
 */
class UserService
{
    public $userRepository;

    private $profileRepository;

    /**
     * UserService constructor.
     */
    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    /**
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

            $profileData['user_id'] = $user->id;

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
        $data = [];
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

        return $data;
    }

    private function formatProfileDataFromInput($inputs)
    {
        $data = [];
        $data['user_profile_data']['father_name'] = $inputs['father_name'] ?? null;
        $data['user_profile_data']['mother_name'] = $inputs['mother_name'] ?? null;
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

        $data['user_profile_data'] = json_encode($data['user_profile_data']);

        return $data;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->userRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        if (isset($inputs['password']) && !empty($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        }
        if (isset($inputs['pin']) && !empty($inputs['pin'])) {
            $inputs['pin'] = Hash::make($inputs['pin']);
        }

        return $this->userRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->userRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->userRepository->restore($id);
    }
}
