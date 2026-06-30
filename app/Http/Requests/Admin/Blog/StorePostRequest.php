<?php


namespace App\Http\Requests\Admin\Blog;



use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'body' => 'required|string',
            'blog_category_id' => ['required_unless:type,page', 'nullable', 'exists:blog_categories,id'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'status' => 'required|in:published,draft',
            'tags' => 'nullable|string',
            'type' => 'nullable|string',
            'published_at' => 'nullable|string',
        ];
    }
}
