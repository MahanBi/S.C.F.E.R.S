<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';
    public const ADMIN_HOME = '/admin/dashboard';

    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
            
            // Web Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            // Admin Routes
            Route::middleware(['web', 'auth', 'role:admin'])
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
            
            // Equipment Manager Routes
            Route::middleware(['web', 'auth', 'role:equipment_manager'])
                ->prefix('manager')
                ->name('manager.')
                ->group(base_path('routes/manager.php'));
            
            // Technician Routes
            Route::middleware(['web', 'auth', 'role:technician'])
                ->prefix('technician')
                ->name('technician.')
                ->group(base_path('routes/technician.php'));
            
            // Equipment Officer Routes
            Route::middleware(['web', 'auth', 'role:equipment_officer'])
                ->prefix('officer')
                ->name('officer.')
                ->group(base_path('routes/officer.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });

        // محدودیت برای ورود به سیستم
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // محدودیت برای ارسال پیام چت
        RateLimiter::for('chat-messages', function (Request $request) {
            return Limit::perMinute(30)->by($request->user()->id);
        });
    }
}