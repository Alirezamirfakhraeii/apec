@extends('back.admin.layouts.master')

@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>
                <h4 class="admin-page-title">
                    <i class="fa fa-file-text-o ml-2"></i>
                    مدیریت صفحات
                </h4>

                <div class="admin-page-subtitle">
                    صفحات ثابت، لندینگ‌ها و صفحات دارای تمپلیت را مدیریت کنید.
                </div>
            </div>

            <a
                href="{{ route('admin.pages.create') }}"
                class="btn admin-create-btn"
            >
                <i class="fa fa-plus ml-1"></i>
                ساخت صفحه جدید
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fa fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>
        @endif


        {{-- Filters --}}
        <div class="admin-card">

            <div class="admin-card-header">
                <h4 class="admin-card-title">
                    <i class="fa fa-filter ml-2"></i>
                    جستجو و فیلتر صفحات
                </h4>
            </div>

            <div class="admin-card-body">

                <form
                    action="{{ route('admin.pages.index') }}"
                    method="GET"
                >

                    <div class="row row-sm align-items-end">

                        {{-- Search --}}
                        <div class="col-md-5">

                            <div class="form-group mb-md-0">

                                <label
                                    for="q"
                                    class="admin-label"
                                >
                                    جستجو
                                </label>

                                <input
                                    type="text"
                                    name="q"
                                    id="q"
                                    value="{{ request('q') }}"
                                    class="form-control admin-form-control"
                                    placeholder="عنوان، اسلاگ یا خلاصه"
                                >

                            </div>

                        </div>


                        {{-- Template --}}
                        <div class="col-md-3">

                            <div class="form-group mb-md-0">

                                <label
                                    for="template"
                                    class="admin-label"
                                >
                                    تمپلیت
                                </label>

                                <select
                                    name="template"
                                    id="template"
                                    class="form-control admin-form-control"
                                >

                                    <option value="">
                                        همه تمپلیت‌ها
                                    </option>

                                    @foreach($templates as $key => $template)

                                        <option
                                            value="{{ $key }}"
                                            @selected(request('template') === $key)
                                        >
                                            {{ $template['label'] }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        {{-- Status --}}
                        <div class="col-md-2">

                            <div class="form-group mb-md-0">

                                <label
                                    for="status"
                                    class="admin-label"
                                >
                                    وضعیت
                                </label>

                                <select
                                    name="status"
                                    id="status"
                                    class="form-control admin-form-control"
                                >

                                    <option value="">
                                        همه
                                    </option>

                                    <option
                                        value="active"
                                        @selected(request('status') === 'active')
                                    >
                                        فعال
                                    </option>

                                    <option
                                        value="inactive"
                                        @selected(request('status') === 'inactive')
                                    >
                                        غیرفعال
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Submit --}}
                        <div class="col-md-2">

                            <button
                                type="submit"
                                class="btn admin-submit-btn"
                            >
                                <i class="fa fa-search ml-1"></i>
                                فیلتر
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Pages List --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-table ml-2"></i>
                    لیست صفحات
                </h4>

            </div>


            <div class="admin-card-body p-0">

                <div class="table-responsive">

                    <table class="table table-striped table-hover mb-0 font_13">

                        <thead>
                        <tr>
                            <th class="pr-3">عنوان</th>
                            <th>اسلاگ</th>
                            <th>تمپلیت</th>
                            <th>وضعیت</th>
                            <th>تاریخ ساخت</th>
                            <th class="text-left pl-3">عملیات</th>
                        </tr>
                        </thead>


                        <tbody>

                        @forelse($pages as $page)

                            <tr>

                                {{-- Title --}}
                                <td class="pr-3 align-middle">

                                    <strong class="d-block text-dark">
                                        {{ $page->title }}
                                    </strong>

                                    @if($page->summary)

                                        <div class="text-muted small mt-1">
                                            {{ \Illuminate\Support\Str::limit(
                                                $page->summary,
                                                80
                                            ) }}
                                        </div>

                                    @endif

                                </td>


                                {{-- Slug --}}
                                <td class="align-middle">

                                    <span dir="ltr">
                                        /{{ $page->slug }}
                                    </span>

                                </td>


                                {{-- Template --}}
                                <td class="align-middle">

                                    <span class="badge badge-light">
                                        {{ $templates[$page->template]['label'] ?? $page->template }}
                                    </span>

                                </td>


                                {{-- Status --}}
                                <td class="align-middle">

                                    @if($page->status)

                                        <span class="admin-status active">
                                            فعال
                                        </span>

                                    @else

                                        <span class="admin-status inactive">
                                            غیرفعال
                                        </span>

                                    @endif

                                </td>


                                {{-- Date --}}
                                <td class="align-middle">
                                    {{ $page->created_at?->format('Y/m/d') }}
                                </td>


                                {{-- Actions --}}
                                <td class="text-left pl-3 align-middle">

                                    <a
                                        href="{{ route('admin.pages.edit', $page) }}"
                                        class="admin-action-btn edit"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <form
                                        action="{{ route('admin.pages.destroy', $page) }}"
                                        method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('آیا از حذف این صفحه مطمئن هستید؟')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="admin-action-btn delete"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="text-center text-muted py-5 font_13"
                                >
                                    هنوز صفحه‌ای ثبت نشده است.
                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            @if($pages->hasPages())

                <div class="card-footer">

                    <div class="d-flex justify-content-center">
                        {{ $pages->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection
