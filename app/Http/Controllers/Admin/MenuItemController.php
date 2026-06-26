<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\MenuItems\Actions\StoreMenuItemAction;
use App\Features\Admin\MenuItems\Actions\UpdateMenuItemAction;
use App\Features\Admin\MenuItems\DTOs\StoreMenuItemDTO;
use App\Features\Admin\MenuItems\DTOs\UpdateMenuItemDTO;
use App\Features\Admin\MenuItems\Queries\GetMenuItemsIndexDataQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItems\StoreMenuItemRequest;
use App\Http\Requests\Admin\MenuItems\UpdateMenuItemRequest;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use App\Features\Admin\MenuItems\Actions\DeleteMenuItemAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MenuItemController extends Controller
{
    public function index(GetMenuItemsIndexDataQuery $query)
    {
        return view('back.admin.menu_items.index', $query->handle());
    }

    public function store(StoreMenuItemRequest $request, StoreMenuItemAction $action)
    {
        $data = StoreMenuItemDTO::fromRequest($request);
        $action->execute($data);
        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ایجاد شد.');
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem, UpdateMenuItemAction $action)
    {
        $data = UpdateMenuItemDTO::fromRequest($request);
        $action->execute($menuItem, $data);
        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ویرایش شد.');
    }

    public function destroy(MenuItem $menuItem, DeleteMenuItemAction $action)
    {
        $action->execute($menuItem);
        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت حذف شد.');
    }

    public function update_order(Request $request)
    {
        try {
            $request->validate([
                'order' => ['required', 'array'],
                'order.*' => ['required', 'integer', 'exists:menu_items,id'],
                'parent_id' => ['nullable'],
            ]);

            $parentId = $request->input('parent_id');

            if ($parentId === 'null' || $parentId === '' || $parentId === null) {
                $parentId = null;
            } else {
                $parentId = (int) $parentId;
            }

            DB::transaction(function () use ($request, $parentId) {
                foreach ($request->order as $index => $itemId) {
                    MenuItem::where('id', $itemId)->update([
                        'parent_id' => $parentId,
                        'position' => $index + 1,
                    ]);
                }
            });

            return response()->json(['status' => true, 'message' => 'ترتیب منو با موفقیت ذخیره شد.']);
        } catch (\Throwable $e) {
            Log::error('Menu order update failed', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'request' => $request->all(),
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
