<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Support\Facades\View;

class DynamicPageController extends Controller
{
    public function show(string $path)
    {
        $path = $this->normalizePath($path);

        $menuItem = $this->findMenuItemByPath($path);

        if (! $menuItem || ! $menuItem->status) {
            abort(404);
        }

        if ($menuItem->type === MenuItem::TYPE_HEADING) {
            abort(404);
        }

        $menuItem->load(['target', 'parent']);

        $segments = $this->segments($path);

        $rootMenuItem = $this->findRootMenuItem($segments) ?: $this->findTopParent($menuItem);

        $sideMenuItems = $rootMenuItem
            ? $this->getChildren($rootMenuItem->id)
            : collect();

        $children = $this->getChildren($menuItem->id);

        $mode = 'menu_item';

        $page = null;
        $post = null;
        $category = null;
        $posts = collect();

        /*
        |--------------------------------------------------------------------------
        | اگر منو به Post وصل بود
        |--------------------------------------------------------------------------
        */

        if ($menuItem->type === MenuItem::TYPE_POST && $menuItem->target instanceof Post) {
            $post = $menuItem->target;

            if ($post->type === 'page') {
                $mode = 'page';

                // برای اینکه قالب internal-page با $page کار کند
                $page = $post;
            } else {
                $mode = 'post';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | اگر منو custom بود
        |--------------------------------------------------------------------------
        */

        if ($menuItem->type === MenuItem::TYPE_CUSTOM) {
            $mode = 'custom';
        }

        $latestPosts = Post::with('mainImage')
            ->where('status', 'published')
            ->where(function ($query) {
                $query->whereNull('type')
                    ->orWhere('type', '!=', 'page');
            })
            ->latest('published_at')
            ->take(5)
            ->get();

        $template = $this->resolveTemplate($path, $menuItem, $mode);

        return view($template, [
            'mode' => $mode,

            'page' => $page,
            'post' => $post,
            'category' => $category,
            'posts' => $posts,

            'menuItem' => $menuItem,
            'currentMenuItem' => $menuItem,
            'rootMenuItem' => $rootMenuItem,
            'sideMenuItems' => $sideMenuItems,
            'sidebarItems' => $sideMenuItems,
            'sidebarTitle' => $rootMenuItem?->title,

            'children' => $children,
            'latestPosts' => $latestPosts,

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
        $path = $this->normalizePath($path);

        return MenuItem::with('target')
            ->where('status', 1)
            ->where(function ($query) use ($path) {
                $query->where('url', $path)
                    ->orWhere('url', '/' . $path)
                    ->orWhere('url', $path . '/');
            })
            ->first();
    }

    private function findRootMenuItem(array $segments): ?MenuItem
    {
        if (empty($segments)) {
            return null;
        }

        $firstSegment = $segments[0];

        return MenuItem::where('status', 1)
            ->where(function ($query) use ($firstSegment) {
                $query->where('url', $firstSegment)
                    ->orWhere('url', '/' . $firstSegment);
            })
            ->first();
    }

    private function findTopParent(MenuItem $menuItem): ?MenuItem
    {
        $item = $menuItem;

        while ($item->parent) {
            $item = $item->parent;
        }

        return $item;
    }

    private function getChildren(int $parentId)
    {
        return MenuItem::with('target')
            ->where('parent_id', $parentId)
            ->where('status', 1)
            ->orderBy('position')
            ->get();
    }

    private function resolveTemplate(string $path, MenuItem $menuItem, string $mode): string
    {
        /*
        |--------------------------------------------------------------------------
        | اگر target پست بود و type آن page بود
        |--------------------------------------------------------------------------
        */

        if ($menuItem->target instanceof Post) {
            if ($menuItem->target->type === 'page') {
                return View::exists('front.templates.internal-page.blade.php.php')
                    ? 'front.templates.internal-page'
                    : 'front.templates.default';
            }

            return View::exists('front.posts.show')
                ? 'front.posts.show'
                : 'front.templates.default';
        }

        /*
        |--------------------------------------------------------------------------
        | fallback
        |--------------------------------------------------------------------------
        */

        return View::exists('front.templates.default')
            ? 'front.templates.default'
            : 'front.templates.internal-page';
    }
}
