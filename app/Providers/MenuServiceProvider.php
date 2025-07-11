<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = auth()->user();
            $menu = [];
            
            if ($user) {
                $menu = $this->generateMenuForUser($user);
            }
            
            $view->with('mainMenu', $menu);
        });
    }

    protected function generateMenuForUser(User $user): array
    {
        $menu = [];
        
        if ($user->isAdmin()) {
            $menu = [
                ['name' => 'داشبورد', 'route' => 'admin.dashboard', 'icon' => 'dashboard'],
                ['name' => 'کاربران', 'route' => 'admin.users.index', 'icon' => 'users'],
                ['name' => 'تجهیزات', 'route' => 'equipment.index', 'icon' => 'tool'],
                ['name' => 'گزارشات', 'icon' => 'report', 'children' => [
                    ['name' => 'عملکرد تعمیرکاران', 'route' => 'reports.technician-performance'],
                    ['name' => 'هزینه تعمیرات', 'route' => 'reports.repair-costs'],
                ]],
                ['name' => 'تنظیمات سیستم', 'route' => 'admin.settings', 'icon' => 'settings'],
            ];
        }
        
        if ($user->isEquipmentManager()) {
            $menu = [
                ['name' => 'داشبورد', 'route' => 'manager.dashboard', 'icon' => 'dashboard'],
                ['name' => 'تجهیزات', 'route' => 'equipment.index', 'icon' => 'tool'],
                ['name' => 'درخواست‌های تعمیر', 'route' => 'repair-requests.index', 'icon' => 'wrench'],
                ['name' => 'تعمیرکاران', 'route' => 'manager.technicians', 'icon' => 'user-group'],
                ['name' => 'گزارشات', 'icon' => 'report', 'children' => [
                    ['name' => 'وضعیت تجهیزات', 'route' => 'reports.equipment-status'],
                    ['name' => 'درخواست‌های تعمیر', 'route' => 'reports.repair-requests'],
                ]],
            ];
        }
        
        // ... (منوهای سایر نقش‌ها)
        
        return $menu;
    }
}