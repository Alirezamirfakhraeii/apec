@extends('front.layouts.master')

@push('styles')
    <link rel="stylesheet"
          href="{{ asset('front/css/companies/index.css') }}">
@endpush

@section('content')

    <section class="companies-page">

        <div class="container">

            {{-- هدر صفحه --}}
            <div class="companies-hero">
                <div>
                    <span class="companies-eyebrow">
                        اعضای انجمن
                    </span>

                    <h1 class="companies-title">
                        فهرست شرکت‌های عضو
                    </h1>

                    <p class="companies-description">
                        مشاهده و جستجو در اطلاعات شرکت‌های عضو انجمن به‌صورت
                        فهرست جدولی یا نمایش لوگویی
                    </p>
                </div>

                <div class="companies-total">
                    <span class="companies-total-number">
                        {{ number_format($totalCompanies) }}
                    </span>

                    <span class="companies-total-label">
                        شرکت ثبت‌شده
                    </span>
                </div>
            </div>

            {{-- جستجو و فیلتر --}}
            @php
                $activitySectionTitles = [
                    'discipline' => [
                        'title' => 'دیسپلین تخصصی',
                        'icon' => 'fa-cogs',
                    ],
                    'work_field' => [
                        'title' => 'زمینه‌های کاری',
                        'icon' => 'fa-briefcase',
                    ],
                    'industry' => [
                        'title' => 'زمینه فعالیت در صنعت',
                        'icon' => 'fa-industry',
                    ],
                ];

                $selectedActivityCount = collect(
                    request('activity_fields', [])
                )
                    ->flatten()
                    ->filter()
                    ->count();

                $hasActiveFilters =
                    request()->filled('q') ||
                    request()->filled('membership_type') ||
                    request()->filled('membership_status') ||
                    $selectedActivityCount > 0;
            @endphp

            {{-- جستجو و فیلتر پیشرفته --}}
            <div class="companies-filter-card">

                <form action="{{ route('companies.index') }}"
                      method="GET"
                      id="companies-filter-form">

                    <input type="hidden"
                           name="view"
                           value="{{ $viewMode }}">

                    {{-- فیلترهای اصلی --}}
                    <div class="row align-items-end">

                        <div class="col-xl-5 col-lg-5 col-md-12 mb-3">
                            <label for="q" class="companies-filter-label">
                                جستجوی شرکت
                            </label>

                            <div class="companies-search-wrapper">
                                <i class="fa fa-search"></i>

                                <input type="text"
                                       name="q"
                                       id="q"
                                       value="{{ request('q') }}"
                                       class="form-control"
                                       placeholder="نام شرکت، شناسه ملی، شماره عضویت یا حوزه فعالیت...">
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6 mb-3">
                            <label for="membership_type"
                                   class="companies-filter-label">
                                نوع عضویت
                            </label>

                            <select name="membership_type"
                                    id="membership_type"
                                    class="form-control">

                                <option value="">همه انواع</option>

                                <option value="اصلی"
                                    @selected(request('membership_type') === 'اصلی')>
                                    اصلی
                                </option>

                                <option value="وابسته"
                                    @selected(request('membership_type') === 'وابسته')>
                                    وابسته
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-2 col-md-6 mb-3">
                            <label for="membership_status"
                                   class="companies-filter-label">
                                وضعیت عضویت
                            </label>

                            <select name="membership_status"
                                    id="membership_status"
                                    class="form-control">

                                <option value="">همه وضعیت‌ها</option>

                                <option value="فعال"
                                    @selected(request('membership_status') === 'فعال')>
                                    فعال
                                </option>

                                <option value="تعلیق"
                                    @selected(request('membership_status') === 'تعلیق')>
                                    تعلیق
                                </option>

                                <option value="لغو"
                                    @selected(request('membership_status') === 'لغو')>
                                    لغو
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-12 mb-3">

                            <button type="button"
                                    class="btn companies-advanced-filter-btn"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#advanced-company-filters"
                                    aria-expanded="{{ $selectedActivityCount > 0 ? 'true' : 'false' }}"
                                    aria-controls="advanced-company-filters">

                                <i class="fa fa-sliders ml-1"></i>

                                فیلتر حوزه‌های فعالیت

                                <span class="companies-selected-count"
                                      id="selected-activity-count">
                        {{ $selectedActivityCount }}
                    </span>
                            </button>

                        </div>

                    </div>

                    {{-- فیلتر حوزه‌های فعالیت --}}
                    <div class="collapse {{ $selectedActivityCount > 0 ? 'show' : '' }}"
                         id="advanced-company-filters">

                        <div class="companies-advanced-filters">

                            <div class="companies-advanced-header">

                                <div>
                                    <h3 class="companies-advanced-title">
                                        فیلتر پیشرفته حوزه‌های فعالیت
                                    </h3>

                                    <p class="companies-advanced-description">
                                        در هر بخش می‌توانید چند گزینه انتخاب کنید.
                                        نتایج باید حداقل با یکی از گزینه‌های هر بخش مطابقت داشته باشند.
                                    </p>
                                </div>

                                @if($selectedActivityCount > 0)
                                    <button type="button"
                                            class="companies-clear-all-activities"
                                            id="clear-all-activities">

                                        <i class="fa fa-times ml-1"></i>
                                        حذف انتخاب‌های فعالیت
                                    </button>
                                @endif

                            </div>

                            <div class="row">

                                @foreach($activitySectionTitles as $sectionKey => $sectionInformation)

                                    @php
                                        $sectionFields = collect(
                                            $activityFields->get(
                                                $sectionKey,
                                                collect()
                                            )
                                        )->sortBy('sort_order');

                                        $selectedSectionIds = collect(
                                            request("activity_fields.$sectionKey", [])
                                        )
                                            ->map(fn ($id) => (int) $id)
                                            ->all();
                                    @endphp

                                    <div class="col-xl-4 col-lg-4 col-md-12 mb-3">

                                        <div class="companies-activity-group"
                                             data-activity-group="{{ $sectionKey }}">

                                            <div class="companies-activity-group-header">

                                                <div class="companies-activity-heading">

                                        <span class="companies-activity-icon">
                                            <i class="fa {{ $sectionInformation['icon'] }}"></i>
                                        </span>

                                                    <div>
                                                        <h4>
                                                            {{ $sectionInformation['title'] }}
                                                        </h4>

                                                        <span class="companies-group-selected-count">
                                                {{ count($selectedSectionIds) }}
                                                انتخاب
                                            </span>
                                                    </div>

                                                </div>

                                                <button type="button"
                                                        class="companies-clear-group"
                                                        data-clear-group="{{ $sectionKey }}">

                                                    پاک‌کردن
                                                </button>

                                            </div>

                                            <div class="companies-activity-options">

                                                @forelse($sectionFields as $field)

                                                    <label class="companies-activity-option"
                                                           for="activity-filter-{{ $field->id }}">

                                                        <input type="checkbox"
                                                               id="activity-filter-{{ $field->id }}"
                                                               name="activity_fields[{{ $sectionKey }}][]"
                                                               value="{{ $field->id }}"
                                                               class="companies-activity-checkbox"
                                                               data-section="{{ $sectionKey }}"
                                                            @checked(
                                                                in_array(
                                                                    (int) $field->id,
                                                                    $selectedSectionIds,
                                                                    true
                                                                )
                                                            )>

                                                        <span class="companies-custom-checkbox">
                                                <i class="fa fa-check"></i>
                                            </span>

                                                        <span class="companies-activity-option-title">
                                                {{ $field->title }}
                                            </span>

                                                    </label>

                                                @empty

                                                    <div class="companies-empty-filter">
                                                        گزینه‌ای برای این بخش تعریف نشده است.
                                                    </div>

                                                @endforelse

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    {{-- دکمه‌های اجرا --}}
                    <div class="companies-filter-footer">

                        <div class="companies-filter-summary">

                            <i class="fa fa-filter ml-1"></i>

                            <span>
                    <strong id="filter-summary-count">
                        {{ $selectedActivityCount }}
                    </strong>

                    حوزه فعالیت انتخاب شده است
                </span>

                        </div>

                        <div class="companies-filter-actions">

                            <button type="submit"
                                    class="btn companies-search-btn">

                                <i class="fa fa-search ml-1"></i>
                                اعمال فیلترها
                            </button>

                            @if($hasActiveFilters)
                                <a href="{{ route('companies.index', ['view' => $viewMode]) }}"
                                   class="btn companies-reset-btn">

                                    <i class="fa fa-times ml-1" style="margin-top: 1rem;"></i>
                                    حذف همه فیلترها
                                </a>
                            @endif

                        </div>

                    </div>

                </form>

            </div>

            {{-- نوار انتخاب نوع نمایش --}}
            <div class="companies-toolbar">

                <div class="companies-result-count">
                    <i class="fa fa-building ml-1"></i>

                    <strong>
                        {{ number_format($companies->total()) }}
                    </strong>

                    شرکت پیدا شد
                </div>

                <div class="companies-view-switcher">

                    <a href="{{ route(
                        'companies.index',
                        array_merge(
                            request()->except('page'),
                            ['view' => 'table']
                        )
                    ) }}"
                       class="companies-view-btn {{ $viewMode === 'table' ? 'active' : '' }}">

                        <i class="fa fa-list"></i>
                        <span>نمایش جدولی</span>
                    </a>

                    <a href="{{ route(
                        'companies.index',
                        array_merge(
                            request()->except('page'),
                            ['view' => 'grid']
                        )
                    ) }}"
                       class="companies-view-btn {{ $viewMode === 'grid' ? 'active' : '' }}">

                        <i class="fa fa-th-large"></i>
                        <span>نمایش مشبک</span>
                    </a>

                </div>
            </div>

            {{-- نوع نمایش --}}
            @if($viewMode === 'table')
                @include('front.companies.partials.table')
            @else
                @include('front.companies.partials.grid')
            @endif

            {{-- صفحه‌بندی --}}
            @if($companies->hasPages())
                <div class="companies-pagination">
                    <div class="companies-pagination-info">
                        نمایش
                        <strong>{{ $companies->firstItem() }}</strong>
                        تا
                        <strong>{{ $companies->lastItem() }}</strong>
                        از
                        <strong>{{ $companies->total() }}</strong>
                        شرکت
                    </div>

                    <div class="companies-pagination-links">
                        {{ $companies->onEachSide(1)->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            @endif

        </div>
    </section>

    {{-- مودال‌ها عمداً بیرون container و section قرار گرفته‌اند
         تا position و overflow والدها باعث رفتن مودال زیر هدر ثابت نشود. --}}
    @foreach($companies as $company)
        @include(
            'front.companies.partials.modal',
            ['company' => $company]
        )
    @endforeach

    <style>
        /* =========================================================
   Fixed header offset
========================================================= */

        /*
         | ارتفاع هدر ثابت سایت را اینجا تنظیم کن.
         | اگر هدر تو کوتاه‌تر یا بلندتر است فقط عدد زیر را تغییر بده.
         */
        :root {
            --companies-fixed-header-offset: 105px;
        }

        .companies-page {
            position: relative;
            padding-top: var(--companies-fixed-header-offset);
        }

        /*
         | مودال و backdrop باید از هدر ثابت سایت بالاتر باشند.
         */
        .company-modal.modal {
            z-index: 10050 !important;
        }

        .modal-backdrop {
            z-index: 10040 !important;
        }

        body.modal-open {
            overflow: hidden;
        }

        @media (max-width: 768px) {
            :root {
                --companies-fixed-header-offset: 82px;
            }
        }

        /* =========================================================
   Companies Pagination
========================================================= */

        .companies-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;

            margin-top: 30px;
            padding: 16px 20px;

            background: #ffffff;
            border: 1px solid #e8edf3;
            border-radius: 16px;

            box-shadow:
                0 8px 25px rgba(15, 23, 42, 0.05),
                0 2px 6px rgba(15, 23, 42, 0.03);
        }

        /* متن تعداد نتایج */

        .companies-pagination-info {
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
            white-space: nowrap;
        }

        .companies-pagination-info strong {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 25px;
            height: 25px;
            margin: 0 3px;
            padding: 0 7px;

            color: #0f172a;
            background: #f1f5f9;
            border-radius: 7px;

            font-size: 12px;
            font-weight: 700;
        }

        /* حذف فاصله پیش‌فرض بوت‌استرپ */

        .companies-pagination-links nav {
            margin: 0;
        }

        .companies-pagination-links .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 7px;

            margin: 0;
            padding: 0;
        }

        /* آیتم‌های صفحه‌بندی */

        .companies-pagination-links .page-item {
            margin: 0;
        }

        .companies-pagination-links .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            min-width: 40px;
            height: 40px;
            padding: 0 12px;

            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px !important;

            font-size: 13px;
            font-weight: 600;
            line-height: 1;

            box-shadow: none;
            transition:
                background-color 0.2s ease,
                border-color 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        /* حالت هاور */

        .companies-pagination-links .page-link:hover {
            color: #ffffff;
            background: #334155;
            border-color: #334155;

            box-shadow: 0 7px 18px rgba(51, 65, 85, 0.2);
            transform: translateY(-2px);
        }

        /* صفحه فعال */

        .companies-pagination-links .page-item.active .page-link {
            color: #ffffff;
            background: linear-gradient(135deg, #0f172a, #334155);
            border-color: #0f172a;

            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.24);
            transform: translateY(-1px);
        }

        /* آیتم غیرفعال */

        .companies-pagination-links .page-item.disabled .page-link {
            color: #cbd5e1;
            background: #f8fafc;
            border-color: #eef2f7;

            cursor: not-allowed;
            box-shadow: none;
            transform: none;
        }

        /* حذف فوکوس پیش‌فرض بوت‌استرپ */

        .companies-pagination-links .page-link:focus {
            box-shadow: 0 0 0 4px rgba(51, 65, 85, 0.1);
        }

        /* فلش‌های قبلی و بعدی */

        .companies-pagination-links .page-item:first-child .page-link,
        .companies-pagination-links .page-item:last-child .page-link {
            min-width: 44px;
            background: #ffffff;
        }

        .companies-pagination-links .page-item:first-child:not(.disabled) .page-link:hover,
        .companies-pagination-links .page-item:last-child:not(.disabled) .page-link:hover {
            color: #ffffff;
            background: #0f172a;
        }

        /* Responsive */

        @media (max-width: 768px) {
            .companies-pagination {
                flex-direction: column;
                justify-content: center;
                padding: 15px;
            }

            .companies-pagination-info {
                width: 100%;
                text-align: center;
                white-space: normal;
            }

            .companies-pagination-links {
                width: 100%;
                overflow-x: auto;
                padding-bottom: 3px;
            }

            .companies-pagination-links .pagination {
                flex-wrap: nowrap;
                justify-content: flex-start;
                width: max-content;
                min-width: 100%;
            }

            .companies-pagination-links .page-link {
                min-width: 38px;
                height: 38px;
                padding: 0 10px;
            }
        }

        @media (max-width: 480px) {
            .companies-pagination-info {
                font-size: 12px;
            }

            .companies-pagination-links .page-link {
                min-width: 36px;
                height: 36px;
                padding: 0 9px;
                font-size: 12px;
                border-radius: 9px !important;
            }
        }


        /* =========================================================
   Company Details Modal
========================================================= */

        .company-modal .modal-dialog {
            max-width: 1180px;
        }

        .company-modal .modal-content {
            overflow: hidden;
            background: #f8fafc;
            border: 0;
            border-radius: 22px;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.2);
        }

        .company-modal-header {
            align-items: flex-start;
            padding: 22px 25px;
            background: #ffffff;
            border-bottom: 1px solid #e8edf3;
        }

        .company-modal-heading {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .company-modal-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 78px;
            height: 78px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 17px;
            box-shadow: 0 7px 20px rgba(15, 23, 42, 0.07);
        }

        .company-modal-logo img {
            width: 100%;
            height: 100%;
            padding: 7px;
            object-fit: contain;
        }

        .company-modal-logo-empty {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #94a3b8;
            background: #f1f5f9;
            font-size: 30px;
        }

        .company-modal-title-wrapper {
            min-width: 0;
        }

        .company-modal-title-wrapper .modal-title {
            margin: 0;
            color: #0f172a;
            font-size: 20px;
            font-weight: 800;
            line-height: 1.8;
        }

        .company-modal-en-name {
            margin-top: 2px;
            color: #64748b;
            font-size: 13px;
            text-align: right;
        }

        .company-modal-header-badges {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 10px;
        }

        .company-membership-number {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 4px 11px;
            color: #475569;
            background: #f1f5f9;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .company-modal-body {
            padding: 22px;
        }

        .company-modal-section {
            margin-bottom: 18px;
            padding: 20px;
            background: #ffffff;
            border: 1px solid #e6ebf1;
            border-radius: 17px;
            box-shadow: 0 5px 18px rgba(15, 23, 42, 0.035);
        }

        .company-modal-section:last-child {
            margin-bottom: 0;
        }

        .company-modal-section-header {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 17px;
            padding-bottom: 13px;
            border-bottom: 1px solid #eef2f6;
        }

        .company-modal-section-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            color: #ffffff;
            background: #334155;
            border-radius: 11px;
            font-size: 16px;
        }

        .company-modal-section-header h5 {
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
        }

        .company-modal-section-header p {
            margin: 3px 0 0;
            color: #94a3b8;
            font-size: 11px;
        }

        .company-information-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 11px;
        }

        .company-info-item {
            min-width: 0;
            padding: 13px 14px;
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 11px;
        }

        .company-info-label {
            display: block;
            margin-bottom: 6px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
        }

        .company-info-value {
            display: block;
            overflow-wrap: anywhere;
            color: #1e293b;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.8;
        }

        .company-info-value a {
            color: #2563eb;
            text-decoration: none;
        }

        .company-info-value a:hover {
            text-decoration: underline;
        }

        .company-modal-text {
            color: #475569;
            font-size: 13px;
            line-height: 2.1;
        }

        .company-address-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 13px;
        }

        .company-address-box {
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 12px;
        }

        /* Activity fields */

        .company-activity-groups {
            display: grid;
            gap: 14px;
        }

        .company-activity-group {
            padding: 15px;
            background: #f8fafc;
            border: 1px solid #edf1f5;
            border-radius: 13px;
        }

        .company-activity-group h6 {
            margin: 0 0 12px;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .company-activity-group h6 i {
            margin-left: 5px;
        }

        .company-activity-tags {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 7px;
        }

        .company-activity-tag {
            display: inline-flex;
            align-items: center;
            min-height: 31px;
            padding: 5px 11px;
            color: #334155;
            background: #ffffff;
            border: 1px solid #dbe3eb;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
        }

        /* Ranks */

        .company-rank-groups {
            display: grid;
            gap: 15px;
        }

        .company-rank-group {
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
        }

        .company-rank-group-title {
            padding: 11px 15px;
            color: #ffffff;
            background: #334155;
            font-size: 13px;
            font-weight: 800;
        }

        .company-rank-list {
            display: grid;
            gap: 1px;
            background: #e9eef4;
        }

        .company-rank-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 13px 15px;
            background: #ffffff;
        }

        .company-rank-content {
            min-width: 0;
        }

        .company-rank-title {
            display: block;
            color: #1e293b;
            font-size: 13px;
        }

        .company-rank-description {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 11px;
            line-height: 1.9;
        }

        .company-rank-value {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
            padding: 6px 10px;
            color: #92400e;
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
        }

        .company-rank-value strong {
            font-size: 15px;
        }

        /* Footer */

        .company-modal-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 22px;
            background: #ffffff;
            border-top: 1px solid #e8edf3;
        }

        .company-modal-footer-actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }

        .company-website-btn,
        .company-catalog-btn,
        .company-modal-close-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            padding: 8px 16px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .company-website-btn {
            color: #ffffff;
            background: #0f172a;
            border: 1px solid #0f172a;
        }

        .company-website-btn:hover {
            color: #ffffff;
            background: #334155;
        }

        .company-catalog-btn {
            color: #ffffff;
            background: #b91c1c;
            border: 1px solid #b91c1c;
        }

        .company-catalog-btn:hover {
            color: #ffffff;
            background: #991b1b;
        }

        .company-modal-close-btn {
            color: #475569;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
        }

        /* Responsive */

        @media (max-width: 992px) {
            .company-information-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .company-modal .modal-dialog {
                margin: 10px;
            }

            .company-modal-header {
                padding: 17px;
            }

            .company-modal-heading {
                align-items: flex-start;
            }

            .company-modal-logo {
                width: 62px;
                height: 62px;
            }

            .company-modal-title-wrapper .modal-title {
                font-size: 16px;
            }

            .company-modal-body {
                padding: 12px;
            }

            .company-modal-section {
                padding: 15px;
                border-radius: 13px;
            }

            .company-information-grid,
            .company-address-grid {
                grid-template-columns: 1fr;
            }

            .company-rank-item {
                align-items: flex-start;
                flex-direction: column;
            }

            .company-modal-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .company-modal-footer-actions {
                width: 100%;
            }

            .company-modal-footer-actions .btn,
            .company-modal-close-btn {
                flex: 1;
            }
        }
    </style>

@endsection
