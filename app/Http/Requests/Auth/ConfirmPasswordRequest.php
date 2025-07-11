<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password']
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.current_password' => 'رمز عبور وارد شده صحیح نیست',
        ];
    }
}