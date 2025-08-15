<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AboutSectionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        if($this->code == 'en'){
            $rules = [
                'image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'image_two' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'image_three' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'short_title' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1000'],
                'button_text' => ['nullable', 'string', 'max:255'],
                'button_url' => ['nullable', 'max: 255'],
                'course_success' => ['nullable', 'max: 255'],
                'year_experience' => ['nullable'],
                'video_url' => ['nullable', 'max: 255'],
                'phone_number' => ['nullable', 'max: 255'],
            ];
        }else {
            $rules = [
                'image' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'image_two' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'image_three' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
                'title' => ['nullable', 'string', 'max:255'],
                'short_title' => ['nullable', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:1000'],
                'button_text' => ['nullable', 'string', 'max:255'],
                'button_url' => ['nullable', 'max: 255'],
                'video_url' => ['nullable', 'max: 255'],
                'phone_number' => ['nullable', 'max: 255'],
            ];
        }

        return $rules;
    }

    function messages() : Array
    {
        return [
            'short_title.required'            => __('The short title is required'),
            'short_title.string'              => __('The short title must be a string'),
            'short_title.max'                 => __('The short title must not be more than 255 characters'),
            'image.nullable' => __('The image is not valid.'),
            'image.image' => __('The image is not valid.'),
            'image.max' => __('The image is too large.'),
            'image_two.image' => __('The image two must be an image.'),
            'image_two.max' => __('The image two may not be greater than 2048 kilobytes.'),
            'image_three.image' => __('The image three must be an image.'),
            'image_three.max' => __('The image three may not be greater than 2048 kilobytes.'),
            'title.nullable' => __('The title is not valid.'),
            'title.string' => __('The title is not valid.'),
            'title.max' => __('The title is too long.'),
            'description.nullable' => __('The description is not valid.'),
            'description.string' => __('The description is not valid.'),
            'description.max' => __('The description is too long.'),
            'button_text.nullable' => __('The button text is not valid.'),
            'button_text.string' => __('The button text is not valid.'),
            'button_text.max' => __('The button text is too long.'),
            'button_url.nullable' => __('The button url is not valid.'),
            'button_url.max' => __('The button url is too long.'),
            'video_url.nullable' => __('The video url is not valid.'),
            'video_url.max' => __('The video url is too long.'),
        ];
    }
}
