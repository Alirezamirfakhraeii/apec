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

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/posts/index.css') }}">
@endpush

@section('content')
    <div class="news-admin-wrapper">
        <br>

        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-users ml-2"></i>
                    بخش اعضا
                </h4>
                <div class="news-page-subtitle">
                    مدیریت، جستجو و آرشیو کامل کاربران سیستم
                </div>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn news-create-btn">
                <i class="fa fa-user-plus ml-2"></i>
                افزودن کاربر جدید
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
                            <h4 class="stat-value">{{ number_format($totalUsers) }}</h4>
                        </div>
                        <div class="stat-icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">نمایش در این صفحه</div>
                            <h4 class="stat-value">{{ number_format($currentCount) }}</h4>
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
                                {{ $currentPage }}
                                <span class="font_12 text-muted">از {{ $lastPage }}</span>
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
                            جستجو و فیلتر کاربران
                        </h6>
                        <div class="filter-subtitle">
                            نام، ایمیل، نقش و ترتیب نمایش کاربران را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary filter-reset-btn">
                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif
                </div>

                <form action="{{ route('admin.users.index') }}" method="GET">
                    <div class="row row-sm">
                        <div class="col-xl-4 col-lg-4 col-md-6 mb-3">
                            <label>جستجو در نام یا ایمیل</label>
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="مثلاً: admin@example.com یا علی">
                        </div>

                        @isset($roles)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                                <label>نقش کاربر</label>
                                <select name="role" class="form-control">
                                    <option value="">همه نقش‌ها</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endisset

                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>مرتب‌سازی</label>
                            <select name="sort" class="form-control">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    جدیدترین
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    قدیمی‌ترین
                                </option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>
                                    نام کاربر
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
                        مدیریت و آرشیو کاربران
                    </h4>
                    <div class="editorial-subtitle">
                        {{ number_format($totalUsers) }} کاربر مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه {{ $currentPage }} از {{ $lastPage }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table editorial-table mb-0 font_13 text-center">
                        <thead>
                        <tr>
                            <th style="width: 5%;">ردیف</th>
                            <th class="text-right" style="width: 30%;">نام کاربر</th>
                            <th style="width: 28%;">ایمیل</th>
                            <th style="width: 22%;">نقش فعلی</th>
                            <th style="width: 15%;">عملیات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($users as $index => $u)
                            <tr>
                                <td class="editorial-index">
                                    @if($isPaginated)
                                        {{ $users->firstItem() + $index }}
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.users.edit', $u->id) }}"
                                       class="editorial-post-title d-block">
                                        {{ $u->name }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        <i class="fa fa-clock-o ml-1"></i>
                                        @if($u->created_at)
                                            {{ jdate($u->created_at)->format('Y/m/d') }}
                                        @else
                                            تاریخ ثبت نشده
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <span class="editorial-views">
                                        <i class="fa fa-envelope-o ml-1"></i>
                                        {{ $u->email }}
                                    </span>
                                </td>

                                <td>
                                    @if($u->roles->isEmpty())
                                        <span class="editorial-category">
                                            کاربر عادی
                                        </span>
                                    @else
                                        @foreach($u->roles as $role)
                                            <span class="editorial-category mb-1">
                                                <i class="fa fa-user-tag ml-1"></i>
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>

                                <td>
                                    <div class="editorial-actions">
                                        <a href="{{ route('admin.users.edit', $u->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="ویرایش">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $u->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟')"
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
                                <td colspan="5" class="editorial-empty-state">
                                    <i class="fa fa-users d-block mb-3"></i>
                                    <div class="fw-bold text-dark mb-1">کاربری پیدا نشد</div>
                                    <div class="text-muted">با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.</div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route('admin.users.index') }}"
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
                        @if($totalUsers > 0)
                            نمایش
                            <strong>{{ $isPaginated ? $users->firstItem() : 1 }}</strong>
                            تا
                            <strong>{{ $isPaginated ? $users->lastItem() : $users->count() }}</strong>
                            از
                            <strong>{{ number_format($totalUsers) }}</strong>
                            کاربر
                        @else
                            هیچ کاربری برای نمایش وجود ندارد
                        @endif
                    </div>

                    <div class="editorial-pagination-links">
                        @if($isPaginated && $users->hasPages())
                            @php
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                $startPage = max($endPage - 4, 1);
                            @endphp

                            <nav class="custom-pagination-nav" aria-label="Page navigation">
                                <ul class="editorial-pagination">

                                    <li class="{{ $users->onFirstPage() ? 'disabled' : '' }}">
                                        @if($users->onFirstPage())
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

                                    <li class="{{ $users->hasMorePages() ? '' : 'disabled' }}">
                                        @if($users->hasMorePages())
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
