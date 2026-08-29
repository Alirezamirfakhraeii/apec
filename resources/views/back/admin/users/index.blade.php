@php
    $activeFilters = collect([
        request('q'),
        request('role'),
        request('sort'),
    ])->filter()->count();

    $isPaginated = method_exists($users, 'currentPage');

    $totalUsers = $isPaginated ? $users->total() : $users->count();
    $currentCount = $users->count();
    $currentPage = $isPaginated ? $users->currentPage() : 1;
    $lastPage = $isPaginated ? $users->lastPage() : 1;
    $pagination = $isPaginated ? $users->appends(request()->query()) : null;
@endphp


@extends('back.admin.layouts.master')


@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>

                <h4 class="admin-page-title">
                    <i class="fa fa-users ml-2"></i>
                    بخش اعضا
                </h4>

                <div class="admin-page-subtitle">
                    مدیریت، جستجو و آرشیو کامل کاربران سیستم
                </div>

            </div>


            <a
                href="{{ route('admin.user.create') }}"
                class="btn admin-create-btn"
            >
                <i class="fa fa-user-plus ml-1"></i>
                افزودن کاربر جدید
            </a>

        </div>


        {{-- Success Message --}}
        @if(session()->has('success'))

            <div
                class="alert alert-success font_13 border-0 shadow-sm rounded mb-4"
                role="alert"
            >

                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="alert"
                    type="button"
                >
                    <span aria-hidden="true">&times;</span>
                </button>


                <i class="fa fa-check-circle ml-2"></i>

                {{ session()->get('success') }}

            </div>

        @endif


        {{-- Error Message --}}
        @if(session()->has('error'))

            <div
                class="alert alert-danger font_13 border-0 shadow-sm rounded mb-4"
                role="alert"
            >

                <button
                    aria-label="Close"
                    class="close"
                    data-bs-dismiss="alert"
                    type="button"
                >
                    <span aria-hidden="true">&times;</span>
                </button>


                <i class="fa fa-exclamation-circle ml-2"></i>

                {{ session()->get('error') }}

            </div>

        @endif


        {{-- Stats --}}
        <div class="row row-sm">

            {{-- Total Results --}}
            <div class="col-xl-3 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="admin-stat-title">
                                کل نتایج
                            </div>

                            <h3 class="admin-stat-number">
                                {{ number_format($totalUsers) }}
                            </h3>

                        </div>


                        <div>
                            <i class="fa fa-users text-primary admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Current Page Results --}}
            <div class="col-xl-3 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="admin-stat-title">
                                نمایش در این صفحه
                            </div>

                            <h3 class="admin-stat-number">
                                {{ number_format($currentCount) }}
                            </h3>

                        </div>


                        <div>
                            <i class="fa fa-list-ul text-info admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Current Page --}}
            <div class="col-xl-3 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="admin-stat-title">
                                صفحه فعلی
                            </div>

                            <h3 class="admin-stat-number">

                                {{ $currentPage }}

                                <span class="font_12 text-muted">
                                    از {{ $lastPage }}
                                </span>

                            </h3>

                        </div>


                        <div>
                            <i class="fa fa-clone text-success admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>


            {{-- Active Filters --}}
            <div class="col-xl-3 col-md-6 col-12">

                <div class="admin-stat-card">

                    <div class="d-flex align-items-center justify-content-between">

                        <div>

                            <div class="admin-stat-title">
                                فیلترهای فعال
                            </div>

                            <h3 class="admin-stat-number">
                                {{ $activeFilters }}
                            </h3>

                        </div>


                        <div>
                            <i class="fa fa-filter text-warning admin-stat-icon"></i>
                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Filters --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <h4 class="admin-card-title">
                            <i class="fa fa-search ml-2"></i>
                            جستجو و فیلتر کاربران
                        </h4>

                        <div class="admin-page-subtitle mt-1">
                            نام، ایمیل، نقش و ترتیب نمایش کاربران را مشخص کنید.
                        </div>

                    </div>


                    @if($activeFilters > 0)

                        <a
                            href="{{ route('admin.user.index') }}"
                            class="btn admin-back-btn"
                        >
                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>

                    @endif

                </div>

            </div>


            <div class="admin-card-body">

                <form
                    action="{{ route('admin.user.index') }}"
                    method="GET"
                >

                    <div class="row row-sm align-items-end">

                        {{-- Search --}}
                        <div class="col-xl-4 col-lg-4 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label
                                    for="q"
                                    class="admin-label"
                                >
                                    جستجو در نام یا ایمیل
                                </label>


                                <input
                                    type="text"
                                    name="q"
                                    id="q"
                                    value="{{ request('q') }}"
                                    class="form-control admin-form-control"
                                    placeholder="مثلاً: admin@example.com یا علی"
                                >

                            </div>

                        </div>


                        {{-- Role --}}
                        @isset($roles)

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <div class="form-group mb-lg-0">

                                    <label
                                        for="role"
                                        class="admin-label"
                                    >
                                        نقش کاربر
                                    </label>


                                    <select
                                        name="role"
                                        id="role"
                                        class="form-control admin-form-control"
                                    >

                                        <option value="">
                                            همه نقش‌ها
                                        </option>


                                        @foreach($roles as $role)

                                            <option
                                                value="{{ $role->name }}"
                                                {{ request('role') == $role->name ? 'selected' : '' }}
                                            >
                                                {{ $role->name }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        @endisset


                        {{-- Sort --}}
                        <div class="col-xl-3 col-lg-4 col-md-6">

                            <div class="form-group mb-lg-0">

                                <label
                                    for="sort"
                                    class="admin-label"
                                >
                                    مرتب‌سازی
                                </label>


                                <select
                                    name="sort"
                                    id="sort"
                                    class="form-control admin-form-control"
                                >

                                    <option
                                        value="latest"
                                        {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}
                                    >
                                        جدیدترین
                                    </option>

                                    <option
                                        value="oldest"
                                        {{ request('sort') == 'oldest' ? 'selected' : '' }}
                                    >
                                        قدیمی‌ترین
                                    </option>

                                    <option
                                        value="name"
                                        {{ request('sort') == 'name' ? 'selected' : '' }}
                                    >
                                        نام کاربر
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Submit --}}
                        <div class="col-xl-2 col-lg-4 col-md-6">

                            <button
                                type="submit"
                                class="btn admin-submit-btn"
                            >
                                <i class="fa fa-filter ml-1"></i>
                                اعمال فیلتر
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Users List --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <div class="d-flex align-items-center justify-content-between">

                    <div>

                        <h4 class="admin-card-title">
                            <i class="fa fa-archive ml-2"></i>
                            مدیریت و آرشیو کاربران
                        </h4>

                        <div class="admin-page-subtitle mt-1">
                            {{ number_format($totalUsers) }}
                            کاربر مطابق با جستجوی شما پیدا شد.
                        </div>

                    </div>


                    <div class="d-none d-md-block">

                        <span class="badge badge-light">
                            صفحه {{ $currentPage }} از {{ $lastPage }}
                        </span>

                    </div>

                </div>

            </div>


            <div class="admin-card-body p-0">

                <div class="table-responsive">

                    <table class="table table-striped table-hover mb-0 font_13 text-center">

                        <thead>

                        <tr>
                            <th>ردیف</th>
                            <th class="text-right">نام کاربر</th>
                            <th>ایمیل</th>
                            <th>نقش فعلی</th>
                            <th>عملیات</th>
                        </tr>

                        </thead>


                        <tbody>

                        @forelse($users as $index => $u)

                            <tr>

                                {{-- Index --}}
                                <td class="align-middle">

                                    @if($isPaginated)

                                        {{ $users->firstItem() + $index }}

                                    @else

                                        {{ $index + 1 }}

                                    @endif

                                </td>


                                {{-- User --}}
                                <td class="text-right align-middle">

                                    <a
                                        href="{{ route('admin.user.edit', $u->id) }}"
                                        class="d-block text-dark font-weight-bold"
                                    >
                                        {{ $u->name }}
                                    </a>


                                    <div class="text-muted font_12 mt-1">

                                        <i class="fa fa-clock-o ml-1"></i>

                                        @if($u->created_at)

                                            {{ jdate($u->created_at)->format('Y/m/d') }}

                                        @else

                                            تاریخ ثبت نشده

                                        @endif

                                    </div>

                                </td>


                                {{-- Email --}}
                                <td class="align-middle">

                                    <span class="text-muted">

                                        <i class="fa fa-envelope-o ml-1"></i>

                                        {{ $u->email }}

                                    </span>

                                </td>


                                {{-- Roles --}}
                                <td class="align-middle">

                                    @if($u->roles->isEmpty())

                                        <span class="badge badge-light">
                                            کاربر عادی
                                        </span>

                                    @else

                                        @foreach($u->roles as $role)

                                            <span class="badge badge-light mb-1">

                                                <i class="fa fa-user-tag ml-1"></i>

                                                {{ $role->name }}

                                            </span>

                                        @endforeach

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="align-middle">

                                    <a
                                        href="{{ route('admin.user.edit', $u->id) }}"
                                        class="admin-action-btn edit"
                                        title="ویرایش"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <form
                                        action="{{ route('admin.user.destroy', $u->id) }}"
                                        method="POST"
                                        class="d-inline-block"
                                        onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟')"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="admin-action-btn delete"
                                            title="حذف"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>


                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="text-center text-muted py-5 font_13"
                                >

                                    <i class="fa fa-users d-block mb-3 admin-empty-icon"></i>


                                    <div class="font-weight-bold text-dark mb-1">
                                        کاربری پیدا نشد
                                    </div>


                                    <div class="text-muted">
                                        با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.
                                    </div>


                                    @if($activeFilters > 0)

                                        <a
                                            href="{{ route('admin.user.index') }}"
                                            class="btn admin-back-btn mt-3"
                                        >
                                            حذف همه فیلترها
                                        </a>

                                    @endif

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination Footer --}}
                <div class="card-footer">

                    <div class="d-flex align-items-center justify-content-between flex-wrap">

                        {{-- Pagination Info --}}
                        <div class="font_12 text-muted">

                            @if($totalUsers > 0)

                                نمایش

                                <strong>
                                    {{ $isPaginated ? $users->firstItem() : 1 }}
                                </strong>

                                تا

                                <strong>
                                    {{ $isPaginated ? $users->lastItem() : $users->count() }}
                                </strong>

                                از

                                <strong>
                                    {{ number_format($totalUsers) }}
                                </strong>

                                کاربر

                            @else

                                هیچ کاربری برای نمایش وجود ندارد

                            @endif

                        </div>


                        {{-- Custom Pagination --}}
                        <div>

                            @if($isPaginated && $users->hasPages())

                                @php
                                    $startPage = max($currentPage - 2, 1);
                                    $endPage = min($startPage + 4, $lastPage);
                                    $startPage = max($endPage - 4, 1);
                                @endphp


                                <nav
                                    class="custom-pagination-nav"
                                    aria-label="Page navigation"
                                >

                                    <ul class="editorial-pagination">

                                        {{-- Previous --}}
                                        <li class="{{ $users->onFirstPage() ? 'disabled' : '' }}">

                                            @if($users->onFirstPage())

                                                <span>
                                                    قبلی
                                                </span>

                                            @else

                                                <a href="{{ $pagination->previousPageUrl() }}">
                                                    قبلی
                                                </a>

                                            @endif

                                        </li>


                                        {{-- First Page --}}
                                        @if($startPage > 1)

                                            <li>
                                                <a href="{{ $pagination->url(1) }}">
                                                    1
                                                </a>
                                            </li>


                                            @if($startPage > 2)

                                                <li class="dots">
                                                    <span>...</span>
                                                </li>

                                            @endif

                                        @endif


                                        {{-- Pages --}}
                                        @for($page = $startPage; $page <= $endPage; $page++)

                                            <li class="{{ $page == $currentPage ? 'active' : '' }}">

                                                @if($page == $currentPage)

                                                    <span>
                                                        {{ $page }}
                                                    </span>

                                                @else

                                                    <a href="{{ $pagination->url($page) }}">
                                                        {{ $page }}
                                                    </a>

                                                @endif

                                            </li>

                                        @endfor


                                        {{-- Last Page --}}
                                        @if($endPage < $lastPage)

                                            @if($endPage < $lastPage - 1)

                                                <li class="dots">
                                                    <span>...</span>
                                                </li>

                                            @endif


                                            <li>

                                                <a href="{{ $pagination->url($lastPage) }}">
                                                    {{ $lastPage }}
                                                </a>

                                            </li>

                                        @endif


                                        {{-- Next --}}
                                        <li class="{{ $users->hasMorePages() ? '' : 'disabled' }}">

                                            @if($users->hasMorePages())

                                                <a href="{{ $pagination->nextPageUrl() }}">
                                                    بعدی
                                                </a>

                                            @else

                                                <span>
                                                    بعدی
                                                </span>

                                            @endif

                                        </li>

                                    </ul>

                                </nav>


                            @else

                                <span class="badge badge-light">
                                    فقط یک صفحه
                                </span>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
