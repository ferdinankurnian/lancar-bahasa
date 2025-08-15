<?php

namespace Modules\Course\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseLevelRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'max:255'],
            'status' => ['required', 'boolean'],
        ];
        if($this->method() == 'POST'){
            $rules['slug'] = ['required', 'max:255', 'unique:course_levels,slug'];
        }
        return $rules;
    }

    function messages() : array {
        return [
            'name.required' => __('The name field is required'),
            'slug.required' => __('The slug field is required'),
            'status.required' => __('The status field is required'),
            'slug.unique' => __('The slug field must be unique'),
            'name.max' => __('The name field must not be greater than 255 characters'),
            'slug.max' => __('The slug field must not be greater than 255 characters'),
            'slug.unique' => __('The slug field must be unique'),
        ];
    }
}
