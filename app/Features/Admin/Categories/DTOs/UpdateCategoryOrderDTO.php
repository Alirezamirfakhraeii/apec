<?php

namespace App\Features\Admin\Categories\DTOs;

use Illuminate\Http\Request;

class UpdateCategoryOrderDTO
{
    public function __construct(
        public array $order,
        public ?int $parentId,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $parentId = $request->input('parent_id');

        if (
            $parentId === null ||
            $parentId === '' ||
            $parentId === 'null' ||
            $parentId === 'undefined'
        ) {
            $parentId = null;
        }

        return new self(
            order: $request->input('order', []),
            parentId: $parentId !== null ? (int) $parentId : null,
        );
    }
}
