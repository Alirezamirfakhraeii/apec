@extends('back.admin.layouts.master')

@push('styles')
    <style>
        .sortable-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sortable-list .sortable-list {
            margin-top: 5px;
        }

        .nested-sortable-item {
            margin-bottom: 5px;
        }

        .cat-row-mock {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 1px solid #e1e6f1;
            padding: 10px 15px;
            border-radius: 4px;
        }

        .theme-dark-mock {
            background: #f8f9fa;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش محتوا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت دسته‌بندی‌ها (ساختار نامحدود)</span>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <!-- ۱. فرم ایجاد دسته‌بندی جدید -->
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header"><h4 class="card-title mb-1">ایجاد دسته‌بندی جدید</h4></div>
                <div class="card-body pt-0">
                    @if(session('success'))
                        <div class="alert alert-success mt-2" role="alert">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="font_13 fw-bold">نام دسته‌بندی :</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   id="title" placeholder="مثلا: فوتبال" value="{{ old('title') }}">
                            @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="parent_id" class="font_13 fw-bold">دسته والد :</label>
                            <select name="parent_id" class="form-control" id="parent_id">
                                <option value="">-- بدون والد (دسته اصلی) --</option>
                                @foreach($allCategories as $cat)
                                    @php
                                        $dash = ''; $parent = $cat->parent;
                                        while($parent) { $dash .= '— '; $parent = $parent->parent; }
                                    @endphp
                                    <option value="{{ $cat->id }}">{{ $dash . $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status" class="font_13 fw-bold">وضعیت نمایش :</label>
                            <select name="status" class="form-control" id="status">
                                <option value="1">فعال (نمایش در سایت)</option>
                                <option value="0">غیرفعال</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary d-block w-100 mt-4">ثبت و ذخیره</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- ۲. ساختار جدید درختی با قابلیت جابجایی واقعی زیردسته‌ها -->
        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-1">لیست دسته‌بندی‌های موجود</h4>
                    <small class="text-muted"><i class="fa fa-info-circle"></i> هر سطح را می‌توانید به طور مستقل جابجا
                        کنید.</small>
                </div>
                <div class="card-body">
                    <!-- هدر شبیه‌ساز جدول -->
                    <div class="cat-row-mock bg-secondary text-white font-weight-bold mb-2" style="border-radius: 4px;">
                        <div style="width: 40%;">عنوان دسته‌بندی</div>
                        <div style="width: 25%;">اسلاگ</div>
                        <div style="width: 15%; text-align: center;">وضعیت</div>
                        <div style="width: 20%; text-align: center;">عملیات</div>
                    </div>

                    <!-- روت اصلی لیست درختی -->
                    <ul class="sortable-list main-tree-root" data-parent-id="null">
                        @foreach($categories as $category)
                            @include('back.admin.categories.category_row', ['category' => $category, 'depth' => 0])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- پاپ‌آ‌پ (Modal) ویرایش دسته‌بندی -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ویرایش دسته‌بندی</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <form id="editCategoryForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="fw-bold">نام دسته‌بندی :</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold">دسته والد :</label>
                            <select name="parent_id" id="edit_parent_id" class="form-control">
                                <option value="">-- بدون والد (دسته اصلی) --</option>
                                @foreach($allCategories as $cat)
                                    @php
                                        $dash = ''; $parent = $cat->parent;
                                        while($parent) { $dash .= '— '; $parent = $parent->parent; }
                                    @endphp
                                    <option value="{{ $cat->id }}">{{ $dash . $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="fw-bold">وضعیت نمایش :</label>
                            <select name="status" id="edit_status" class="form-control">
                                <option value="1">فعال</option>
                                <option value="0">غیرفعال</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                        <button type="submit" class="btn btn-primary">اعمال تغییرات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function initSortable(el) {
                Sortable.create(el, {
                    group: 'nested-category-group',
                    handle: '.handle',
                    animation: 180,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onEnd: function (evt) {
                        const targetList = evt.to;
                        const parentId = targetList.getAttribute('data-parent-id');

                        // 🌟 فیلتر دقیق: فقط المنت‌های لایه اول همین لیست که ویژگی data-id دارند
                        let order = [];
                        Array.from(targetList.children).forEach(li => {
                            if (li.matches && li.matches('[data-id]')) {
                                order.push(li.getAttribute('data-id'));
                            }
                        });

                        console.log("آی‌دی‌های ارسالی به سرور برای والد (" + parentId + "):", order);

                        if (order.length > 0) {
                            fetch("{{ route('admin.categories.update_order') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    order: order,
                                    parent_id: parentId
                                })
                            })
                                .then(response => response.json())
                                .then(data => {
                                    console.log('پاسخ سرور:', data.message);
                                })
                                .catch(error => {
                                    console.error('خطا در ارسال:', error);
                                });
                        }
                    }
                });
            }

            document.querySelectorAll('.sortable-list').forEach(function (listEl) {
                initSortable(listEl);
            });

            document.querySelectorAll('.sortable-list').forEach(function (listEl) {
                initSortable(listEl);
            });

            document.querySelectorAll('.edit-cat-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const parentId = this.getAttribute('data-parent');
                    const status = this.getAttribute('data-status');

                    let updateUrl = "{{ route('admin.categories.update', ':id') }}".replace(':id', id);
                    document.getElementById('editCategoryForm').setAttribute('action', updateUrl);

                    document.getElementById('edit_title').value = title;
                    document.getElementById('edit_status').value = status;

                    const selectParent = document.getElementById('edit_parent_id');
                    selectParent.value = parentId ? parentId : "";

                    Array.from(selectParent.options).forEach(option => {
                        option.style.display = (option.value == id) ? 'none' : 'block';
                    });

                    const modalEl = document.getElementById('editCategoryModal');
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                });
            });
        });
    </script>
@endpush
