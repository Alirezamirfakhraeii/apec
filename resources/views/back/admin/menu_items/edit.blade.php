@extends('back.admin.layouts.master')


<div class="modal fade" id="editModal{{ $item->id }}" {{ url()->current() }} tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-right" dir="rtl">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title font_13 font-weight-bold">ویرایش آیتم: {{ $item->title }}</h5>
                <button type="button" class="btn-close btn-close-white ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.menu-items.update', $item->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label font_11 font-weight-bold text-dark">عنوان منو</label>
                        <input type="text" name="title" class="form-control text-right" value="{{ $item->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font_11 font-weight-bold text-dark">نوع پیوند</label>
                        <select name="type" id="modal_type_{{ $item->id }}" class="form-select text-right" onchange="toggleModalFields({{ $item->id }}, this.value)" required>
                            <option value="custom" {{ $item->type == 'custom' ? 'selected' : '' }}>لینک سفارشی (دستی)</option>
                            <option value="category" {{ $item->type == 'category' ? 'selected' : '' }}>اتصال به دسته‌بندی دیتابیس</option>
                        </select>
                    </div>

                    <div class="mb-3 {{ $item->type == 'category' ? 'd-none' : '' }}" id="modal_url_wrapper_{{ $item->id }}">
                        <label class="form-label font_11 font-weight-bold text-dark">آدرس لینک (URL)</label>
                        <input type="text" name="url" class="form-control text-left dir-ltr" value="{{ $item->url }}">
                    </div>

                    <div class="mb-3 {{ $item->type == 'custom' ? 'd-none' : '' }}" id="modal_cat_wrapper_{{ $item->id }}">
                        <label class="form-label font_11 font-weight-bold text-dark">انتخاب دسته‌بندی مرجع</label>
                        <select name="category_id" class="form-select text-right">
                            <option value="">--- یک دسته‌بندی انتخاب کنید ---</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $item->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font_11 font-weight-bold text-dark">منوی والد</label>
                        <select name="parent_id" class="form-select text-right">
                            <option value="">منوی اصلی (بدون والد)</option>
                            @foreach($allMenuItems as $allMenu)
                                @if($allMenu->id != $item->id) <option value="{{ $allMenu->id }}" {{ $item->parent_id == $allMenu->id ? 'selected' : '' }}>{{ $allMenu->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label font_11 font-weight-bold text-dark">وضعیت نمایش</label>
                        <select name="status" class="form-select text-right" required>
                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>فعال</option>
                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>غیرفعال</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary font_11" data-bs-dismiss="modal">انصراف</button>
                    <button type="submit" class="btn btn-primary font_11"><i class="fa fa-refresh ml-1"></i> بروزرسانی منو</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleModalFields(id, value) {
        var urlW = document.getElementById('modal_url_wrapper_' + id);
        var catW = document.getElementById('modal_cat_wrapper_' + id);
        if (value === 'category') {
            catW.classList.remove('d-none');
            urlW.classList.add('d-none');
        } else {
            urlW.classList.remove('d-none');
            catW.classList.add('d-none');
        }
    }
</script>
