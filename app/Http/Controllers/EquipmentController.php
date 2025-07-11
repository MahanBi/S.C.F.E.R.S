<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\User;
use App\Http\Requests\StoreEquipmentRequest;
use App\Http\Requests\UpdateEquipmentRequest;
use Illuminate\Support\Facades\Gate;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('officer')
            ->when(!Gate::allows('manage-all'), function ($query) {
                $query->where('responsible_officer_id', auth()->id());
            })
            ->paginate(10);
            
        return view('equipment.index', compact('equipments'));
    }

    public function create()
    {
        $officers = User::where('role_key', 'equipment_officer')->get();
        return view('equipment.create', compact('officers'));
    }

    public function store(StoreEquipmentRequest $request)
    {
        Equipment::create($request->validated());
        
        return redirect()->route('equipment.index')
            ->with('success', 'تجهیز جدید با موفقیت ثبت شد');
    }

    public function show(Equipment $equipment)
    {
        Gate::authorize('view-equipment', $equipment);
        
        $repairRequests = $equipment->repairRequests()
            ->with('technician')
            ->latest()
            ->paginate(5);
            
        return view('equipment.show', compact('equipment', 'repairRequests'));
    }

    public function edit(Equipment $equipment)
    {
        Gate::authorize('update-equipment', $equipment);
        
        $officers = User::where('role_key', 'equipment_officer')->get();
        return view('equipment.edit', compact('equipment', 'officers'));
    }

    public function update(UpdateEquipmentRequest $request, Equipment $equipment)
    {
        Gate::authorize('update-equipment', $equipment);
        
        $equipment->update($request->validated());
        
        return redirect()->route('equipment.index')
            ->with('success', 'اطلاعات تجهیز با موفقیت به‌روزرسانی شد');
    }

    public function destroy(Equipment $equipment)
    {
        Gate::authorize('delete-equipment', $equipment);
        
        $equipment->delete();
        
        return redirect()->route('equipment.index')
            ->with('success', 'تجهیز با موفقیت حذف شد');
    }
}