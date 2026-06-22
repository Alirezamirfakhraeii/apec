<?php

namespace App\Http\Requests\Admin\MenuItems;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'           => ['required', 'string', 'max:255'],
            'type'            => ['required', 'in:custom,category,page,post,route,heading'],
            'url'             => ['nullable', 'string', 'max:1000'],
            'target_id'       => ['nullable', 'integer'],
            'route_name'      => ['nullable', 'string', 'max:255'],
            'route_params'    => ['nullable', 'json'],
            'parent_id'       => ['nullable', 'exists:menu_items,id'],
            'status'          => ['required', 'in:0,1'],
            'icon'            => ['nullable', 'string', 'max:100'],
            'open_in_new_tab' => ['nullable', 'boolean'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $type = $this->input('type');

            $menuItem = $this->route('menu_item') ?? $this->route('menuItem');

            $currentMenuItemId = $menuItem instanceof MenuItem
                ? $menuItem->id
                : $menuItem;

            if ($this->filled('parent_id') && (int) $this->input('parent_id') === (int) $currentMenuItemId) {
                $validator->errors()->add('parent_id', 'آیتم نمی‌تواند والد خودش باشد.');
            }

            if ($type === 'custom' && ! $this->filled('url')) {
                $validator->errors()->add('url', 'آدرس برای لینک سفارشی الزامی است.');
            }

            if ($type === 'category') {
                if (! $this->filled('target_id')) {
                    $validator->errors()->add('target_id', 'انتخاب دسته‌بندی الزامی است.');
                } elseif (! Category::whereKey($this->input('target_id'))->exists()) {
                    $validator->errors()->add('target_id', 'دسته‌بندی انتخاب‌شده معتبر نیست.');
                }
            }

            if ($type === 'post') {
                if (! $this->filled('target_id')) {
                    $validator->errors()->add('target_id', 'انتخاب پست الزامی است.');
                } elseif (! Post::whereKey($this->input('target_id'))->exists()) {
                    $validator->errors()->add('target_id', 'پست انتخاب‌شده معتبر نیست.');
                }
            }

            if ($type === 'page') {
                $validator->errors()->add('type', 'نوع صفحه فعلاً در سیستم فعال نیست.');
            }

            if ($type === 'route' && ! $this->filled('route_name')) {
                $validator->errors()->add('route_name', 'نام route الزامی است.');
            }
        });
    }
}
