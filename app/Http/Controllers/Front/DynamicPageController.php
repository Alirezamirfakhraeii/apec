<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Support\Facades\View;

class DynamicPageController extends Controller
{
    public function show(string $path)
    {
        $path = $this->normalizePath($path);

        $menuItem = $this->findMenuItemByPath($path);

        if (! $menuItem) {
            abort(404);
        }

        if ($menuItem->type === 'heading') {
            abort(404);
        }

        $template = $this->resolveTemplate($path, $menuItem);

        $segments = $this->segments($path);

        $rootMenuItem = $this->findRootMenuItem($segments);

        $sideMenuItems = $rootMenuItem
            ? $this->getChildren($rootMenuItem->id)
            : collect();

        $children = $this->getChildren($menuItem->id);

        return view($template, [
            'mode' => 'menu_item',

            'menuItem' => $menuItem,
            'currentMenuItem' => $menuItem,
            'rootMenuItem' => $rootMenuItem,
            'sideMenuItems' => $sideMenuItems,
            'children' => $children,

            'path' => $path,
            'segments' => $segments,
        ]);
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path);

        $path = preg_replace('#^https?://[^/]+#i', '', $path);

        $appUrl = config('app.url');

        if ($appUrl) {
            $path = str_replace($appUrl, '', $path);
        }

        $path = trim($path, '/');

        $path = preg_replace('#/+#', '/', $path);

        return $path;
    }

    private function segments(string $path): array
    {
        return array_values(array_filter(explode('/', $path)));
    }

    private function findMenuItemByPath(string $path): ?MenuItem
    {
        return MenuItem::where('url', trim($path, '/'))
            ->where('status', 1)
            ->first();
    }

    private function findRootMenuItem(array $segments): ?MenuItem
    {
        if (empty($segments)) {
            return null;
        }

        return MenuItem::where('url', $segments[0])
            ->where('status', 1)
            ->first();
    }

    private function getChildren(int $parentId)
    {
        return MenuItem::where('parent_id', $parentId)
            ->where('status', 1)
            ->orderBy('position')
            ->get();
    }

    private function resolveTemplate(string $path, MenuItem $menuItem): string
    {
        if (property_exists($menuItem, 'template') && ! empty($menuItem->template)) {
            $template = 'front.templates.' . $menuItem->template;

            if (View::exists($template)) {
                return $template;
            }
        }

        if (str_starts_with($path, 'education')) {
            return View::exists('front.templates.education')
                ? 'front.templates.education'
                : 'front.templates.default';
        }

        if (str_starts_with($path, 'media')) {
            return View::exists('front.templates.media')
                ? 'front.templates.media'
                : 'front.templates.default';
        }

        return View::exists('front.templates.default')
            ? 'front.templates.default'
            : 'front.templates.education';
    }
}
