<?php

namespace App\Features\Admin\MenuItems\DTOs;

use App\Http\Requests\Admin\MenuItems\StoreMenuItemRequest;

class StoreMenuItemDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $type,
        public readonly ?string $url,
        public readonly ?int $targetId,
        public readonly ?string $routeName,
        public readonly ?array $routeParams,
        public readonly ?int $parentId,
        public readonly int $status,
        public readonly ?string $icon,
        public readonly bool $openInNewTab,
    ) {
    }

    public static function fromRequest(StoreMenuItemRequest $request): self
    {
        return new self(
            title: $request->input('title'),
            type: $request->input('type'),

            url: $request->input('type') === 'custom'
                ? $request->input('url')
                : null,

            targetId: in_array($request->input('type'), ['category', 'post', 'page'], true)
                ? (int) $request->input('target_id')
                : null,

            routeName: $request->input('type') === 'route'
                ? $request->input('route_name')
                : null,

            routeParams: $request->input('type') === 'route' && $request->filled('route_params')
                ? json_decode($request->input('route_params'), true)
                : null,

            parentId: $request->filled('parent_id')
                ? (int) $request->input('parent_id')
                : null,

            status: (int) $request->input('status'),

            icon: $request->input('icon'),

            openInNewTab: $request->boolean('open_in_new_tab'),
        );
    }
}
