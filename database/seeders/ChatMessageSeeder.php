<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatMessageSeeder extends Seeder
{
    public function run(): void
    {
        $messages = [
            // Chat for request 1
            [
                'chat_id' => 1,
                'user_id' => 4, // مریم مسئول تجهیزات
                'message' => 'سیستم هیدرولیک کمباین نشتی شدید داره، لطفا سریع بررسی کنید',
                'type' => 'failure_report',
                'created_at' => now()->subHours(3),
                'updated_at' => now()->subHours(3)
            ],
            [
                'chat_id' => 1,
                'user_id' => 2, // علی مدیر تجهیزات
                'message' => 'به رضا تعمیرکار ارجاع داده شد. لطفا وضعیت رو گزارش بدید',
                'type' => 'normal',
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2)
            ],
            [
                'chat_id' => 1,
                'user_id' => 3, // رضا تعمیرکار
                'message' => 'در حال بررسی هستم. به نظر می‌رسد اورینگ اصلی آسیب دیده',
                'type' => 'technical_note',
                'created_at' => now()->subHours(1),
                'updated_at' => now()->subHours(1)
            ],
            
            // Chat for request 2
            [
                'chat_id' => 2,
                'user_id' => 5, // محمد مسئول تجهیزات
                'message' => 'فشار پمپ به شدت کاهش پیدا کرده، عملکرد آبیاری مختل شده',
                'type' => 'failure_report',
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'chat_id' => 2,
                'user_id' => 3, // رضا تعمیرکار
                'message' => 'فیلترها رو تمیز کردم ولی مشکل برطرف نشد. احتمالا پمپ اصلی مشکل داره',
                'type' => 'technical_note',
                'created_at' => now()->subHours(12),
                'updated_at' => now()->subHours(12)
            ],
            [
                'chat_id' => 2,
                'user_id' => 2, // علی مدیر تجهیزات
                'message' => 'اگر نیاز به قطعه دارید اطلاع بدید تا تهیه کنیم',
                'type' => 'normal',
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6)
            ],
        ];

        DB::table('chat_messages')->insert($messages);
    }
}