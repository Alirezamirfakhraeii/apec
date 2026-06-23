@extends('back.admin.layouts.master')

@php
    $oldType = old('type', 'custom');
@endphp

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
                            <label for="menu_type_select" class="font_12 fw-bold">نوع پیوند :</label>
                            <select name="type" id="menu_type_select" class="form-control" required>
                                <option value="custom" {{ $oldType == 'custom' ? 'selected' : '' }}>لینک سفارشی</option>
                                <option value="category" {{ $oldType == 'category' ? 'selected' : '' }}>اتصال به
                                    دسته‌بندی
                                </option>
                                <option value="page" {{ $oldType == 'page' ? 'selected' : '' }}>اتصال به صفحه ثابت
                                </option>
                                <option value="post" {{ $oldType == 'post' ? 'selected' : '' }}>اتصال به خبر / مقاله
                                </option>
                                <option value="route" {{ $oldType == 'route' ? 'selected' : '' }}>مسیر سیستمی</option>
                                <option value="heading" {{ $oldType == 'heading' ? 'selected' : '' }}>فقط عنوان بدون
                                    لینک
                                </option>
                            </select>
                        </div>

                        <input type="hidden" name="target_type" id="target_type" value="{{ old('target_type') }}">

                        <div class="form-group mb-3 menu-field" id="url_input_wrapper">
                            <label for="url" class="font_12 fw-bold">لینک سفارشی :</label>
                            <div class="input-group" dir="ltr">
                                <span
                                    class="input-group-text bg-light border-light-subtle font_11 px-2">irapec.com/</span>
                                <input type="text"
                                       name="url"
                                       id="url"
                                       class="form-control text-start font_12"
                                       placeholder="about-us یا https://example.com"
                                       value="{{ old('url') }}">
                            </div>
                            @error('url') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3 menu-field d-none" id="target_category_wrapper">
                            <label for="target_category_id" class="font_12 fw-bold">انتخاب دسته‌بندی :</label>
                            <select name="target_id" id="target_category_id" class="form-control target-select">
                                <option value="">-- یک دسته‌بندی انتخاب کنید --</option>
                                @foreach($categories as $cat)
                                    <option
                                        value="{{ $cat->id }}" {{ old('type') == 'category' && old('target_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 menu-field d-none" id="target_page_wrapper">
                            <label for="target_page_id" class="font_12 fw-bold">انتخاب صفحه ثابت :</label>
                            <select name="target_id" id="target_page_id" class="form-control target-select">
                                <option value="">-- یک صفحه انتخاب کنید --</option>
                                @foreach($pages as $page)
                                    <option
                                        value="{{ $page->id }}" {{ old('type') == 'page' && old('target_id') == $page->id ? 'selected' : '' }}>
                                        {{ $page->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 menu-field d-none" id="target_post_wrapper">
                            <label for="target_post_id" class="font_12 fw-bold">انتخاب خبر / مقاله :</label>
                            <select name="target_id" id="target_post_id" class="form-control target-select">
                                <option value="">-- یک خبر یا مقاله انتخاب کنید --</option>
                                @foreach($posts as $post)
                                    <option
                                        value="{{ $post->id }}" {{ old('type') == 'post' && old('target_id') == $post->id ? 'selected' : '' }}>
                                        {{ $post->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 menu-field d-none" id="route_input_wrapper">
                            <label for="route_name" class="font_12 fw-bold">نام Route سیستمی :</label>
                            <input type="text"
                                   name="route_name"
                                   id="route_name"
                                   class="form-control text-start"
                                   dir="ltr"
                                   placeholder="مثلا: contact یا about"
                                   value="{{ old('route_name') }}">

                            <label for="route_params" class="font_12 fw-bold mt-2">پارامترهای Route:</label>
                            <textarea name="route_params"
                                      id="route_params"
                                      class="form-control text-start"
                                      dir="ltr"
                                      rows="2"
                                      placeholder='مثلا: {"slug":"test"}'>{{ old('route_params') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="icon" class="font_12 fw-bold">آیکون منو :</label>
                            <input type="text"
                                   name="icon"
                                   id="icon"
                                   class="form-control text-start"
                                   dir="ltr"
                                   placeholder="مثلا: fa-newspaper-o"
                                   value="{{ old('icon') }}">
                        </div>

                        <div class="form-group mb-3">
                            <input type="hidden" name="open_in_new_tab" value="0">

                            <label class="d-flex align-items-center gap-2 font_12">
                                <input type="checkbox"
                                       name="open_in_new_tab"
                                       value="1"
                                    {{ old('open_in_new_tab') ? 'checked' : '' }}>
                                باز شدن لینک در تب جدید
                            </label>
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
                    <small class="text-muted"><i class="fa fa-info-circle"></i> هر سطح منو را می‌توانید به طور مستقل
                        جابجا کنید.</small>
                </div>
                <div class="card-body">
                    <div class="menu-row-mock bg-secondary text-white font-weight-bold mb-2"
                         style="border-radius: 4px;">
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
                    <button type="button" class="close ms-0 me-auto" data-bs-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
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
                                <option value="custom">لینک سفارشی</option>
                                <option value="category">اتصال به دسته‌بندی</option>
                                <option value="page">اتصال به صفحه ثابت</option>
                                <option value="post">اتصال به خبر / مقاله</option>
                                <option value="route">مسیر سیستمی</option>
                                <option value="heading">فقط عنوان بدون لینک</option>
                            </select>
                        </div>

                        <input type="hidden" name="target_type" id="edit_target_type">

                        <div class="form-group mb-3 edit-menu-field" id="edit_url_wrapper">
                            <label class="fw-bold font_12">لینک سفارشی :</label>
                            <div class="input-group" dir="ltr">
                                <span
                                    class="input-group-text bg-light border-light-subtle font_11 px-2">irapec.com/</span>
                                <input type="text" name="url" id="edit_url" class="form-control text-start font_12">
                            </div>
                        </div>

                        <div class="form-group mb-3 edit-menu-field d-none" id="edit_target_category_wrapper">
                            <label class="fw-bold font_12">انتخاب دسته‌بندی :</label>
                            <select name="target_id" id="edit_target_category_id"
                                    class="form-control edit-target-select">
                                <option value="">-- یک دسته‌بندی انتخاب کنید --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 edit-menu-field d-none" id="edit_target_page_wrapper">
                            <label class="fw-bold font_12">انتخاب صفحه ثابت :</label>
                            <select name="target_id" id="edit_target_page_id" class="form-control edit-target-select">
                                <option value="">-- یک صفحه انتخاب کنید --</option>
                                @foreach($pages as $page)
                                    <option value="{{ $page->id }}">{{ $page->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 edit-menu-field d-none" id="edit_target_post_wrapper">
                            <label class="fw-bold font_12">انتخاب خبر / مقاله :</label>
                            <select name="target_id" id="edit_target_post_id" class="form-control edit-target-select">
                                <option value="">-- یک خبر یا مقاله انتخاب کنید --</option>
                                @foreach($posts as $post)
                                    <option value="{{ $post->id }}">{{ $post->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3 edit-menu-field d-none" id="edit_route_wrapper">
                            <label class="fw-bold font_12">نام Route سیستمی :</label>
                            <input type="text"
                                   name="route_name"
                                   id="edit_route_name"
                                   class="form-control text-start"
                                   dir="ltr">

                            <label class="fw-bold font_12 mt-2">پارامترهای Route:</label>
                            <textarea name="route_params"
                                      id="edit_route_params"
                                      class="form-control text-start"
                                      dir="ltr"
                                      rows="2"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="fw-bold font_12">آیکون منو :</label>
                            <input type="text"
                                   name="icon"
                                   id="edit_icon"
                                   class="form-control text-start"
                                   dir="ltr"
                                   placeholder="مثلا: fa-newspaper-o">
                        </div>

                        <div class="form-group mb-3">
                            <input type="hidden" name="open_in_new_tab" value="0">

                            <label class="d-flex align-items-center gap-2 font_12">
                                <input type="checkbox"
                                       name="open_in_new_tab"
                                       id="edit_open_in_new_tab"
                                       value="1">
                                باز شدن لینک در تب جدید
                            </label>
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

            /*
            |--------------------------------------------------------------------------
            | Model target map
            |--------------------------------------------------------------------------
            | برای type هایی که به مدل وصل می‌شوند
            */
            const targetTypeMap = {
                category: "App\\Models\\Category",
                page: "App\\Models\\Page",
                post: "App\\Models\\Post"
            };

            /*
            |--------------------------------------------------------------------------
            | Helper functions
            |--------------------------------------------------------------------------
            */

            function getEl(id) {
                return document.getElementById(id);
            }

            function setValue(id, value) {
                const el = getEl(id);

                if (!el) {
                    console.warn("Element not found:", id);
                    return;
                }

                el.value = value ?? "";
            }

            function setChecked(id, value) {
                const el = getEl(id);

                if (!el) {
                    console.warn("Element not found:", id);
                    return;
                }

                el.checked = value === "1" || value === 1 || value === true || value === "true";
            }

            function disableFields(wrapper, disabled) {
                if (!wrapper) return;

                wrapper.querySelectorAll("input, select, textarea").forEach(function (field) {
                    field.disabled = disabled;
                });
            }

            function hideAndDisable(wrapper) {
                if (!wrapper) return;

                wrapper.classList.add("d-none");
                disableFields(wrapper, true);
            }

            function showAndEnable(wrapper) {
                if (!wrapper) return;

                wrapper.classList.remove("d-none");
                disableFields(wrapper, false);
            }

            function resetTargetSelects(prefix) {
                const selector = prefix === "edit" ? ".edit-target-select" : ".target-select";

                document.querySelectorAll(selector).forEach(function (select) {
                    select.disabled = true;
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Toggle create/edit form fields
            |--------------------------------------------------------------------------
            */

            function toggleMenuFields(type, prefix = "create") {
                const isEdit = prefix === "edit";

                const targetTypeInput = getEl(isEdit ? "edit_target_type" : "target_type");

                const wrappers = {
                    custom: getEl(isEdit ? "edit_url_wrapper" : "url_input_wrapper"),
                    category: getEl(isEdit ? "edit_target_category_wrapper" : "target_category_wrapper"),
                    page: getEl(isEdit ? "edit_target_page_wrapper" : "target_page_wrapper"),
                    post: getEl(isEdit ? "edit_target_post_wrapper" : "target_post_wrapper"),
                    route: getEl(isEdit ? "edit_route_wrapper" : "route_input_wrapper")
                };

                Object.values(wrappers).forEach(function (wrapper) {
                    hideAndDisable(wrapper);
                });

                resetTargetSelects(prefix);

                if (targetTypeInput) {
                    targetTypeInput.value = "";
                }

                if (type === "heading") {
                    return;
                }

                if (type === "custom") {
                    showAndEnable(wrappers.custom);
                    return;
                }

                if (type === "route") {
                    showAndEnable(wrappers.route);
                    return;
                }

                if (["category", "page", "post"].includes(type)) {
                    showAndEnable(wrappers[type]);

                    if (targetTypeInput) {
                        targetTypeInput.value = targetTypeMap[type] || "";
                    }
                }
            }

            const typeSelect = getEl("menu_type_select");

            if (typeSelect) {
                typeSelect.addEventListener("change", function () {
                    toggleMenuFields(this.value, "create");
                });

                toggleMenuFields(typeSelect.value, "create");
            }

            const editTypeSelect = getEl("edit_type");

            if (editTypeSelect) {
                editTypeSelect.addEventListener("change", function () {
                    toggleMenuFields(this.value, "edit");
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Sortable menu tree
            |--------------------------------------------------------------------------
            */

            function initSortable(el) {
                Sortable.create(el, {
                    group: "nested-menu-group",
                    handle: ".handle",
                    animation: 180,
                    fallbackOnBody: true,
                    swapThreshold: 0.65,

                    onEnd: function (evt) {
                        const targetList = evt.to;
                        const parentId = targetList.getAttribute("data-parent-id");

                        let order = [];

                        Array.from(targetList.children).forEach(function (li) {
                            if (li.matches && li.matches("[data-id]")) {
                                order.push(li.getAttribute("data-id"));
                            }
                        });

                        if (order.length > 0) {
                            fetch("{{ route('admin.menu-items.update-order') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "Accept": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                },
                                body: JSON.stringify({
                                    order: order,
                                    parent_id: parentId
                                })
                            })
                                .then(async function (response) {
                                    const text = await response.text();

                                    if (!response.ok) {
                                        console.error("خطای سرور:", text);
                                        throw new Error("Server Error " + response.status);
                                    }

                                    return JSON.parse(text);
                                })
                                .then(function (data) {
                                    console.log("پاسخ سرور:", data.message);
                                })
                                .catch(function (error) {
                                    console.error("خطا در ارسال ردیف:", error);
                                });

                        }
                    }
                });
            }

            document.querySelectorAll(".sortable-list").forEach(function (listEl) {
                initSortable(listEl);
            });

            /*
            |--------------------------------------------------------------------------
            | Open edit modal
            |--------------------------------------------------------------------------
            */

            document.querySelectorAll(".edit-menu-btn").forEach(function (button) {
                button.addEventListener("click", function () {

                    const id = this.getAttribute("data-id");
                    const title = this.getAttribute("data-title");
                    const type = this.getAttribute("data-type") || "custom";
                    const url = this.getAttribute("data-url");
                    const targetId = this.getAttribute("data-target-id");
                    const parentId = this.getAttribute("data-parent");
                    const status = this.getAttribute("data-status");
                    const routeName = this.getAttribute("data-route-name");
                    const routeParams = this.getAttribute("data-route-params");
                    const icon = this.getAttribute("data-icon");
                    const openInNewTab = this.getAttribute("data-open-in-new-tab");

                    const editForm = getEl("editMenuForm");

                    if (editForm) {
                        let updateUrl = "{{ route('admin.menu-items.update', ':id') }}".replace(":id", id);
                        editForm.setAttribute("action", updateUrl);
                    }

                    setValue("edit_title", title);
                    setValue("edit_type", type);
                    setValue("edit_url", url);
                    setValue("edit_route_name", routeName);
                    setValue("edit_route_params", routeParams);
                    setValue("edit_icon", icon);
                    setValue("edit_status", status || "1");

                    setChecked("edit_open_in_new_tab", openInNewTab);

                    toggleMenuFields(type, "edit");

                    setValue("edit_target_category_id", "");
                    setValue("edit_target_page_id", "");
                    setValue("edit_target_post_id", "");

                    if (type === "category") {
                        setValue("edit_target_category_id", targetId);
                    }

                    if (type === "page") {
                        setValue("edit_target_page_id", targetId);
                    }

                    if (type === "post") {
                        setValue("edit_target_post_id", targetId);
                    }

                    const selectParent = getEl("edit_parent_id");

                    if (selectParent) {
                        selectParent.value = parentId || "";

                        Array.from(selectParent.options).forEach(function (option) {
                            option.style.display = option.value == id ? "none" : "block";
                        });
                    }

                    openEditModal();
                });
            });

            /*
            |--------------------------------------------------------------------------
            | Bootstrap 4 / Bootstrap 5 modal support
            |--------------------------------------------------------------------------
            */

            function openEditModal() {
                const modalEl = getEl("editMenuModal");

                if (!modalEl) {
                    console.warn("Element not found: editMenuModal");
                    return;
                }

                // Bootstrap 5
                if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                    return;
                }

                // Bootstrap 4
                if (typeof $ !== "undefined" && typeof $("#editMenuModal").modal === "function") {
                    $("#editMenuModal").modal("show");
                    return;
                }

                console.warn("Bootstrap modal is not available.");
            }

        });
    </script>
@endpush
