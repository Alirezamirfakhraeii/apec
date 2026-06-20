<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    /**
     * نمایش لیست فهرست‌ها به همراه دسته‌بندی‌ها برای اتصال
     */
    public function index()
    {
        // دریافت منوهای ریشه (بدون والد) به همراه زیرمنوهایشان با ترتیب پوزیشن
        $menuItems = MenuItem::with('children')
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->get();

        // دریافت همه منوها برای انتخاب والد در فرم‌ها
        $allMenuItems = MenuItem::orderBy('title', 'asc')->get();

        // دریافت همه دسته‌بندی‌ها تا ادمین بتواند آیتم منو را به یک کاتگوری متصل کند
        $categories = Category::orderBy('title', 'asc')->get();

        return view('back.admin.menu_items.index', compact('menuItems', 'allMenuItems', 'categories'));
    }

    /**
     * ذخیره آیتم جدید در فهرست
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:custom,category',
            'url'         => 'required_if:type,custom|nullable|string|max:1000',
            'category_id' => 'required_if:type,category|nullable|exists:categories,id',
            'parent_id'   => 'nullable|exists:menu_items,id',
            'status'      => 'required|in:0,1',
        ]);

        // پیدا کردن آخرین پوزیشن برای چیدمان درست در دیتابیس
        $lastPosition = MenuItem::where('parent_id', $request->parent_id)->max('position') ?? 0;

        MenuItem::create([
            'title'       => $request->title,
            'type'        => $request->type,
            // اگر نوع کاتگوری بود، url را null کن و بالعکس
            'url'         => $request->type === 'custom' ? $request->url : null,
            'category_id' => $request->type === 'category' ? $request->category_id : null,
            'parent_id'   => $request->parent_id,
            'status'      => $request->status,
            'position'    => $lastPosition + 1,
        ]);

        // پاک‌سازی کش فرانت‌اند فهرست‌ها
        Cache::forget('global_front_menu_items');

        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ایجاد شد.');
    }

    /**
     * ویرایش آیتم فهرست
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $parentId = $request->filled('parent_id') ? $request->parent_id : null;

        $data = [
            'title'       => $request->title,
            'type'        => $request->type,
            'url'         => $request->type === 'custom' ? $request->url : null,
            'category_id' => $request->type === 'category' ? $request->category_id : null,
            'parent_id'   => $parentId,
            'status'      => $request->status,
        ];

        if ($menuItem->parent_id != $parentId) {
            $lastPosition = MenuItem::where('parent_id', $parentId)->max('position') ?? 0;
            $data['position'] = $lastPosition + 1;
        }

        $menuItem->update($data);

        Cache::forget('global_front_menu_items');

        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت ویرایش شد.');
    }

    /**
     * به‌روزرسانی ترتیب چیدمان منوها به صورت Drag & Drop و AJAX
     */
    public function update_order(Request $request)
    {
        $order = $request->input('order');
        $parentId = $request->input('parent_id');

        if ($parentId === 'null' || $parentId === 'undefined' || empty($parentId)) {
            $parentId = null;
        }

        if (!empty($order) && is_array($order)) {
            foreach ($order as $index => $id) {
                DB::table('menu_items')->where('id', $id)->update([
                    'parent_id' => $parentId,
                    'position'  => $index + 1
                ]);
            }

            Cache::forget('global_front_menu_items');

            return response()->json(['status' => 'success', 'message' => 'ترتیب فهرست‌ها با موفقیت بروزرسانی شد']);
        }

        return response()->json(['status' => 'error', 'message' => 'دیتا ارسال نشد']);
    }

    /**
     * متد کمکی بازگشتی برای پیدا کردن تمام زیرمجموعه‌های یک منو تا بی‌نهایت لایه
     */
    private function getAllChildrenIds($menuItem)
    {
        $ids = [];
        // لود کردن ریلیشن children در صورت عدم وجود
        foreach ($menuItem->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getAllChildrenIds($child));
        }
        return $ids;
    }

    /**
     * حذف آیتم فهرست
     */
    public function destroy(MenuItem $menuItem)
    {
        // انتقال زیرمنوها به ریشه (بر اساس استراتژی کاتگوری شما) تا با حذف والد، فرزندان یتیم نشوند
        MenuItem::where('parent_id', $menuItem->id)->update(['parent_id' => null]);

        $menuItem->delete();

        Cache::forget('global_front_menu_items');

        return redirect()->back()->with('success', 'آیتم فهرست با موفقیت حذف شد.');
    }
}
