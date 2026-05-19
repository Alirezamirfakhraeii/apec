<?php

use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
require __DIR__.'/user.php';




Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');



