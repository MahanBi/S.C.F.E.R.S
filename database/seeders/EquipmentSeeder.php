<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipments = [
            [
                'name' => 'کمباین نیشکر مدل A-700',
                'description' => 'کمباین مدرن برداشت نیشکر با قابلیت کار در شرایط سخت',
                'serial_number' => 'EQ-SC-001',
                'status' => 'active',
                'responsible_officer_id' => 4, // مریم مسئول تجهیزات
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'تراکتور ترانسپورت مدل T-500',
                'description' => 'تراکتور حمل نیشکر با ظرفیت 10 تن',
                'serial_number' => 'EQ-SC-002',
                'status' => 'active',
                'responsible_officer_id' => 5, // محمد مسئول تجهیزات
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'دستگاه بسته‌بندی اتوماتیک',
                'description' => 'سیستم بسته‌بندی نیشکر با ظرفیت 5 تن در ساعت',
                'serial_number' => 'EQ-SC-003',
                'status' => 'active',
                'responsible_officer_id' => 4, // مریم مسئول تجهیزات
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'پمپ آبیاری فشار قوی',
                'description' => 'پمپ آبیاری مزارع نیشکر با قدرت 50 اسب بخار',
                'serial_number' => 'EQ-SC-004',
                'status' => 'under_maintenance',
                'responsible_officer_id' => 5, // محمد مسئول تجهیزات
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('equipments')->insert($equipments);
    }
}