<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_request_id',
        'approved_by',
        'technician_summary',
        'parts_used',
        'repair_duration_minutes',
        'cost',
        'final_status',
        'report_submitted_at'
    ];

    protected $casts = [
        'report_submitted_at' => 'datetime'
    ];

    protected $appends = ['final_status_text'];

    // روابط
    public function request()
    {
        return $this->belongsTo(RepairRequest::class, 'repair_request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Attribute Accessors
    public function getFinalStatusTextAttribute(): string
    {
        return [
            'repaired' => 'تعمیر شده',
            'replaced' => 'تعویض شده',
            'cannot_repair' => 'عدم امکان تعمیر'
        ][$this->final_status] ?? 'نامشخص';
    }

    // محاسبه هزینه کل
    public function getTotalCostAttribute(): float
    {
        return $this->cost + $this->parts_cost;
    }
}