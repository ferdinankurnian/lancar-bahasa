<?php

namespace Modules\Course\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseCategoryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'unique:course_categories,slug'],
            'icon' => ['required', 'image', 'max:255'],
            'status' => ['required', 'boolean'],
            'show_at_trending' => ['required', 'boolean'],
        ];
    }

    function messages(): array
    {
        return [
            'name.required' => __('The name field is required'),
            'name.string' => __('The name must be a string'),
            'name.max' => __('The name may not be greater than 255 characters.'),
            'slug.required' => __('The slug field is required'),
            'slug.unique' => __('The slug has already been taken.'),
            'icon.required' => __('The icon field is required'),
            'icon.image' => __('The icon must be an image'),
            'icon.max' => __('The icon may not be greater than 255 characters.'),
            'status.required' => __('The status field is required'),
            'status.boolean' => __('The status must be a boolean'),
            'show_at_rending.required' => __('The show_at_rending field is required'),
        ];
    }
}
