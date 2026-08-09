<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BoardMember;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function boardOfDirectors()
    {
        $page = Page::where('slug', 'board-of-directors')->first();

        $members = BoardMember::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('front.board-members.index', compact('page', 'members'));
    }

    public function show(string $slug)
    {
        $page = Page::query()
            ->with('media')
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $templates = config('page_templates');

        $template = $templates[$page->template]
            ?? $templates['default'];

        $pageData = $page->template_data ?? [];


        return view($template['view'], [
            'page' => $page,
            'pageData' => $pageData,
        ]);
    }

}
