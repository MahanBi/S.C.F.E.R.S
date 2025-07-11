<?php

namespace App\Repositories\Eloquent;

use App\Models\Equipment;
use App\Repositories\Contracts\EquipmentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class EquipmentRepository implements EquipmentRepositoryInterface
{
    public function all(): Collection
    {
        return Equipment::all();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Equipment::paginate($perPage);
    }

    public function find(int $id): ?Equipment
    {
        return Equipment::find($id);
    }

    public function create(array $data): Equipment
    {
        return Equipment::create($data);
    }

    public function update(int $id, array $data): Equipment
    {
        $equipment = Equipment::findOrFail($id);
        $equipment->update($data);
        return $equipment;
    }

    public function delete(int $id): bool
    {
        return Equipment::destroy($id);
    }

    public function forOfficer(int $officerId): Collection
    {
        return Equipment::where('responsible_officer_id', $officerId)->get();
    }

    public function activeEquipmentCount(): int
    {
        return Equipment::where('status', 'active')->count();
    }
}