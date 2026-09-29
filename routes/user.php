<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\User\Dashboard\MembershipTrackingController;
use App\Http\Controllers\Front\User\Dashboard\ProfileController;
use App\Http\Controllers\Front\User\Dashboard\TicketController;
use App\Http\Controllers\Front\User\MembershipApplicationController;
use App\Http\Controllers\Front\User\MembershipIntakeController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard',DashboardController::class)->name('dashboard');
    Route::get('/membership-request',[MembershipIntakeController::class,'show'])->name('membership.create');
    Route::post('/membership-request/intake',[MembershipIntakeController::class,'store'])->name('membership.intake.store');
    Route::get('/membership-request/{application}/basic',[MembershipApplicationController::class,'basic'])->name('membership.basic');
    Route::put('/membership-request/{application}/basic',[MembershipApplicationController::class,'updateBasicCompanyInfo'])->name('membership.basic.update');
    Route::get('/membership-request/{application}/registration',[MembershipApplicationController::class,'registration'])->name('membership.registration');
    Route::put('/membership-request/{application}/registration',[MembershipApplicationController::class,'updateRegistrationInfo'])->name('membership.registration.update');
    Route::get('/membership-request/{application}/qualifications',[MembershipApplicationController::class,'qualifications'])->name('membership.qualifications');
    Route::put('/membership-request/{application}/qualifications',[MembershipApplicationController::class,'updateQualifications'])->name('membership.qualifications.update');
    Route::get('/membership-request/{application}/review',[MembershipApplicationController::class,'review'])->name('membership.review');
    Route::post('/membership-request/{application}/submit',[MembershipApplicationController::class,'submit'])->name('membership.submit');
    Route::get('/membership-request/{application}/status', [MembershipApplicationController::class, 'status'])->name('membership.status');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/reply', [TicketController::class, 'reply'])->name('tickets.reply');


    Route::delete(
        '/tickets/{ticket}',
        [TicketController::class, 'destroy']
    )->name('tickets.destroy');
    Route::get('/membership/tracking', [MembershipTrackingController::class, 'index'])->name('membership.tracking');
});
