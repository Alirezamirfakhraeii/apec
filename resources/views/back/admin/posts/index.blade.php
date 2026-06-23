@php
    use Illuminate\Support\Str;

    $activeFilters = collect([
        request('q'),
        request('status'),
        request('category_id'),
        request('date_from'),
        request('date_to'),
        request('sort'),
    ])->filter()->count();

    $pagination = $posts->appends(request()->query());

@endphp

@extends('back.admin.layouts.master')

@section('content')

    <style>
        .news-admin-wrapper {
            direction: rtl;
        }

        .news-page-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
        }

        .news-page-title {
            color: #111827;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .news-page-subtitle {
            color: #64748b;
            font-size: 13px;
        }

        .news-create-btn {
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 800;
            background: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
        }

        .news-create-btn:hover {
            background: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
        }

        .stat-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
        }

        .stat-label {
            color: #64748b;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .stat-value {
            color: #111827;
            font-size: 20px;
            font-weight: 900;
            margin: 0;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #334155;
        }

        .filter-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.04);
        }

        .filter-title {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
        }

        .filter-subtitle {
            color: #64748b;
            font-size: 12px;
        }

        .filter-card label {
            font-size: 12px;
            color: #475569;
            font-weight: 700;
        }

        .filter-card .form-control,
        .filter-card select {
            min-height: 42px;
            border-radius: 8px;
            border: 1px solid #dbe1ea;
            color: #334155;
            font-size: 13px;
            box-shadow: none;
        }

        .filter-card .form-control:focus,
        .filter-card select:focus {
            border-color: #334155;
            box-shadow: 0 0 0 0.12rem rgba(51, 65, 85, 0.12);
        }

        .filter-submit-btn {
            border-radius: 8px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 800;
            background: #1e293b;
            border-color: #1e293b;
        }

        .filter-submit-btn:hover {
            background: #0f172a;
            border-color: #0f172a;
        }

        .filter-reset-btn {
            border-radius: 8px;
            padding: 8px 15px;
            font-size: 12px;
            font-weight: 700;
        }

        .editorial-table-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.045);
            overflow: hidden;
            background: #ffffff;
        }

        .editorial-table-header {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .editorial-title {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
        }

        .editorial-title i {
            color: #334155;
        }

        .editorial-subtitle {
            color: #64748b;
            font-size: 12px;
        }

        .editorial-page-badge {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            padding: 7px 13px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 6px;
        }

        .editorial-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .editorial-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 12px;
            font-weight: 900;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 10px;
            white-space: nowrap;
        }

        .editorial-table tbody td {
            color: #334155;
            padding: 14px 10px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
        }

        .editorial-table tbody tr {
            transition: background 0.18s ease;
        }

        .editorial-table tbody tr:hover {
            background: #f9fafb;
        }

        .editorial-index {
            color: #64748b;
            font-weight: 800;
        }

        .editorial-thumb {
            width: 64px;
            height: 44px;
            object-fit: cover;
            border-radius: 7px;
            border: 1px solid #e5e7eb;
            background: #f8fafc;
        }

        .editorial-empty-thumb {
            width: 64px;
            height: 44px;
            border-radius: 7px;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            color: #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
        }

        .editorial-post-title {
            color: #0f172a;
            font-weight: 900;
            line-height: 1.8;
            text-decoration: none;
        }

        .editorial-post-title:hover {
            color: #1e40af;
            text-decoration: none;
        }

        .editorial-date {
            color: #64748b;
            font-size: 11px;
        }

        .editorial-category {
            display: inline-block;
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 700;
        }

        .editorial-status {
            display: inline-block;
            min-width: 82px;
            padding: 6px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 800;
        }

        .editorial-status.published {
            color: #166534;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        .editorial-status.draft {
            color: #854d0e;
            background: #fffbeb;
            border: 1px solid #fde68a;
        }

        .editorial-views {
            color: #334155;
            font-size: 12px;
            font-weight: 800;
        }

        .editorial-views i {
            color: #94a3b8;
        }

        .editorial-actions {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            direction: rtl;
        }

        .editorial-delete-form {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 0;
        }

        .editorial-action-btn {
            width: 34px;
            height: 34px;
            min-width: 34px;
            min-height: 34px;
            padding: 0;
            margin: 0;
            border-radius: 8px;
            border: 1px solid #dbe1ea;
            background: #ffffff;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: none;
            outline: none;
            transition: all 0.18s ease;
            appearance: none;
            -webkit-appearance: none;
        }

        .editorial-action-btn i {
            width: 13px;
            height: 13px;
            line-height: 13px;
            text-align: center;
            display: inline-block;
            font-size: 13px;
        }

        .editorial-action-btn:hover,
        .editorial-action-btn:focus {
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.08);
        }

        .editorial-edit-btn:hover {
            color: #1d4ed8;
            border-color: #bfdbfe;
            background: #eff6ff;
        }

        .editorial-delete-btn:hover {
            color: #b91c1c;
            border-color: #fecaca;
            background: #fef2f2;
        }

        .editorial-empty-state {
            text-align: center;
            padding: 55px 15px;
            color: #64748b;
            font-size: 13px;
        }

        .editorial-empty-state i {
            font-size: 38px;
            color: #cbd5e1;
        }

        .editorial-footer {
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            padding: 15px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
        }

        .editorial-pagination-info {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
        }

        .editorial-pagination-info strong {
            color: #0f172a;
            font-weight: 900;
        }

        .editorial-pagination-links {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-pagination-nav {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .editorial-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            margin: 0;
            padding: 0;
            list-style: none;
            direction: rtl;
        }

        .editorial-pagination li {
            margin: 0;
            padding: 0;
        }

        .editorial-pagination a,
        .editorial-pagination span {
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 7px;
            border: 1px solid #dbe1ea;
            background: #ffffff;
            color: #334155;
            font-size: 12px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            line-height: 1;
        }

        .editorial-pagination a:hover {
            background: #f8fafc;
            color: #0f172a;
            border-color: #cbd5e1;
            text-decoration: none;
        }

        .editorial-pagination .active span {
            background: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
        }

        .editorial-pagination .disabled span {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }

        .editorial-pagination .dots span {
            border-color: transparent;
            background: transparent;
            color: #94a3b8;
            min-width: 22px;
            padding: 0 4px;
        }

        .single-page-label {
            color: #64748b;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .news-page-header,
            .editorial-table-header,
            .editorial-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .news-create-btn {
                width: 100%;
                margin-top: 12px;
                text-align: center;
            }

            .stat-card {
                margin-bottom: 12px;
            }

            .editorial-pagination {
                flex-wrap: wrap;
                justify-content: flex-start;
            }
        }
    </style>

    <div class="news-admin-wrapper">
        <br>
        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">
            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-newspaper-o ml-2"></i>
                    اتاق خبر
                </h4>
                <div class="news-page-subtitle">
                    مدیریت، جستجو، فیلتر و آرشیو کامل اخبار و مقالات سایت
                </div>
            </div>

            <a href="{{ route('admin.posts.create') }}" class="btn news-create-btn">
                <i class="fa fa-plus-circle ml-2"></i>
                ارسال خبر جدید
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
                            <h4 class="stat-value">{{ number_format($posts->total()) }}</h4>
                        </div>
                        <div class="stat-icon">
                            <i class="fa fa-file-text-o"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card stat-card p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="stat-label">نمایش در این صفحه</div>
                            <h4 class="stat-value">{{ number_format($posts->count()) }}</h4>
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
                                {{ $posts->currentPage() }}
                                <span class="font_12 text-muted">از {{ $posts->lastPage() }}</span>
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
                            جستجو و فیلتر مطالب
                        </h6>
                        <div class="filter-subtitle">
                            عنوان، وضعیت، دسته‌بندی، تاریخ و ترتیب نمایش را مشخص کنید.
                        </div>
                    </div>

                    @if($activeFilters > 0)
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary filter-reset-btn">
                            <i class="fa fa-times ml-1"></i>
                            حذف فیلترها
                        </a>
                    @endif
                </div>

                <form action="{{ route('admin.posts.index') }}" method="GET">
                    <div class="row row-sm">
                        <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                            <label>جستجو در عنوان</label>
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   class="form-control"
                                   placeholder="مثلاً: اقتصاد، سینما، فناوری...">
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
                            <label>سرویس خبری</label>

                            <select name="blog_category_id" class="form-control">
                                <option value="">همه سرویس‌ها</option>

                                @foreach($categories->where('parent_id', null) as $mainCat)
                                    <option value="{{ $mainCat->id }}"
                                        {{ request('blog_category_id') == $mainCat->id ? 'selected' : '' }}>
                                        {{ $mainCat->name }}
                                    </option>

                                    @foreach($mainCat->children as $child)
                                        <option value="{{ $child->id }}"
                                            {{ request('blog_category_id') == $child->id ? 'selected' : '' }}>
                                            — {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
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

                        <div class="col-xl-1 col-lg-4 col-md-6 mb-3">
                            <label>مرتب‌سازی</label>
                            <select name="sort" class="form-control">
                                <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                    جدید
                                </option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                    قدیم
                                </option>
                                <option value="views" {{ request('sort') == 'views' ? 'selected' : '' }}>
                                    بازدید
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary filter-submit-btn">
                            <i class="fa fa-filter ml-2"></i>
                            اعمال فیلتر
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card editorial-table-card">
            <div class="editorial-table-header">
                <div>
                    <h4 class="card-title editorial-title mb-1">
                        <i class="fa fa-archive ml-2"></i>
                        مدیریت و آرشیو مطالب
                    </h4>
                    <div class="editorial-subtitle">
                        {{ number_format($posts->total()) }} مطلب مطابق با جستجوی شما پیدا شد.
                    </div>
                </div>

                <div class="d-none d-md-flex align-items-center">
                    <span class="editorial-page-badge">
                        صفحه {{ $posts->currentPage() }} از {{ $posts->lastPage() }}
                    </span>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table editorial-table mb-0 font_13 text-center">
                        <thead>
                        <tr>
                            <th style="width: 5%;">ردیف</th>
                            <th style="width: 8%;">تصویر</th>
                            <th class="text-right" style="width: 38%;">عنوان مطلب</th>
                            <th style="width: 14%;">دسته‌بندی</th>
                            <th style="width: 10%;">وضعیت</th>
                            <th style="width: 10%;">بازدید</th>
                            <th style="width: 15%;">عملیات</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($posts as $key => $post)
                            <tr>
                                <td class="editorial-index">
                                    {{ $posts->firstItem() + $key }}
                                </td>

                                <td>
                                    @if($post->mainImage && $post->mainImage->path)
                                        <img src="{{ $post->main_image_url }}"
                                             alt="{{ $post->title }}"
                                             class="editorial-thumb">
                                    @else
                                        <div class="editorial-empty-thumb mx-auto">
                                            بدون عکس
                                        </div>
                                    @endif
                                </td>

                                <td class="text-right">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                                       class="editorial-post-title d-block">
                                        {{ Str::limit($post->title, 75) }}
                                    </a>

                                    <div class="editorial-date mt-1">
                                        <i class="fa fa-clock-o ml-1"></i>
                                        @if($post->published_at)
                                            {{ $post->published_at }}
                                        @else
                                            تاریخ انتشار ثبت نشده
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <span class="editorial-category">
                                        {{ $post->category->name ?? 'بدون دسته‌بندی' }}
                                    </span>
                                </td>

                                <td>
                                    @if($post->status == 'published')
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
                                        <i class="fa fa-eye ml-1"></i>
                                        {{ number_format($post->view_count ?? $post->views ?? 0) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="editorial-actions">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}"
                                           class="editorial-action-btn editorial-edit-btn"
                                           title="ویرایش">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.posts.destroy', $post->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('آیا از حذف این خبر اطمینان دارید؟');"
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
                                    <i class="fa fa-folder-open d-block mb-3"></i>
                                    <div class="fw-bold text-dark mb-1">مطلبی پیدا نشد</div>
                                    <div class="text-muted">با تغییر فیلترها یا حذف جستجو دوباره امتحان کنید.</div>

                                    @if($activeFilters > 0)
                                        <a href="{{ route('admin.posts.index') }}"
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
                        @if($posts->total() > 0)
                            نمایش
                            <strong>{{ $posts->firstItem() }}</strong>
                            تا
                            <strong>{{ $posts->lastItem() }}</strong>
                            از
                            <strong>{{ number_format($posts->total()) }}</strong>
                            مطلب
                        @else
                            هیچ مطلبی برای نمایش وجود ندارد
                        @endif
                    </div>

                    <div class="editorial-pagination-links">
                        @if($posts->hasPages())
                            @php
                                $currentPage = $posts->currentPage();
                                $lastPage = $posts->lastPage();
                                $startPage = max($currentPage - 2, 1);
                                $endPage = min($startPage + 4, $lastPage);
                                $startPage = max($endPage - 4, 1);
                            @endphp

                            <nav class="custom-pagination-nav" aria-label="Page navigation">
                                <ul class="editorial-pagination">

                                    <li class="{{ $posts->onFirstPage() ? 'disabled' : '' }}">
                                        @if($posts->onFirstPage())
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

                                    <li class="{{ $posts->hasMorePages() ? '' : 'disabled' }}">
                                        @if($posts->hasMorePages())
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
