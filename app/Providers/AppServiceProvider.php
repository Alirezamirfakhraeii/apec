<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
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

        Paginator::useBootstrapFive();




        View::composer('*', function ($view) {
            $frontMenuItems = Cache::remember('global_front_menu_items', now()->addDays(7), function () {
                return MenuItem::with([
                    'target',
                    'activeChildren',
                ])
                    ->whereNull('parent_id')
                    ->where('status', 1)
                    ->orderBy('position', 'asc')
                    ->get();
            });

            $view->with('frontMenuItems', $frontMenuItems);
        });


        View::composer('front.*', function ($view) {
            $view->with([
                'featuredPosts' => Post::where('status', 'published')->latest('published_at')->take(7)->get(),
                'mostVisited'   => Post::where('status', 'published')->orderBy('views', 'desc')->take(10)->get(),
                'latestPosts'   => Post::where('status', 'published')->latest('published_at')->take(10)->get(),
                'mostCommented' => Post::where('status', 'published')->latest('published_at')->take(10)->get(),
                'editorsChoice' => Post::where('status', 'published')->latest('published_at')->take(10)->get(),
                'subjectOfTheDay' => Post::where('status', 'published')->latest('published_at')->first(),
            ]);
        });

        View::composer('front.*', function ($view) {
            $siteSettings = Setting::first() ?? new Setting();

            $footerCategories = Category::take(12)->get();

            $view->with([
                'siteSettings'     => $siteSettings,
                'footerCategories' => $footerCategories
            ]);
        });


    }

}
