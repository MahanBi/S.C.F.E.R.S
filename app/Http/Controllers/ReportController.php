<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\RepairRequestsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * گزارش وضعیت تجهیزات
     */
    public function equipmentStatusReport()
    {
        $report = Equipment::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // محاسبه درصدها
        $total = $report->sum('count');
        $report = $report->map(function ($item) use ($total) {
            $item->percentage = $total > 0 ? round(($item->count / $total) * 100, 2) : 0;
            return $item;
        });

        return view('reports.equipment-status', compact('report', 'total'));
    }

    /**
     * گزارش درخواست‌های تعمیر بر اساس تاریخ
     */
    public function repairRequestsReport(Request $request)
    {
        // تنظیم تاریخ پیش‌فرض (30 روز اخیر)
        $startDate = $request->input('start_date', now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        // اعتبارسنجی تاریخ
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // گزارش روزانه
        $dailyReport = RepairRequest::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total'),
                DB::raw('sum(case when status = "completed" then 1 else 0 end) as completed'),
                DB::raw('sum(case when status = "canceled" then 1 else 0 end) as canceled'),
                DB::raw('sum(case when priority = "critical" then 1 else 0 end) as critical')
            )
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // گزارش تجمعی
        $cumulativeReport = [];
        $totalRequests = 0;
        $totalCompleted = 0;
        $totalCanceled = 0;
        $totalCritical = 0;

        foreach ($dailyReport as $item) {
            $totalRequests += $item->total;
            $totalCompleted += $item->completed;
            $totalCanceled += $item->canceled;
            $totalCritical += $item->critical;

            $cumulativeReport[] = [
                'date' => $item->date,
                'total' => $totalRequests,
                'completed' => $totalCompleted,
                'canceled' => $totalCanceled,
                'critical' => $totalCritical
            ];
        }

        // آمار کلی
        $stats = [
            'total' => RepairRequest::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => RepairRequest::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'avg_completion_time' => RepairRequest::where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->avg(DB::raw('TIMESTAMPDIFF(HOUR, created_at, completed_at)')),
            'critical_percentage' => $totalRequests > 0 
                ? round(($totalCritical / $totalRequests) * 100, 2) 
                : 0
        ];

        return view('reports.repair-requests', compact(
            'dailyReport', 
            'cumulativeReport',
            'stats',
            'startDate',
            'endDate'
        ));
    }

    /**
     * گزارش عملکرد تعمیرکاران
     */
    public function technicianPerformanceReport()
    {
        $report = User::where('role_key', 'technician')
            ->withCount([
                'assignedRequests as total_requests' => function ($query) {
                    $query->where('status', '!=', 'canceled');
                },
                'assignedRequests as completed_requests' => function ($query) {
                    $query->where('status', 'completed');
                },
                'assignedRequests as critical_requests' => function ($query) {
                    $query->where('priority', 'critical');
                }
            ])
            ->withCount(['assignedRequests as avg_completion_time' => function ($query) {
                $query->select(DB::raw('AVG(TIMESTAMPDIFF(HOUR, assigned_at, completed_at))'))
                    ->where('status', 'completed');
            }])
            ->paginate(10);

        // محاسبه نرخ تکمیل
        $report->each(function ($tech) {
            $tech->completion_rate = $tech->total_requests > 0 
                ? round(($tech->completed_requests / $tech->total_requests) * 100, 2) 
                : 0;
        });

        return view('reports.technician-performance', compact('report'));
    }

    /**
     * خروجی اکسل درخواست‌های تعمیر
     */
    public function exportRepairRequests(Request $request)
    {
        // اعتبارسنجی پارامترها
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|in:reported,assigned,in_progress,completed,canceled',
            'priority' => 'nullable|in:low,medium,high,critical',
            'technician_id' => 'nullable|exists:users,id',
            'format' => 'required|in:excel,pdf'
        ]);

        // ایجاد کوئری
        $query = RepairRequest::with(['equipment', 'reporter', 'technician'])
            ->when($request->filled('start_date'), function ($q) use ($request) {
                $q->where('created_at', '>=', $request->start_date . ' 00:00:00');
            })
            ->when($request->filled('end_date'), function ($q) use ($request) {
                $q->where('created_at', '<=', $request->end_date . ' 23:59:59');
            })
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->filled('priority'), function ($q) use ($request) {
                $q->where('priority', $request->priority);
            })
            ->when($request->filled('technician_id'), function ($q) use ($request) {
                $q->where('assigned_technician_id', $request->technician_id);
            });

        // نام فایل
        $fileName = 'repair-requests-report-' . now()->format('Ymd-His');

        if ($request->format === 'excel') {
            return Excel::download(new RepairRequestsExport($query), $fileName . '.xlsx');
        }

        // خروجی PDF
        $requests = $query->get();
        $pdf = Pdf::loadView('exports.repair-requests-pdf', compact('requests'));

        return $pdf->download($fileName . '.pdf');
    }

    /**
     * گزارش تجهیزات پرخطا
     */
    public function problematicEquipmentReport()
    {
        $report = Equipment::withCount(['repairRequests as repair_count' => function ($query) {
                $query->where('created_at', '>=', now()->subYear());
            }])
            ->having('repair_count', '>', 0)
            ->orderByDesc('repair_count')
            ->paginate(10);

        return view('reports.problematic-equipment', compact('report'));
    }

    /**
     * گزارش زمان پاسخگویی
     */
    public function responseTimeReport()
    {
        $report = RepairRequest::selectRaw('
                AVG(TIMESTAMPDIFF(HOUR, created_at, assigned_at)) as avg_assignment_time,
                AVG(TIMESTAMPDIFF(HOUR, assigned_at, completed_at)) as avg_repair_time,
                priority
            ')
            ->whereNotNull('assigned_at')
            ->whereNotNull('completed_at')
            ->groupBy('priority')
            ->get();

        return view('reports.response-time', compact('report'));
    }

    /**
     * گزارش هزینه‌های تعمیرات
     */
    public function repairCostsReport(Request $request)
    {
        $year = $request->input('year', now()->year);

        $report = RepairRequest::selectRaw('
                MONTH(completed_at) as month,
                SUM(cost) as total_cost,
                AVG(cost) as avg_cost,
                COUNT(*) as repair_count
            ')
            ->whereYear('completed_at', $year)
            ->where('status', 'completed')
            ->whereNotNull('cost')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // پر کردن ماه‌های فاقد داده
        $fullReport = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $report->firstWhere('month', $i);
            $fullReport[] = [
                'month' => $i,
                'month_name' => jdate()->setMonth($i)->format('F'),
                'total_cost' => $monthData->total_cost ?? 0,
                'avg_cost' => $monthData->avg_cost ?? 0,
                'repair_count' => $monthData->repair_count ?? 0
            ];
        }

        $years = range(now()->year - 5, now()->year);

        return view('reports.repair-costs', compact('fullReport', 'year', 'years'));
    }
}