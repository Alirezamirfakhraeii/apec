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
                ->where('blog_category_id', $podcastCategory->id)
                ->latest('published_at')
                ->take(5)
                ->get();
        }

        $homeCategories = BlogCategory::whereIn('slug', ['akhbar-angmn', 'akhbar-kmyth', 'amozsh'])
            ->with(['posts' => function ($query) {
                $query->with('mainImage')
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->take(3);
            }])
            ->get();


        $announcementCategory = BlogCategory::where('slug', 'atlaaa-rsany')->first();

        $announcementPosts = collect();

        if ($announcementCategory) {
            $announcementPosts = Post::with('mainImage')
                ->where('status', 'published')
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

        $magazineCategory = BlogCategory::where('slug', 'nshryh-nft-o-tosaah')->first();

        $magazinePosts = collect();

        if ($magazineCategory) {
            $magazinePosts = Post::with('mainImage')
                ->where('status', 'published')
                ->where('blog_category_id', $magazineCategory->id)
                ->latest('published_at')
                ->take(9)
                ->get();
        }

        $featuredPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        $mostVisited = Post::with('mainImage')
            ->where('status', 'published')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();


        $mostCommented = Post::with('mainImage')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(10)
            ->get();

        $editorsChoice = Post::with('mainImage')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(10)
            ->get();

        $latestPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(10)
            ->get();

        $subjectOfTheDay = Post::with('mainImage')
            ->where('status', 'published')
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
            ->with(['user', 'tags'])
            ->firstOrFail();

        $post->increment('views');

        $latestPosts = Post::where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $featuredPosts = Post::where('status', 'published')
            ->latest('published_at')
            ->take(8)
            ->get();

        return view('front.posts.show', compact('post', 'latestPosts', 'featuredPosts'));
    }


    public function test()
    {
        return view('front.test');
    }

    public function menu()
    {
        return view('front.menu');
    }



}
