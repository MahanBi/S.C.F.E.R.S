<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_key',
        'avatar_path',
        'phone',
        'department',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    protected $appends = ['role_name', 'avatar_url'];

    // روابط
    public function equipments()
    {
        return $this->hasMany(Equipment::class, 'responsible_officer_id');
    }

    public function reportedRequests()
    {
        return $this->hasMany(RepairRequest::class, 'reporter_id');
    }

    public function assignedRequests()
    {
        return $this->hasMany(RepairRequest::class, 'assigned_technician_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function approvedReports()
    {
        return $this->hasMany(RepairReport::class, 'approved_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    // دسترسی‌ها
    public function isAdmin(): bool
    {
        return $this->role_key === 'admin';
    }

    public function isEquipmentManager(): bool
    {
        return $this->role_key === 'equipment_manager';
    }

    public function isTechnician(): bool
    {
        return $this->role_key === 'technician';
    }

    public function isEquipmentOfficer(): bool
    {
        return $this->role_key === 'equipment_officer';
    }

    // Attribute Accessors
    public function getRoleNameAttribute(): string
    {
        return [
            'admin' => 'مدیر سامانه',
            'equipment_manager' => 'مدیر تجهیزات',
            'technician' => 'تعمیرکار',
            'equipment_officer' => 'مسئول تجهیزات'
        ][$this->role_key] ?? 'نامشخص';
    }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar_path 
            ? asset('storage/' . $this->avatar_path)
            : asset('images/default-avatar.png');
    }

    // اسکوپها
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTechnicians($query)
    {
        return $query->where('role_key', 'technician');
    }

    public function scopeOfficers($query)
    {
        return $query->where('role_key', 'equipment_officer');
    }
}