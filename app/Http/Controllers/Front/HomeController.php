<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Podcast;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $podcastCategory = BlogCategory::where('slug', 'podcasts')->first();

        $podcastPosts = collect();

        if ($podcastCategory) {
            $podcastPosts = Post::with('mainImage')
                ->where('status', 'published')
                ->where('type', '!=', 'page')
                ->where('blog_category_id', $podcastCategory->id)
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        $homeCategories = BlogCategory::whereIn('slug', ['akhbar-angmn', 'akhbar-kmyth', 'amozsh'])
            ->with(['posts' => function ($query) {
                $query->with('mainImage')
                    ->where('status', 'published')
                    ->where('type', '!=', 'page')
                    ->latest('published_at')
                    ->take(3);
            }])
            ->get();

        $announcementCategory = BlogCategory::where('slug', 'notification')->first();

        $announcementPosts = collect();

        if ($announcementCategory) {
            $announcementPosts = Post::with('mainImage')
                ->where('status', 'published')
                ->where('type', '!=', 'page')
                ->where('blog_category_id', $announcementCategory->id)
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        $podcasts = Podcast::with([
            'category' => function ($query) {
                $query->where('type', 'podcast');
            }
        ])
            ->whereHas('category', function ($query) {
                $query->where('type', 'podcast');
            })
            ->where('status', 'published')
            ->latest('published_at')
            ->get();

        $podcastCategories = $podcasts
            ->pluck('category')
            ->filter()
            ->unique('id')
            ->values();


        $tenderCategory = BlogCategory::where('slug', 'mnaksat')->first();

        $tenders = collect();

        if ($tenderCategory) {
            $tenders = Post::with('mainImage')
                ->where('status', 'published')
                ->where('type', '!=', 'page')
                ->where('blog_category_id', $tenderCategory->id)
                ->latest('published_at')
                ->take(4)
                ->get();
        }


        $magazineCategory = BlogCategory::where('slug', 'oil-and-development-journal')->first();

        $magazinePosts = collect();

        if ($magazineCategory) {
            $magazinePosts = Post::with('mainImage')
                ->where('status', 'published')
                ->where('type', '!=', 'page')
                ->where('blog_category_id', $magazineCategory->id)
                ->latest('published_at')
                ->take(9)
                ->get();
        }

        $featuredPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->latest('published_at')
            ->take(5)
            ->get();

        $mostVisited = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();

        $mostCommented = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->latest('published_at')
            ->take(10)
            ->get();

        $editorsChoice = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latestPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->latest('published_at')
            ->take(10)
            ->get();

        $subjectOfTheDay = Post::with('mainImage')
            ->where('status', 'published')
            ->where('type', '!=', 'page')
            ->latest('published_at')
            ->first();

        return view('front.index', compact(
            'featuredPosts',
            'mostVisited',
            'mostCommented',
            'editorsChoice',
            'latestPosts',
            'subjectOfTheDay',
            'tenders',
            'tenderCategory',
            'homeCategories',
            'announcementPosts',
            'magazinePosts',
            'podcastPosts',
            'podcasts',
            'podcastCategories',
            'announcementCategory'
        ));
    }


    public function show($slug)
    {
        // دریافت خبر، مناقصه، اطلاعیه یا صفحه
        $post = Post::with([
            'user',
            'tags',
            'mainImage',
        ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // ثبت بازدید
        $post->increment('views');

        /*
        |--------------------------------------------------------------------------
        | آخرین مطالب
        |--------------------------------------------------------------------------
        */
        $latestPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->where(function ($query) {
                $query->whereNull('type')
                    ->orWhere('type', '!=', 'page');
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | مطالب منتخب
        |--------------------------------------------------------------------------
        */
        $featuredPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where('blog_category_id', '!=', 6)
            ->where('id', '!=', $post->id)
            ->where(function ($query) {
                $query->whereNull('type')
                    ->orWhere('type', '!=', 'page');
            })
            ->latest('published_at')
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | صفحات داخلی
        |--------------------------------------------------------------------------
        */
        if ($post->type === 'page') {

            return view('front.templates.internal-page', [

                'mode' => 'page',

                'page' => $post,
                'post' => $post,

                'latestPosts' => $latestPosts,
                'featuredPosts' => $featuredPosts,

                'menuItem' => null,
                'currentMenuItem' => null,
                'rootMenuItem' => null,

                'sideMenuItems' => collect(),
                'sidebarItems' => collect(),

                'sidebarTitle' => null,
                'children' => collect(),

                'path' => $post->slug,
                'segments' => [$post->slug],
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | اخبار، مناقصات، اطلاعیه‌ها و گزارش‌ها
        |--------------------------------------------------------------------------
        */
        return view('front.posts.show', compact(
            'post',
            'latestPosts',
            'featuredPosts'
        ));
    }


}
