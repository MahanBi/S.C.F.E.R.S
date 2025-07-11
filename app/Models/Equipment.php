<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'serial_number',
        'status',
        'responsible_officer_id',
        'purchase_date',
        'warranty_expiry'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'warranty_expiry' => 'date'
    ];

    protected $appends = ['status_text'];

    // روابط
    public function officer()
    {
        return $this->belongsTo(User::class, 'responsible_officer_id');
    }

    public function repairRequests()
    {
        return $this->hasMany(RepairRequest::class);
    }

    public function activeRepairRequest()
    {
        return $this->hasOne(RepairRequest::class)
            ->whereNotIn('status', ['completed', 'canceled']);
    }

    public function lastRepair()
    {
        return $this->hasOne(RepairRequest::class)
            ->latestOfMany();
    }

    // Attribute Accessors
    public function getStatusTextAttribute(): string
    {
        return [
            'active' => 'فعال',
            'under_maintenance' => 'در حال تعمیر',
            'out_of_service' => 'خارج از سرویس'
        ][$this->status] ?? 'نامشخص';
    }

    public function getRepairCountAttribute(): int
    {
        return $this->repairRequests()->count();
    }

    // اسکوپها
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUnderMaintenance($query)
    {
        return $query->where('status', 'under_maintenance');
    }

    public function scopeWithOfficer($query, $officerId)
    {
        return $query->where('responsible_officer_id', $officerId);
    }
}