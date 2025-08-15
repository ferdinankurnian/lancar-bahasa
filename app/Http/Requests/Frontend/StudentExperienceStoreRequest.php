<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentExperienceStoreRequest extends FormRequest
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
            'company' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'current' => ['boolean']
        ];
    }

    function messages()
    {
        return [
            'company.required' => __('The company field is required'),
            'company.string' => __('The company must be a string'),
            'company.max' => __('The company may not be greater than 255 characters.'),
            'position.required' => __('The position field is required'),
            'position.string' => __('The position must be a string'),
            'position.max' => __('The position may not be greater than 255 characters.'),
            'start_date.required' => __('The start date field is required'),
            'start_date.date' => __('The start date must be a date'),
            'end_date.date' => __('The end date must be a date'),
            'current.boolean' => __('The current field must be a boolean'),
        ];
    }
}
