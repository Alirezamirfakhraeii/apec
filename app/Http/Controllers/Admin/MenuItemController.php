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
use DeleteMenuItemAction;
use Illuminate\Support\Facades\Cache;

class MenuItemController extends Controller
{
    public function index(GetMenuItemsIndexDataQuery $query)
    {
        return view('back.admin.menu_items.index', $query->handle());
    }

    public function store(StoreMenuItemRequest $request, StoreMenuItemAction $action)
    {
        $data = StoreMenuItemDTO::fromRequest($request);
        $action->handle($data);
        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ایجاد شد.');
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem, UpdateMenuItemAction $action)
    {
        $data = UpdateMenuItemDTO::fromRequest($request);
        $action->handle($menuItem, $data);
        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ویرایش شد.');
    }


    public function destroy(MenuItem $menuItem, DeleteMenuItemAction $action)
    {
        $action->handle($menuItem);
        return redirect()
            ->back()
            ->with('success', 'آیتم فهرست با موفقیت حذف شد.');
    }
}
