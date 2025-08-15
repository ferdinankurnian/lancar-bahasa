<?php

namespace Modules\CertificateBuilder\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertificateUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'background' => ['nullable', 'image', 'max:3000'],
            'title' => ['nullable', 'string', 'max:255'],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:600'],
            'signature' => ['nullable', 'image', 'max:3000', 'dimensions:max_width=500,min_height=10'],   
        ];
    }

function messages(): array{
    
    return [
        'background.image' => __('The background must be an image and cannot be empty, with a maximum size of 3000.'),
        'title.string' => __('The title must be a string with a maximum of 255 characters.'),
        'sub_title.string' => __('The sub title must be a string with a maximum of 255 characters.'),
        'description.string' => __('The description must be a string with a maximum of 600 characters.'),
    ];
}

}
