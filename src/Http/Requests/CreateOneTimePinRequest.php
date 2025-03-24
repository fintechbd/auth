<?php

namespace Fintech\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOneTimePinRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'mobile' => ['required_without_all:email,user', 'string', 'min:10', 'max:15', 'mobile'],
            'email' => ['required_without_all:mobile,user', 'string', 'email:rfc,dns'],
            'user' => ['required_without_all:mobile,email', 'integer', 'min:1', 'exists:users,id'],
        ];
    }
}
