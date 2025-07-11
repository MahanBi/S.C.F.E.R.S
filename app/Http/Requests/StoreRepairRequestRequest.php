<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRepairRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'equipment_id' => [
                'required',
                'exists:equipments,id',
                Rule::exists('equipments', 'id')->where('status', 'active')
            ],
            'issue_description' => ['required', 'string', 'min:10', 'max:1000'],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'critical'])],
            'attachments.*' => ['nullable', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,doc,docx']
        ];
    }

    public function messages(): array
    {
        return [
            'equipment_id.required' => 'انتخاب تجهیز الزامی است',
            'equipment_id.exists' => 'تجهیز انتخاب شده معتبر نیست یا غیرفعال است',
            'issue_description.required' => 'توضیح مشکل الزامی است',
            'issue_description.min' => 'توضیح مشکل باید حداقل ۱۰ حرف داشته باشد',
            'priority.required' => 'انتخاب اولویت الزامی است',
            'attachments.*.max' => 'حداکثر حجم هر فایل ۵ مگابایت است',
            'attachments.*.mimes' => 'فرمت‌های مجاز: jpg, png, pdf, doc, docx',
        ];
    }
}