<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی است',
            'current_password.current_password' => 'رمز عبور فعلی اشتباه است',
            'password.required' => 'وارد کردن رمز عبور جدید الزامی است',
            'password.confirmed' => 'تکرار رمز عبور مطابقت ندارد',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
        ];
    }
}