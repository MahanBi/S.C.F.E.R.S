<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use App\Models\User;
use App\Http\Requests\StoreRepairRequestRequest;
use App\Http\Requests\UpdateRepairRequestRequest;
use Illuminate\Support\Facades\Gate;

class RepairRequestController extends Controller
{
    public function index()
    {
        $requests = RepairRequest::with(['equipment', 'reporter', 'technician'])
            ->when(!Gate::allows('manage-all'), function ($query) {
                $query->where('reporter_id', auth()->id());
            })
            ->latest()
            ->paginate(10);
            
        return view('repair-requests.index', compact('requests'));
    }

    public function create()
    {
        $equipment = Equipment::when(!Gate::allows('manage-all'), function ($query) {
                $query->where('responsible_officer_id', auth()->id());
            })
            ->get();
            
        return view('repair-requests.create', compact('equipment'));
    }

    public function store(StoreRepairRequestRequest $request)
    {
        $request->merge(['reporter_id' => auth()->id()]);
        RepairRequest::create($request->validated());
        
        return redirect()->route('repair-requests.index')
            ->with('success', 'درخواست تعمیر با موفقیت ثبت شد');
    }

    public function show(RepairRequest $repairRequest)
    {
        Gate::authorize('view-request', $repairRequest);
        
        return view('repair-requests.show', compact('repairRequest'));
    }

    public function edit(RepairRequest $repairRequest)
    {
        Gate::authorize('update-request', $repairRequest);
        
        $technicians = User::where('role_key', 'technician')->get();
        $equipment = Equipment::all();
        
        return view('repair-requests.edit', compact('repairRequest', 'technicians', 'equipment'));
    }

    public function update(UpdateRepairRequestRequest $request, RepairRequest $repairRequest)
    {
        Gate::authorize('update-request', $repairRequest);
        
        $repairRequest->update($request->validated());
        
        return redirect()->route('repair-requests.index')
            ->with('success', 'درخواست تعمیر با موفقیت به‌روزرسانی شد');
    }

    public function assignTechnician(RepairRequest $repairRequest, User $technician)
    {
        Gate::authorize('assign-technician', $repairRequest);
        
        $repairRequest->update([
            'assigned_technician_id' => $technician->id,
            'status' => 'assigned',
            'assigned_at' => now()
        ]);
        
        return back()->with('success', 'تعمیرکار با موفقیت تخصیص داده شد');
    }

    public function updateStatus(RepairRequest $repairRequest, $status)
    {
        Gate::authorize('update-request-status', $repairRequest);
        
        $validStatuses = ['in_progress', 'completed', 'canceled'];
        
        if (!in_array($status, $validStatuses)) {
            abort(400, 'وضعیت نامعتبر');
        }
        
        $updateData = ['status' => $status];
        
        if ($status === 'completed') {
            $updateData['completed_at'] = now();
        }
        
        $repairRequest->update($updateData);
        
        return back()->with('success', 'وضعیت درخواست با موفقیت به‌روزرسانی شد');
    }
}