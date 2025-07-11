<?php

namespace App\Repositories\Eloquent;

use App\Models\RepairRequest;
use App\Repositories\Contracts\RepairRequestRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RepairRequestRepository implements RepairRequestRepositoryInterface
{
    public function find(int $id): ?RepairRequest
    {
        return RepairRequest::find($id);
    }

    public function create(array $data): RepairRequest
    {
        return RepairRequest::create($data);
    }

    public function update(int $id, array $data): RepairRequest
    {
        $request = RepairRequest::findOrFail($id);
        $request->update($data);
        return $request;
    }

    public function forTechnician(int $technicianId, string $status = null): LengthAwarePaginator
    {
        $query = RepairRequest::where('assigned_technician_id', $technicianId);
        
        if ($status) {
            $query->where('status', $status);
        }
        
        return $query->paginate(10);
    }

    public function forOfficer(int $officerId): LengthAwarePaginator
    {
        return RepairRequest::where('reporter_id', $officerId)
            ->paginate(10);
    }

    public function assignTechnician(int $requestId, int $technicianId): RepairRequest
    {
        $request = RepairRequest::findOrFail($requestId);
        $request->update([
            'assigned_technician_id' => $technicianId,
            'status' => 'assigned',
            'assigned_at' => now()
        ]);
        return $request;
    }

    public function changeStatus(int $requestId, string $status): RepairRequest
    {
        $request = RepairRequest::findOrFail($requestId);
        
        $updateData = ['status' => $status];
        if ($status === 'completed') {
            $updateData['completed_at'] = now();
        }
        
        $request->update($updateData);
        return $request;
    }

    public function getStats(): array
    {
        return [
            'pending' => RepairRequest::where('status', 'reported')->count(),
            'in_progress' => RepairRequest::where('status', 'in_progress')->count(),
            'completed_today' => RepairRequest::where('status', 'completed')
                ->whereDate('completed_at', today())
                ->count(),
        ];
    }
}