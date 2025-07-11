<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RepairChatSeeder extends Seeder
{
    public function run(): void
    {
        $chats = [
            [
                'repair_request_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'repair_request_id' => 2,
                'is_active' => true,
                'created_at' => now()->subDays(1),
                'updated_at' => now()
            ],
        ];

        DB::table('repair_chats')->insert($chats);
    }
}