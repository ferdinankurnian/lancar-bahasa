<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounterSectionRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {

        $rules = [
            'total_student_count'    => ['nullable', 'numeric', 'max:1000000000', 'min:0'],
            'total_instructor_count' => ['nullable', 'numeric', 'max:1000000000', 'min:0'],
            'total_courses_count'    => ['nullable', 'numeric', 'max:1000000000', 'min:0'],
            'total_awards_count'     => ['nullable', 'numeric', 'max:1000000000', 'min:0'],
            'section_title'          => ['nullable', 'string', 'max:1000'],
            'description'            => ['nullable', 'string', 'max:255'],
            'button_text'            => ['nullable', 'string', 'max:255'],
            'button_url'             => ['nullable', 'max: 255'],
            'image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];

        return $rules;
    }

    function messages(): Array {
        return [
            'total_student_count.max'    => __('Total student count must be less than or equal to 1000000000'),
            'total_student_count.min'    => __('Total student count must be greater than or equal to 0'),
            'total_instructor_count.max' => __('Total instructor count must be less than or equal to 1000000000'),
            'total_instructor_count.min' => __('Total instructor count must be greater than or equal to 0'),
            'total_courses_count.max'    => __('Total courses count must be less than or equal to 1000000000'),
            'total_courses_count.min'    => __('Total courses count must be greater than or equal to 0'),
            'total_awards_count.max'     => __('Total awards count must be less than or equal to 1000000000'),
            'total_awards_count.min'     => __('Total awards count must be greater than or equal to 0'),
            'section_title.max'          => __('Title must be less than or equal to 255'),
            'description.nullable'       => __('The description is not valid.'),
            'description.string'         => __('The description is not valid.'),
            'description.max'            => __('The description is too long.'),
            'button_text.nullable'       => __('The button text is not valid.'),
            'button_text.string'         => __('The button text is not valid.'),
            'button_text.max'            => __('The button text is too long.'),
            'button_url.nullable'        => __('The button url is not valid.'),
            'button_url.max'             => __('The button url is too long.'),
            'image.nullable' => __('The image is not valid.'),
            'image.image' => __('The image is not valid.'),
            'image.max' => __('The image is too large.'),
        ];
    }
}
