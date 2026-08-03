@php
    use Illuminate\Support\Str;

    $activeFilters = collect([
        request('q'),
        request('company_id'),
        request('date_from'),
        request('date_to'),
        request('sort'),
    ])->filter()->count();

    $pagination = $projects->appends(request()->query());

    /*
    |--------------------------------------------------------------------------
    | نمایش تاریخ شمسی
    |--------------------------------------------------------------------------
    |
    | اگر پکیج morilog/jalali نصب باشد، تاریخ شمسی نمایش داده می‌شود.
    | در غیر این صورت، تاریخ ذخیره‌شده به‌صورت معمول نمایش داده خواهد شد.
    |
    */

    $formatProjectDate = static function ($date) {
        if (empty($date)) {
            return null;
        }

        try {
            if (class_exists(\Morilog\Jalali\Jalalian::class)) {
                return \Morilog\Jalali\Jalalian::fromDateTime($date)
                    ->format('Y/m/d');
            }

            return \Illuminate\Support\Carbon::parse($date)
                ->format('Y/m/d');
        } catch (\Throwable $exception) {
            return (string) $date;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | نام قابل نمایش شرکت
    |--------------------------------------------------------------------------
    */

    $companyDisplayName = static function ($company) {
        if (! $company) {
            return 'شرکت نامشخص';
        }

        return $company->short_name
            ?? $company->registered_name
            ?? $company->company_name
            ?? $company->name
            ?? 'بدون نام';
    };
@endphp

@extends('back.admin.layouts.master')

@push('styles')
    {{-- فعلاً از همان استایل صفحه اخبار استفاده می‌کنیم --}}
    <link rel="stylesheet" href="{{ asset('back/css/posts/index.css') }}">
@endpush

@section('content')
    <div class="news-admin-wrapper">

        <br>

        {{-- هدر صفحه --}}
        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-briefcase ml-2"></i>
                    پروژه‌های اعضا
                </h4>

                <div class="news-page-subtitle">
                    مدیریت، جستجو، ثبت و ویرایش پروژه‌های شرکت‌های عضو
                </div>
            </div>

            <a href="{{ route('admin.company-projects.create') }}"
               class="btn news-create-btn">
                <i class="fa fa-plus-circle ml-2"></i>
                ثبت پروژه جدید
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

        {{-- پیام خطا --}}
        @if(session()->has('error'))
            <div class="alert alert-danger font_13 border-0 shadow-sm rounded mb-4"
                 role="alert">

                <button aria-label="Close"
                        class="close"
                        data-bs-dismiss="alert"
                        type="button"
                        style="line-height: 0;">
                    <span aria-hidden="true">&times;</span>
                </button>

                <i class="fa fa-exclamation-circle ml-2"></i>

                {{ session()->get('error') }}
            </div>
        @endif

        {{-- کارت‌های آماری --}}
        <div class="row row-sm mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <div class="stat-label">
                                کل پروژه‌ها
                            </div>

                            <h4 class="stat-value">
                                {{ number_format($projects->total()) }}
                            </h4>
                        </div>

                        <div class="stat-icon">
                            <i class="fa fa-briefcase"></i>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">

                        <div>
                            <div class="stat-label">
                                نمایش در این صفحه
                            </div>

                            <h4 class="stat-value">
                                {{ number_format($projects->count()) }}
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
                                {{ $projects->currentPage() }}

                                <span class="font_12 text-muted">
                                    از {{ $projects->lastPage() }}
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
                            جستجو و فیلتر پروژه‌ها
                        </h6>

                        <div class="filter-subtitle">
                            نام پروژه، کارفرما، شرکت عضو و بازه زمانی را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.company-projects.index') }}"
                           class="btn btn-outline-secondary filter-reset-btn">

                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif

                </div>

                <form action="{{ route('admin.company-projects.index') }}"
                      method="GET">

                    <div class="row row-sm">

                        {{-- جستجو --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>
                                جستجو
                            </label>

                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="نام پروژه، کارفرما یا شرح خدمات...">
                        </div>

                        {{-- شرکت --}}
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>
                                شرکت عضو
                            </label>

                            <select name="company_id"
                                    class="form-control">

                                <option value="">
                                    همه شرکت‌ها
                                </option>

                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ (string) request('company_id') === (string) $company->id
                                            ? 'selected'
                                            : ''
                                        }}>

                                        {{ $companyDisplayName($company) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        {{-- از تاریخ --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                شروع از تاریخ
                            </label>

                            <input type="text"
                                   name="date_from"
                                   value="{{ request('date_from') }}"
                                   class="form-control persian-date-input"
                                   placeholder="مثلاً 1405/05/01"
                                   autocomplete="off">
                        </div>

                        {{-- تا تاریخ --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                شروع تا تاریخ
                            </label>

                            <input type="text"
                                   name="date_to"
                                   value="{{ request('date_to') }}"
                                   class="form-control persian-date-input"
                                   placeholder="مثلاً 1405/05/30"
                                   autocomplete="off">
                        </div>

                        {{-- مرتب‌سازی --}}
                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>
                                مرتب‌سازی
                            </label>

                            <select name="sort"
                                    class="form-control">

                                <option value="latest"
                                    {{ request('sort', 'latest') === 'latest'
                                        ? 'selected'
                                        : ''
                                    }}>
                                    جدیدترین ثبت
                                </option>

                                <option value="oldest"
                                    {{ request('sort') === 'oldest'
                                        ? 'selected'
                                        : ''
                                    }}>
                                    قدیمی‌ترین ثبت
                                </option>

                                <option value="start_date_desc"
                                    {{ request('sort') === 'start_date_desc'
                                        ? 'selected'
                                        : ''
                                    }}>
                                    جدیدترین تاریخ شروع
                                </option>

                                <option value="start_date_asc"
                                    {{ request('sort') === 'start_date_asc'
                                        ? 'selected'
                                        : ''
                                    }}>
                                    قدیمی‌ترین تاریخ شروع
                                </option>

                                <option value="project_name"
                                    {{ request('sort') === 'project_name'
                                        ? 'selected'
                                        : ''
                                    }}>
                                    نام پروژه
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

        {{-- جدول پروژه‌ها --}}
        <div class="card editorial-table-card">

            <div class="editorial-table-header">

                <div>
                    <h4 class="card-title editorial-title mb-1">
                        <i class="fa fa-archive ml-2"></i>
                        مدیریت پروژه‌های اعضا
                    </h4>

                    <div class="editorial-subtitle">
                        {{ number_format($projects->total()) }}
                        پروژه مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه
                        {{ $projects->currentPage() }}
                        از
                        {{ $projects->lastPage() }}
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

                            <th class="text-right"
                                style="width: 20%;">
                                نام پروژه
                            </th>

                            <th class="text-right"
                                style="width: 15%;">
                                شرکت عضو
                            </th>

                            <th class="text-right"
                                style="width: 13%;">
                                کارفرما
                            </th>

                            <th style="width: 10%;">
                                تاریخ شروع
                            </th>

                            <th style="width: 10%;">
                                تاریخ پایان
                            </th>

                            <th class="text-right"
                                style="width: 17%;">
                                شرح خدمات
                            </th>

                            <th style="width: 10%;">
                                عملیات
                            </th>
                        </tr>
                        </thead>

                        <tbody>

                        @forelse($projects as $key => $project)

                            @php
                                $startDate = $formatProjectDate(
                                    $project->start_date
                                );

                                $endDate = $formatProjectDate(
                                    $project->end_date
                                );
                            @endphp

                            <tr>

                                {{-- ردیف --}}
                                <td class="editorial-index">
                                    {{ $projects->firstItem() + $key }}
                                </td>

                                {{-- نام پروژه --}}
                                <td class="text-right">

                                    <a href="{{ route(
                                            'admin.company-projects.edit',
                                            $project
                                        ) }}"
                                       class="editorial-post-title d-block">

                                        {{ Str::limit(
                                            $project->project_name,
                                            70
                                        ) }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        <i class="fa fa-clock-o ml-1"></i>

                                        ثبت شده در:

                                        {{ $formatProjectDate(
                                            $project->created_at
                                        ) }}
                                    </div>

                                </td>

                                {{-- شرکت --}}
                                <td class="text-right">

                                    @if($project->company)
                                        <span class="editorial-category">
                                            {{ $companyDisplayName(
                                                $project->company
                                            ) }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            شرکت حذف شده
                                        </span>
                                    @endif

                                </td>

                                {{-- کارفرما --}}
                                <td class="text-right">

                                    @if($project->employer)
                                        {{ Str::limit(
                                            $project->employer,
                                            50
                                        ) }}
                                    @else
                                        <span class="text-muted">
                                            ثبت نشده
                                        </span>
                                    @endif

                                </td>

                                {{-- تاریخ شروع --}}
                                <td>

                                    @if($startDate)
                                        <span class="editorial-views">
                                            <i class="fa fa-calendar ml-1"></i>
                                            {{ $startDate }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            ثبت نشده
                                        </span>
                                    @endif

                                </td>

                                {{-- تاریخ پایان --}}
                                <td>

                                    @if($endDate)
                                        <span class="editorial-views">
                                            <i class="fa fa-calendar-check-o ml-1"></i>
                                            {{ $endDate }}
                                        </span>
                                    @else
                                        <span class="editorial-status published">
                                            در حال اجرا
                                        </span>
                                    @endif

                                </td>

                                {{-- شرح خدمات --}}
                                <td class="text-right">

                                    @if($project->service_description)
                                        <span title="{{ $project->service_description }}">
                                            {{ Str::limit(
                                                strip_tags(
                                                    $project->service_description
                                                ),
                                                90
                                            ) }}
                                        </span>
                                    @else
                                        <span class="text-muted">
                                            شرح خدمات ثبت نشده
                                        </span>
                                    @endif

                                </td>

                                {{-- عملیات --}}
                                <td>

                                    <div class="editorial-actions">

                                        <a href="{{ route(
                                                'admin.company-projects.edit',
                                                $project
                                            ) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="ویرایش پروژه">

                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route(
                                                'admin.company-projects.destroy',
                                                $project
                                            ) }}"
                                              method="POST"
                                              onsubmit="return confirm(
                                                  'آیا از حذف این پروژه اطمینان دارید؟'
                                              );"
                                              class="editorial-delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="editorial-action-btn editorial-delete-btn"
                                                    title="حذف پروژه">

                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8"
                                    class="editorial-empty-state">

                                    <i class="fa fa-folder-open d-block mb-3"></i>

                                    <div class="fw-bold text-dark mb-1">
                                        پروژه‌ای پیدا نشد
                                    </div>

                                    <div class="text-muted">
                                        با تغییر فیلترها یا ثبت پروژه جدید دوباره امتحان کنید.
                                    </div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route(
                                                'admin.company-projects.index'
                                            ) }}"
                                           class="btn btn-outline-secondary mt-3 px-4">

                                            حذف همه فیلترها
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

                        @if($projects->total() > 0)

                            نمایش

                            <strong>
                                {{ $projects->firstItem() }}
                            </strong>

                            تا

                            <strong>
                                {{ $projects->lastItem() }}
                            </strong>

                            از

                            <strong>
                                {{ number_format($projects->total()) }}
                            </strong>

                            پروژه

                        @else

                            هیچ پروژه‌ای برای نمایش وجود ندارد

                        @endif

                    </div>

                    <div class="editorial-pagination-links">

                        @if($projects->hasPages())

                            @php
                                $currentPage = $projects->currentPage();
                                $lastPage = $projects->lastPage();

                                $startPage = max(
                                    $currentPage - 2,
                                    1
                                );

                                $endPage = min(
                                    $startPage + 4,
                                    $lastPage
                                );

                                $startPage = max(
                                    $endPage - 4,
                                    1
                                );
                            @endphp

                            <nav class="custom-pagination-nav"
                                 aria-label="Page navigation">

                                <ul class="editorial-pagination">

                                    {{-- قبلی --}}
                                    <li class="{{ $projects->onFirstPage()
                                        ? 'disabled'
                                        : ''
                                    }}">

                                        @if($projects->onFirstPage())
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
                                                <span>
                                                    ...
                                                </span>
                                            </li>
                                        @endif

                                    @endif

                                    {{-- صفحات میانی --}}
                                    @for(
                                        $page = $startPage;
                                        $page <= $endPage;
                                        $page++
                                    )

                                        <li class="{{ $page === $currentPage
                                            ? 'active'
                                            : ''
                                        }}">

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
                                                <span>
                                                    ...
                                                </span>
                                            </li>
                                        @endif

                                        <li>
                                            <a href="{{ $pagination->url($lastPage) }}">
                                                {{ $lastPage }}
                                            </a>
                                        </li>

                                    @endif

                                    {{-- بعدی --}}
                                    <li class="{{ $projects->hasMorePages()
                                        ? ''
                                        : 'disabled'
                                    }}">

                                        @if($projects->hasMorePages())
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
