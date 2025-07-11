<?php

namespace App\Exports;

use App\Models\RepairRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RepairRequestsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'شناسه',
            'تجهیز',
            'گزارش دهنده',
            'تعمیرکار',
            'توضیح مشکل',
            'اولویت',
            'وضعیت',
            'زمان ثبت',
            'زمان تخصیص',
            'زمان تکمیل',
            'زمان تعمیر (ساعت)'
        ];
    }

    public function map($request): array
    {
        return [
            $request->id,
            $request->equipment->name,
            $request->reporter->name,
            $request->technician ? $request->technician->name : '—',
            $request->issue_description,
            $this->priorityToText($request->priority),
            $this->statusToText($request->status),
            $request->created_at->format('Y/m/d H:i'),
            $request->assigned_at ? $request->assigned_at->format('Y/m/d H:i') : '—',
            $request->completed_at ? $request->completed_at->format('Y/m/d H:i') : '—',
            $request->completed_at ? round($request->created_at->diffInHours($request->completed_at), 2) : '—'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']]
            ]
        ];
    }

    private function priorityToText($priority)
    {
        $priorities = [
            'low' => 'کم',
            'medium' => 'متوسط',
            'high' => 'زیاد',
            'critical' => 'بحرانی'
        ];

        return $priorities[$priority] ?? $priority;
    }

    private function statusToText($status)
    {
        $statuses = [
            'reported' => 'ثبت شده',
            'assigned' => 'تخصیص یافته',
            'in_progress' => 'در دست تعمیر',
            'completed' => 'تکمیل شده',
            'canceled' => 'لغو شده'
        ];

        return $statuses[$status] ?? $status;
    }
}