<?php

namespace App\Repositories\Contracts;

interface ReportRepositoryInterface
{
    public function equipmentStatusReport(): array;
    public function repairRequestsReport(array $filters): array;
    public function technicianPerformanceReport(): LengthAwarePaginator;
    public function exportRepairRequests(array $filters, string $format);
}