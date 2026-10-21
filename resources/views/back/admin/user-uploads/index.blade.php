@extends('back.admin.layouts.master')

@section('title', 'فایل‌های کاربران')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header">

                <h4 class="mb-0">
                    فایل‌های ارسال‌شده کاربران
                </h4>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                        <tr>
                            <th>#</th>
                            <th>کاربر</th>
                            <th>ایمیل</th>
                            <th>نام فایل</th>
                            <th>حجم</th>
                            <th>تاریخ ارسال</th>
                            <th>عملیات</th>
                        </tr>

                        </thead>

                        <tbody>

                        @forelse($uploads as $upload)

                            <tr>

                                <td>
                                    {{ $upload->id }}
                                </td>

                                <td>
                                    {{ $upload->user?->name ?: '—' }}
                                </td>

                                <td dir="ltr">
                                    {{ $upload->user?->email ?: '—' }}
                                </td>

                                <td>
                                    {{ $upload->original_name }}
                                </td>

                                <td>
                                    {{
                                        number_format(
                                            $upload->file_size / 1024 / 1024,
                                            2
                                        )
                                    }}
                                    MB
                                </td>

                                <td>
                                    {{ $upload->created_at }}
                                </td>

                                <td>

                                    <a
                                        href="{{
                                            route(
                                                'admin.user-uploads.download',
                                                $upload
                                            )
                                        }}"
                                        class="btn btn-sm btn-primary"
                                    >
                                        دانلود فایل
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center">
                                    هنوز فایلی ارسال نشده است.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $uploads->links() }}

            </div>
        </div>
    </div>
@endsection
