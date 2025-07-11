<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => [
                'required', 
                Rule::in(['equipment_manager', 'technician', 'equipment_officer'])
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'terms' => ['accepted']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'وارد کردن نام کامل الزامی است',
            'name.min' => 'نام کامل باید حداقل ۳ حرف داشته باشد',
            'email.required' => 'وارد کردن ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل وارد شده معتبر نیست',
            'email.unique' => 'این ایمیل قبلا ثبت شده است',
            'role.required' => 'انتخاب نقش کاربری الزامی است',
            'role.in' => 'نقش کاربری انتخاب شده معتبر نیست',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
            'terms.accepted' => 'پذیرش قوانین و مقررات الزامی است',
        ];
    }
}