<?php

namespace Fintech\Auth\Http\Requests;

use Fintech\Core\Enums\Auth\FavouriteStatus;
use Fintech\Core\Traits\RestApi\HasPaginateQuery;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexFavouriteRequest extends FormRequest
{
    use HasPaginateQuery;

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
            'search' => ['string', 'nullable', 'max:255'],
            'per_page' => ['integer', 'nullable', 'min:10', 'max:500'],
            'page' => ['integer', 'nullable', 'min:1'],
            'sender_id' => ['integer', 'nullable', 'min:1'],
            'receiver_id' => ['integer', 'nullable', 'min:1'],
            'status' => ['nullable'],
            'status.*' => ['string', 'nullable', Rule::in(FavouriteStatus::values())],
            'paginate' => ['boolean'],
            'sort' => ['string', 'nullable', 'min:2', 'max:255'],
            'dir' => ['string', 'min:3', 'max:4'],
            'trashed' => ['boolean', 'nullable'],
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
