<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Podcasts\Actions\StorePodcastAction;
use App\Features\Admin\Podcasts\Actions\UpdatePodcastAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Podcasts\StorePodcastRequest;
use App\Http\Requests\Admin\Podcasts\UpdatePodcastRequest;
use App\Models\Category;
use App\Models\Podcast;
use Illuminate\Support\Facades\Storage;

class PodcastController extends Controller
{
    public function index()
    {
        $podcasts = Podcast::with('category')->latest()->paginate(10);
        return view('back.admin.podcasts.index', compact('podcasts'));
    }

    public function create()
    {
        $categories = Category::query()
            ->with('children')
            ->orderBy('title')
            ->get();
        return view('back.admin.podcasts.create', compact('categories'));
    }

    public function store(StorePodcastRequest $request, StorePodcastAction $action)
    {

        $action->execute($request->validated());
        return redirect()->route('admin.podcasts.index')->with('success', 'پادکست با موفقیت ذخیره شد.');
    }

    public function edit(Podcast $podcast)
    {
        $categories = Category::all();
        return view('back.admin.podcasts.edit', compact('podcast', 'categories'));
    }

    public function update(UpdatePodcastRequest $request, Podcast $podcast, UpdatePodcastAction $action)
    {
        $action->execute($podcast, $request->validated());

        return redirect()->route('admin.podcasts.index')->with('success', 'پادکست با موفقیت بروزرسانی شد.');
    }

    public function destroy(Podcast $podcast)
    {
        if ($podcast->image) {
            Storage::disk('public')->delete($podcast->image);
        }
        if ($podcast->audio_url) {
            Storage::disk('public')->delete($podcast->audio_url);
        }

        $podcast->delete();
        return redirect()->route('admin.podcasts.index')->with('success', 'پادکست حذف شد.');
    }
}
