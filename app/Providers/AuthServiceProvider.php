<?php

namespace App\Providers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use App\Models\RepairChat;
use App\Models\RepairReport;
use App\Models\User;
use App\Policies\EquipmentPolicy;
use App\Policies\RepairRequestPolicy;
use App\Policies\RepairChatPolicy;
use App\Policies\RepairReportPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Equipment::class => EquipmentPolicy::class,
        RepairRequest::class => RepairRequestPolicy::class,
        RepairChat::class => RepairChatPolicy::class,
        RepairReport::class => RepairReportPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        // تعریف دروازه‌های عمومی
        Gate::define('manage-all', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('manage-equipment', function (User $user) {
            return $user->isAdmin() || $user->isEquipmentManager();
        });

        Gate::define('access-reports', function (User $user) {
            return $user->isAdmin() || $user->isEquipmentManager();
        });

        // دروازه‌های پویا
        Gate::define('view-equipment', [EquipmentPolicy::class, 'view']);
        Gate::define('update-equipment', [EquipmentPolicy::class, 'update']);
        Gate::define('delete-equipment', [EquipmentPolicy::class, 'delete']);

        Gate::define('view-request', [RepairRequestPolicy::class, 'view']);
        Gate::define('update-request', [RepairRequestPolicy::class, 'update']);
        Gate::define('assign-technician', [RepairRequestPolicy::class, 'assignTechnician']);
        Gate::define('update-request-status', [RepairRequestPolicy::class, 'changeStatus']);

        Gate::define('view-chat', [RepairChatPolicy::class, 'view']);
        Gate::define('send-message', [RepairChatPolicy::class, 'sendMessage']);
        Gate::define('upload-attachment', [RepairChatPolicy::class, 'uploadAttachment']);

        Gate::define('manage-users', [UserPolicy::class, 'viewAny']);
        
        Gate::define('update-profile', function (User $user, User $profileUser) {
            return $user->id === $profileUser->id;
        });
    }
}