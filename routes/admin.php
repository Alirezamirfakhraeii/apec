<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);

    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);

    Route::resource('posts', PostController::class);
    Route::get('posts/tags-ajax', [PostController::class, 'getTagsAjax'])->name('posts.tags_ajax'); // راوت سرچ هشتگ


    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::post('/categories/update-order', [CategoryController::class, 'update_order'])->name('categories.update_order');
    Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::resource('blog-categories', BlogCategoryController::class)->except(['create', 'show', 'edit', 'update']);

    Route::resource('podcasts', PodcastController::class);

    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');

    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');

    Route::get('/settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');


    Route::post('menu-items/update-order', [MenuItemController::class, 'update_order'])->name('menu-items.update-order');
    Route::resource('menu-items', MenuItemController::class)->except(['create', 'show', 'edit']);

});
