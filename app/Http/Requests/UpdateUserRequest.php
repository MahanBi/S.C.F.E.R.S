<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user->id)
            ],
            'role_key' => ['required', Rule::in(['admin', 'equipment_manager', 'technician', 'equipment_officer'])],
            'is_active' => ['required', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام کامل الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.unique' => 'این ایمیل قبلا توسط کاربر دیگری ثبت شده است',
            'role_key.required' => 'نقش کاربری الزامی است',
        ];
    }
}