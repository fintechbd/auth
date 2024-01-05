<?php

namespace Fintech\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyIdDocTypeRequest extends FormRequest
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
        $availableDocTypes = \Fintech\Auth\Facades\Auth::idDocType()
            ->list(['paginate' => false, 'country_id' => $this->input('id_country')]);

        if ($availableDocTypes->isNotEmpty()) {
            $availableDocTypes = $availableDocTypes->pluck('code')->toArray();
            $availableDocTypes = (count($availableDocTypes) > 0)
                ? ['string', 'in:' . implode(',', $availableDocTypes)]
            : ['string'];
        } else {
            $availableDocTypes = ['string'];
        }

        return [
            'id_issue_country' => ['required', 'string', 'min:3'],
            'id_no' => ['required', 'string', 'min:3'],
            'id_type' => ['required', ...$availableDocTypes],
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
