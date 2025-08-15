<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class BankInformationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bank_name' => 'required|string|max:190',
            'account_number' => 'required|string|max:190',
            'routing_number' => 'nullable|string|max:190',
            'branch' => 'required|string|max:190',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => __('admin.Bank Name is required.'),
            'account_number.required' => __('Account Number is required.'),
            'routing_number.required' => __('admin.Routing Number is required.'),
            'branch.required' => __('admin.Branch is required.'),
        ];
    }
}
