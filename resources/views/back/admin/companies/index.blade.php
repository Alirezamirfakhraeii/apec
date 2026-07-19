@php
    use Illuminate\Support\Str;

    $activeFilters = collect([
        request('q'),
        request('membership_status'),
        request('membership_type'),
        request('activity_type'),
        request('date_from'),
        request('date_to'),
     request('sort') !== null && request('sort') !== 'name_asc'
    ? request('sort')
    : null,
    ])->filter(function ($value) {
        return $value !== null && $value !== '';
    })->count();

    $pagination = $companies->appends(request()->query());
@endphp

@extends('back.admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/posts/index.css') }}">
@endpush

@section('content')

    <div class="news-admin-wrapper">

        <br>

        {{-- هدر صفحه --}}
        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-building ml-2"></i>
                    مدیریت اعضا
                </h4>

                <div class="news-page-subtitle">
                    مدیریت، جستجو، فیلتر و مشاهده اطلاعات شرکت‌های عضو انجمن
                </div>
            </div>

            <a href="{{ route('admin.company.create') }}"
               class="btn news-create-btn">

                <i class="fa fa-plus-circle ml-2"></i>
                ثبت عضو جدید
            </a>
        </div>

        {{-- پیام موفقیت --}}
        @if(session()->has('success'))
            <div class="alert alert-success font_13 border-0 shadow-sm rounded mb-4"
                 role="alert">

                <button aria-label="Close"
                        class="close"
                        data-bs-dismiss="alert"
                        type="button"
                        style="line-height: 0;">

                    <span aria-hidden="true">&times;</span>
                </button>

                <i class="fa fa-check-circle ml-2"></i>
                {{ session()->get('success') }}
            </div>
        @endif

        {{-- کارت‌های آماری --}}
        <div class="row row-sm mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">
                                کل اعضای سیستم
                            </div>

                            <h4 class="stat-value">
                                {{ number_format($totalCompanies) }}
                            </h4>
                        </div>

                        <div class="stat-icon">
                            <i class="fa fa-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">
                                نتایج جستجو
                            </div>

                            <h4 class="stat-value">
                                {{ number_format($companies->total()) }}
                            </h4>
                        </div>

                        <div class="stat-icon">
                            <i class="fa fa-list-ul"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">
                                صفحه فعلی
                            </div>

                            <h4 class="stat-value">
                                {{ $companies->currentPage() }}

                                <span class="font_12 text-muted">
                                    از {{ $companies->lastPage() }}
                                </span>
                            </h4>
                        </div>

                        <div class="stat-icon">
                            <i class="fa fa-clone"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">
                                فیلترهای فعال
                            </div>

                            <h4 class="stat-value">
                                {{ $activeFilters }}
                            </h4>
                        </div>

                        <div class="stat-icon">
                            <i class="fa fa-filter"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- فیلترها --}}
        <div class="card filter-card mb-4">
            <div class="card-body">

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="filter-title mb-1">
                            <i class="fa fa-search ml-2"></i>
                            جستجو و فیلتر اعضا
                        </h6>

                        <div class="filter-subtitle">
                            نام شرکت، شناسه ملی، شماره عضویت، وضعیت و نوع فعالیت را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.company.index') }}"
                           class="btn btn-outline-secondary filter-reset-btn">

                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif
                </div>

                <form action="{{ route('admin.company.index') }}"
                      method="GET">

                    <div class="row row-sm">

                        {{-- جستجو --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>
                                جستجوی عضو
                            </label>

                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="نام، شناسه ملی، شماره عضویت...">
                        </div>

                        {{-- وضعیت عضویت --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                وضعیت عضویت
                            </label>

                            <select name="membership_status"
                                    class="form-control">

                                <option value="">
                                    همه وضعیت‌ها
                                </option>

                                <option value="فعال"
                                    {{ request('membership_status') === 'فعال' ? 'selected' : '' }}>
                                    فعال
                                </option>

                                <option value="تعلیق"
                                    {{ request('membership_status') === 'تعلیق' ? 'selected' : '' }}>
                                    تعلیق
                                </option>

                                <option value="لغو"
                                    {{ request('membership_status') === 'لغو' ? 'selected' : '' }}>
                                    لغو
                                </option>
                            </select>
                        </div>

                        {{-- نوع عضویت --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                نوع عضویت
                            </label>

                            <select name="membership_type"
                                    class="form-control">

                                <option value="">
                                    همه انواع
                                </option>

                                <option value="اصلی"
                                    {{ request('membership_type') === 'اصلی' ? 'selected' : '' }}>
                                    اصلی
                                </option>

                                <option value="وابسته"
                                    {{ request('membership_type') === 'وابسته' ? 'selected' : '' }}>
                                    وابسته
                                </option>
                            </select>
                        </div>

                        {{-- نوع فعالیت --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>
                                نوع فعالیت
                            </label>

                            <input type="text"
                                   name="activity_type"
                                   value="{{ request('activity_type') }}"
                                   class="form-control"
                                   placeholder="بخشی از عنوان فعالیت...">
                        </div>

                        {{-- تعداد نمایش --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                تعداد نمایش
                            </label>

                            <select name="per_page"
                                    class="form-control">

                                @foreach([10, 20, 50, 100] as $perPage)
                                    <option value="{{ $perPage }}"
                                        {{ (int) request('per_page', 10) === $perPage ? 'selected' : '' }}>
                                        {{ $perPage }} رکورد
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- از تاریخ --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                ثبت‌شده از تاریخ
                            </label>

                            <input type="date"
                                   name="date_from"
                                   value="{{ request('date_from') }}"
                                   class="form-control">
                        </div>

                        {{-- تا تاریخ --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                ثبت‌شده تا تاریخ
                            </label>

                            <input type="date"
                                   name="date_to"
                                   value="{{ request('date_to') }}"
                                   class="form-control">
                        </div>

                        {{-- مرتب‌سازی --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>
                                مرتب‌سازی
                            </label>

                            <select name="sort"
                                    class="form-control">

                                <option value="latest"
                                    {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                                    جدیدترین رکوردها
                                </option>

                                <option value="oldest"
                                    {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                                    قدیمی‌ترین رکوردها
                                </option>

                                <option value="latest"
                                    {{ request('sort') === 'latest' ? 'selected' : '' }}>
                                    جدیدترین رکوردها
                                </option>

                                <option value="name_desc"
                                    {{ request('sort') === 'name_desc' ? 'selected' : '' }}>
                                    نام شرکت؛ نزولی
                                </option>

                                <option value="membership"
                                    {{ request('sort') === 'membership' ? 'selected' : '' }}>
                                    شماره عضویت
                                </option>
                            </select>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit"
                                class="btn btn-primary filter-submit-btn">

                            <i class="fa fa-filter ml-2"></i>
                            اعمال فیلتر
                        </button>
                    </div>

                </form>
            </div>
        </div>

        {{-- جدول اعضا --}}
        <div class="card editorial-table-card">

            <div class="editorial-table-header">
                <div>
                    <h4 class="card-title editorial-title mb-1">
                        <i class="fa fa-address-book ml-2"></i>
                        فهرست اعضای انجمن
                    </h4>

                    <div class="editorial-subtitle">
                        {{ number_format($companies->total()) }}
                        عضو مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه {{ $companies->currentPage() }}
                        از {{ $companies->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table editorial-table mb-0 font_13 text-center">

                        <thead>
                        <tr>
                            <th style="width: 5%;">
                                ردیف
                            </th>

                            <th style="width: 7%;">
                                شرکت
                            </th>

                            <th class="text-right" style="width: 25%;">
                                نام شرکت
                            </th>

                            <th style="width: 12%;">
                                شناسه ملی
                            </th>

                            <th style="width: 10%;">
                                شماره عضویت
                            </th>

                            <th style="width: 10%;">
                                نوع عضویت
                            </th>

                            <th style="width: 10%;">
                                وضعیت
                            </th>

                            <th style="width: 10%;">
                                تلفن
                            </th>

                            <th style="width: 11%;">
                                عملیات
                            </th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($companies as $key => $company)

                            <tr>
                                {{-- ردیف --}}
                                <td class="editorial-index">
                                    {{ $companies->firstItem() + $key }}
                                </td>

                                {{-- آیکن شرکت --}}
                                <td>
                                    <div class="editorial-empty-thumb mx-auto">
                                        <i class="fa fa-building"></i>
                                    </div>
                                </td>

                                {{-- نام شرکت --}}
                                <td class="text-right">
                                    <a href="{{ route('admin.company.edit', $company->id) }}"
                                       class="editorial-post-title d-block">

                                        {{ Str::limit(
                                            $company->registered_name ?: 'نام شرکت ثبت نشده',
                                            65
                                        ) }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        @if($company->company_short_name)
                                            <i class="fa fa-tag ml-1"></i>
                                            {{ $company->company_short_name }}
                                        @else
                                            <i class="fa fa-calendar ml-1"></i>
                                            ثبت در سیستم:
                                            {{ optional($company->created_at)->format('Y/m/d') }}
                                        @endif
                                    </div>
                                </td>

                                {{-- شناسه ملی --}}
                                <td>
                                    @if($company->national_id)
                                        <span dir="ltr">
                                                {{ $company->national_id }}
                                            </span>
                                    @else
                                        <span class="text-muted">
                                                ثبت نشده
                                            </span>
                                    @endif
                                </td>

                                {{-- شماره عضویت --}}
                                <td>
                                    @if($company->membership_number)
                                        <span class="editorial-category">
                                                {{ $company->membership_number }}
                                            </span>
                                    @else
                                        <span class="text-muted">
                                                بدون شماره
                                            </span>
                                    @endif
                                </td>

                                {{-- نوع عضویت --}}
                                <td>
                                        <span class="editorial-category">
                                            {{ $company->membership_type ?: 'نامشخص' }}
                                        </span>
                                </td>

                                {{-- وضعیت عضویت --}}
                                <td>
                                    @if($company->membership_status === 'فعال')
                                        <span class="editorial-status published">
                                                فعال
                                            </span>

                                    @elseif($company->membership_status === 'تعلیق')
                                        <span class="editorial-status draft">
                                                تعلیق
                                            </span>

                                    @elseif($company->membership_status === 'لغو')
                                        <span class="editorial-status draft">
                                                لغو
                                            </span>

                                    @else
                                        <span class="editorial-status draft">
                                                نامشخص
                                            </span>
                                    @endif
                                </td>

                                {{-- تلفن --}}
                                <td>
                                    @if($company->phone)
                                        <span dir="ltr">
                                                {{ $company->phone }}
                                            </span>
                                    @else
                                        <span class="text-muted">
                                                ثبت نشده
                                            </span>
                                    @endif
                                </td>

                                {{-- عملیات --}}
                                <td>
                                    <div class="editorial-actions">

                                        <a href="{{ route('admin.company.show', $company->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="مشاهده">

                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.company.edit', $company->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="ویرایش">

                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.company.destroy', $company->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('آیا از حذف این عضو اطمینان دارید؟');"
                                              class="editorial-delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="editorial-action-btn editorial-delete-btn"
                                                    title="حذف">

                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9"
                                    class="editorial-empty-state">

                                    <i class="fa fa-folder-open d-block mb-3"></i>

                                    <div class="fw-bold text-dark mb-1">
                                        عضوی پیدا نشد
                                    </div>

                                    <div class="text-muted">
                                        با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.
                                    </div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route('admin.company.index') }}"
                                           class="btn btn-outline-secondary mt-3 px-4">

                                            حذف همه فیلترها
                                        </a>
                                    @else
                                        <a href="{{ route('admin.company.create') }}"
                                           class="btn btn-primary mt-3 px-4">

                                            ثبت اولین عضو
                                        </a>
                                    @endif
                                </td>
                            </tr>

                        @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- فوتر و صفحه‌بندی --}}
                <div class="editorial-footer">

                    <div class="editorial-pagination-info">
                        @if($companies->total() > 0)
                            نمایش

                            <strong>
                                {{ $companies->firstItem() }}
                            </strong>

                            تا

                            <strong>
                                {{ $companies->lastItem() }}
                            </strong>

                            از

                            <strong>
                                {{ number_format($companies->total()) }}
                            </strong>

                            عضو
                        @else
                            هیچ عضوی برای نمایش وجود ندارد
                        @endif
                    </div>

                    <div class="editorial-pagination-links">

                        @if($companies->hasPages())

                            @php
                                $currentPage = $companies->currentPage();
                                $lastPage = $companies->lastPage();

                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                $startPage = max($endPage - 4, 1);
                            @endphp

                            <nav class="custom-pagination-nav"
                                 aria-label="Page navigation">

                                <ul class="editorial-pagination">

                                    {{-- قبلی --}}
                                    <li class="{{ $companies->onFirstPage() ? 'disabled' : '' }}">
                                        @if($companies->onFirstPage())
                                            <span>
                                                قبلی
                                            </span>
                                        @else
                                            <a href="{{ $pagination->previousPageUrl() }}">
                                                قبلی
                                            </a>
                                        @endif
                                    </li>

                                    {{-- صفحه اول --}}
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

                                    {{-- صفحات میانی --}}
                                    @for($page = $startPage; $page <= $endPage; $page++)
                                        <li class="{{ $page === $currentPage ? 'active' : '' }}">

                                            @if($page === $currentPage)
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

                                    {{-- صفحه آخر --}}
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

                                    {{-- بعدی --}}
                                    <li class="{{ $companies->hasMorePages() ? '' : 'disabled' }}">

                                        @if($companies->hasMorePages())
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
                            <span class="single-page-label">
                                فقط یک صفحه
                            </span>
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
