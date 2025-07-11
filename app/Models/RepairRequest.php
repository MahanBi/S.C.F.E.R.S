<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class RepairRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'equipment_id',
        'reporter_id',
        'assigned_technician_id',
        'issue_description',
        'priority',
        'status',
        'assigned_at',
        'completed_at',
        'cost',
        'technician_notes'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    protected $appends = [
        'priority_text',
        'status_text',
        'response_time',
        'repair_duration'
    ];

    // روابط
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_technician_id');
    }

    public function chat()
    {
        return $this->hasOne(RepairChat::class);
    }

    public function report()
    {
        return $this->hasOne(RepairReport::class);
    }

    // Attribute Accessors
    public function getPriorityTextAttribute(): string
    {
        return [
            'low' => 'کم',
            'medium' => 'متوسط',
            'high' => 'زیاد',
            'critical' => 'بحرانی'
        ][$this->priority] ?? 'نامشخص';
    }

    public function getStatusTextAttribute(): string
    {
        return [
            'reported' => 'ثبت شده',
            'assigned' => 'تخصیص یافته',
            'in_progress' => 'در دست تعمیر',
            'completed' => 'تکمیل شده',
            'canceled' => 'لغو شده'
        ][$this->status] ?? 'نامشخص';
    }

    public function getResponseTimeAttribute(): ?int
    {
        if (!$this->assigned_at) return null;
        return $this->created_at->diffInMinutes($this->assigned_at);
    }

    public function getRepairDurationAttribute(): ?int
    {
        if (!$this->completed_at || !$this->assigned_at) return null;
        return $this->assigned_at->diffInMinutes($this->completed_at);
    }

    // اسکوپها
    public function scopePending($query)
    {
        return $query->where('status', 'reported');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCritical($query)
    {
        return $query->where('priority', 'critical');
    }

    public function scopeForTechnician($query, $technicianId)
    {
        return $query->where('assigned_technician_id', $technicianId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}