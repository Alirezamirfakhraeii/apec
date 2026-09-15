<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BoardMemberController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyProjectController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactPageController;
use App\Http\Controllers\Admin\CompanyReportController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MembershipApplicationController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware([
    'auth',
    'role:admin|it_specialist|association_secretary|membership_chair|board_chairman',
])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | مدیریت کاربران و دسترسی‌ها
        |--------------------------------------------------------------------------
        */

        Route::resource('user', UserController::class);

        Route::resource('roles', RoleController::class)
            ->except(['create', 'show', 'edit']);

        /*
        |--------------------------------------------------------------------------
        | مدیریت اعضا
        |--------------------------------------------------------------------------
        */

        Route::get(
            '/companies/export',
            [CompanyController::class, 'export']
        )->name('companies.export');


        Route::post('company/import-excel', [CompanyController::class, 'importExcel'])
            ->name('company.import-excel');
        // باید قبل از resource باشد تا reports به‌عنوان شناسه عضو شناخته نشود.
        Route::get('company/reports', [CompanyReportController::class, 'index'])
            ->name('company.reports');

        Route::resource('company', CompanyController::class);

        Route::get(
            '/membership-applications',
            [MembershipApplicationController::class, 'index']
        )->name('membership-applications.index');

        Route::get(
            '/membership-applications/{application}',
            [MembershipApplicationController::class, 'show']
        )->name('membership-applications.show');

        Route::post(
            '/membership-applications/{application}/route',
            [
                MembershipApplicationController::class,
                'routeToStage',
            ]
        )->name('membership-applications.route');

        Route::patch(
            '/membership-applications/{application}/status',
            [
                MembershipApplicationController::class,
                'updateStatus',
            ]
        )->name('membership-applications.status.update');


        Route::get(
            '/membership-applications/{application}/edit',
            [
                MembershipApplicationController::class,
                'edit',
            ]
        )->name('membership-applications.edit');


        Route::put(
            '/membership-applications/{application}',
            [
                MembershipApplicationController::class,
                'update',
            ]
        )->name('membership-applications.update');

        Route::post(
            '/membership-applications/{application}/review',
            [
                MembershipApplicationController::class,
                'review',
            ]
        )->name('membership-applications.review');


        /*
        |--------------------------------------------------------------------------
        | مدیریت محتوا
        |--------------------------------------------------------------------------
        */

        Route::resource('posts', PostController::class);

        Route::resource('contact-pages', ContactPageController::class)
            ->except('show');

        Route::resource('board-members', BoardMemberController::class)
            ->except('show');

        Route::post('categories/update-order', [CategoryController::class, 'update_order'])
            ->name('categories.update_order');

        Route::resource('categories', CategoryController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('blog-categories', BlogCategoryController::class)
            ->except(['create', 'show', 'edit', 'update']);

        Route::resource('podcasts', PodcastController::class);

        /*
        |--------------------------------------------------------------------------
        | پیام‌های تماس با ما
        |--------------------------------------------------------------------------
        */

        Route::get('contacts', [ContactController::class, 'index'])
            ->name('contacts.index');

        Route::get('contacts/{contact}', [ContactController::class, 'show'])
            ->name('contacts.show');

        /*
        |--------------------------------------------------------------------------
        | تنظیمات
        |--------------------------------------------------------------------------
        */

        Route::get('settings', [SettingController::class, 'edit'])
            ->name('settings.edit');

        Route::post('settings', [SettingController::class, 'update'])
            ->name('settings.update');

        /*
        |--------------------------------------------------------------------------
        | صفحات
        |--------------------------------------------------------------------------
        */

        Route::resource('pages', PageController::class);

        Route::post('ckeditor/upload', [PostController::class, 'upload'])->name('ckeditor.upload');

        /*
        |--------------------------------------------------------------------------
        | مدیریت منوها
        |--------------------------------------------------------------------------
        */

        Route::post('menu-items/update-order', [MenuItemController::class, 'update_order'])
            ->name('menu-items.update-order');

        Route::resource('menu-items', MenuItemController::class)
            ->except(['create', 'show', 'edit']);


        Route::get('/media', [MediaController::class, 'index'])
            ->name('media.index');

        Route::post('/media', [MediaController::class, 'store'])
            ->name('media.store');

        Route::patch('/media/{media}', [MediaController::class, 'update'])
            ->name('media.update');

        Route::delete('/media/{media}', [MediaController::class, 'destroy'])
            ->name('media.destroy');



        Route::resource('company-projects', CompanyProjectController::class);



    });
