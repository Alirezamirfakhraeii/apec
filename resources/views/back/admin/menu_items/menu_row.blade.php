<li class="nested-sortable-item" data-id="{{ $item->id }}">
    <div class="menu-row-mock bg-light border rounded-2 p-1.5 mb-1">

        <div style="width: 35%;" class="d-flex align-items-center">
            <i class="fa fa-grip-vertical text-muted handle ml-2 opacity-50 p-1" style="cursor: grab;"></i>
            <span class="font_12 fw-semibold text-dark">{{ $item->title }}</span>
        </div>

        <div style="width: 30%; font-family: monospace; text-align: left;" dir="ltr">
            @if($item->type == 'category' || $item->type == 'menu')
                <span class="badge bg-primary bg-opacity-10 font_10 py-0.5 px-2">{{ $item->category->title ?? 'نامشخص' }}</span>
            @else
                <small class="text-secondary font_11">irapec.com/{{ ltrim($item->url, '/') }}</small>
            @endif
        </div>

        <div style="width: 15%; text-align: center;">
            @if($item->status == 1)
                <span class="badge bg-success bg-opacity-10 border border-success border-opacity-10 px-2 py-0.5 font_10 fw-normal">فعال</span>
            @else
                <span class="badge bg-danger bg-opacity-10 border border-danger border-opacity-10 px-2 py-0.5 font_10 fw-normal">مخفی</span>
            @endif
        </div>

        <div style="width: 20%; text-align: center;" class="d-flex align-items-center justify-content-center" style="gap: 2px;">
            <button class="btn btn-sm btn-link text-primary edit-menu-btn py-0 px-2 shadow-none"
                    data-id="{{ $item->id }}"
                    data-title="{{ $item->title }}"
                    data-type="{{ $item->type }}"
                    data-url="{{ $item->url }}"
                    data-category="{{ $item->category_id }}"
                    data-parent="{{ $item->parent_id }}"
                    data-status="{{ $item->status }}"
                    title="ویرایش">
                <i class="fa fa-edit font_11"></i>
            </button>

            <form action="{{ route('admin.menu-items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این منو مطمئن هستید؟ زیرمنوها به ریشه منتقل می‌شوند.');" class="m-0">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-link text-danger py-0 px-2 shadow-none" title="حذف"><i class="fa fa-trash font_11"></i></button>
            </form>
        </div>
    </div>

    @if($item->children->count() > 0)
        <ul class="sortable-list" data-parent-id="{{ $item->id }}">
            @foreach($item->children as $child)
                @include('back.admin.menu_items.menu_row', ['item' => $child, 'depth' => $depth + 1])
            @endforeach
        </ul>
    @else
        <ul class="sortable-list" data-parent-id="{{ $item->id }}"></ul>
    @endif
</li>
