<?php

namespace App\Features\Admin\Posts\DTOs;

use App\Http\Requests\Admin\Blog\StorePostRequest;
use Illuminate\Http\UploadedFile;

class PostDTO
{
    public function __construct(
        public readonly string        $title,
        public readonly ?string       $summary,
        public readonly string        $body,
        public readonly ?int          $blog_category_id,
        public readonly ?UploadedFile $image,
        public readonly ?string       $meta_title,
        public readonly ?string       $meta_description,
        public readonly string        $status,
        public readonly ?string       $tags,
        public readonly ?string       $type,
        public ?string                $published_at,
    ) {
    }

    public static function fromRequest(StorePostRequest $request): self
    {
        $validated = $request->validated();

        $type = $validated['type'] ?? 'news';

        $blogCategoryId = null;

        if ($type !== 'page' && ! empty($validated['blog_category_id'])) {
            $blogCategoryId = (int) $validated['blog_category_id'];
        }

        return new self(
            title: $validated['title'],
            summary: $validated['summary'] ?? null,
            body: $validated['body'],
            blog_category_id: $blogCategoryId,
            image: $request->file('image'),
            meta_title: $validated['meta_title'] ?? null,
            meta_description: $validated['meta_description'] ?? null,
            status: $validated['status'],
            tags: $validated['tags'] ?? null,
            type: $type,
            published_at: $validated['published_at'] ?? null,
        );
    }
}
