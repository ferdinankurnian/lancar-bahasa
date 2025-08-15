<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class StudentProfileUpdateRequest extends FormRequest
{
    function __construct()
    {
        setFormTabStep('profile_tab', 'profile');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'image' => ['nullable', 'image', 'max:2000'],
            'cover' => ['nullable', 'image', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:30'],
            'age' => ['nullable', 'integer', 'max:150'],
        ];
    }

    // custom validation error messages
    function messages(): array
    {
        return [
            'name.required' => __('The name field is required'),
            'name.string' => __('The name must be a string'),
            'name.max' => __('The name may not be greater than 50 characters.'),
            'email.required' => __('The email field is required'),
            'email.email' => __('The email must be a valid email address'),
            'email.max' => __('The email may not be greater than 255 characters'),
            'image.image' => __('The image must be an image'),
            'image.max' => __('The image may not be greater than 2000 kilobytes'),
            'cover.image' => __('The cover must be an image'),
            'cover.max' => __('The cover may not be greater than 2000 kilobytes'),
            'phone.string' => __('The phone must be a string'),
            'phone.max' => __('The phone may not be greater than 30 characters'),
            'age.integer' => __('The age must be an integer'),
            'age.max' => __('The age may not be greater than 150'),
        ];
    }

}
