<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        switch ($user->role_key) {
            case 'admin':
                $data = $this->adminDashboard();
                break;
            case 'equipment_manager':
                $data = $this->managerDashboard();
                break;
            case 'technician':
                $data = $this->technicianDashboard();
                break;
            case 'equipment_officer':
                $data = $this->officerDashboard();
                break;
        }

        return view('dashboard.' . $user->role_key, $data);
    }

    protected function adminDashboard()
    {
        return [
            'total_equipment' => Equipment::count(),
            'active_equipment' => Equipment::where('status', 'active')->count(),
            'under_maintenance' => Equipment::where('status', 'under_maintenance')->count(),
            'pending_requests' => RepairRequest::where('status', 'reported')->count(),
            'completed_requests' => RepairRequest::where('status', 'completed')->count(),
            'recent_requests' => RepairRequest::with('equipment')->latest()->take(5)->get()
        ];
    }

    protected function managerDashboard()
    {
        return [
            'my_equipment' => Equipment::where('responsible_officer_id', Auth::id())->count(),
            'pending_requests' => RepairRequest::where('status', 'reported')->count(),
            'assigned_requests' => RepairRequest::where('status', 'assigned')->count(),
            'in_progress_requests' => RepairRequest::where('status', 'in_progress')->count(),
            'urgent_requests' => RepairRequest::where('priority', 'critical')->count(),
            'recent_requests' => RepairRequest::with('equipment')->latest()->take(5)->get()
        ];
    }

    protected function technicianDashboard()
    {
        return [
            'assigned_requests' => RepairRequest::where('assigned_technician_id', Auth::id())
                ->whereIn('status', ['assigned', 'in_progress'])
                ->count(),
            'completed_requests' => RepairRequest::where('assigned_technician_id', Auth::id())
                ->where('status', 'completed')
                ->count(),
            'pending_requests' => RepairRequest::where('assigned_technician_id', Auth::id())
                ->where('status', 'assigned')
                ->count(),
            'active_requests' => RepairRequest::where('assigned_technician_id', Auth::id())
                ->where('status', 'in_progress')
                ->with('equipment')
                ->get()
        ];
    }

    protected function officerDashboard()
    {
        return [
            'my_equipment' => Equipment::where('responsible_officer_id', Auth::id())->count(),
            'active_equipment' => Equipment::where('responsible_officer_id', Auth::id())
                ->where('status', 'active')
                ->count(),
            'under_maintenance' => Equipment::where('responsible_officer_id', Auth::id())
                ->where('status', 'under_maintenance')
                ->count(),
            'my_requests' => RepairRequest::where('reporter_id', Auth::id())
                ->with('equipment')
                ->latest()
                ->take(5)
                ->get()
        ];
    }
}