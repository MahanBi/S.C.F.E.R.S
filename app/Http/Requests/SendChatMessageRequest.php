<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendChatMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'message' => ['required_without:attachment', 'string', 'max:1000'],
            'type' => ['required', Rule::in(['normal', 'technical', 'report', 'completion'])],
            'attachment' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,doc,docx']
        ];
    }

    public function messages(): array
    {
        return [
            'message.required_without' => 'متن پیام یا فایل پیوست الزامی است',
            'message.max' => 'طول پیام حداکثر ۱۰۰۰ کاراکتر مجاز است',
            'type.required' => 'نوع پیام الزامی است',
            'attachment.max' => 'حداکثر حجم فایل ۵ مگابایت است',
            'attachment.mimes' => 'فرمت‌های مجاز: jpg, png, pdf, doc, docx',
        ];
    }
}