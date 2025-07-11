<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileAvatarRequest extends FormRequest
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
                'mimes:jpeg,png,jpg,gif,webp',
                'max:2048',
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'avatar.required' => 'انتخاب تصویر الزامی است',
            'avatar.image' => 'فایل باید تصویر باشد',
            'avatar.mimes' => 'فرمت‌های مجاز: jpeg, png, jpg, gif, webp',
            'avatar.max' => 'حداکثر حجم فایل ۲ مگابایت است',
            'avatar.dimensions' => 'ابعاد تصویر باید بین ۱۰۰x۱۰۰ تا ۲۰۰۰x۲۰۰۰ پیکسل باشد',
        ];
    }
}