<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(20);

        return view('back.admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('back.admin.pages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug'],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        Page::create($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت ساخته شد.');
    }

    public function edit(Page $page)
    {
        return view('back.admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:pages,slug,' . $page->id],
            'summary' => ['nullable', 'string'],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);

        $page->update($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت ویرایش شد.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'صفحه حذف شد.');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
        ]);

        $path = $request->file('upload')->store('uploads/editor', 'public');

        return response()->json([
            'url' => Storage::url($path),
        ]);
    }
}
