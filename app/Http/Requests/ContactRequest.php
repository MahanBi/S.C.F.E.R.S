<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'g-recaptcha-response' => ['required', 'recaptcha']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام الزامی است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل معتبر نیست',
            'subject.required' => 'عنوان پیام الزامی است',
            'message.required' => 'متن پیام الزامی است',
            'message.min' => 'متن پیام باید حداقل ۱۰ کاراکتر باشد',
            'g-recaptcha-response.required' => 'تأیید کپچا الزامی است',
            'g-recaptcha-response.recaptcha' => 'کپچا نامعتبر است. لطفاً دوباره تلاش کنید',
        ];
    }
}