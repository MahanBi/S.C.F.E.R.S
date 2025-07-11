<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RepairChat;
use Illuminate\Auth\Access\Response;

class RepairChatPolicy
{
    public function view(User $user, RepairChat $chat): bool
    {
        $participantIds = $chat->participants->pluck('id')->toArray();
        return in_array($user->id, $participantIds);
    }

    public function sendMessage(User $user, RepairChat $chat): bool
    {
        $participantIds = $chat->participants->pluck('id')->toArray();
        return in_array($user->id, $participantIds);
    }

    public function viewMessages(User $user, RepairChat $chat): bool
    {
        $participantIds = $chat->participants->pluck('id')->toArray();
        return in_array($user->id, $participantIds);
    }

    public function uploadAttachment(User $user, RepairChat $chat): bool
    {
        // فقط تعمیرکار و مدیر تجهیزات می‌توانند فایل پیوست کنند
        $participantIds = $chat->participants->pluck('id')->toArray();
        return in_array($user->id, $participantIds) && 
               ($user->isTechnician() || $user->isEquipmentManager());
    }
}