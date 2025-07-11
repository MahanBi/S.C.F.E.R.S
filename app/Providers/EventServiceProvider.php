<?php

namespace App\Providers;

use App\Events\NewChatMessage;
use App\Events\RepairRequestAssigned;
use App\Events\RepairRequestCompleted;
use App\Listeners\BroadcastChatMessage;
use App\Listeners\SendRepairAssignedNotification;
use App\Listeners\SendRepairCompletedNotification;
use App\Listeners\SendChatMessageNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        
        RepairRequestAssigned::class => [
            SendRepairAssignedNotification::class,
        ],
        
        RepairRequestCompleted::class => [
            SendRepairCompletedNotification::class,
        ],
        
        NewChatMessage::class => [
            BroadcastChatMessage::class,
            SendChatMessageNotification::class,
        ],
    ];

    public function boot(): void
    {
        // ثبت آبزرورهای مدل
        \App\Models\RepairRequest::observe(\App\Observers\RepairRequestObserver::class);
        \App\Models\Equipment::observe(\App\Observers\EquipmentObserver::class);
        \App\Models\ChatMessage::observe(\App\Observers\ChatMessageObserver::class);
    }

    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}