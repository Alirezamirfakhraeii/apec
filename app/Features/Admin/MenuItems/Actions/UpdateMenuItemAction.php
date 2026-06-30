<?php

namespace App\Features\Admin\MenuItems\Actions;

use App\Features\Admin\MenuItems\DTOs\UpdateMenuItemDTO;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UpdateMenuItemAction
{
    public function execute(MenuItem $menuItem, UpdateMenuItemDTO $data): MenuItem
    {
        $updatedMenuItem = DB::transaction(function () use ($menuItem, $data) {
            $payload = [
                'title' => $data->title,
                'type' => $data->type,

                // برای route و heading آدرس لازم نیست
                // ولی برای page/category/post/custom آدرس لازمه چون DynamicPageController با url پیدا می‌کند
                'url' => in_array($data->type, ['custom', 'category', 'page', 'post'], true)
                    ? $data->url
                    : null,

                'target_type' => $this->resolveTargetType($data),
                'target_id' => $this->resolveTargetId($data),

                'route_name' => $data->type === 'route'
                    ? $data->routeName
                    : null,

                'route_params' => $data->type === 'route'
                    ? $data->routeParams
                    : null,

                'icon' => $data->icon,
                'parent_id' => $data->parentId,
                'status' => $data->status,
                'open_in_new_tab' => $data->openInNewTab,
            ];

            if ($menuItem->parent_id !== $data->parentId) {
                $lastPosition = MenuItem::where('parent_id', $data->parentId)
                    ->max('position') ?? 0;

                $payload['position'] = $lastPosition + 1;
            }

            $menuItem->update($payload);

            return $menuItem->fresh();
        });

        Cache::forget('global_front_menu_items');

        return $updatedMenuItem;
    }

    private function resolveTargetType(UpdateMenuItemDTO $data): ?string
    {
        return match ($data->type) {
            'category' => Category::class,
            'post' => Post::class,
            'page' => Page::class,
            default => null,
        };
    }

    private function resolveTargetId(UpdateMenuItemDTO $data): ?int
    {
        return in_array($data->type, ['category', 'post', 'page'], true)
            ? $data->targetId
            : null;
    }
}
