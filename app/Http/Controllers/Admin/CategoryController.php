<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Categories\Actions\CategoryAction;
use App\Features\Admin\Categories\DTOs\StoreCategoryDTO;
use App\Features\Admin\Categories\DTOs\UpdateCategoryDTO;
use App\Features\Admin\Categories\DTOs\UpdateCategoryOrderDTO;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoryAction $categoryAction)
    {
        $data = $categoryAction->getIndexData();
        return view('back.admin.categories.index', $data);
    }

    public function store(Request $request, CategoryAction $categoryAction)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|in:0,1',
            'type' => 'nullable|string|max:50',
        ]);
        $dto = StoreCategoryDTO::fromRequest($request);
        $categoryAction->store($dto);
        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function update(Request $request, Category $category, CategoryAction $categoryAction)
    {
        $childrenIds = $categoryAction->getAllChildrenIds($category);
        $childrenIds[] = $category->id;
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id|not_in:' . implode(',', $childrenIds),
            'status' => 'required|in:0,1',
        ]);
        $dto = UpdateCategoryDTO::fromRequest($request);
        $categoryAction->update($category, $dto);
        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت ویرایش شد.');
    }

    public function update_order(Request $request, CategoryAction $categoryAction)
    {
        $dto = UpdateCategoryOrderDTO::fromRequest($request);
        $result = $categoryAction->updateOrder($dto);
        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'ترتیب دیتابیس با موفقیت بروزرسانی شد',
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'دیتا ارسال نشد',
        ]);
    }

    public function destroy(Category $category, CategoryAction $categoryAction)
    {
        $categoryAction->delete($category);
        return redirect()->back()->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}

