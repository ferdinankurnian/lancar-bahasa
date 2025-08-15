<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class StudentProfileSocialUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'social');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'facebook' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'linkedin' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'github' => ['nullable', 'string', 'max:255'],
        ];
    }

    function messages(): array
    {
        return [
            'facebook.string' => __('The facebook must be a string.'),
            'facebook.max' => __('The facebook may not be greater than 255 characters.'),
            'twitter.string' => __('The twitter must be a string.'),
            'twitter.max' => __('The twitter may not be greater than 255 characters.'),
            'linkedin.string' => __('The linkedin must be a string.'),
            'linkedin.max' => __('The linkedin may not be greater than 255 characters.'),
            'website.string' => __('The website must be a string.'),
            'website.max' => __('The website may not be greater than 255 characters.'),
            'github.string' => __('The github must be a string.'),
            'github.max' => __('The github may not be greater than 255 characters.'),
        ];
    }
}
