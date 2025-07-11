<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
                Rule::unique('users')->ignore(auth()->id())
            ],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{10,15}$/'],
            'department' => ['nullable', 'string', 'max:100']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام کامل الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.unique' => 'این ایمیل قبلا توسط کاربر دیگری ثبت شده است',
            'phone.regex' => 'شماره تلفن معتبر نیست (۱۰ تا ۱۵ رقم)',
        ];
    }
}