@extends('back.admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/companies/index.css') }}">
@endpush

@section('content')

    @php
        $activeFilters = collect([
            request('q'),
            request('membership_status'),
            request('membership_type'),
            request('activity_type'),
            request('date_from'),
            request('date_to'),
            request('sort') && request('sort') !== 'name_asc'
                ? request('sort')
                : null,
            request('per_page') && (int) request('per_page') !== 10
                ? request('per_page')
                : null,
        ])->filter()->count();

        $pagination = $companies->appends(request()->query());
    @endphp

    <div class="company-admin-wrapper">

        {{-- هدر صفحه --}}
        <div class="company-page-header">
            <div class="company-page-heading">
                <span class="company-page-icon">
                    <i class="fa fa-building"></i>
                </span>

                <div>
                    <h1>مدیریت اعضا و شرکت‌ها</h1>

                    <p>
                        مشاهده، جستجو و مدیریت اطلاعات شرکت‌های عضو انجمن
                    </p>
                </div>
            </div>

            <a href="{{ route('admin.company.create') }}"
               class="company-create-btn">

                <i class="fa fa-plus ml-1"></i>
                ثبت شرکت جدید
            </a>
        </div>

        {{-- پیام‌ها --}}
        @if(session()->has('success'))
            <div class="alert alert-success company-alert">
                <i class="fa fa-check-circle ml-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger company-alert">
                <i class="fa fa-exclamation-circle ml-2"></i>
                {{ session('error') }}
            </div>
        @endif

        {{-- آمار --}}
        <div class="row row-sm company-stats-row">

            <div class="col-xl-3 col-md-6">
                <div class="company-stat-card">
                    <div>
                        <span class="company-stat-label">کل شرکت‌ها</span>

                        <strong class="company-stat-value">
                            {{ number_format($totalCompanies) }}
                        </strong>
                    </div>

                    <span class="company-stat-icon">
                        <i class="fa fa-building"></i>
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="company-stat-card">
                    <div>
                        <span class="company-stat-label">نتایج فیلترشده</span>

                        <strong class="company-stat-value">
                            {{ number_format($companies->total()) }}
                        </strong>
                    </div>

                    <span class="company-stat-icon">
                        <i class="fa fa-search"></i>
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="company-stat-card">
                    <div>
                        <span class="company-stat-label">صفحه فعلی</span>

                        <strong class="company-stat-value">
                            {{ $companies->currentPage() }}
                        </strong>
                    </div>

                    <span class="company-stat-icon">
                        <i class="fa fa-file-alt"></i>
                    </span>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="company-stat-card">
                    <div>
                        <span class="company-stat-label">فیلترهای فعال</span>

                        <strong class="company-stat-value">
                            {{ $activeFilters }}
                        </strong>
                    </div>

                    <span class="company-stat-icon">
                        <i class="fa fa-filter"></i>
                    </span>
                </div>
            </div>

        </div>

        {{-- فیلترها --}}
        <div class="company-filter-card">

            <div class="company-filter-header">
                <div>
                    <h2>
                        <i class="fa fa-search ml-1"></i>
                        جستجو و فیلتر
                    </h2>

                    <p>
                        اطلاعات موردنظر را وارد کرده و نتایج را محدود کنید.
                    </p>
                </div>

                @if($activeFilters > 0)
                    <a href="{{ route('admin.company.index') }}"
                       class="company-reset-btn">

                        <i class="fa fa-times ml-1"></i>
                        حذف فیلترها
                    </a>
                @endif
            </div>

            <form action="{{ route('admin.company.index') }}"
                  method="GET">

                <div class="row row-sm">

                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="q">جستجوی عمومی</label>

                            <input type="text"
                                   name="q"
                                   id="q"
                                   class="form-control"
                                   value="{{ request('q') }}"
                                   placeholder="نام، شناسه ملی، شماره عضویت، تلفن یا ایمیل">
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="membership_status">
                                وضعیت عضویت
                            </label>

                            <select name="membership_status"
                                    id="membership_status"
                                    class="form-control">

                                <option value="">همه وضعیت‌ها</option>

                                @foreach(['فعال', 'تعلیق', 'لغو'] as $status)
                                    <option value="{{ $status }}"
                                        {{ request('membership_status') === $status ? 'selected' : '' }}>

                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="membership_type">
                                نوع عضویت
                            </label>

                            <select name="membership_type"
                                    id="membership_type"
                                    class="form-control">

                                <option value="">همه انواع</option>

                                @foreach(['اصلی', 'وابسته'] as $type)
                                    <option value="{{ $type }}"
                                        {{ request('membership_type') === $type ? 'selected' : '' }}>

                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-12">
                        <div class="form-group">
                            <label for="activity_type">نوع فعالیت</label>

                            <input type="text"
                                   name="activity_type"
                                   id="activity_type"
                                   class="form-control"
                                   value="{{ request('activity_type') }}"
                                   placeholder="مثلاً تولید، پیمانکاری یا EPC">
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="date_from">از تاریخ</label>

                            <input type="date"
                                   name="date_from"
                                   id="date_from"
                                   class="form-control"
                                   value="{{ request('date_from') }}">
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="date_to">تا تاریخ</label>

                            <input type="date"
                                   name="date_to"
                                   id="date_to"
                                   class="form-control"
                                   value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="sort">مرتب‌سازی</label>

                            <select name="sort"
                                    id="sort"
                                    class="form-control">

                                <option value="name_asc"
                                    {{ request('sort', 'name_asc') === 'name_asc' ? 'selected' : '' }}>
                                    نام صعودی
                                </option>

                                <option value="name_desc"
                                    {{ request('sort') === 'name_desc' ? 'selected' : '' }}>
                                    نام نزولی
                                </option>

                                <option value="latest"
                                    {{ request('sort') === 'latest' ? 'selected' : '' }}>
                                    جدیدترین
                                </option>

                                <option value="oldest"
                                    {{ request('sort') === 'oldest' ? 'selected' : '' }}>
                                    قدیمی‌ترین
                                </option>

                                <option value="membership"
                                    {{ request('sort') === 'membership' ? 'selected' : '' }}>
                                    شماره عضویت
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="per_page">تعداد نمایش</label>

                            <select name="per_page"
                                    id="per_page"
                                    class="form-control">

                                @foreach([10, 20, 50, 100] as $perPage)
                                    <option value="{{ $perPage }}"
                                        {{ (int) request('per_page', 10) === $perPage ? 'selected' : '' }}>

                                        {{ $perPage }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6 col-md-12 company-filter-actions">
                        <button type="submit"
                                class="company-filter-submit">

                            <i class="fa fa-filter ml-1"></i>
                            اعمال فیلتر
                        </button>

                        <a href="{{ route('admin.company.index') }}"
                           class="company-filter-clear">

                            پاک‌کردن
                        </a>
                    </div>

                </div>
            </form>

        </div>

        {{-- جدول --}}
        <div class="company-table-card">

            <div class="company-table-header">
                <div>
                    <h2>
                        <i class="fa fa-list ml-1"></i>
                        فهرست شرکت‌ها
                    </h2>

                    <p>
                        {{ number_format($companies->total()) }}
                        شرکت پیدا شد.
                    </p>
                </div>

                <span class="company-page-badge">
                    صفحه {{ $companies->currentPage() }}
                    از {{ $companies->lastPage() }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table company-table mb-0">

                    <thead>
                    <tr>
                        <th class="company-row-number">ردیف</th>
                        <th class="company-logo-column">لوگو</th>
                        <th class="text-right">اطلاعات شرکت</th>
                        <th>شناسه ملی</th>
                        <th>عضویت</th>
                        <th>وضعیت</th>
                        <th class="company-action-column">عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($companies as $key => $company)
                        <tr>

                            <td class="company-row-number">
                                {{ $companies->firstItem() + $key }}
                            </td>

                            <td>
                                @if($company->logo)
                                    <div class="company-logo-box">
                                        <img src="{{ asset('storage/' . $company->logo) }}"
                                             alt="{{ $company->registered_name }}"
                                             loading="lazy">
                                    </div>
                                @else
                                    <div class="company-logo-placeholder">
                                        <i class="fa fa-building"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="text-right">
                                <a href="{{ route('admin.company.edit', $company) }}"
                                   class="company-name">

                                    {{ $company->registered_name ?: 'بدون نام ثبتی' }}
                                </a>

                                <div class="company-secondary-text">
                                    {{ $company->company_short_name ?: 'نام اختصاری ثبت نشده' }}
                                </div>

                                @if($company->company_name_en)
                                    <div class="company-en-name"
                                         dir="ltr">

                                        {{ $company->company_name_en }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                <span class="company-national-id"
                                      dir="ltr">

                                    {{ $company->national_id ?: '—' }}
                                </span>
                            </td>

                            <td>
                                <span class="company-membership-type">
                                    {{ $company->membership_type ?: 'نامشخص' }}
                                </span>

                                <div class="company-secondary-text">
                                    شماره:
                                    {{ $company->membership_number ?: '—' }}
                                </div>
                            </td>

                            <td>
                                @if($company->membership_status === 'فعال')
                                    <span class="company-status company-status-active">
                                        فعال
                                    </span>
                                @elseif($company->membership_status === 'تعلیق')
                                    <span class="company-status company-status-suspended">
                                        تعلیق
                                    </span>
                                @elseif($company->membership_status === 'لغو')
                                    <span class="company-status company-status-cancelled">
                                        لغو
                                    </span>
                                @else
                                    <span class="company-status company-status-unknown">
                                        نامشخص
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="company-actions">

                                    <a href="{{ route('admin.company.edit', $company) }}"
                                       class="company-action-btn company-edit-btn"
                                       title="ویرایش">

                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.company.destroy', $company) }}"
                                          method="POST"
                                          onsubmit="return confirm('آیا از حذف این شرکت اطمینان دارید؟');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="company-action-btn company-delete-btn"
                                                title="حذف">

                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="company-empty-state">

                                    <span class="company-empty-icon">
                                        <i class="fa fa-building"></i>
                                    </span>

                                    <h3>شرکتی پیدا نشد</h3>

                                    <p>
                                        فیلترها را تغییر دهید یا شرکت جدیدی ثبت کنید.
                                    </p>

                                    <a href="{{ route('admin.company.create') }}"
                                       class="company-create-btn">

                                        ثبت شرکت جدید
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

            <div class="company-table-footer">

                <div class="company-result-info">
                    @if($companies->total() > 0)
                        نمایش
                        <strong>{{ $companies->firstItem() }}</strong>
                        تا
                        <strong>{{ $companies->lastItem() }}</strong>
                        از
                        <strong>{{ number_format($companies->total()) }}</strong>
                        شرکت
                    @else
                        هیچ شرکتی برای نمایش وجود ندارد.
                    @endif
                </div>

                @if($companies->hasPages())
                    <nav class="company-pagination-nav">
                        <ul class="company-pagination">

                            <li class="{{ $companies->onFirstPage() ? 'disabled' : '' }}">
                                @if($companies->onFirstPage())
                                    <span>قبلی</span>
                                @else
                                    <a href="{{ $pagination->previousPageUrl() }}">
                                        قبلی
                                    </a>
                                @endif
                            </li>

                            @foreach($pagination->getUrlRange(
                                max(1, $companies->currentPage() - 2),
                                min($companies->lastPage(), $companies->currentPage() + 2)
                            ) as $page => $url)
                                <li class="{{ $page === $companies->currentPage() ? 'active' : '' }}">
                                    @if($page === $companies->currentPage())
                                        <span>{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    @endif
                                </li>
                            @endforeach

                            <li class="{{ $companies->hasMorePages() ? '' : 'disabled' }}">
                                @if($companies->hasMorePages())
                                    <a href="{{ $pagination->nextPageUrl() }}">
                                        بعدی
                                    </a>
                                @else
                                    <span>بعدی</span>
                                @endif
                            </li>

                        </ul>
                    </nav>
                @endif

            </div>

        </div>

    </div>

@endsection
