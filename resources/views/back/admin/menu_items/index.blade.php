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
            padding-right: 20px; /* ایجاد تورفتگی منظم در حالت راست‌چین RTL */
        }

        .nested-sortable-item {
            margin-bottom: 5px;
        }

        .menu-row-mock {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 1px solid #e1e6f1;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .handle {
            cursor: grab;
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش محتوا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت فهرست‌ها (منوی سایت)</span>
            </div>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header"><h4 class="card-title mb-1">ایجاد آیتم جدید در فهرست</h4></div>
                <div class="card-body pt-0" dir="rtl" style="text-align: right;">
                    @if(session('success'))
                        <div class="alert alert-success mt-2" role="alert">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('admin.menu-items.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title" class="font_12 fw-bold">عنوان منو :</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   id="title" placeholder="مثلا: درباره انجمن" value="{{ old('title') }}" required>
                            @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="menu_type_select" class="font_12 fw-bold">نوع پیوند (لینک) :</label>
                            <select name="type" id="menu_type_select" class="form-control" required>
                                <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>لینک سفارشی (دستی)</option>
                                <option value="category" {{ old('type') == 'category' ? 'selected' : '' }}>اتصال به دسته‌بندی</option>
                            </select>
                        </div>

                        <div class="form-group mb-3" id="url_input_wrapper">
                            <label for="url" class="font_12 fw-bold">مسیر صفحه (URL) :</label>
                            <div class="input-group" dir="ltr">
                                <span class="input-group-text bg-light border-light-subtle font_11 px-2">irapec.com/</span>
                                <input type="text" name="url" id="url" class="form-control text-start font_12" placeholder="about-us" value="{{ old('url') }}">
                            </div>
                            @error('url') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3 d-none" id="category_select_wrapper">
                            <label for="category_id" class="font_12 fw-bold">انتخاب دسته‌بندی مرجع :</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">-- یک دسته‌بندی انتخاب کنید --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="parent_id" class="font_12 fw-bold">انتخاب منوی والد :</label>
                            <select name="parent_id" class="form-control" id="parent_id">
                                <option value="">-- بدون والد (منوی اصلی) --</option>
                                @foreach($allMenuItems as $menu)
                                    @php
                                        $dash = ''; $parent = $menu->parent;
                                        while($parent) { $dash .= '— '; $parent = $parent->parent; }
                                    @endphp
                                    <option value="{{ $menu->id }}">{{ $dash . $menu->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="font_12 fw-bold">وضعیت نمایش :</label>
                            <select name="status" class="form-control" id="status">
                                <option value="1">فعال (نمایش در سایت)</option>
                                <option value="0">غیرفعال (مخفی)</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary d-block w-100 mt-4">ثبت و پیکربندی منو</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-1">ساختار چیدمان فهرست‌ها</h4>
                    <small class="text-muted"><i class="fa fa-info-circle"></i> هر سطح منو را می‌توانید به طور مستقل جابجا کنید.</small>
                </div>
                <div class="card-body">
                    <div class="menu-row-mock bg-secondary text-white font-weight-bold mb-2" style="border-radius: 4px;">
                        <div style="width: 35%;">عنوان فهرست</div>
                        <div style="width: 30%;">پیوند / آدرس صفحه</div>
                        <div style="width: 15%; text-align: center;">وضعیت</div>
                        <div style="width: 20%; text-align: center;">عملیات</div>
                    </div>

                    <ul class="sortable-list main-tree-root" data-parent-id="null">
                        @foreach($menuItems as $item)
                            @include('back.admin.menu_items.menu_row', ['item' => $item, 'depth' => 0])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-right" dir="rtl">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">ویرایش آیتم فهرست</h5>
                    <button type="button" class="close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form id="editMenuForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label class="fw-bold font_12">عنوان منو :</label>
                            <input type="text" name="title" id="edit_title" class="form-control" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold font_12">نوع پیوند :</label>
                            <select name="type" id="edit_type" class="form-control" required>
                                <option value="custom">لینک سفارشی (دستی)</option>
                                <option value="category">اتصال به دسته‌بندی</option>
                            </select>
                        </div>

                        <div class="form-group mb-3" id="edit_url_wrapper">
                            <label class="fw-bold font_12">مسیر صفحه (URL) :</label>
                            <div class="input-group" dir="ltr">
                                <span class="input-group-text bg-light border-light-subtle font_11 px-2">irapec.com/</span>
                                <input type="text" name="url" id="edit_url" class="form-control text-start font_12">
                            </div>
                        </div>

                        <div class="form-group mb-3 d-none" id="edit_category_wrapper">
                            <label class="fw-bold font_12">انتخاب دسته‌بندی مرجع :</label>
                            <select name="category_id" id="edit_category_id" class="form-control">
                                <option value="">-- یک دسته‌بندی انتخاب کنید --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold font_12">منوی والد :</label>
                            <select name="parent_id" id="edit_parent_id" class="form-control">
                                <option value="">-- بدون والد (منوی اصلی) --</option>
                                @foreach($allMenuItems as $menu)
                                    @php
                                        $dash = ''; $parent = $menu->parent;
                                        while($parent) { $dash .= '— '; $parent = $parent->parent; }
                                    @endphp
                                    <option value="{{ $menu->id }}">{{ $dash . $menu->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold font_12">وضعیت نمایش :</label>
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

            // سوییچ فرم اصلی (ایجاد)
            const typeSelect = document.getElementById('menu_type_select');
            const urlWrapper = document.getElementById('url_input_wrapper');
            const catWrapper = document.getElementById('category_select_wrapper');

            function toggleFormFields(value) {
                if (value === 'category') {
                    catWrapper.classList.remove('d-none');
                    urlWrapper.classList.add('d-none');
                } else {
                    urlWrapper.classList.remove('d-none');
                    catWrapper.classList.add('d-none');
                }
            }
            typeSelect.addEventListener('change', function() { toggleFormFields(this.value); });
            toggleFormFields(typeSelect.value);

            // سوییچ فرم داخل مودال (ویرایش)
            const editTypeSelect = document.getElementById('edit_type');
            const editUrlWrapper = document.getElementById('edit_url_wrapper');
            const editCatWrapper = document.getElementById('edit_category_wrapper');

            function toggleModalFields(value) {
                if (value === 'category') {
                    editCatWrapper.classList.remove('d-none');
                    editUrlWrapper.classList.add('d-none');
                } else {
                    editUrlWrapper.classList.remove('d-none');
                    editCatWrapper.classList.add('d-none');
                }
            }
            editTypeSelect.addEventListener('change', function() { toggleModalFields(this.value); });


            // سیستم مرتب‌سازی درختی واقعی با SortableJS برای منوها
            function initSortable(el) {
                Sortable.create(el, {
                    group: 'nested-menu-group',
                    handle: '.handle',
                    animation: 180,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,
                    onEnd: function (evt) {
                        const targetList = evt.to;
                        const parentId = targetList.getAttribute('data-parent-id');

                        let order = [];
                        Array.from(targetList.children).forEach(li => {
                            if (li.matches && li.matches('[data-id]')) {
                                order.push(li.getAttribute('data-id'));
                            }
                        });

                        if (order.length > 0) {
                            fetch("{{ route('admin.menu-items.update-order') }}", {
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
                                .then(data => { console.log('پاسخ سرور:', data.message); })
                                .catch(error => { console.error('خطا در ارسال ردیف:', error); });
                        }
                    }
                });
            }

            document.querySelectorAll('.sortable-list').forEach(function (listEl) {
                initSortable(listEl);
            });


            // باز کردن مودال و ست کردن دیتا به روش پیشرفته و متمرکز شما
            document.querySelectorAll('.edit-menu-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const type = this.getAttribute('data-type');
                    const url = this.getAttribute('data-url');
                    const categoryId = this.getAttribute('data-category');
                    const parentId = this.getAttribute('data-parent');
                    const status = this.getAttribute('data-status');

                    let updateUrl = "{{ route('admin.menu-items.update', ':id') }}".replace(':id', id);
                    document.getElementById('editMenuForm').setAttribute('action', updateUrl);

                    document.getElementById('edit_title').value = title;
                    document.getElementById('edit_type').value = type;
                    document.getElementById('edit_url').value = url ? url : "";
                    document.getElementById('edit_category_id').value = categoryId ? categoryId : "";
                    document.getElementById('edit_status').value = status;

                    toggleModalFields(type);

                    const selectParent = document.getElementById('edit_parent_id');
                    selectParent.value = parentId ? parentId : "";

                    // جلوگیری از والد قرار دادن خودش
                    Array.from(selectParent.options).forEach(option => {
                        option.style.display = (option.value == id) ? 'none' : 'block';
                    });

                    const modalEl = document.getElementById('editMenuModal');
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                });
            });
        });
    </script>
@endpush
