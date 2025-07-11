<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_id',
        'user_id',
        'message',
        'type',
        'attachment_path'
    ];

    protected $appends = ['type_text', 'attachment_url'];

    // روابط
    public function chat()
    {
        return $this->belongsTo(RepairChat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reads()
    {
        return $this->hasMany(ChatMessageRead::class);
    }

    // Attribute Accessors
    public function getTypeTextAttribute(): string
    {
        return [
            'normal' => 'معمولی',
            'technical' => 'فنی',
            'report' => 'گزارش',
            'completion' => 'تکمیل تعمیر',
            'attachment' => 'پیوست'
        ][$this->type] ?? 'نامشخص';
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path 
            ? asset('storage/' . $this->attachment_path) 
            : null;
    }

    // اسکوپها
    public function scopeTechnicalNotes($query)
    {
        return $query->where('type', 'technical');
    }

    public function scopeReports($query)
    {
        return $query->where('type', 'report');
    }

    public function scopeUnread($query, $userId)
    {
        return $query->whereDoesntHave('reads', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }
}