<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'مدیر سیستم',
                'email' => 'admin@scfers.local',
                'password' => Hash::make('12345678'),
                'role_key' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'علی مدیر تجهیزات',
                'email' => 'manager@scfers.local',
                'password' => Hash::make('12345678'),
                'role_key' => 'equipment_manager',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'رضا تعمیرکار',
                'email' => 'technician@scfers.local',
                'password' => Hash::make('12345678'),
                'role_key' => 'technician',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'مریم مسئول تجهیزات',
                'email' => 'officer@scfers.local',
                'password' => Hash::make('12345678'),
                'role_key' => 'equipment_officer',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'محمد مسئول تجهیزات',
                'email' => 'officer2@scfers.local',
                'password' => Hash::make('12345678'),
                'role_key' => 'equipment_officer',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('users')->insert($users);
    }
}