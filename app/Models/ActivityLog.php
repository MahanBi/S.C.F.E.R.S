<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event',
        'description',
        'loggable_id',
        'loggable_type',
        'properties'
    ];

    protected $casts = [
        'properties' => 'json'
    ];

    // روابط
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loggable()
    {
        return $this->morphTo();
    }

    // Attribute Accessors
    public function getEventTextAttribute(): string
    {
        return [
            'created_equipment' => 'ثبت تجهیز جدید',
            'updated_equipment' => 'به‌روزرسانی تجهیز',
            'deleted_equipment' => 'حذف تجهیز',
            'created_repair_request' => 'ثبت درخواست تعمیر',
            'assigned_technician' => 'تخصیص تعمیرکار',
            'completed_repair' => 'تکمیل تعمیر',
            'sent_message' => 'ارسال پیام',
            'uploaded_attachment' => 'آپلود پیوست'
        ][$this->event] ?? $this->event;
    }
}