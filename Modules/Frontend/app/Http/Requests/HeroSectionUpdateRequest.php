<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroSectionUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        return [
            'short_title'           => ['nullable', 'string', 'max:255'],
            'title'                 => ['required', 'string', 'max:255'],
            'sub_title'             => ['nullable', 'string', 'max:255'],
            'action_button_text'    => ['nullable', 'string', 'max:255'],
            'action_button_url'     => ['nullable', 'max:255'],
            'video_button_text'     => ['nullable', 'string', 'max:255'],
            'video_button_url'      => ['nullable', 'max:255'],
            'booking_number'      => ['nullable', 'max:255'],
            'total_student'         => ['nullable', 'max:255'],
            'total_instructor'      => ['nullable', 'max:255'],
            'total_courses'         => ['nullable', 'max:255'],
            'average_reviews'         => ['nullable', 'max:255'],
            'banner_image'          => ['nullable', 'image', 'max:2048'],
            'banner_background'     => ['nullable', 'image', 'max:2048'],
            'banner_background_two' => ['nullable', 'image', 'max:2048'],
            'hero_background'       => ['nullable', 'image', 'max:2048'],
            'enroll_students_image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    function messages(): array {
        return [
            'short_title.required'        => __('The short title is required'),
            'short_title.string'          => __('The short title must be a string'),
            'short_title.max'             => __('The short title must not be more than 255 characters'),
            'title.required'              => __('The title is required'),
            'title.string'                => __('The title must be a string'),
            'title.max'                   => __('The title must not be more than 255 characters'),
            'sub_title.required'          => __('The sub title is required'),
            'sub_title.string'            => __('The sub title must be a string'),
            'sub_title.max'               => __('The sub title must not be more than 255 characters'),
            'action_button_text.string'   => __('The action button text must be a string'),
            'action_button_text.max'      => __('The action button text must not be more than 255 characters'),
            'action_button_url.max'       => __('The action button url must not be more than 255 characters'),
            'video_button_text.string'    => __('The video button text must be a string'),
            'video_button_text.max'       => __('The video button text must not be more than 255 characters'),
            'video_button_url.max'        => __('The video button url must not be more than 255 characters'),
            'total_student.max'           => __('The total student must not be more than 255 characters'),
            'total_instructor.max'        => __('The total instructor must not be more than 255 characters'),
            'total_courses.max'           => __('The total recipes must not be more than 255 characters'),
            'banner_image.image'          => __('The banner image must be an image'),
            'banner_image.max'            => __('The banner image must not be more than 2048 kilobytes'),
            'banner_background.image'     => __('The banner background must be an image'),
            'banner_background.max'       => __('The banner background must not be more than 2048 kilobytes'),
            'banner_background_two.image' => __('The banner background two must be an image'),
            'banner_background_two.max'   => __('The banner background two must not be more than 2048 kilobytes'),
            'hero_background.image'       => __('The hero background must be an image'),
            'hero_background.max'         => __('The hero background must not be more than 2048 kilobytes'),
        ];
    }

}
