<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\ProfileRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class UserService
 *
 */
class ProfileService
{
    /**
     * UserService constructor.
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        private string|int        $userId,
        private ProfileRepository $profileRepository
    )
    {
    }

    public function create(array $inputs = [])
    {
        try {

            $profileData = $this->formatDataFromInput($inputs);
            $profileData['user_id'] = $this->userId;

            DB::beginTransaction();

            $profile = $this->profileRepository->create($profileData);

            DB::commit();

            return $profile;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }

    }

    private function formatDataFromInput($inputs)
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

    public function update(array $inputs = [])
    {
        try {
            DB::beginTransaction();

            $profileData = $this->formatDataFromInput($inputs);

            $user = $this->profileRepository->update($user_id, $profileData);

            DB::commit();

            return $user;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }
    }
}
