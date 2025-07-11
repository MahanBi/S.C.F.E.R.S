<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // ثبت بایندرهای مخزن
        $this->app->bind(
            \App\Contracts\RepairServiceInterface::class,
            \App\Services\RepairService::class
        );
        
        $this->app->bind(
            \App\Contracts\ChatServiceInterface::class,
            \App\Services\ChatService::class
        );
    }

    public function boot(): void
    {
        // حل مشکل طول کلید برای نسخه‌های قدیمی MySQL
        Schema::defaultStringLength(191);
        
        // استفاده از Bootstrap برای صفحه‌بندی
        Paginator::useBootstrapFive();
        
        // تنظیم لوکال پیش‌فرض
        app()->setLocale('fa');
        
        // تعریف کامپوننت‌های Blade سفارشی
        \Blade::component('components.alert', 'alert');
        \Blade::component('components.card', 'card');
        \Blade::component('components.modal', 'modal');
        
        // تنظیمات مشترک برای تمام ویوها
        view()->composer('*', function ($view) {
            $view->with('currentUser', auth()->user());
            $view->with('systemName', config('app.name'));
        });
    }
}