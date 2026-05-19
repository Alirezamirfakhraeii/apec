<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminLoginController::class, 'login']);

});

Route::post('admin/logout', [AdminLoginController::class, 'logout'])
    ->name('admin.logout')
    ->middleware(['auth', 'role:admin']);
