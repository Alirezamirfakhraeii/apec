<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\MembershipApplicationController;
use App\Http\Controllers\User\MembershipIntakeController;
use Illuminate\Support\Facades\Route;
Route::middleware(['auth','role:user'])->prefix('user')->name('user.')->group(function(){
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
    Route::get(
        '/membership-request/{application}/status',
        [MembershipApplicationController::class, 'status']
    )->name('membership.status');
});
