<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EquipmentSeeder::class,
            RepairRequestSeeder::class,
            RepairChatSeeder::class,
            ChatMessageSeeder::class,
            RepairReportSeeder::class,
        ]);
    }
}