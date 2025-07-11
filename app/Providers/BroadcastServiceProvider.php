<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Broadcast::routes(['middleware' => ['auth:sanctum']]);

        // کانال چت تعمیرات
        Broadcast::channel('repair-chat.{chatId}', function ($user, $chatId) {
            $chat = \App\Models\RepairChat::findOrFail($chatId);
            return $chat->participants->contains($user->id);
        });

        // کانال اعلان‌های کاربر
        Broadcast::channel('user-notifications.{userId}', function ($user, $userId) {
            return $user->id === (int) $userId;
        });
    }
}