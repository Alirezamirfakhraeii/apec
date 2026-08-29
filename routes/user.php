<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\MembershipApplicationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get(
        '/membership-request',
        [MembershipApplicationController::class, 'create']
    )->name('membership.create');

    Route::post(
        '/membership-request',
        [MembershipApplicationController::class, 'store']
    )->name('membership.store');

    Route::get(
        '/membership-request/{application}/edit',
        [MembershipApplicationController::class, 'edit']
    )->name('membership.edit');
});
