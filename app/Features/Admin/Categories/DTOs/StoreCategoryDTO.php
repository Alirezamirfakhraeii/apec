<?php

namespace App\Features\Admin\Categories\DTOs;

use Illuminate\Http\Request;

class StoreCategoryDTO
{
    public function __construct(
        public string  $title,
        public ?int    $parentId,
        public int     $status,
        public ?string $type,
    )
    {
    }

    public static function fromRequest(Request $request): self
    {
        return new self(
            title: trim($request->input('title')),
            parentId: $request->filled('parent_id') ? (int)$request->input('parent_id') : null,
            status: (int)$request->input('status'),
            type: $request->query('type'),
        );
    }

    public function slug(): string
    {
        return str_replace(' ', '-', trim($this->title));
    }
}
