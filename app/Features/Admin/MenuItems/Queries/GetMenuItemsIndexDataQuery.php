<?php

namespace App\Features\Admin\MenuItems\Queries;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Support\Collection;

class GetMenuItemsIndexDataQuery
{
    /**
     * @return array{
     *     categories: Collection,
     *     pages: Collection,
     *     posts: Collection,
     *     menuItems: Collection,
     *     allMenuItems: Collection
     * }
     */
    public function handle(): array
    {
        return [
            'categories'   => $this->getCategories(),
            'pages'        => $this->getPages(),
            'posts'        => $this->getPosts(),
            'menuItems'    => $this->getMenuItems(),
            'allMenuItems' => $this->getAllMenuItems(),
        ];
    }

    private function getCategories(): Collection
    {
        return Category::query()
            ->orderBy('title')
            ->get();
    }

    private function getPages(): Collection
    {
        return collect();
    }

    private function getPosts(): Collection
    {
        return Post::query()
            ->latest()
            ->take(200)
            ->get();
    }

    private function getMenuItems(): Collection
    {
        return MenuItem::query()
            ->whereNull('parent_id')
            ->where('status', 1)
            ->with(['target', 'activeChildren'])
            ->orderBy('position')
            ->get();
    }

    private function getAllMenuItems(): Collection
    {
        return MenuItem::query()
            ->with('parent')
            ->orderBy('position')
            ->get();
    }
}
