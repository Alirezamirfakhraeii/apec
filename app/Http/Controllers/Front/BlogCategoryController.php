<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Post;

class BlogCategoryController extends Controller
{

    public function show($slug)
    {

        $category = BlogCategory::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $posts = Post::where('blog_category_id', $category->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('front.blog-categories.show', compact('category', 'posts'));
    }


}
