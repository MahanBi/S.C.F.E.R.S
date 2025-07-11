<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\RepairChat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Events\NewChatMessage;

class ChatController extends Controller
{
    public function show(RepairRequest $request)
    {
        Gate::authorize('view-chat', $request);
        
        $chat = $request->chat()->firstOrCreate();
        $messages = $chat->messages()->with('user')->latest()->paginate(20);
        
        return view('chats.show', compact('chat', 'messages', 'request'));
    }

    public function sendMessage(Request $request, RepairChat $chat)
    {
        Gate::authorize('send-message', $chat);
        
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'type' => 'sometimes|in:normal,technical,report'
        ]);

        $message = $chat->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'type' => $validated['type'] ?? 'normal'
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function uploadAttachment(Request $request, RepairChat $chat)
    {
        Gate::authorize('send-message', $chat);
        
        $request->validate([
            'attachment' => 'required|file|max:5120'
        ]);

        $path = $request->file('attachment')->store('chat-attachments');
        
        $message = $chat->messages()->create([
            'user_id' => auth()->id(),
            'message' => 'فایل پیوست شده',
            'type' => 'attachment',
            'attachment_path' => $path
        ]);

        broadcast(new NewChatMessage($message))->toOthers();

        return response()->json(['status' => 'success', 'message' => $message]);
    }
}