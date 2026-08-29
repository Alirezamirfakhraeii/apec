<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Front\BlogCategoryController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\CompanyController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\DynamicPageController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\MediaDownloadController;
use App\Http\Controllers\Front\NewsController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\PodcastController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';


Route::get('/', [HomeController::class, 'index'])->name('home');




Route::get('/page/{slug}', [PageController::class, 'show'])->name('front.pages.show');
Route::get('/posts/{slug}', [HomeController::class, 'show'])->name('front.posts.show');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('front.categories.show');
Route::get('/blog/category/{slug}', [BlogCategoryController::class, 'show'])->name('front.blog-categories.show');


Route::get('/news', [NewsController::class, 'index'])
    ->name('front.news.index');

Route::get('/news/{slug}', [NewsController::class, 'show'])
    ->name('front.news.show');

Route::get('/podcasts', [PodcastController::class, 'archive'])
    ->name('front.podcasts.archive');

Route::get('/contact-us', [ContactController::class, 'index'])->name('front.contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('front.contact.store');

Route::get('/association/members', [CompanyController::class, 'index'])
    ->name('companies.index');


Route::get('/contact', [ContactController::class, 'show'])->name('front.contact');


Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['fa', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');


Route::get(
    '/board-of-directors',
    [PageController::class, 'boardOfDirectors']
)->name('front.board-of-directors');


Route::get(
    '/media/{media}/download',
    [MediaDownloadController::class, 'download']
)->name('media.download');


Route::get('/media/pdf/{id}', function ($id) {

    $media = \App\Models\Media::findOrFail($id);

    abort_unless(
        $media->mime_type === 'application/pdf',
        404
    );

    $disk = $media->disk ?: 'public';

    abort_unless(
        \Illuminate\Support\Facades\Storage::disk($disk)
            ->exists($media->path),
        404
    );

    $content = \Illuminate\Support\Facades\Storage::disk($disk)
        ->get($media->path);

    return response(
        $content,
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Length' => strlen($content),
            'Content-Disposition' => 'inline',
            'Accept-Ranges' => 'none',
        ]
    );

})->name('media.pdf');


Route::get('/route-test', function () {
    return 'ROUTE OK';
});


/*
|--------------------------------------------------------------------------
| این Route حتماً باید آخرین Route باشد
|--------------------------------------------------------------------------
*/

Route::get(
    '/{path}',
    [DynamicPageController::class, 'show']
)
    ->where('path', '.*')
    ->name('front.dynamic');
