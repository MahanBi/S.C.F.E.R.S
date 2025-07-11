<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', 'before_or_equal:end_date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'report_type' => ['required', Rule::in(['requests', 'equipment', 'technicians', 'costs'])],
            'status' => ['nullable', Rule::in(['reported', 'assigned', 'in_progress', 'completed', 'canceled'])],
            'priority' => ['nullable', Rule::in(['low', 'medium', 'high', 'critical'])],
            'technician_id' => ['nullable', 'exists:users,id'],
            'format' => ['required', Rule::in(['html', 'excel', 'pdf'])]
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'تاریخ شروع الزامی است',
            'start_date.before_or_equal' => 'تاریخ شروع باید قبل یا مساوی تاریخ پایان باشد',
            'end_date.required' => 'تاریخ پایان الزامی است',
            'end_date.after_or_equal' => 'تاریخ پایان باید بعد یا مساوی تاریخ شروع باشد',
            'report_type.required' => 'نوع گزارش الزامی است',
            'format.required' => 'فرمت خروجی الزامی است',
            'technician_id.exists' => 'تعمیرکار انتخاب شده معتبر نیست',
        ];
    }
}