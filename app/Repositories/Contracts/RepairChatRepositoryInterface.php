<?php

namespace App\Repositories\Contracts;

use App\Models\RepairChat;
use App\Models\ChatMessage;

interface RepairChatRepositoryInterface
{
    public function findOrCreateChat(int $requestId): RepairChat;
    public function addMessage(int $chatId, array $data): ChatMessage;
    public function getMessages(int $chatId, int $perPage = 20): LengthAwarePaginator;
    public function markAsRead(int $messageId, int $userId): bool;
}