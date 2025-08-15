<?php

namespace Modules\Blog\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() ? true : false;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:255',
        ];

        if ($this->isMethod('put')) {
            $rules['code'] = 'required|string';
        }
        if ($this->isMethod('post')) {
            $rules['slug'] = 'required|string|max:255';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => __('Title must be unique.'),
            'title.max' => __('Title must be string with a maximum length of 255 characters.'),
            'slug.required' => __('Slug is required.'),
            'slug.max' => __('Slug must be string with a maximum length of 255 characters.'),
            'short_description.string' => __('Short description must be a string.'),
            'short_description.max' => __('Short description must be string with a maximum length of 255 characters.'),
        ];
    }
}
