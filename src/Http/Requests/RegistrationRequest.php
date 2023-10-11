<?php

namespace Fintech\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return config('fintech.auth.register_rules', [
            //user
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'mobile' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email:rfc,dns', 'min:2', 'max:255'],
            'login_id' => ['required', 'string', 'min:6', 'max:255'],
            'password' => ['required', 'string', Password::default()],
            'pin' => ['required', 'string', 'min:4', 'max:16'],
            'parent_id' => ['nullable', 'integer'],
            'app_version' => ['nullable', 'string'],
            'fcm_token' => ['nullable', 'string'],
            'language' => ['nullable', 'string'],
            'currency' => ['nullable', 'string'],

            //profile
            'father_name' => ['string', 'nullable'],
            'mother_name' => ['string', 'nullable'],
            'gender' => ['string', 'nullable'],
            'marital_status' => ['string', 'nullable'],
            'occupation' => ['string', 'nullable'],
            'source_of_income' => ['string', 'nullable'],
            'id_type' => ['string', 'nullable'],
            'id_no' => ['string', 'nullable'],
            'id_issue_country' => ['string', 'nullable'],
            'id_expired_at' => ['string', 'nullable'],
            'id_issue_at' => ['string', 'nullable'],
            'profile_photo' => [File::image(), 'nullable'],
            'scan' => [File::types(['application/pdf', 'image/*']), 'nullable'],
            'scan_1' => [File::types(['application/pdf', 'image/*']), 'nullable'],
            'scan_2' => [File::types(['application/pdf', 'image/*']), 'nullable'],
            'date_of_birth' => ['date', 'nullable'],
            'permanent_address' => ['string', 'nullable'],
            'city_id' => ['integer', 'nullable'],
            'state_id' => ['integer', 'nullable'],
            'country_id' => ['integer', 'nullable'],
            'post_code' => ['string', 'nullable'],
            'present_address' => ['string', 'nullable'],
            'present_city_id' => ['integer', 'nullable'],
            'present_state_id' => ['integer', 'nullable'],
            'present_country_id' => ['integer', 'nullable'],
            'present_post_code' => ['string', 'nullable'],
            'note' => ['string', 'nullable'],
            'nationality' => ['string', 'nullable'],
        ]);
    }
}
