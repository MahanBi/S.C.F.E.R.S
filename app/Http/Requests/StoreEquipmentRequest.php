<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEquipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'description' => ['nullable', 'string', 'max:1000'],
            'serial_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('equipments')->ignore($this->equipment)
            ],
            'status' => ['required', Rule::in(['active', 'under_maintenance', 'out_of_service'])],
            'responsible_officer_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where('role_key', 'equipment_officer')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'نام تجهیز الزامی است',
            'name.min' => 'نام تجهیز باید حداقل ۳ حرف داشته باشد',
            'serial_number.required' => 'شماره سریال الزامی است',
            'serial_number.unique' => 'این شماره سریال قبلا ثبت شده است',
            'status.required' => 'انتخاب وضعیت الزامی است',
            'responsible_officer_id.required' => 'انتخاب مسئول تجهیز الزامی است',
            'responsible_officer_id.exists' => 'مسئول انتخاب شده معتبر نیست',
        ];
    }
}