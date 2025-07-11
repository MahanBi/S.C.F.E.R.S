<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role_key' => ['required', Rule::in(['admin', 'equipment_manager', 'technician', 'equipment_officer'])],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام کامل الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.unique' => 'این ایمیل قبلا ثبت شده است',
            'role_key.required' => 'نقش کاربری الزامی است',
            'password.required' => 'رمز عبور الزامی است',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
        ];
    }
}