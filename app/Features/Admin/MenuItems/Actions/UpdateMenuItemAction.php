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
    public function execute(
        MenuItem $menuItem,
        UpdateMenuItemDTO $data
    ): MenuItem {

        $updatedMenuItem = DB::transaction(function () use ($menuItem, $data) {

            /*
            |--------------------------------------------------------------------------
            | Resolve target
            |--------------------------------------------------------------------------
            */

            $targetType = $this->resolveTargetType($data);
            $targetId = $this->resolveTargetId($data);

            /*
            |--------------------------------------------------------------------------
            | Update Menu Item
            |--------------------------------------------------------------------------
            */

            $payload = [
                'title' => $data->title,
                'type' => $data->type,

                'url' => in_array(
                    $data->type,
                    ['custom', 'category', 'page', 'post'],
                    true
                )
                    ? $data->url
                    : null,

                'target_type' => $targetType,
                'target_id' => $targetId,

                'route_name' => $data->type === 'route'
                    ? $data->routeName
                    : null,

                'route_params' => $data->type === 'route'
                    ? $data->routeParams
                    : null,

                'icon' => $data->icon,
                'status' => $data->status,
                'open_in_new_tab' => $data->openInNewTab,
            ];

            $menuItem->update($payload);

            /*
            |--------------------------------------------------------------------------
            | Page Template
            |--------------------------------------------------------------------------
            |
            | اگر آیتم منو به Page متصل باشد، بر اساس چک‌باکس 3D Book
            | قالب همان Page تغییر می‌کند.
            |
            */

            if (
                $data->type === 'page' &&
                $targetId
            ) {
                $page = Page::findOrFail($targetId);

                $page->update([
                    'template' => $data->use3dBook
                        ? '3d-book'
                        : 'default',
                ]);
            }

            return $menuItem->fresh();
        });

        /*
        |--------------------------------------------------------------------------
        | Clear Menu Cache
        |--------------------------------------------------------------------------
        */

        Cache::forget('global_front_menu_items');

        return $updatedMenuItem;
    }

    private function resolveTargetType(UpdateMenuItemDTO $data): ?string
    {
        return match ($data->type) {
            'category' => \App\Models\Category::class,
            'page' => \App\Models\Page::class,
            'post' => \App\Models\Post::class,
            default => null,
        };
    }

    private function resolveTargetId(UpdateMenuItemDTO $data): ?int
    {
        return in_array(
            $data->type,
            ['category', 'page', 'post'],
            true
        )
            ? $data->targetId
            : null;
    }

}
