<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderSectionUpdateRequest extends FormRequest {
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array {
        $rules = [
            'image_one'         => ['nullable', 'image', 'max:2048'],
            'short_title_one'   => ['required', 'string', 'max:255'],
            'title_one'         => ['required', 'string', 'max:255'],
            'sub_title_one'     => ['required', 'string', 'max:255'],

            'image_two'         => ['nullable', 'image', 'max:2048'],
            'short_title_two'   => ['required', 'string', 'max:255'],
            'title_two'         => ['required', 'string', 'max:255'],
            'sub_title_two'     => ['required', 'string', 'max:255'],

            'image_three'       => ['nullable', 'image', 'max:2048'],
            'short_title_three' => ['required', 'string', 'max:255'],
            'title_three'       => ['required', 'string', 'max:255'],
            'sub_title_three'   => ['required', 'string', 'max:255'],
        ];

        return $rules;

    }

    function messages(): array {

        return [
            'image_one.nullable'         => __('The image one must be a file.'),
            'image_one.image'            => __('The image one must be an image.'),
            'image_one.max'              => __('The image one may not be greater than 2048 kilobytes.'),
            'short_title_one.required'   => __('The short title is required'),
            'short_title_one.string'     => __('The short title must be a string'),
            'short_title_one.max'        => __('The short title must not be more than 255 characters'),
            'title_one.required'         => __('The title one field is required.'),
            'title_one.string'           => __('The title one must be a string.'),
            'title_one.max'              => __('The title one may not be greater than 255 characters.'),
            'sub_title_one.required'     => __('The sub title one field is required.'),
            'sub_title_one.string'       => __('The sub title one must be a string.'),
            'sub_title_one.max'          => __('The sub title one may not be greater than 255 characters.'),

            'image_two.nullable'         => __('The image two must be a file.'),
            'image_two.image'            => __('The image two must be an image.'),
            'image_two.max'              => __('The image two may not be greater than 2048 kilobytes.'),
            'short_title_two.required'   => __('The short title is required'),
            'short_title_two.string'     => __('The short title must be a string'),
            'short_title_two.max'        => __('The short title must not be more than 255 characters'),
            'title_two.required'         => __('The title two field is required.'),
            'title_two.string'           => __('The title two must be a string.'),
            'title_two.max'              => __('The title two may not be greater than 255 characters.'),
            'sub_title_two.required'     => __('The sub title two field is required.'),
            'sub_title_two.string'       => __('The sub title two must be a string.'),
            'sub_title_two.max'          => __('The sub title two may not be greater than 255 characters.'),

            'image_three.nullable'       => __('The image three must be a file.'),
            'image_three.image'          => __('The image three must be an image.'),
            'image_three.max'            => __('The image three may not be greater than 2048 kilobytes.'),
            'short_title_three.required' => __('The short title is required'),
            'short_title_three.string'   => __('The short title must be a string'),
            'short_title_three.max'      => __('The short title must not be more than 255 characters'),
            'title_three.required'       => __('The title three field is required.'),
            'title_three.string'         => __('The title three must be a string.'),
            'title_three.max'            => __('The title three may not be greater than 255 characters.'),
            'sub_title_three.required'   => __('The sub title three field is required.'),
            'sub_title_three.string'     => __('The sub title three must be a string.'),
            'sub_title_three.max'        => __('The sub title three may not be greater than 255 characters.'),
        ];
    }
}
