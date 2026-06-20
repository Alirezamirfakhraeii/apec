@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between border-bottom pb-3 mb-4">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto text-dark fw-bold">اتاق خبر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ لیست اخبار و مقالات</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary fw-bold px-3 shadow-sm rounded-pill">
                    <i class="fa fa-plus-circle ml-2"></i> ارسال خبر جدید
                </a>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success font_13 border-0 shadow-sm rounded mb-4" role="alert">
            <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button" style="line-height: 0;">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fa fa-check-circle ml-2"></i> {{ session()->get('success') }}
        </div>
    @endif

    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-header bg-white pb-3 border-bottom d-flex align-items-center justify-content-between">
                    <h4 class="card-title text-dark mb-0 font_14 fw-bold"><i
                            class="fa fa-list-ul ml-2 text-primary"></i>مدیریت و آرشیو مطالب</h4>
                    <span
                        class="badge badge-light text-muted font_11 p-2">صفحه {{ $posts->currentPage() }} از {{ $posts->lastPage() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 font_13 text-center align-middle">
                            <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 5%; padding: 15px 8px;">#</th>
                                <th style="width: 8%; padding: 15px 8px;">تصویر</th>
                                <th class="text-right" style="width: 42%; padding: 15px 8px;">عنوان مطلب</th>
                                <th style="width: 15%; padding: 15px 8px;">دسته‌بندی</th>
                                <th style="width: 10%; padding: 15px 8px;">وضعیت</th>
                                <th style="width: 10%; padding: 15px 8px;">تعداد بازدید</th>
                                <th style="width: 10%; padding: 15px 8px;">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($posts as $key => $post)
                                <tr>
                                    <td class="align-middle fw-bold text-muted">{{ $posts->firstItem() + $key }}</td>
                                    <td class="align-middle">
                                        @if($post->mainImage && $post->mainImage->path)
                                            <img src="{{ $post->main_image_url }}"
                                                 alt="{{ $post->title }}"
                                                 class="rounded border shadow-sm"
                                                 style="width: 50px; height: 38px; object-fit: cover;">
                                        @else
                                            <span class="badge badge-light text-muted font_10 border py-2 px-1 d-block">
            بدون عکس
        </span>
                                        @endif
                                    </td>
                                    <td class="text-right align-middle fw-bold">
                                        <a href="#"
                                           class="text-dark text-decoration-none hover-primary d-block py-1">{{ \Illuminate\Support\Str::limit($post->title, 65) }}</a>
                                    </td>
                                    <td class="align-middle">
                                        <span
                                            class="badge badge-light text-secondary border font_11 px-2 py-1.5">{{ $post->category->name ?? 'بدون دسته‌بندی' }}</span>
                                    </td>
                                    <td class="align-middle">
                                        @if($post->status == 'published')
                                            <span
                                                class="badge bg-success-transparent text-success border border-success-transparent font_11 px-2 py-1.5 rounded-pill"><i
                                                    class="fa fa-circle font_8 ml-2"></i>منتشر شده</span>
                                        @else
                                            <span
                                                class="badge bg-warning-transparent text-warning border border-warning-transparent font_11 px-2 py-1.5 rounded-pill"><i
                                                    class="fa fa-circle font_8 ml-2"></i>پیش‌نویس</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <span class="text-dark fw-bold font_12"><i
                                                class="fa fa-eye text-muted ml-2 font_10"></i>{{ $post->view_count ?? $post->views ?? 0 }}</span>
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-icon-list d-flex justify-content-center">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}"
                                               class="btn btn-sm btn-info text-white ml-2 rounded" title="ویرایش">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                                  onsubmit="return confirm('آیا از حذف این خبر اطمینان دارید؟');"
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5 font_13">
                                        <i class="fa fa-folder-open fa-2x d-block mb-2 text-light"></i>
                                        هنوز هیچ خبر یا مقاله‌ای در سیستم ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-center app-pagination">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
