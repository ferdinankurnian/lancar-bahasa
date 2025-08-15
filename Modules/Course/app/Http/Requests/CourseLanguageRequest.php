<?php

namespace Modules\Course\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseLanguageRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
        ];
    }

    function messages(): array
    {
        return [
            'name.required' => __('Course language name is required'),
            'name.string' => __('Course language name must be a string'),
            'name.max' => __('Course language name may not be greater than 255 characters'),
            'status.required' => __('Course language status is required'),
            'status.boolean' => __('Course language status must be a boolean'),
        ];
    }

}
