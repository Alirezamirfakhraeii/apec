@php
    use Illuminate\Support\Str;

    $activeFilters = collect([
        request('q'),
        request('status'),
        request('date_from'),
        request('date_to'),
        request('sort'),
    ])->filter()->count();

    $pagination = $podcasts->appends(request()->query());
@endphp

@extends('back.admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/posts/index.css') }}">
@endpush

@section('content')
    <div class="news-admin-wrapper">
        <br>

        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-microphone ml-2"></i>
                    اتاق پادکست
                </h4>
                <div class="news-page-subtitle">
                    مدیریت، جستجو، فیلتر و آرشیو کامل فایل‌های صوتی و پادکست‌های سایت
                </div>
            </div>

            <a href="{{ route('admin.podcasts.create') }}" class="btn news-create-btn">
                <i class="fa fa-plus-circle ml-2"></i>
                ثبت پادکست جدید
            </a>
        </div>

        @if(session()->has('success'))
            <div class="alert alert-success font_13 border-0 shadow-sm rounded mb-4" role="alert">
                <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button" style="line-height: 0;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-check-circle ml-2"></i>
                {{ session()->get('success') }}
            </div>
        @endif

        <div class="row row-sm mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">کل نتایج</div>
                            <h4 class="stat-value">{{ number_format($podcasts->total()) }}</h4>
                        </div>
                        <div class="stat-icon">
                            <i class="fa fa-microphone"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">نمایش در این صفحه</div>
                            <h4 class="stat-value">{{ number_format($podcasts->count()) }}</h4>
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
                            <div class="stat-label">صفحه فعلی</div>
                            <h4 class="stat-value">
                                {{ $podcasts->currentPage() }}
                                <span class="font_12 text-muted">از {{ $podcasts->lastPage() }}</span>
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
                            <div class="stat-label">فیلترهای فعال</div>
                            <h4 class="stat-value">{{ $activeFilters }}</h4>
                        </div>
                        <div class="stat-icon">
                            <i class="fa fa-filter"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card filter-card mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h6 class="filter-title mb-1">
                            <i class="fa fa-search ml-2"></i>
                            جستجو و فیلتر پادکست‌ها
                        </h6>
                        <div class="filter-subtitle">
                            عنوان، وضعیت، تاریخ ثبت و ترتیب نمایش را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.podcasts.index') }}" class="btn btn-outline-secondary filter-reset-btn">
                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif
                </div>

                <form action="{{ route('admin.podcasts.index') }}" method="GET">
                    <div class="row row-sm">
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>جستجو در عنوان</label>
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="مثلاً: گفت‌وگو، اقتصاد، فناوری...">
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>وضعیت انتشار</label>
                            <select name="status" class="form-control">
                                <option value="">همه وضعیت‌ها</option>
                                <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                    منتشر شده
                                </option>
                                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                                    پیش‌نویس
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>از تاریخ</label>
                            <input type="date"
                                   name="date_from"
                                   value="{{ request('date_from') }}"
                                   class="form-control">
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>تا تاریخ</label>
                            <input type="date"
                                   name="date_to"
                                   value="{{ request('date_to') }}"
                                   class="form-control">
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                            <label>مرتب‌سازی</label>
                            <select name="sort" class="form-control">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    جدید
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    قدیم
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-1 col-lg-4 col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary filter-submit-btn w-100">
                                <i class="fa fa-filter ml-1"></i>
                                اعمال
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card editorial-table-card">
            <div class="editorial-table-header">
                <div>
                    <h4 class="card-title editorial-title mb-1">
                        <i class="fa fa-archive ml-2"></i>
                        مدیریت و آرشیو پادکست‌ها
                    </h4>
                    <div class="editorial-subtitle">
                        {{ number_format($podcasts->total()) }} پادکست مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه {{ $podcasts->currentPage() }} از {{ $podcasts->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table editorial-table mb-0 font_13 text-center">
                        <thead>
                        <tr>
                            <th style="width: 5%;">ردیف</th>
                            <th style="width: 8%;">کاور</th>
                            <th class="text-right" style="width: 35%;">عنوان پادکست</th>
                            <th style="width: 15%;">میزبان</th>
                            <th style="width: 10%;">وضعیت</th>
                            <th style="width: 12%;">تاریخ ثبت</th>
                            <th style="width: 15%;">عملیات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($podcasts as $key => $podcast)
                            <tr>
                                <td class="editorial-index">
                                    {{ $podcasts->firstItem() + $key }}
                                </td>

                                <td>
                                    @if($podcast->image)
                                        <img src="{{ asset('storage/' . $podcast->image) }}"
                                             alt="{{ $podcast->title }}"
                                             class="editorial-thumb">
                                    @else
                                        <div class="editorial-empty-thumb mx-auto">
                                            بدون عکس
                                        </div>
                                    @endif
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.podcasts.edit', $podcast->id) }}"
                                       class="editorial-post-title d-block">
                                        {{ Str::limit($podcast->title, 75) }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        <i class="fa fa-clock-o ml-1"></i>
                                        @if($podcast->created_at)
                                            {{ jdate($podcast->created_at)->format('Y/m/d') }}
                                        @else
                                            تاریخ ثبت نشده
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <span class="editorial-category">
                                        {{ $podcast->host_name ?? '---' }}
                                    </span>
                                </td>

                                <td>
                                    @if($podcast->status == 'published')
                                        <span class="editorial-status published">
                                            منتشر شده
                                        </span>
                                    @else
                                        <span class="editorial-status draft">
                                            پیش‌نویس
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="editorial-views">
                                        <i class="fa fa-calendar-o ml-1"></i>
                                        @if($podcast->created_at)
                                            {{ jdate($podcast->created_at)->format('Y/m/d') }}
                                        @else
                                            ---
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <div class="editorial-actions">
                                        <a href="{{ route('admin.podcasts.edit', $podcast->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="ویرایش">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.podcasts.destroy', $podcast->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('آیا از حذف این پادکست اطمینان دارید؟');"
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
                                <td colspan="7" class="editorial-empty-state">
                                    <i class="fa fa-microphone-slash d-block mb-3"></i>
                                    <div class="fw-bold text-dark mb-1">پادکستی پیدا نشد</div>
                                    <div class="text-muted">با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.</div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route('admin.podcasts.index') }}"
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

                <div class="editorial-footer">
                    <div class="editorial-pagination-info">
                        @if($podcasts->total() > 0)
                            نمایش
                            <strong>{{ $podcasts->firstItem() }}</strong>
                            تا
                            <strong>{{ $podcasts->lastItem() }}</strong>
                            از
                            <strong>{{ number_format($podcasts->total()) }}</strong>
                            پادکست
                        @else
                            هیچ پادکستی برای نمایش وجود ندارد
                        @endif
                    </div>

                    <div class="editorial-pagination-links">
                        @if($podcasts->hasPages())
                            @php
                                $currentPage = $podcasts->currentPage();
                                $lastPage = $podcasts->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                $startPage = max($endPage - 4, 1);
                            @endphp

                            <nav class="custom-pagination-nav" aria-label="Page navigation">
                                <ul class="editorial-pagination">

                                    <li class="{{ $podcasts->onFirstPage() ? 'disabled' : '' }}">
                                        @if($podcasts->onFirstPage())
                                            <span>قبلی</span>
                                        @else
                                            <a href="{{ $pagination->previousPageUrl() }}">قبلی</a>
                                        @endif
                                    </li>

                                    @if($startPage > 1)
                                        <li>
                                            <a href="{{ $pagination->url(1) }}">1</a>
                                        </li>

                                        @if($startPage > 2)
                                            <li class="dots">
                                                <span>...</span>
                                            </li>
                                        @endif
                                    @endif

                                    @for($page = $startPage; $page <= $endPage; $page++)
                                        <li class="{{ $page == $currentPage ? 'active' : '' }}">
                                            @if($page == $currentPage)
                                                <span>{{ $page }}</span>
                                            @else
                                                <a href="{{ $pagination->url($page) }}">{{ $page }}</a>
                                            @endif
                                        </li>
                                    @endfor

                                    @if($endPage < $lastPage)
                                        @if($endPage < $lastPage - 1)
                                            <li class="dots">
                                                <span>...</span>
                                            </li>
                                        @endif

                                        <li>
                                            <a href="{{ $pagination->url($lastPage) }}">{{ $lastPage }}</a>
                                        </li>
                                    @endif

                                    <li class="{{ $podcasts->hasMorePages() ? '' : 'disabled' }}">
                                        @if($podcasts->hasMorePages())
                                            <a href="{{ $pagination->nextPageUrl() }}">بعدی</a>
                                        @else
                                            <span>بعدی</span>
                                        @endif
                                    </li>

                                </ul>
                            </nav>
                        @else
                            <span class="single-page-label">فقط یک صفحه</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
