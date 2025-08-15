<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentBioUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'bio');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'designation' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:2000'],
            'short_bio' => ['required', 'string', 'max:300'],
        ];
    }

    function messages() : array
    {
        return [
            'designation.required' => __('The designation field is required'),
            'designation.string' => __('The designation must be a string'),
            'designation.max' => __('The designation may not be greater than 255 characters.'),
            'bio.required' => __('The bio field is required'),
            'bio.string' => __('The bio must be a string'),
            'bio.max' => __('The bio may not be greater than 2000 characters.'),
            'short_bio.required' => __('The short bio field is required'),
            'short_bio.string' => __('The short bio must be a string'),
            'short_bio.max' => __('The short bio may not be greater than 300 characters.'),
        ];
    }

}
