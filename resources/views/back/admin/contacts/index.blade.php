@php
    $activeFilters = collect([
        request('q'),
        request('date_from'),
        request('date_to'),
        request('sort'),
    ])->filter()->count();

    $pagination = $messages->appends(request()->query());
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
                    <i class="fa fa-envelope ml-2"></i>
                    پیام‌های دریافتی
                </h4>
                <div class="news-page-subtitle">
                    مدیریت، جستجو، فیلتر و آرشیو کامل پیام‌های ارسال‌شده توسط کاربران
                </div>
            </div>
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

        @if(session()->has('error'))
            <div class="alert alert-danger font_13 border-0 shadow-sm rounded mb-4" role="alert">
                <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button" style="line-height: 0;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <i class="fa fa-exclamation-circle ml-2"></i>
                {{ session()->get('error') }}
            </div>
        @endif

        <div class="row row-sm mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">کل نتایج</div>
                            <h4 class="stat-value">{{ number_format($messages->total()) }}</h4>
                        </div>
                        <div class="stat-icon">
                            <i class="fa fa-envelope-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">نمایش در این صفحه</div>
                            <h4 class="stat-value">{{ number_format($messages->count()) }}</h4>
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
                                {{ $messages->currentPage() }}
                                <span class="font_12 text-muted">از {{ $messages->lastPage() }}</span>
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
                            جستجو و فیلتر پیام‌ها
                        </h6>
                        <div class="filter-subtitle">
                            نام، پل ارتباطی، موضوع، تاریخ ارسال و ترتیب نمایش را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary filter-reset-btn">
                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif
                </div>

                <form action="{{ route('admin.contacts.index') }}" method="GET">
                    <div class="row row-sm">
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-3">
                            <label>جستجو در پیام‌ها</label>
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="نام، ایمیل، موبایل یا موضوع پیام...">
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
                                    جدیدترین
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    قدیمی‌ترین
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-4 col-md-6 mb-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary filter-submit-btn w-100">
                                <i class="fa fa-filter ml-1"></i>
                                اعمال فیلتر
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
                        مدیریت و آرشیو پیام‌ها
                    </h4>
                    <div class="editorial-subtitle">
                        {{ number_format($messages->total()) }} پیام مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه {{ $messages->currentPage() }} از {{ $messages->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table editorial-table mb-0 font_13 text-center">
                        <thead>
                        <tr>
                            <th style="width: 5%;">ردیف</th>
                            <th class="text-right" style="width: 22%;">نام فرستنده</th>
                            <th style="width: 22%;">پل ارتباطی</th>
                            <th class="text-right" style="width: 26%;">موضوع پیام</th>
                            <th style="width: 13%;">تاریخ ارسال</th>
                            <th style="width: 12%;">عملیات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($messages as $key => $msg)
                            <tr>
                                <td class="editorial-index">
                                    {{ $messages->firstItem() + $key }}
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.contacts.show', $msg->id) }}"
                                       class="editorial-post-title d-block">
                                        {{ $msg->name }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        <i class="fa fa-clock-o ml-1"></i>
                                        {{ jdate($msg->created_at)->format('Y/m/d H:i') }}
                                    </div>
                                </td>

                                <td>
                                    <span class="editorial-category" dir="ltr">
                                        {{ $msg->contact }}
                                    </span>
                                </td>

                                <td class="text-right">
                                    <span class="editorial-views">
                                        {{ $msg->subject ?? 'بدون موضوع' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="editorial-views">
                                        <i class="fa fa-calendar-o ml-1"></i>
                                        {{ jdate($msg->created_at)->format('Y/m/d') }}
                                    </span>
                                </td>

                                <td>
                                    <div class="editorial-actions">
                                        <a href="{{ route('admin.contacts.show', $msg->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="مشاهده پیام">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="editorial-empty-state">
                                    <i class="fa fa-folder-open d-block mb-3"></i>
                                    <div class="fw-bold text-dark mb-1">پیامی پیدا نشد</div>
                                    <div class="text-muted">با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.</div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route('admin.contacts.index') }}"
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
                        @if($messages->total() > 0)
                            نمایش
                            <strong>{{ $messages->firstItem() }}</strong>
                            تا
                            <strong>{{ $messages->lastItem() }}</strong>
                            از
                            <strong>{{ number_format($messages->total()) }}</strong>
                            پیام
                        @else
                            هیچ پیامی برای نمایش وجود ندارد
                        @endif
                    </div>

                    <div class="editorial-pagination-links">
                        @if($messages->hasPages())
                            @php
                                $currentPage = $messages->currentPage();
                                $lastPage = $messages->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                $startPage = max($endPage - 4, 1);
                            @endphp

                            <nav class="custom-pagination-nav" aria-label="Page navigation">
                                <ul class="editorial-pagination">

                                    <li class="{{ $messages->onFirstPage() ? 'disabled' : '' }}">
                                        @if($messages->onFirstPage())
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

                                    <li class="{{ $messages->hasMorePages() ? '' : 'disabled' }}">
                                        @if($messages->hasMorePages())
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
