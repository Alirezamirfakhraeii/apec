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
            <div class="companies-filter-card">

                <form action="{{ route('companies.index') }}"
                      method="GET">

                    <input type="hidden"
                           name="view"
                           value="{{ $viewMode }}">

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
                                       placeholder="نام شرکت، شناسه ملی، شماره عضویت یا فعالیت...">
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
                                    {{ request('membership_type') === 'اصلی' ? 'selected' : '' }}>
                                    اصلی
                                </option>

                                <option value="وابسته"
                                    {{ request('membership_type') === 'وابسته' ? 'selected' : '' }}>
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

                        <div class="col-xl-3 col-lg-3 col-md-12 mb-3">
                            <div class="d-flex companies-filter-actions">

                                <button type="submit"
                                        class="btn companies-search-btn">
                                    <i class="fa fa-search ml-1"></i>
                                    جستجو
                                </button>

                                @if(
                                    request()->filled('q') ||
                                    request()->filled('membership_type') ||
                                    request()->filled('membership_status')
                                )
                                    <a href="{{ route('companies.index', ['view' => $viewMode]) }}"
                                       class="btn companies-reset-btn">

                                        <i class="fa fa-times ml-1"></i>
                                        حذف
                                    </a>
                                @endif

                            </div>
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
                        <span>نمایش لوگویی</span>
                    </a>

                </div>
            </div>

            {{-- نوع نمایش --}}
            @if($viewMode === 'table')
                @include('front.companies.partials.table')
            @else
                @include('front.companies.partials.grid')
            @endif

            {{-- Modalهای شرکت‌ها --}}
            @foreach($companies as $company)
                @include(
                    'front.companies.partials.modal',
                    ['company' => $company]
                )
            @endforeach

            {{-- صفحه‌بندی --}}
            @if($companies->hasPages())
                <div class="companies-pagination">
                    {{ $companies->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>
    </section>

@endsection
