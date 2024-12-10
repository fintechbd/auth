<?php

namespace Fintech\Auth\Http\Requests;

use Fintech\Core\Enums\Auth\FavouriteStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFavouriteRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'sender_id' => ['required', 'integer', 'exists:users,id'],
            'receiver_id' => ['required', 'integer', 'exists:users,id', 'different:sender_id'],
            'status' => ['nullable', 'string',  Rule::in(FavouriteStatus::values())],
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
