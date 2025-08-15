<?php

namespace Modules\Frontend\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeaturedInstructorSectionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
       
        $rules = [
            'title'  => ['required', 'max:255'],
            'sub_title'  => ['required', 'max:255'],
            'button_text'  => ['nullable', 'max:255'],
            'button_url'  => ['nullable', 'max:255'],
            'instructor_ids'  => ['required'],
        ];

        return $rules;
    }

  function messages() : array{
    return [
        'title.required'  => __('The title is required'),
        'title.max'  => __('The title must not be greater than 255 characters'),
        'sub_title.required'  => __('The sub title is required'),
        'sub_title.max'  => __('The sub title must not be greater than 255 characters'),
        'button_text.max'  => __('The button text must not be greater than 255 characters'),
        'button_url.max'  => __('The button url must not be greater than 255 characters'),
        'instructor_ids.required'  => __('At least one instructor is required'),
    ];
  } 
}
