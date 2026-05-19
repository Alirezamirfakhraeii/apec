<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

// اضافه کردن پریفیکس admin به کل روت‌های این فایل
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin') // <- پریفیکس اضافه شد
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });
