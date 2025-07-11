<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Equipment;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function view(User $user, Equipment $equipment): bool
    {
        // مدیران و مدیر تجهیزات به همه تجهیزات دسترسی دارند
        if ($user->isAdmin() || $user->isEquipmentManager()) {
            return true;
        }
        
        // مسئول تجهیزات فقط به تجهیزات خود دسترسی دارد
        return $user->isEquipmentOfficer() && 
               $equipment->responsible_officer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->isEquipmentManager();
    }

    public function update(User $user, Equipment $equipment): bool
    {
        // مدیر تجهیزات می‌تواند همه تجهیزات را ویرایش کند
        if ($user->isEquipmentManager()) {
            return true;
        }
        
        // مسئول تجهیزات فقط تجهیزات خود را می‌تواند ویرایش کند
        return $user->isEquipmentOfficer() && 
               $equipment->responsible_officer_id === $user->id;
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin();
    }

    public function assignOfficer(User $user): bool
    {
        return $user->isEquipmentManager();
    }
}