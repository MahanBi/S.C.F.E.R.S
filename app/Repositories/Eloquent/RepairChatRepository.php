<?php

namespace App\Repositories\Eloquent;

use App\Models\RepairChat;
use App\Models\ChatMessage;
use App\Repositories\Contracts\RepairChatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class RepairChatRepository implements RepairChatRepositoryInterface
{
    public function findOrCreateChat(int $requestId): RepairChat
    {
        return RepairChat::firstOrCreate(['repair_request_id' => $requestId]);
    }

    public function addMessage(int $chatId, array $data): ChatMessage
    {
        return ChatMessage::create(array_merge(['chat_id' => $chatId], $data));
    }

    public function getMessages(int $chatId, int $perPage = 20): LengthAwarePaginator
    {
        return ChatMessage::where('chat_id', $chatId)
            ->latest()
            ->paginate($perPage);
    }

    public function markAsRead(int $messageId, int $userId): bool
    {
        return ChatMessageRead::firstOrCreate([
            'message_id' => $messageId,
            'user_id' => $userId
        ], ['read_at' => now()]);
    }
}