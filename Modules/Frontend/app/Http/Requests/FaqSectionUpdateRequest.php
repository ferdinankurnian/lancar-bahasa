<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqSectionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'max:2048'],
            'title' => ['required', 'max:255'],
            'sub_title' => ['required', 'max:255'],
        ];
    }

    function messages() : array{
        return [
            'image.nullable' => __('Image must be an image file'),
            'image.image' => __('Image must be an image file'),
            'image.max' => __('Image must not be greater than 2048 kilobytes'),
            'title.required' => __('Title is required'),
            'title.max' => __('Title must not be greater than 255 characters'),
            'sub_title.required' => __('Sub Title is required'),
            'sub_title.max' => __('Sub Title must not be greater than 255 characters'),
        ];
    }

}
