<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
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

        $currentMenu = MenuItem::where('type', 'blog_category')
            ->where('target_id', $category->id)
            ->with(['parent', 'children'])
            ->first();



        $sectionMenu = $currentMenu?->parent ?: $currentMenu;

        $sidebarItems = $sectionMenu
            ? $sectionMenu->children()
                ->where('status', true)
                ->orderBy('order')
                ->get()
            : collect();

        $segments = request()->segments();

        return view('front.pages.section', [
            'mode' => 'category',
            'page' => null,
            'category' => $category,
            'posts' => $posts,
            'segments' => $segments,
            'sidebarTitle' => $sectionMenu?->title,
            'sidebarItems' => $sidebarItems,
        ]);
    }
}
