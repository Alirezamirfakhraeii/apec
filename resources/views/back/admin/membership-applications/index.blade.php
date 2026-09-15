@php
    use App\Enums\MembershipApplicationState;
    use App\Support\PersianDate;

    $activeFilters = collect([
        request('q'),
        request('state'),
        request('stage'),

        request('sort') && request('sort') !== 'latest'
            ? request('sort')
            : null,

        request('per_page') && (int) request('per_page') !== 10
            ? request('per_page')
            : null,
    ])->filter()->count();

    $pagination = $applications->appends(
        request()->query()
    );


@endphp

@extends('back.admin.layouts.master')


@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('back/css/companies/index.css') }}"
    >
@endpush


@section('content')

    <div class="company-admin-wrapper">

        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="company-page-header">

            <div class="company-page-heading">

            <span class="company-page-icon">
                <i class="fa fa-file-text-o"></i>
            </span>

                <div>

                    <h1>
                        درخواست‌های جدید عضویت
                    </h1>

                    <p>
                        مشاهده، جستجو و بررسی درخواست‌های عضویت شرکت‌ها
                    </p>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Messages
        ========================================================== --}}

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


        {{-- =========================================================
            Stats
        ========================================================== --}}

        <div class="row row-sm company-stats-row">

            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div>

                    <span class="company-stat-label">
                        کل درخواست‌ها
                    </span>

                        <strong class="company-stat-value">
                            {{ number_format($totalApplications) }}
                        </strong>

                    </div>

                    <span class="company-stat-icon">
                    <i class="fa fa-files-o"></i>
                </span>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div>

                    <span class="company-stat-label">
                        در حال بررسی
                    </span>

                        <strong class="company-stat-value">
                            {{ number_format($inReviewCount) }}
                        </strong>

                    </div>

                    <span class="company-stat-icon">
                    <i class="fa fa-clock-o"></i>
                </span>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div>

                    <span class="company-stat-label">
                        نیازمند اصلاح
                    </span>

                        <strong class="company-stat-value">
                            {{ number_format($needsCorrectionCount) }}
                        </strong>

                    </div>

                    <span class="company-stat-icon">
                    <i class="fa fa-pencil-square-o"></i>
                </span>

                </div>

            </div>


            <div class="col-xl-3 col-md-6">

                <div class="company-stat-card">

                    <div>

                    <span class="company-stat-label">
                        تأیید شده
                    </span>

                        <strong class="company-stat-value">
                            {{ number_format($approvedCount) }}
                        </strong>

                    </div>

                    <span class="company-stat-icon">
                    <i class="fa fa-check-circle-o"></i>
                </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Filters
        ========================================================== --}}

        <div class="company-filter-card">

            <div class="company-filter-header">

                <div>

                    <h2>

                        <i class="fa fa-search ml-1"></i>

                        جستجو و فیلتر

                    </h2>

                    <p>
                        درخواست موردنظر را بر اساس شرکت، وضعیت یا مرحله بررسی پیدا کنید.
                    </p>

                </div>


                @if($activeFilters > 0)

                    <a
                        href="{{ route(
                        'admin.membership-applications.index'
                    ) }}"
                        class="company-reset-btn"
                    >

                        <i class="fa fa-times ml-1"></i>

                        حذف فیلترها

                    </a>

                @endif

            </div>


            <form
                action="{{ route(
                'admin.membership-applications.index'
            ) }}"
                method="GET"
            >

                <div class="row row-sm">


                    {{-- Search --}}
                    <div class="col-xl-4 col-lg-6 col-md-12">

                        <div class="form-group">

                            <label for="q">
                                جستجوی عمومی
                            </label>

                            <input
                                type="text"
                                name="q"
                                id="q"
                                class="form-control"
                                value="{{ request('q') }}"
                                placeholder="نام شرکت، نماینده، موبایل یا شماره ثبت"
                            >

                        </div>

                    </div>


                    {{-- State --}}
                    <div class="col-xl-2 col-lg-3 col-md-6">

                        <div class="form-group">

                            <label for="state">
                                وضعیت درخواست
                            </label>

                            <select
                                name="state"
                                id="state"
                                class="form-control"
                            >

                                <option value="">
                                    همه وضعیت‌ها
                                </option>

                                @foreach(
                                    MembershipApplicationState::cases()
                                    as $state
                                )

                                    @if(
                                        $state !==
                                        MembershipApplicationState::Draft
                                    )

                                        <option
                                            value="{{ $state->value }}"
                                            {{ request('state') === $state->value
                                                ? 'selected'
                                                : ''
                                            }}
                                        >
                                            {{ $state->label() }}
                                        </option>

                                    @endif

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- Stage --}}
                    <div class="col-xl-2 col-lg-3 col-md-6">

                        <div class="form-group">

                            <label for="stage">
                                مرحله بررسی
                            </label>

                            <select
                                name="stage"
                                id="stage"
                                class="form-control"
                            >

                                <option value="">
                                    همه مراحل
                                </option>

                                @foreach(
                                    $workflowStages
                                    as $stage
                                )

                                    <option
                                        value="{{ $stage->id }}"
                                        {{ (string) request('stage') ===
                                            (string) $stage->id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >

                                        {{ $stage->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- Sort --}}
                    <div class="col-xl-2 col-lg-3 col-md-6">

                        <div class="form-group">

                            <label for="sort">
                                مرتب‌سازی
                            </label>

                            <select
                                name="sort"
                                id="sort"
                                class="form-control"
                            >

                                <option
                                    value="latest"
                                    {{ request('sort', 'latest') === 'latest'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    جدیدترین
                                </option>

                                <option
                                    value="oldest"
                                    {{ request('sort') === 'oldest'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    قدیمی‌ترین
                                </option>

                                <option
                                    value="company_asc"
                                    {{ request('sort') === 'company_asc'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    نام شرکت صعودی
                                </option>

                                <option
                                    value="company_desc"
                                    {{ request('sort') === 'company_desc'
                                        ? 'selected'
                                        : ''
                                    }}
                                >
                                    نام شرکت نزولی
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- Per Page --}}
                    <div class="col-xl-2 col-lg-3 col-md-6">

                        <div class="form-group">

                            <label for="per_page">
                                تعداد نمایش
                            </label>

                            <select
                                name="per_page"
                                id="per_page"
                                class="form-control"
                            >

                                @foreach(
                                    [10, 20, 50, 100]
                                    as $perPage
                                )

                                    <option
                                        value="{{ $perPage }}"
                                        {{ (int) request(
                                            'per_page',
                                            10
                                        ) === $perPage
                                            ? 'selected'
                                            : ''
                                        }}
                                    >

                                        {{ $perPage }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="col-xl-4 col-lg-6 col-md-12 company-filter-actions">

                        <button
                            type="submit"
                            class="company-filter-submit"
                        >

                            <i class="fa fa-filter ml-1"></i>

                            اعمال فیلتر

                        </button>


                        <a
                            href="{{ route(
                            'admin.membership-applications.index'
                        ) }}"
                            class="company-filter-clear"
                        >
                            پاک‌کردن
                        </a>

                    </div>

                </div>

            </form>

        </div>


        {{-- =========================================================
            Table
        ========================================================== --}}

        <div class="company-table-card">

            <div class="company-table-header">

                <div>

                    <h2>

                        <i class="fa fa-list ml-1"></i>

                        فهرست درخواست‌ها

                    </h2>

                    <p>

                        {{ number_format(
                            $applications->total()
                        ) }}

                        درخواست پیدا شد.

                    </p>

                </div>


                <span class="company-page-badge">

                صفحه {{ $applications->currentPage() }}

                از {{ $applications->lastPage() }}

            </span>

            </div>


            <div class="table-responsive">

                <table class="table company-table mb-0">

                    <thead>

                    <tr>

                        <th class="company-row-number">
                            ردیف
                        </th>

                        <th class="company-logo-column">
                            لوگو
                        </th>

                        <th class="text-right">
                            اطلاعات شرکت
                        </th>

                        <th>
                            نماینده
                        </th>

                        <th>
                            مرحله فعلی
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            تاریخ ارسال
                        </th>

                        <th class="company-action-column">
                            عملیات
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse(
                        $applications
                        as $key => $application
                    )

                        @php

                            $profile =
                                $application->companyProfile;


                            $submittedDate =
                                $application->submitted_at
                                    ? PersianDate::fromGregorian(
                                        $application
                                            ->submitted_at
                                            ->format('Y-m-d')
                                    )
                                    : null;

                        @endphp


                        <tr>

                            {{-- Row Number --}}
                            <td class="company-row-number">

                                {{
                                    $applications->firstItem()
                                    + $key
                                }}

                            </td>


                            {{-- Logo --}}
                            <td>

                                @if($profile?->logo_path)

                                    <div class="company-logo-box">

                                        <img
                                            src="{{ asset(
                                            'storage/' .
                                            $profile->logo_path
                                        ) }}"
                                            alt="{{ $profile->registered_name }}"
                                            loading="lazy"
                                        >

                                    </div>

                                @else

                                    <div class="company-logo-placeholder">

                                        <i class="fa fa-building"></i>

                                    </div>

                                @endif

                            </td>


                            {{-- Company --}}
                            <td class="text-right">

                                <strong class="company-name">

                                    {{
                                        $profile?->registered_name
                                        ?: $application->intake_company_name
                                        ?: 'بدون نام'
                                    }}

                                </strong>


                                @if(
                                    $profile?->company_short_name
                                )

                                    <div class="company-secondary-text">

                                        {{
                                            $profile->company_short_name
                                        }}

                                    </div>

                                @endif


                                @if(
                                    $profile?->company_name_en
                                )

                                    <div
                                        class="company-en-name"
                                        dir="ltr"
                                    >

                                        {{
                                            $profile->company_name_en
                                        }}

                                    </div>

                                @endif


                                <div class="company-secondary-text">

                                    شماره درخواست:

                                    #{{ $application->id }}

                                </div>

                            </td>


                            {{-- Representative --}}
                            <td>

                                <strong>

                                    {{
                                        $application
                                            ->representative_name
                                        ?: '—'
                                    }}

                                </strong>


                                <div
                                    class="company-secondary-text"
                                    dir="ltr"
                                >

                                    {{
                                        $application
                                            ->representative_mobile
                                        ?: '—'
                                    }}

                                </div>

                            </td>


                            {{-- Current Stage --}}
                            <td>

                                @if(
                                    $application->currentStage
                                )

                                    <strong>

                                        {{
                                            $application
                                                ->currentStage
                                                ->name
                                        }}

                                    </strong>

                                    <div class="company-secondary-text">

                                        مرحله

                                        {{
                                            $application
                                                ->currentStage
                                                ->position
                                        }}

                                    </div>

                                @else

                                    <span class="company-secondary-text">
                                    —
                                </span>

                                @endif

                            </td>


                            {{-- State --}}
                            <td>

                                @switch(
                                    $application->state
                                )


                                    @case(
                                        MembershipApplicationState::Approved
                                    )

                                        <span class="company-status company-status-active">

                                        تأیید شده

                                    </span>

                                        @break


                                    @case(
                                        MembershipApplicationState::InReview
                                    )

                                        <span class="company-status company-status-suspended">

                                        در حال بررسی

                                    </span>

                                        @break


                                    @case(
                                        MembershipApplicationState::NeedsCorrection
                                    )

                                        <span class="company-status company-status-cancelled">

                                        نیازمند اصلاح

                                    </span>

                                        @break


                                    @case(
                                        MembershipApplicationState::Rejected
                                    )

                                        <span class="company-status company-status-cancelled">

                                        رد شده

                                    </span>

                                        @break


                                    @default

                                        <span class="company-status company-status-unknown">

                                        {{
                                            $application
                                                ->state
                                                ->label()
                                        }}

                                    </span>

                                @endswitch

                            </td>


                            {{-- Submitted At --}}
                            <td>

                                @if($submittedDate)

                                    <strong>
                                        {{ $submittedDate }}
                                    </strong>

                                @else

                                    <span class="company-secondary-text">
                                    —
                                </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td>

                                <div class="company-actions">

                                    <a
                                        href="{{ route(
                                            'admin.membership-applications.show',
                                            $application
                                        ) }}"
                                        class="company-action-btn company-edit-btn"
                                        title="مشاهده پرونده"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    @can('update', $application)
                                        <a
                                            href="{{ route(
                                                'admin.membership-applications.edit',
                                                $application
                                            ) }}"
                                            class="company-action-btn company-edit-btn"
                                            title="ویرایش پرونده"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8">

                                <div class="company-empty-state">

                                <span class="company-empty-icon">

                                    <i class="fa fa-folder-open-o"></i>

                                </span>

                                    <h3>
                                        درخواستی پیدا نشد
                                    </h3>

                                    <p>
                                        فیلترها را تغییر دهید یا منتظر ثبت درخواست جدید باشید.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =========================================================
                Pagination
            ========================================================== --}}

            <div class="company-table-footer">

                <div class="company-result-info">

                    @if(
                        $applications->total() > 0
                    )

                        نمایش

                        <strong>
                            {{ $applications->firstItem() }}
                        </strong>

                        تا

                        <strong>
                            {{ $applications->lastItem() }}
                        </strong>

                        از

                        <strong>
                            {{
                                number_format(
                                    $applications->total()
                                )
                            }}
                        </strong>

                        درخواست

                    @else

                        هیچ درخواستی برای نمایش وجود ندارد.

                    @endif

                </div>


                @if(
                    $applications->hasPages()
                )

                    <nav class="company-pagination-nav">

                        <ul class="company-pagination">


                            <li
                                class="{{ $applications->onFirstPage()
                                ? 'disabled'
                                : ''
                            }}"
                            >

                                @if(
                                    $applications->onFirstPage()
                                )

                                    <span>
                                    قبلی
                                </span>

                                @else

                                    <a
                                        href="{{ $pagination->previousPageUrl() }}"
                                    >
                                        قبلی
                                    </a>

                                @endif

                            </li>


                            @foreach(
                                $pagination->getUrlRange(
                                    max(
                                        1,
                                        $applications->currentPage() - 2
                                    ),
                                    min(
                                        $applications->lastPage(),
                                        $applications->currentPage() + 2
                                    )
                                )
                                as $page => $url
                            )

                                <li
                                    class="{{ $page ===
                                    $applications->currentPage()
                                        ? 'active'
                                        : ''
                                }}"
                                >

                                    @if(
                                        $page ===
                                        $applications->currentPage()
                                    )

                                        <span>
                                        {{ $page }}
                                    </span>

                                    @else

                                        <a href="{{ $url }}">
                                            {{ $page }}
                                        </a>

                                    @endif

                                </li>

                            @endforeach


                            <li
                                class="{{ $applications->hasMorePages()
                                ? ''
                                : 'disabled'
                            }}"
                            >

                                @if(
                                    $applications->hasMorePages()
                                )

                                    <a
                                        href="{{ $pagination->nextPageUrl() }}"
                                    >
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

                @endif

            </div>

        </div>

    </div>

@endsection
