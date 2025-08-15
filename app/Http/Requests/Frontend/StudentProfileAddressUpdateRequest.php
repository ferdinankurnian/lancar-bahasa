<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentProfileAddressUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'location');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country' => ['required', 'integer', 'exists:countries,id'],
            'state' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:255'],
            'address' => ['nullable', 'string', 'max:255']
        ];
    }

    function messages(): array
    {
        return [
            'country.required' => __('You must select a country.'),
            'country.integer' => __('Country ID must be an integer.'),
            'country.exists' => __('The selected country is invalid.'),
            'state.integer' => __('State ID must be an integer.'),
            'state.exists' => __('The selected state is invalid.'),
            'city.integer' => __('City ID must be an integer.'),
            'city.exists' => __('The selected city is invalid.'),
            'address.string' => __('The address must be a string.'),
            'address.max' => __('The address may not be greater than 255 characters.'),
        ];
    }

}
