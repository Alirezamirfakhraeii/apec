<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->filled('q')) {
            $q = $request->q;

            $query->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%");
            });
        }

        if ($request->filled('template')) {
            $query->where('template', $request->template);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        $pages = $query
            ->latest()
            ->paginate(10)
            ->appends($request->query());

        $templates = config('page_templates');

        return view('back.admin.pages.index', compact('pages', 'templates'));
    }

    public function create()
    {
        $templates = config('page_templates', []);


        $selectedTemplate = old('template', 'default');

        $templateFields = $templates[$selectedTemplate]['fields'] ?? [];

        $page = new Page();

        return view('back.admin.pages.create', compact(
            'page',
            'templates',
            'templateFields'
        ));
    }

    public function store(Request $request)
    {
        $templates = config('page_templates');
        $allowedTemplates = array_keys($templates);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'summary' => ['nullable', 'string'],
            'template' => ['required', 'string', Rule::in($allowedTemplates)],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],
        ]);

        $page = Page::create([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'summary' => $data['summary'] ?? null,
            'template' => $data['template'],
            'template_data' => [],
            'body' => $data['body'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'صفحه با موفقیت ساخته شد. حالا فیلدهای مخصوص تمپلیت را تکمیل کنید.');
    }

    public function edit(Page $page)
    {
        $templates = config('page_templates');

        $currentTemplate = $templates[$page->template] ?? $templates['default'];
        $templateFields = $currentTemplate['fields'] ?? [];

        return view('back.admin.pages.edit', compact('page', 'templates', 'templateFields'));
    }

    public function update(Request $request, Page $page)
    {
        $templates = config('page_templates', []);
        $allowedTemplates = array_keys($templates);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('pages', 'slug')->ignore($page->id),
            ],
            'summary' => ['nullable', 'string'],
            'template' => ['required', 'string', Rule::in($allowedTemplates)],
            'body' => ['nullable', 'string'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string'],
            'status' => ['nullable', 'boolean'],

            'template_data' => ['nullable', 'array'],
            'template_files' => ['nullable', 'array'],
            'template_files.*' => ['nullable', 'image', 'max:5120'],
        ]);

        $templateData = $page->template_data ?? [];

        foreach ($request->input('template_data', []) as $key => $value) {
            $templateData[$key] = $value;
        }

        foreach ($request->file('template_files', []) as $key => $file) {
            if ($file && $file->isValid()) {
                $path = $file->store('pages/template-files', 'public');

                $templateData[$key] = $path;
            }
        }

        $page->update([
            'title' => $data['title'],
            'slug' => $data['slug'],
            'summary' => $data['summary'] ?? null,
            'template' => $data['template'],
            'template_data' => $templateData,
            'body' => $data['body'] ?? null,
            'meta_title' => $data['meta_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        return redirect()
            ->route('admin.pages.edit', $page)
            ->with('success', 'صفحه با موفقیت ویرایش شد.');
    }

    public function destroy(Page $page)
    {
        $templateData = $page->template_data ?? [];

        foreach ($templateData as $value) {
            if (is_string($value) && Storage::disk('public')->exists($value)) {
                Storage::disk('public')->delete($value);
            }
        }

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت حذف شد.');
    }
}
