<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RepairRequest;
use Illuminate\Auth\Access\Response;

class RepairRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager() || 
               $user->isEquipmentOfficer() || $user->isTechnician();
    }

    public function view(User $user, RepairRequest $request): bool
    {
        // مدیران و مدیر تجهیزات به همه درخواست‌ها دسترسی دارند
        if ($user->isAdmin() || $user->isEquipmentManager()) {
            return true;
        }
        
        // مسئول تجهیزات فقط به درخواست‌های خود دسترسی دارد
        if ($user->isEquipmentOfficer() && $request->reporter_id === $user->id) {
            return true;
        }
        
        // تعمیرکار فقط به درخواست‌های تخصیص یافته به خود دسترسی دارد
        return $user->isTechnician() && $request->assigned_technician_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isEquipmentOfficer();
    }

    public function update(User $user, RepairRequest $request): bool
    {
        // مدیر تجهیزات می‌تواند همه درخواست‌ها را ویرایش کند
        if ($user->isEquipmentManager()) {
            return true;
        }
        
        // مسئول تجهیزات فقط درخواست‌های خود را می‌تواند ویرایش کند
        if ($user->isEquipmentOfficer() && $request->reporter_id === $user->id) {
            return true;
        }
        
        // تعمیرکار فقط درخواست‌های تخصیص یافته به خود را می‌تواند ویرایش کند
        return $user->isTechnician() && $request->assigned_technician_id === $user->id;
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }

    public function assignTechnician(User $user): bool
    {
        return $user->isEquipmentManager();
    }

    public function changeStatus(User $user, RepairRequest $request): bool
    {
        // مدیر تجهیزات می‌تواند وضعیت همه درخواست‌ها را تغییر دهد
        if ($user->isEquipmentManager()) {
            return true;
        }
        
        // تعمیرکار فقط می‌تواند وضعیت درخواست‌های خود را تغییر دهد
        return $user->isTechnician() && $request->assigned_technician_id === $user->id;
    }
}