<?php

namespace Fintech\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'integer'],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'mobile' => ['required', 'string', 'min:10'],
            'email' => ['required', 'string', 'email:rfc,dns', 'min:2', 'max:255'],
            'loginid' => ['required', 'string', 'min:6', 'max:255'],
            'password' => ['required', 'string', Password::default()],
            'pin' => ['required', 'string', 'min:4', 'max:16'],
            'status' => ['required', 'string'],
            'app_version' => ['nullable', 'string'],
            'fcm_token' => ['nullable', 'string'],
            'language' => ['nullable', 'string'],
            'currency' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
