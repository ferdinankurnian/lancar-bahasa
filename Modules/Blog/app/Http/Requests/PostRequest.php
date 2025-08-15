<?php

namespace Modules\Blog\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('admin')->check() ? true : false;
    }

    public function rules(): array
    {
        $rules = [
            'blog_category_id' => 'sometimes|exists:blog_categories,id',
            'seo_title' => 'nullable|string|max:1000',
            'seo_description' => 'nullable|string|max:2000',
            'tags' => 'nullable|string|max:2000',
            'show_homepage' => 'nullable',
            'is_popular' => 'nullable',
            'status' => 'nullable',
            'description' => 'required',
        ];

        if ($this->isMethod('put')) {
            $rules['code'] = 'required|exists:languages,code';
            $rules['title'] = 'required|string|max:255';
            $rules['slug'] = 'sometimes|string|max:255|unique:blogs,slug,'.$this->blog;
            $rules['image'] = 'nullable';
        }
        if ($this->isMethod('post')) {
            $rules['image'] = 'required';
            $rules['slug'] = 'required|string|max:255|unique:blogs,slug';
            $rules['title'] = 'required|string|max:255|unique:blog_translations,title';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'blog_category_id.required' => __('The category is required.'),
            'blog_category_id.exists' => __('The selected category is invalid.'),

            'code.required' => __('Language is required and must be a string.'),
            'code.exists' => __('The selected language is invalid.'),

            'seo_title.max' => __('SEO title must be a string with a maximum length of 1000 characters.'),
            'seo_description.max' => __('SEO description must be a string with a maximum length of 2000 characters.'),
            'tags.max' => __('Tags must be a string with a maximum length of 255 characters.'),

            'seo_title.string' => __('SEO title must be a string with a maximum length of 1000 characters.'),
            'seo_description.string' => __('SEO description must be a string with a maximum length of 2000 characters.'),
            'tags.string' => __('Tags must be a string with a maximum length of 255 characters.'),

            'image.required' => __('The image is required and must be an image file with a maximum size of 2048 kilobytes (2 MB).'),
            'image.image' => __('The image must be an image file with a maximum size of 2048 kilobytes (2 MB).'),
            'image.max' => __('The image must be an image file with a maximum size of 2048 kilobytes (2 MB).'),

            'title.required' => __('Title is required and must be a unique string with a maximum length of 255 characters.'),
            'slug.required' => __('Slug is required and must be a unique string with a maximum length of 255 characters.'),

            'title.max' => __('Title is required and must be a unique string with a maximum length of 255 characters.'),
            'slug.max' => __('Slug is required and must be a unique string with a maximum length of 255 characters.'),

            'title.string' => __('Title is required and must be a unique string with a maximum length of 255 characters.'),

            'slug.unique' => __('Slug must be unique.'),
            'title.unique' => __('Title must be unique.'),

            'description.required' => __('Description is required.'),
        ];
    }
}
