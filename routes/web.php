<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentHistoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// صفحه اصلی (برای کاربران مهمان)
Route::get('/', function () {
    return view('welcome');
});

// مسیرهای احراز هویت
require __DIR__.'/auth.php';

// مسیرهای نیازمند احراز هویت
Route::middleware(['auth', 'verified'])->group(function () {
    // داشبورد
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // پروفایل کاربری
    Route::prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
    });

    // مدیریت تجهیزات
    Route::prefix('/equipment')->name('equipment.')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index');
        Route::get('/create', [EquipmentController::class, 'create'])->name('create');
        Route::post('/', [EquipmentController::class, 'store'])->name('store');
        Route::get('/{equipment}', [EquipmentController::class, 'show'])->name('show');
        Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->name('edit');
        Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('update');
        Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');

        // تاریخچه تجهیزات
        Route::get('/{equipment}/history', [EquipmentHistoryController::class, 'index'])
            ->name('history');
    });

    // درخواست‌های تعمیر
    Route::prefix('/repair-requests')->name('repair-requests.')->group(function () {
        Route::get('/', [RepairRequestController::class, 'index'])->name('index');
        Route::get('/create', [RepairRequestController::class, 'create'])->name('create');
        Route::post('/', [RepairRequestController::class, 'store'])->name('store');
        Route::get('/{repairRequest}', [RepairRequestController::class, 'show'])->name('show');

        // انتساب تعمیرکار
        Route::post('/{repairRequest}/assign', [RepairRequestController::class, 'assignTechnician'])
            ->name('assign');

        // تغییر وضعیت درخواست
        Route::post('/{repairRequest}/status', [RepairRequestController::class, 'updateStatus'])
            ->name('status');

        // کامنت‌ها
        Route::post('/{repairRequest}/comments', [CommentController::class, 'store'])
            ->name('comments.store');
    });

    // مدیریت کامنت‌ها
    Route::prefix('/comments')->name('comments.')->group(function () {
        Route::put('/{comment}', [CommentController::class, 'update'])->name('update');
        Route::delete('/{comment}', [CommentController::class, 'destroy'])->name('destroy');
    });

    // گزارشات
    Route::prefix('/reports')->name('reports.')->group(function () {
        Route::get('/equipment', [ReportController::class, 'equipmentRepairs'])
            ->name('equipment');
        Route::get('/technicians', [ReportController::class, 'technicianPerformance'])
            ->name('technicians');
        Route::get('/monthly', [ReportController::class, 'monthlyReport'])
            ->name('monthly');
    });

    // مدیریت کاربران (فقط برای مدیر سامانه)
    Route::middleware('can:system_admin')->prefix('/users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
