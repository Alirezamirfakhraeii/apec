<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{

    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        $posts = Post::where('category_id', $category->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(12);

        return view('front.categories.show', compact('category', 'posts'));
    }

}
