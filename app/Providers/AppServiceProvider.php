<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('front.layouts.partials.header', function ($view) {

            // ذخیره در کش برای همیشه (تا زمانی که در کنترلر پاک شود)
            $frontCategories = Cache::rememberForever('global_front_categories', function () {
                return Category::with(['children' => function($query) {
                    // ۱. زیردسته‌ها را بر اساس پوزیشن به صورت صعودی مرتب کن
                    $query->where('status', 1)->orderBy('position', 'asc');
                }])
                    ->whereNull('parent_id')
                    ->where('status', 1)
                    // ۲. دسته‌های اصلی را هم بر اساس پوزیشن به صورت صعودی مرتب کن
                    ->orderBy('position', 'asc')
                    ->get();
            });

            $view->with('frontCategories', $frontCategories);
        });
    }
}
