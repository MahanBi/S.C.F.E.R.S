<?php

namespace App\Repositories\Contracts;

use App\Models\Equipment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface EquipmentRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): ?Equipment;
    public function create(array $data): Equipment;
    public function update(int $id, array $data): Equipment;
    public function delete(int $id): bool;
    public function forOfficer(int $officerId): Collection;
    public function activeEquipmentCount(): int;
}