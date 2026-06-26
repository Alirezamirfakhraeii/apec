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

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/posts/index.css') }}">
@endpush

@section('content')
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
