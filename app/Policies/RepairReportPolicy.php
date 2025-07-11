<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RepairReport;
use Illuminate\Auth\Access\Response;

class RepairReportPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function view(User $user, RepairReport $report): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function create(User $user): bool
    {
        // فقط تعمیرکاران می‌توانند گزارش تعمیر ایجاد کنند
        return $user->isTechnician();
    }

    public function update(User $user, RepairReport $report): bool
    {
        // فقط تعمیرکار ایجادکننده گزارش یا مدیر تجهیزات می‌توانند ویرایش کنند
        $isTechnicianOwner = $user->isTechnician() && 
                             $report->request->assigned_technician_id === $user->id;
        
        return $isTechnicianOwner || $user->isEquipmentManager();
    }

    public function approve(User $user): bool
    {
        // فقط مدیر تجهیزات می‌تواند گزارش را تأیید کند
        return $user->isEquipmentManager();
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }
}