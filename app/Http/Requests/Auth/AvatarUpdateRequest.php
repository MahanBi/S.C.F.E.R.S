<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AvatarUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'avatar' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif',
                'max:2048', // 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'انتخاب تصویر الزامی است',
            'avatar.image' => 'فایل انتخاب شده باید تصویر باشد',
            'avatar.mimes' => 'فرمت‌های مجاز: jpeg, png, jpg, gif',
            'avatar.max' => 'حداکثر حجم مجاز: ۲ مگابایت',
            'avatar.dimensions' => 'ابعاد تصویر باید بین ۱۰۰x۱۰۰ تا ۲۰۰۰x۲۰۰۰ پیکسل باشد',
        ];
    }
}