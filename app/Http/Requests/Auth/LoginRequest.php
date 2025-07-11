<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::exists('users', 'email')->where(function ($query) {
                    $query->where('is_active', true);
                })
            ],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'وارد کردن ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل وارد شده معتبر نیست',
            'email.exists' => 'ایمیل یا رمز عبور اشتباه است',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
        ];
    }
}