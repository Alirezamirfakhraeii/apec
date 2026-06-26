<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'body'             => ['nullable', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status'           => ['required', 'boolean'],
        ]);

        $data['slug'] = $this->normalizeSlug($data['slug'] ?? null, $data['title']);

        $this->ensureSlugIsUnique($data['slug']);

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
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255'],
            'summary'          => ['nullable', 'string'],
            'body'             => ['nullable', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status'           => ['required', 'boolean'],
        ]);

        $data['slug'] = $this->normalizeSlug($data['slug'] ?? null, $data['title']);

        $this->ensureSlugIsUnique($data['slug'], $page->id);

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

    private function normalizeSlug(?string $slug, string $title): string
    {
        $slug = trim((string) $slug);
        if ($slug === '') {
            $slug = Str::slug($title);
        }
        if ($slug === '') {
            $slug = 'page-' . Str::random(8);
        }
        $slug = preg_replace('#^https?://[^/]+#i', '', $slug);
        $appUrl = config('app.url');

        if ($appUrl) {
            $slug = str_replace($appUrl, '', $slug);
        }

        $slug = trim($slug);
        $slug = trim($slug, '/');
        $slug = preg_replace('/\s+/', '-', $slug);
        $slug = preg_replace('#/+#', '/', $slug);
        return $slug;
    }

    private function ensureSlugIsUnique(string $slug, ?int $ignoreId = null): void
    {
        $exists = Page::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            })
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'slug' => 'این آدرس قبلاً برای صفحه دیگری ثبت شده است.',
            ]);
        }
    }
}
