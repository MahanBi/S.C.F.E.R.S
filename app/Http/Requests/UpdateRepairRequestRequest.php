<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepairRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'assigned_technician_id' => [
                'nullable',
                'exists:users,id',
                Rule::exists('users', 'id')->where('role_key', 'technician')
            ],
            'status' => ['required', Rule::in(['reported', 'assigned', 'in_progress', 'completed', 'canceled'])],
            'technician_notes' => ['nullable', 'string', 'max:1000'],
            'cost' => ['nullable', 'numeric', 'min:0', 'max:1000000000'],
            'completion_time' => ['nullable', 'integer', 'min:1']
        ];
    }

    public function messages(): array
    {
        return [
            'assigned_technician_id.exists' => 'تعمیرکار انتخاب شده معتبر نیست',
            'status.required' => 'انتخاب وضعیت الزامی است',
            'cost.numeric' => 'هزینه باید عددی باشد',
            'cost.min' => 'هزینه نمی‌تواند منفی باشد',
            'completion_time.integer' => 'زمان تکمیل باید عدد صحیح باشد',
            'completion_time.min' => 'زمان تکمیل باید حداقل ۱ دقیقه باشد',
        ];
    }
}