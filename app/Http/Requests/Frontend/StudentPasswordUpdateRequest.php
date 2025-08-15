<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentPasswordUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'password');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string', 'max:255', 'current_password'],
            'password' => ['required', 'string', 'max:255', 'confirmed'],
        ];
    }

    function messages()
    {
        return [
            'current_password.required' => __('The current password field is required'),
            'current_password.string' => __('The current password must be a string'),
            'current_password.max' => __('The current password may not be greater than 255 characters.'),
            'current_password.current_password' => __('The current password is incorrect.'),
            'password.required' => __('The password field is required'),
            'password.string' => __('The password must be a string'),
            'password.max' => __('The password may not be greater than 255 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),
        ];
    }
}
