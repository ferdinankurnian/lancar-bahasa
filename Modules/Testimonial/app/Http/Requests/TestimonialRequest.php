<?php

namespace Modules\Testimonial\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (Auth::guard('admin')->check() && checkAdminHasPermission('testimonial.store')) ? true : false;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'comment' => 'required|string|max:5000',
        ];

        if ($this->isMethod('put')) {
            $rules['image'] = 'nullable|image|max:2048';
            $rules['rating'] = 'nullable';
        }

        if ($this->isMethod('post')) {
            $rules['image'] = 'nullable|image|max:2048';
            $rules['rating'] = 'nullable';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'name.string' => __('The name must be a string.'),
            'name.max' => __('The name may not be greater than 255 characters.'),
            'designation.required' => __('The designation field is required.'),
            'designation.string' => __('The designation must be a string.'),
            'designation.max' => __('The designation may not be greater than 255 characters.'),
            'comment.required' => __('The comment field is required.'),
            'comment.string' => __('The comment must be a string.'),
            'comment.max' => __('The comment may not be greater than 5000 characters.'),
            'image.image' => __('The image must be an image.'),
            'image.max' => __('The image may not be greater than 2048 kilobytes.'),
        ];
    }
}
