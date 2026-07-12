@extends('back.admin.layouts.master')

@section('content')

    @include('back.admin.board-members.partials.styles')

    <div class="board-member-wrapper">

        <div class="board-member-page-header d-flex align-items-center justify-content-between">
            <div>
                <h4 class="board-member-page-title">
                    <i class="fa fa-user-edit ml-2"></i>
                    ویرایش عضو هیئت مدیره
                </h4>

                <div class="board-member-page-subtitle">
                    ویرایش اطلاعات، تصویر، سمت‌ها و وضعیت نمایش عضو انتخاب‌شده
                </div>
            </div>

            <a href="{{ route('admin.board-members.index') }}" class="btn board-member-back-btn">
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست
            </a>
        </div>

        <form action="{{ route('admin.board-members.update', $boardMember) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('back.admin.board-members.partials.form', [
                'member' => $boardMember,
                'submitText' => 'ذخیره تغییرات عضو'
            ])
        </form>

    </div>
@endsection
