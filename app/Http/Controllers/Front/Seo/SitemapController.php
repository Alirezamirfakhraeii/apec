<?php

namespace App\Http\Controllers\Front\Seo;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Page;
use App\Models\Podcast;
use App\Models\Post;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $posts = $this->getPosts();

        $categories = $this->getCategories();

        $podcasts = $this->getPodcasts();

        $pages = $this->getPages();

        return response()
            ->view(
                'front.seo.sitemap',
                compact(
                    'posts',
                    'categories',
                    'podcasts',
                    'pages'
                )
            )
            ->header(
                'Content-Type',
                'application/xml; charset=UTF-8'
            );
    }


    // خبرهای منتشرشده
    private function getPosts()
    {
        return Post::query()
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->whereNotNull('slug')
            ->where(function ($query) {
                $query
                    ->whereNull('published_at')
                    ->orWhere(
                        'published_at',
                        '<=',
                        now()
                    );
            })
            ->latest('updated_at')
            ->get([
                'id',
                'slug',
                'updated_at',
            ]);
    }


    // دسته‌بندی‌های دارای خبر
    private function getCategories()
    {
        return BlogCategory::query()
            ->whereNotNull('slug')
            ->whereHas(
                'posts',
                function ($query) {
                    $query
                        ->where(
                            'status',
                            'published'
                        )
                        ->where(
                            'type',
                            '!=',
                            'page'
                        );
                }
            )
            ->latest('updated_at')
            ->get([
                'id',
                'slug',
                'updated_at',
            ]);
    }


    // پادکست‌های منتشرشده
    private function getPodcasts()
    {
        if (!Route::has('front.podcasts.show')) {
            return collect();
        }

        return Podcast::query()
            ->where('status', 'published')
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get([
                'id',
                'slug',
                'updated_at',
            ]);
    }


    // صفحات عمومی
    private function getPages()
    {
        if (!Route::has('front.pages.show')) {
            return collect();
        }

        return Page::query()
            ->whereNotNull('slug')
            ->latest('updated_at')
            ->get([
                'id',
                'slug',
                'updated_at',
            ]);
    }
}
