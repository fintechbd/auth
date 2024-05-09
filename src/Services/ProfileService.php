<?php

namespace Fintech\Auth\Services;

use Exception;
use Fintech\Auth\Interfaces\ProfileRepository;
use Fintech\Core\Enums\Ekyc\KycStatus;
use Fintech\Core\Facades\Core;
use Fintech\Ekyc\Facades\Ekyc;
use Fintech\MetaData\Facades\MetaData;
use Fintech\MetaData\Models\Country;
use Fintech\Transaction\Facades\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use PDOException;

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

    public function create(string|int $user_id, array $inputs = [])
    {
        try {

            $kycStatus = null;

            if (isset($inputs['ekyc'])) {

                $kycData = $inputs['ekyc'];
                unset($inputs['ekyc']);

                if (Core::packageExists('Ekyc')) {
                    $kycStatus = $this->logKycStatus($user_id, $kycData);
                }
            }

            $profileData = $this->formatDataFromInput($inputs);

            $profileData['user_id'] = $user_id;

            if ($kycStatus != null) {
                $profileData['user_profile_data']['ekyc'] = [
                    'status' => $kycStatus->status ?? KycStatus::Pending->value,
                    'note' => $kycStatus->note ?? '',
                    'reference_no' => $kycStatus->reference_no ?? '',
                ];
            }

            DB::beginTransaction();

            $profile = $this->profileRepository->create($profileData);

            if (Core::packageExists('MetaData')) {

                $presentCountry = MetaData::country()->find($inputs['present_country_id']);

                if (!$presentCountry) {
                    throw (new ModelNotFoundException())->setModel(config('fintech.metadata.country_model', Country::class), $inputs['present_country_id']);
                }

                $defaultUserAccount = [
                    'user_id' => $user_id,
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
                    Transaction::userAccount()->create($defaultUserAccount);
                }
            }

            DB::commit();

            return $profile;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }

    }

    private function logKycStatus($user_id, array $data = [])
    {
        $kycModel = Ekyc::kycStatus()->list(['reference_no' => $data['reference_no']])->first();

        if ($kycModel) {
            return Ekyc::kycStatus()->update($kycModel->getKey(), ['user_id' => $user_id]);
        } else {
            $payload['user_id'] = $user_id;
            $payload['reference_no'] = $data['reference_no'];
            $payload['type'] = 'document';
            $payload['attempts'] = 1;
            $payload['vendor'] = $data['vendor'];
            $payload['kyc_status_data'] = ['inputs' => request()->all()];
            $payload['request'] = $data['request'] ?? ['message' => 'this request is done using sdk'];
            $payload['response'] = $data['response'] ?? [];
            //@TODO Parse Response to get status and note.
            $payload['status'] = KycStatus::Accepted->value;
            $payload['note'] = 'This request is done using sdk.';
            return Ekyc::kycStatus()->create($payload);
        }
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->profileRepository->list($filters);
    }

    public function update(string|int $userId, array $inputs = [])
    {
        try {
            DB::beginTransaction();

            $profileData = $this->formatDataFromInput($inputs);

            $user = $this->profileRepository->update($userId, $profileData);

            DB::commit();

            return $user;

        } catch (Exception $exception) {
            DB::rollBack();
            throw new PDOException($exception->getMessage(), 0, $exception);
        }
    }

    private function formatDataFromInput($inputs, bool $forCreate = false): array
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

        if (isset($inputs['employer'])) {
            $data['user_profile_data']['employer'] = $inputs['employer'];
            unset($data['employer']);
        }

        return $data;
    }
}
