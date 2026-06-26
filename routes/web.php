<?php

use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DynamicPageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
//require __DIR__.'/user.php';




Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('front.posts.show');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('front.pages.show');

Route::get('/contact-us', [ContactController::class, 'index'])->name('front.contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('front.contact.store');

Route::get('/{path}', [DynamicPageController::class, 'show'])
    ->where('path', '.*')
    ->name('front.dynamic');


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');





