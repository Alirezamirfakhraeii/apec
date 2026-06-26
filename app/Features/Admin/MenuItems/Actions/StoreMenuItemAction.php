<?php

namespace App\Features\Admin\MenuItems\Actions;

use App\Features\Admin\MenuItems\DTOs\StoreMenuItemDTO;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StoreMenuItemAction
{
    public function execute(StoreMenuItemDTO $data): MenuItem
    {
        return DB::transaction(function () use ($data) {
            $lastPosition = MenuItem::where('parent_id', $data->parentId)
                ->max('position') ?? 0;

            $menuItem = MenuItem::create([
                'title'           => $data->title,
                'type'            => $data->type,

                'url'             => $this->resolveUrl($data),

                'target_type'     => $this->resolveTargetType($data),
                'target_id'       => $this->resolveTargetId($data),

                'route_name'      => $data->type === 'route'
                    ? $data->routeName
                    : null,

                'route_params'    => $data->type === 'route'
                    ? $data->routeParams
                    : null,

                'icon'            => $data->icon,
                'parent_id'       => $data->parentId,
                'status'          => $data->status,
                'open_in_new_tab' => $data->openInNewTab,
                'position'        => $lastPosition + 1,
            ]);

            Cache::forget('global_front_menu_items');

            return $menuItem;
        });
    }

    private function resolveUrl(StoreMenuItemDTO $data): ?string
    {
        if ($data->type === 'heading') {
            return null;
        }

        if ($data->type === 'route') {
            return null;
        }

        if (!$data->url) {
            return null;
        }

        return trim($data->url, '/');
    }

    private function resolveTargetType(StoreMenuItemDTO $data): ?string
    {
        return match ($data->type) {
            'category' => Category::class,
            'post'     => Post::class,
            'page'     => Page::class,
            default    => null,
        };
    }

    private function resolveTargetId(StoreMenuItemDTO $data): ?int
    {
        return in_array($data->type, ['category', 'post', 'page'], true)
            ? $data->targetId
            : null;
    }
}
