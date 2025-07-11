<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairReportSeeder extends Seeder
{
    public function run(): void
    {
        $reports = [
            [
                'repair_request_id' => 2,
                'technician_summary' => 'پمپ اصلی دچار سایش شده و نیاز به تعویض دارد',
                'parts_used' => 'پمپ جدید مدل P-450',
                'repair_duration_minutes' => 180,
                'cost' => 28500000,
                'final_status' => 'repaired',
                'approved_by' => 2, // علی مدیر تجهیزات
                'report_submitted_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('repair_reports')->insert($reports);
    }
}