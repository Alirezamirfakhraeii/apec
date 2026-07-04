<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::query()
            ->withCount([
                'posts as published_posts_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('id', 'desc')
            ->get();

        return view('front.news.index', compact('categories'));
    }

    public function show($slug)
    {
        $blogCategory = BlogCategory::query()
            ->where('slug', $slug)
            ->firstOrFail();

        $posts = Post::query()
            ->where('blog_category_id', $blogCategory->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('front.news.show', compact('blogCategory', 'posts'));
    }
}
