<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentEducationStoreRequest extends FormRequest
{

    function __construct()
    {
        setFormTabStep('profile_tab', 'education');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'organization' => ['required', 'max:255', 'string'],
            'degree' => ['required', 'max:255', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
        ];
    }

    function messages() {

        return [
            'organization.required' => __('The organization field is required.'),
            'organization.max' => __('The organization field must not be greater than 255 characters.'),
            'organization.string' => __('The organization field must be a string.'),

            'degree.required' => __('The degree field is required.'),
            'degree.max' => __('The degree field must not be greater than 255 characters.'),
            'degree.string' => __('The degree field must be a string.'),

            'start_date.required' => __('The start date field is required.'),
            'start_date.date' => __('The start date field must be a valid date.'),

            'end_date.required' => __('The end date field is required.'),
            'end_date.date' => __('The end date field must be a valid date.'),
        ];
    }
}
