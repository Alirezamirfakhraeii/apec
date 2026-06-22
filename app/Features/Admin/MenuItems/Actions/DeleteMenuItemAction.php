<?php

use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DeleteMenuItemAction
{
    public function handle(MenuItem $menuItem): void
    {
        DB::transaction(function () use ($menuItem) {
            $parentId = $menuItem->parent_id;

            $children = MenuItem::query()
                ->where('parent_id', $menuItem->id)
                ->orderBy('position')
                ->lockForUpdate()
                ->get();

            $lastPosition = MenuItem::query()
                ->when(
                    $parentId === null,
                    fn ($query) => $query->whereNull('parent_id'),
                    fn ($query) => $query->where('parent_id', $parentId)
                )
                ->where('id', '!=', $menuItem->id)
                ->lockForUpdate()
                ->max('position') ?? 0;

            foreach ($children as $index => $child) {
                $child->update([
                    'parent_id' => $parentId,
                    'position'  => $lastPosition + $index + 1,
                ]);
            }

            $menuItem->delete();

            $this->reorderPositions($parentId);
        });

        Cache::forget('global_front_menu_items');
    }

    private function reorderPositions(?int $parentId): void
    {
        MenuItem::query()
            ->when(
                $parentId === null,
                fn ($query) => $query->whereNull('parent_id'),
                fn ($query) => $query->where('parent_id', $parentId)
            )
            ->orderBy('position')
            ->orderBy('id')
            ->get()
            ->each(function (MenuItem $menuItem, int $index) {
                $menuItem->update([
                    'position' => $index + 1,
                ]);
            });
    }
}
