<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class InstructorProfilePayoutUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'payout');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payout_account' => 'required',
            'payout_information' => ['required', 'string', 'max: 3000']
        ];
    }

    function messages()
    {
        return [
            'payout_account.required' => __('The payout account field is required.'),
            'payout_information.required' => __('The payout information field is required.'),
            'payout_information.max' => __('The payout information field cannot be longer than :max characters.', ['max' => 3000]),
        ];
    }
}

