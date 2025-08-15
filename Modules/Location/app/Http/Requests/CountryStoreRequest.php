<?php

namespace Modules\Location\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:countries,name,'.$this->country],
            'status' => ['required', 'boolean'],
        ];
    }

    function messages() : array {

        return [
            'name.required' => __('The name field is required'),
            'name.string' => __('The name must be a string'),
            'name.max' => __('The name may not be greater than 255 characters.'),
            'status.required' => __('The status field is required'),
            'status.boolean' => __('The status must be a boolean'),
        ];
    }
}
