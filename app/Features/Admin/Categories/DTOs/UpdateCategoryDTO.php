<?php

namespace App\Features\Admin\Categories\DTOs;

use Illuminate\Http\Request;


class UpdateCategoryDTO
{
    public function __construct(
        public string $title,
        public ?int $parentId,
        public int $status,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: trim($request->input('title')),
            parentId: $request->filled('parent_id') ? (int) $request->input('parent_id') : null,
            status: (int) $request->input('status'),
        );
    }

    public function slug(): string
    {
        return str_replace(' ', '-', trim($this->title));
    }
}
