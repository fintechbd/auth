<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Core\Facades\Core;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        private readonly ProfileRepository $profileRepository
    )
    {
    }

    public function create(string|int $userId, array $inputs = [])
    {
        try {
            $profileData = $this->formatDataFromInput($inputs);

            $profileData['user_id'] = $userId;

            DB::beginTransaction();

            $profile = $this->profileRepository->create($profileData);

            if (Core::packageExists('MetaData')) {

                $presentCountry = \Fintech\MetaData\Facades\MetaData::country()->find($inputs['present_country_id']);

                if (!$presentCountry) {
                    throw (new ModelNotFoundException())->setModel(config('fintech.metadata.country_model', \Fintech\MetaData\Models\Country::class), $inputs['present_country_id']);
                }

                $defaultUserAccount = [
                    'user_id' => $userId,
                    'country_id' => $presentCountry->getKey(),
                    'enabled' => true,
                    'user_account_data' => [
                        'currency' => $presentCountry->currency,
                        'currency_name' => $presentCountry->currency_name,
                        'currency_symbol' => $presentCountry->currency_symbol,
                        'deposit_amount' => 0,
                        'available_amount' => 0,
                        'spent_amount' => 0
                    ]
                ];

                if (Core::packageExists('Transaction')) {
                    \Fintech\Transaction\Facades\Transaction::userAccount()->create($defaultUserAccount);
                }
            }

            DB::commit();

            return $profile;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }

    }

    private function formatDataFromInput($inputs, bool $forCreate = false)
    {
        $data = $inputs;

        if (isset($inputs['password'])) {
            $data['user_profile_data']['password_updated_at'] = now();
        }

        if (isset($inputs['pin'])) {
            $data['user_profile_data']['pin_updated_at'] = now();
        }

        if (isset($inputs['father_name'])) {
            $data['user_profile_data']['father_name'] = $inputs['father_name'];
            unset($data['father_name']);
        }

        if (isset($inputs['mother_name'])) {
            $data['user_profile_data']['mother_name'] = $inputs['mother_name'];
            unset($data['mother_name']);
        }

        if (isset($inputs['gender'])) {
            $data['user_profile_data']['gender'] = $inputs['gender'];
            unset($data['gender']);
        }

        if (isset($inputs['marital_status'])) {
            $data['user_profile_data']['marital_status'] = $inputs['marital_status'];
            unset($data['marital_status']);
        }

        if (isset($inputs['occupation'])) {
            $data['user_profile_data']['occupation'] = $inputs['occupation'];
            unset($data['occupation']);
        }

        if (isset($inputs['source_of_income'])) {
            $data['user_profile_data']['source_of_income'] = $inputs['source_of_income'];
            unset($data['source_of_income']);
        }

        if (isset($inputs['note'])) {
            $data['user_profile_data']['note'] = $inputs['note'];
            unset($data['note']);
        }

        if (isset($inputs['nationality'])) {
            $data['user_profile_data']['nationality'] = $inputs['nationality'];
            unset($data['nationality']);
        }

        return $data;
    }

    public function update(string|int $userId, array $inputs = [])
    {
        try {
            DB::beginTransaction();

            $profileData = $this->formatDataFromInput($inputs);

            $user = $this->profileRepository->update($userId, $profileData);

            DB::commit();

            return $user;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw new \PDOException($exception->getMessage(), 0, $exception);
        }
    }
}
