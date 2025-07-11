<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReportPolicy
{
    public function viewEquipmentReport(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function viewRepairRequestsReport(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function viewTechnicianPerformanceReport(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function exportReports(User $user): bool
    {
        return $user->isAdmin() || $user->isEquipmentManager();
    }

    public function viewCostReport(User $user): bool
    {
        return $user->isAdmin();
    }
}