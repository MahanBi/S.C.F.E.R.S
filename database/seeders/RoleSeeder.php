<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'مدیر سامانه', 'key' => 'admin'],
            ['name' => 'مدیر تجهیزات', 'key' => 'equipment_manager'],
            ['name' => 'تعمیرکار', 'key' => 'technician'],
            ['name' => 'مسئول تجهیزات', 'key' => 'equipment_officer'],
        ];

        DB::table('roles')->insert($roles);
    }
}