<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Podcast;
use App\Models\Post;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function archive(Request $request)
    {
        $categories = Category::query()
            ->where('type', 'podcast')
            ->withCount([
                'podcasts as published_podcasts_count' => function ($query) {
                    $query->where('status', 'published');
                }
            ])
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $activeCategory = null;

        $podcastsQuery = Podcast::query()
            ->with('category')
            ->where('status', 'published')
            ->latest('published_at');

        if ($request->filled('category')) {
            $activeCategory = Category::query()
                ->where('type', 'podcast')
                ->where('slug', $request->category)
                ->firstOrFail();

            $podcastsQuery->where('category_id', $activeCategory->id);
        }

        $podcasts = $podcastsQuery
            ->paginate(12)
            ->withQueryString();

        return view('front.podcasts.archive', compact(
            'podcasts',
            'categories',
            'activeCategory'
        ));
    }
}
