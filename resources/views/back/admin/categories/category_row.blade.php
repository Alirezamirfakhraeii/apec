{{-- resources/views/back/admin/categories/category_row.blade.php --}}
<li class="nested-sortable-item" data-id="{{ $category->id }}">
    <!-- ردیف شبیه‌ساز جدول -->
    <div class="cat-row-mock {{ $depth > 0 ? 'theme-dark-mock' : '' }}">

        <!-- بخش عنوان و دندانه ها -->
        <div style="width: 40%; padding-right: {{ $depth * 15 }}px;" class="d-flex align-items-center">
            <span class="handle mr-2" style="cursor: move; color: #a3a3a3; padding-left: 10px;">
                <i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i>
            </span>
            @if($depth > 0)
                <span class="text-muted mr-1" style="letter-spacing: 2px;">
                    @for($i = 0; $i < $depth; $i++) — @endfor
                </span>
                <i class="fa fa-reply fa-rotate-180 text-secondary mx-2" style="font-size: 11px;"></i>
            @endif
            <span class="{{ $depth === 0 ? 'fw-bold text-dark' : 'text-muted font_13' }}">
                {{ $category->title }}
            </span>
        </div>

        <!-- اسلاگ -->
        <div style="width: 25%;" class="text-muted font_13">{{ $category->slug }}</div>

        <!-- وضعیت -->
        <div style="width: 15%;" class="text-center">
            <span class="badge {{ $category->status == 1 ? 'badge-success' : 'badge-danger' }}">
                {{ $category->status == 1 ? 'فعال' : 'غیرفعال' }}
            </span>
        </div>

        <!-- عملیات -->
        <div style="width: 20%;" class="text-center">
            <button class="btn btn-sm btn-info-light edit-cat-btn"
                    data-id="{{ $category->id }}"
                    data-title="{{ $category->title }}"
                    data-parent="{{ $category->parent_id }}"
                    data-status="{{ $category->status }}">
                <i class="fa fa-edit"></i>
            </button>

            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این دسته‌بندی مطمئن هستید؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger-light" title="حذف">
                    <i class="fa fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- ایجاد کانتینر اختصاصی و مجزا برای فرزندان این سطح (کلید حل مشکل جابجایی) -->
    @if($category->children && $category->children->count() > 0)
        <ul class="sortable-list" data-parent-id="{{ $category->id }}" style="padding-right: 20px;">
            @foreach($category->children as $child)
                @include('back.admin.categories.category_row', ['category' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @else
        <!-- کانتینر خالی برای زمانی که زیردسته‌ای کشیده می‌شود و به اینجا می‌آید -->
        <ul class="sortable-list" data-parent-id="{{ $category->id }}" style="padding-right: 20px;"></ul>
    @endif
</li>
