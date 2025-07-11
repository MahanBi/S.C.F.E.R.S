<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmailUpdateRequest extends FormRequest
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
                Rule::unique('users', 'email')->ignore(auth()->id())
            ],
            'current_password' => ['required', 'current_password']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'وارد کردن ایمیل جدید الزامی است',
            'email.email' => 'فرمت ایمیل وارد شده معتبر نیست',
            'email.unique' => 'این ایمیل قبلا توسط کاربر دیگری ثبت شده است',
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی است',
            'current_password.current_password' => 'رمز عبور فعلی اشتباه است',
        ];
    }
}