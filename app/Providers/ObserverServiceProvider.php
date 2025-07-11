<?php

namespace App\Providers;

use App\Models\{
    Equipment,
    RepairRequest,
    User,
    ChatMessage
};
use App\Observers\{
    EquipmentObserver,
    RepairRequestObserver,
    UserObserver,
    ChatMessageObserver
};
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    protected $observers = [
        Equipment::class => [EquipmentObserver::class],
        RepairRequest::class => [RepairRequestObserver::class],
        User::class => [UserObserver::class],
        ChatMessage::class => [ChatMessageObserver::class],
    ];

    public function boot(): void
    {
        foreach ($this->observers as $model => $observerClasses) {
            foreach ($observerClasses as $observerClass) {
                $model::observe($observerClass);
            }
        }
    }
}