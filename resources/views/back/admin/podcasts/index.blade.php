@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between border-bottom pb-3 mb-4">
        <div class="my-auto">
            <div class="d-flex align-items-center">
                <h4 class="content-title mb-0 my-auto text-dark fw-bold">اتاق پادکست</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ لیست فایل‌های صوتی و پادکست‌ها</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.podcasts.create') }}" class="btn btn-primary fw-bold px-3 shadow-sm rounded-pill">
                    <i class="fa fa-plus-circle ml-2"></i> ثبت پادکست جدید
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
                    <h4 class="card-title text-dark mb-0 font_14 fw-bold"><i class="fa fa-list-ul ml-2 text-primary"></i>مدیریت و آرشیو پادکست‌ها</h4>
                    <span class="badge badge-light text-muted font_11 p-2">صفحه {{ $podcasts->currentPage() }} از {{ $podcasts->lastPage() }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 font_13 text-center align-middle">
                            <thead class="bg-light text-secondary">
                            <tr>
                                <th style="width: 5%; padding: 15px 8px;">#</th>
                                <th style="width: 8%; padding: 15px 8px;">کاور</th>
                                <th class="text-right" style="width: 35%; padding: 15px 8px;">عنوان پادکست</th>
                                <th style="width: 15%; padding: 15px 8px;">میزبان</th>
                                <th style="width: 10%; padding: 15px 8px;">وضعیت</th>
                                <th style="width: 15%; padding: 15px 8px;">تاریخ ثبت</th>
                                <th style="width: 12%; padding: 15px 8px;">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($podcasts as $key => $podcast)
                                <tr>
                                    <td class="align-middle fw-bold text-muted">{{ $podcasts->firstItem() + $key }}</td>
                                    <td class="align-middle">
                                        @if($podcast->image)
                                            <img src="{{ asset($podcast->image) }}" alt="img" class="rounded border shadow-sm" style="width: 50px; height: 38px; object-fit: cover;">
                                        @else
                                            <span class="badge badge-light text-muted font_10 border py-2 px-1 d-block">بدون عکس</span>
                                        @endif
                                    </td>
                                    <td class="text-right align-middle fw-bold">
                                        <a href="#" class="text-dark text-decoration-none hover-primary d-block py-1">{{ \Illuminate\Support\Str::limit($podcast->title, 65) }}</a>
                                    </td>
                                    <td class="align-middle text-secondary font_12">{{ $podcast->host_name ?? '---' }}</td>
                                    <td class="align-middle">
                                        @if($podcast->status == 'published')
                                            <span class="badge bg-success-transparent text-success border border-success-transparent font_11 px-2 py-1.5 rounded-pill"><i class="fa fa-circle font_8 ml-2"></i>منتشر شده</span>
                                        @else
                                            <span class="badge bg-warning-transparent text-warning border border-warning-transparent font_11 px-2 py-1.5 rounded-pill"><i class="fa fa-circle font_8 ml-2"></i>پیش‌نویس</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-muted font_12">
                                        {{ jdate($podcast->created_at)->format('Y/m/d') }}
                                    </td>
                                    <td class="align-middle">
                                        <div class="btn-icon-list d-flex justify-content-center">
                                            <a href="{{ route('admin.podcasts.edit', $podcast->id) }}" class="btn btn-sm btn-info text-white ml-2 rounded" title="ویرایش">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.podcasts.destroy', $podcast->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این پادکست اطمینان دارید؟');" class="d-inline">
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
                                        <i class="fa fa-microphone-slash fa-2x d-block mb-2 text-light"></i>
                                        هنوز هیچ پادکستی در سیستم ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top p-3 d-flex justify-content-center app-pagination">
                        {!! $podcasts->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
