<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('position', 'asc')
            ->get();

        $allCategories = Category::orderBy('title', 'asc')->get();

        return view('back.admin.categories.index', compact('categories', 'allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:0,1',
        ]);

        $slug = str_replace(' ', '-', trim($request->title));

        $lastPosition = Category::where('parent_id', $request->parent_id)->max('position') ?? 0;

        Category::create([
            'title' => $request->title,
            'slug' => $slug,
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'position' => $lastPosition + 1,
        ]);

        Cache::forget('global_front_categories');

        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function update(Request $request, Category $category)
    {
        $childrenIds = $this->getAllChildrenIds($category);
        $childrenIds[] = $category->id; // خود دسته هم نباید انتخاب بشه

        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . implode(',', $childrenIds),
            'status' => 'required|in:0,1',
        ]);

        $category->update([
            'title' => $request->title,
            'slug' => str_replace(' ', '-', trim($request->title)),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
        ]);

        Cache::forget('global_front_categories');

        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    public function update_order(Request $request)
    {
        $order = $request->input('order');
        $parentId = $request->input('parent_id');

        if ($parentId === 'null' || $parentId === 'undefined' || empty($parentId)) {
            $parentId = null;
        }

        if (!empty($order) && is_array($order)) {
            foreach ($order as $index => $id) {
                DB::table('categories')->where('id', $id)->update([
                    'parent_id' => $parentId,
                    'position' => $index + 1
                ]);
            }

            Cache::forget('global_front_categories');

            return response()->json(['status' => 'success', 'message' => 'ترتیب دیتابیس با موفقیت بروزرسانی شد']);
        }

        return response()->json(['status' => 'error', 'message' => 'دیتا ارسال نشد']);
    }

    /**
     * یک متد کمکی بازگشتی برای پیدا کردن تمام زیرمجموعه‌های یک دسته تا بی‌نهایت لایه
     */
    private function getAllChildrenIds($category)
    {
        $ids = [];
        foreach ($category->children as $child) {
            $ids[] = $child->id;
            $ids = array_merge($ids, $this->getAllChildrenIds($child));
        }
        return $ids;
    }

    public function destroy(Category $category)
    {
        Category::where('parent_id', $category->id)->update(['parent_id' => null]);
        $category->delete();
        Cache::forget('global_front_categories');
        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }







}
