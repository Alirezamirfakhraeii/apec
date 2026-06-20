@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش اعضا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت کاربران</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fa fa-user-plus ml-1"></i> افزودن کاربر جدید
            </a>
        </div>
    </div>

    <div class="row row-sm">
        @if(session('success'))
            <div class="col-12"><div class="alert alert-success">{{ session('success') }}</div></div>
        @endif
        @if(session('error'))
            <div class="col-12"><div class="alert alert-danger">{{ session('error') }}</div></div>
        @endif

        <div class="col-xl-12">
            <div class="card">
                <div class="card-header"><h4 class="card-title mb-1">لیست کاربران سیستم</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle">
                            <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>نام کاربر</th>
                                <th>ایمیل (نام کاربری)</th>
                                <th>نقش فعلی</th>
                                <th width="150">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $index => $u)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td>
                                        @if($u->roles->isEmpty())
                                            <span class="px-2 py-2">کاربر عادی</span>
                                        @else
                                            @foreach($u->roles as $role)
                                                <span class="badge badge-primary px-2 py-2 font_12"><i class="fa fa-user-tag ml-1"></i>{{ $role->name }}</span>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-info-light">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('آیا از حذف این کاربر مطمئن هستید؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-light"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
