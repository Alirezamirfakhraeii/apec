@extends('back.admin.layouts.master')


<head>
    <link rel="stylesheet" href="{{ asset('back/css/pages/index.css') }}">
</head>


@section('content')
    <div class="news-admin-wrapper" dir="rtl">
        <div class="news-page-header">
            <div>
                <h1>مدیریت صفحات</h1>
                <p>صفحات ثابت، لندینگ‌ها و صفحات دارای تمپلیت را مدیریت کنید.</p>
            </div>

            <a href="{{ route('admin.pages.create') }}" class="news-create-btn">
                ساخت صفحه جدید
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="filter-card mb-4">
            <form action="{{ route('admin.pages.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label class="form-label">جستجو</label>
                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control"
                            placeholder="عنوان، اسلاگ یا خلاصه"
                        >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">تمپلیت</label>
                        <select name="template" class="form-control">
                            <option value="">همه تمپلیت‌ها</option>
                            @foreach($templates as $key => $template)
                                <option value="{{ $key }}" @selected(request('template') === $key)>
                                    {{ $template['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label">وضعیت</label>
                        <select name="status" class="form-control">
                            <option value="">همه</option>
                            <option value="active" @selected(request('status') === 'active')>فعال</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>غیرفعال</option>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="news-create-btn w-100">
                            فیلتر
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="editorial-table-card">
            <div class="editorial-table-header">
                <h2>لیست صفحات</h2>
            </div>

            <div class="table-responsive">
                <table class="table editorial-table">
                    <thead>
                    <tr>
                        <th>عنوان</th>
                        <th>اسلاگ</th>
                        <th>تمپلیت</th>
                        <th>وضعیت</th>
                        <th>تاریخ ساخت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>
                                <strong class="editorial-post-title">{{ $page->title }}</strong>

                                @if($page->summary)
                                    <div class="text-muted small mt-1">
                                        {{ \Illuminate\Support\Str::limit($page->summary, 80) }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                /{{ $page->slug }}
                            </td>

                            <td>
                                    <span class="editorial-category">
                                        {{ $templates[$page->template]['label'] ?? $page->template }}
                                    </span>
                            </td>

                            <td>
                                @if($page->status)
                                    <span class="editorial-status published">فعال</span>
                                @else
                                    <span class="editorial-status draft">غیرفعال</span>
                                @endif
                            </td>

                            <td>
                                {{ $page->created_at?->format('Y/m/d') }}
                            </td>

                            <td>
                                <div class="editorial-actions">
                                    <a
                                        href="{{ route('admin.pages.edit', $page) }}"
                                        class="editorial-action-btn"
                                    >
                                        ویرایش
                                    </a>

                                    <form
                                        action="{{ route('admin.pages.destroy', $page) }}"
                                        method="POST"
                                        onsubmit="return confirm('آیا از حذف این صفحه مطمئن هستید؟')"
                                        style="display: inline-block;"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="editorial-action-btn">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                هنوز صفحه‌ای ثبت نشده است.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="editorial-footer">
                {{ $pages->links() }}
            </div>
        </div>
    </div>
@endsection
