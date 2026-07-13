<?php

namespace App\Features\Admin\MenuItems\DTOs;

use App\Http\Requests\Admin\MenuItems\UpdateMenuItemRequest;

class UpdateMenuItemDTO
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

    public static function fromRequest(UpdateMenuItemRequest $request): self
    {
        $type = $request->input('type');

        $rawParentId = $request->input('parent_id');

        return new self(
            title: $request->input('title'),

            type: $type,

            url: $type === 'custom'
                ? $request->input('url')
                : null,

            targetId: in_array($type, ['category', 'post', 'page'], true)
            && $request->filled('target_id')
                ? (int) $request->input('target_id')
                : null,

            routeName: $type === 'route'
                ? $request->input('route_name')
                : null,

            routeParams: $type === 'route'
            && $request->filled('route_params')
                ? json_decode(
                    $request->input('route_params'),
                    true
                )
                : null,

            /*
             * صفر، رشته خالی و null یعنی آیتم ریشه
             */
            parentId: $rawParentId !== null
            && $rawParentId !== ''
            && (int) $rawParentId > 0
                ? (int) $rawParentId
                : null,

            status: (int) $request->input('status'),

            icon: $request->input('icon'),

            openInNewTab: $request->boolean('open_in_new_tab'),
        );
    }
}
