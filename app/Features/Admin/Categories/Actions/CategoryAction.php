<?php

namespace App\Features\Admin\Categories\Actions;


use App\Features\Admin\Categories\DTOs\StoreCategoryDTO;
use App\Features\Admin\Categories\DTOs\UpdateCategoryDTO;
use App\Features\Admin\Categories\DTOs\UpdateCategoryOrderDTO;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoryAction
{
    public function getIndexData(): array
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->get();

        $allCategories = Category::orderBy('title', 'asc')->get();

        return [
            'categories' => $categories,
            'allCategories' => $allCategories,
        ];
    }

    public function store(StoreCategoryDTO $dto): Category
    {
        $lastPositionQuery = Category::query();

        if ($dto->parentId === null) {
            $lastPositionQuery->whereNull('parent_id');
        } else {
            $lastPositionQuery->where('parent_id', $dto->parentId);
        }

        $lastPosition = $lastPositionQuery->max('position') ?? 0;

        $category = Category::create([
            'title' => $dto->title,
            'slug' => $dto->slug(),
            'parent_id' => $dto->parentId,
            'status' => $dto->status,
            'type' => $dto->type,
            'position' => $lastPosition + 1,
        ]);

        Cache::forget('global_front_categories');

        return $category;
    }

    public function update(Category $category, UpdateCategoryDTO $dto): Category
    {
        $category->update([
            'title' => $dto->title,
            'slug' => $dto->slug(),
            'parent_id' => $dto->parentId,
            'status' => $dto->status,
        ]);

        Cache::forget('global_front_categories');

        return $category;
    }

    public function updateOrder(UpdateCategoryOrderDTO $dto): bool
    {
        if (empty($dto->order) || !is_array($dto->order)) {
            return false;
        }

        DB::transaction(function () use ($dto) {
            foreach ($dto->order as $index => $id) {
                DB::table('categories')
                    ->where('id', $id)
                    ->update([
                        'parent_id' => $dto->parentId,
                        'position' => $index + 1,
                    ]);
            }
        });

        Cache::forget('global_front_categories');

        return true;
    }

    public function delete(Category $category): void
    {
        DB::transaction(function () use ($category) {
            Category::where('parent_id', $category->id)
                ->update(['parent_id' => null]);

            $category->delete();
        });

        Cache::forget('global_front_categories');
    }

    public function getAllChildrenIds(Category $category): array
    {
        $ids = [];

        foreach ($category->children as $child) {
            $ids[] = $child->id;

            $ids = array_merge($ids, $this->getAllChildrenIds($child));
        }

        return $ids;
    }
}
