<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairRequestSeeder extends Seeder
{
    public function run(): void
    {
        $requests = [
            [
                'equipment_id' => 1,
                'reporter_id' => 4, // مریم مسئول تجهیزات
                'issue_description' => 'خرابی در سیستم هیدرولیک - نشتی روغن شدید',
                'priority' => 'high',
                'status' => 'assigned',
                'assigned_technician_id' => 3, // رضا تعمیرکار
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'equipment_id' => 4,
                'reporter_id' => 5, // محمد مسئول تجهیزات
                'issue_description' => 'پمپاژ آب با فشار پایین - احتمال گرفتگی فیلتر',
                'priority' => 'medium',
                'status' => 'in_progress',
                'assigned_technician_id' => 3, // رضا تعمیرکار
                'assigned_at' => now()->subHours(2),
                'created_at' => now()->subDays(1),
                'updated_at' => now()
            ],
            [
                'equipment_id' => 2,
                'reporter_id' => 4, // مریم مسئول تجهیزات
                'issue_description' => 'لرزش غیرعادی در موتور هنگام بارگیری',
                'priority' => 'critical',
                'status' => 'reported',
                'assigned_technician_id' => null,
                'assigned_at' => null,
                'created_at' => now()->subHours(5),
                'updated_at' => now()->subHours(5)
            ],
        ];

        DB::table('repair_requests')->insert($requests);
    }
}