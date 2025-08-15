<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        if ($this->method() == 'POST') {
            return [
                'name' => 'required|unique:roles,name',
            ];
        } else {
            return [
                'name' => "required|unique:roles,name,{$this->role->id}",
            ];
        }
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The role name field is required!'),
            'name.unique' => __('This role has already been taken!'),
        ];
    }
}
