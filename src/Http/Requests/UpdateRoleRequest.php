<?php

namespace Fintech\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $uniqueRule = 'unique:' . config('fintech.auth.role_model', \Fintech\Auth\Models\Role::class) . ',name';

        return [
            'name' => ['required', 'string', 'min:5', 'max:255', $uniqueRule],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards', ['web', 'api'])))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['nullable', 'integer']
        ];
    }

}
