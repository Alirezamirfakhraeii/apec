@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش محتوا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت صفحات</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
                ایجاد صفحه جدید
            </a>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-1">لیست صفحات</h4>
                    <small class="text-muted">مدیریت صفحات ثابت سایت</small>
                </div>

                <div class="card-body pt-0" dir="rtl" style="text-align: right;">
                    @if(session('success'))
                        <div class="alert alert-success mt-2" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0 text-center">
                            <thead class="bg-secondary text-white">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th>عنوان صفحه</th>
                                <th>اسلاگ</th>
                                <th style="width: 120px;">وضعیت</th>
                                <th style="width: 180px;">تاریخ ایجاد</th>
                                <th style="width: 220px;">عملیات</th>
                            </tr>
                            </thead>

                            <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td class="text-right">
                                        <strong>{{ $page->title }}</strong>

                                        @if($page->summary)
                                            <div class="text-muted font_11 mt-1">
                                                {{ \Illuminate\Support\Str::limit($page->summary, 80) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td dir="ltr" class="text-left">
                                        {{ $page->slug }}
                                    </td>

                                    <td>
                                        @if($page->status)
                                            <span class="badge badge-success">فعال</span>
                                        @else
                                            <span class="badge badge-danger">غیرفعال</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $page->created_at ? $page->created_at->format('Y/m/d') : '-' }}
                                    </td>

                                    <td>
                                        <a href="{{ route('admin.pages.edit', $page->id) }}"
                                           class="btn btn-sm btn-info">
                                            ویرایش
                                        </a>

                                        <form action="{{ route('admin.pages.destroy', $page->id) }}"
                                              method="POST"
                                              class="d-inline-block"
                                              onsubmit="return confirm('آیا از حذف این صفحه مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        هنوز هیچ صفحه‌ای ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $pages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
