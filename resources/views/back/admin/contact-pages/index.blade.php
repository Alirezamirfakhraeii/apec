@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div>
            <h4 class="content-title mb-0">تماس با ما</h4>
            <span class="text-muted tx-13">مدیریت صفحه تماس با ما</span>
        </div>

        <a href="{{ route('admin.contact-pages.create') }}" class="btn btn-primary">
            <i class="fa fa-plus ml-1"></i>
            افزودن صفحه
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان</th>
                        <th>تلفن</th>
                        <th>ایمیل</th>
                        <th>وضعیت</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($contactPages as $contactPage)
                        <tr>
                            <td>{{ $contactPage->id }}</td>
                            <td>{{ $contactPage->title }}</td>
                            <td>{{ $contactPage->phone ?? '-' }}</td>
                            <td>{{ $contactPage->email ?? '-' }}</td>
                            <td>
                                @if($contactPage->status)
                                    <span class="badge badge-success">فعال</span>
                                @else
                                    <span class="badge badge-secondary">غیرفعال</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.contact-pages.edit', $contactPage) }}"
                                   class="btn btn-sm btn-warning">
                                    ویرایش
                                </a>

                                <form action="{{ route('admin.contact-pages.destroy', $contactPage) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('حذف شود؟')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger">
                                        حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">موردی ثبت نشده است.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $contactPages->links() }}
        </div>
    </div>
@endsection
