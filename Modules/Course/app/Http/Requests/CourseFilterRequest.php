<?php

namespace Modules\Course\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [
            'category' => ['sometimes', 'integer', 'exists:course_categories,id'],
            'title' => ['required', 'string', 'max:255']
        ];

        return $rules;
    }
}
