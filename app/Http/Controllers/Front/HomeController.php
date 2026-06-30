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
        $post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'tags', 'mainImage'])
            ->firstOrFail();

        $post->increment('views');


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

        $featuredPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where('blog_category_id', '!=',6)
            ->where('id', '!=', $post->id)
            ->where(function ($query) {
                $query->whereNull('type')
                    ->orWhere('type', '!=', 'page');
            })
            ->latest('published_at')
            ->take(8)
            ->get();


        if ($post->type === 'page') {
            return view('front.templates.internal-page', [
                'mode' => 'page',

                // برای قالب internal-page
                'page' => $post,

                // اگر جایی داخل قالب از post استفاده کردی
                'post' => $post,

                // برای سایدبار / آخرین مطالب
                'latestPosts' => $latestPosts,
                'featuredPosts' => $featuredPosts,

                // برای جلوگیری از خطای undefined در قالب‌های داینامیک
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
        | اگر خبر / گزارش / اطلاعیه / رویداد بود
        |--------------------------------------------------------------------------
        */

        return view('front.posts.show', compact(
            'post',
            'latestPosts',
            'featuredPosts'
        ));
    }

}
