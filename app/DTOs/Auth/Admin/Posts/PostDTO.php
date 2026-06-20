<?php

namespace App\DTOs\Auth\Admin\Posts;

use App\Http\Requests\Admin\Blog\StorePostRequest;
use Illuminate\Http\UploadedFile;

class PostDTO
{
    public function __construct(
        public readonly string        $title,
        public readonly ?string       $summary,
        public readonly string        $body,
        public readonly int           $blog_category_id,
        public readonly ?UploadedFile $image,
        public readonly ?string       $meta_title,
        public readonly ?string       $meta_description,
        public readonly string        $status,
        public readonly ?string       $tags,
        public ?string                $published_at,

    )
    {
    }

    public static function fromRequest(StorePostRequest $request): self
    {
        return new self(
            title: $request->validated('title'),
            summary: $request->validated('summary'),
            body: $request->validated('body'),
            blog_category_id: (int)$request->validated('blog_category_id'),
            image: $request->file('image'),
            meta_title: $request->validated('meta_title'),
            meta_description: $request->validated('meta_description'),
            status: $request->validated('status'),
            tags: $request->validated('tags'),
            published_at: $request->validated('published_at'),

        );
    }
}
