@extends('back.admin.layouts.master')

@section('content')

    @include('back.admin.board-members.partials.styles')

    <div class="board-member-wrapper">

        <div class="board-member-page-header d-flex align-items-center justify-content-between">
            <div>
                <h4 class="board-member-page-title">
                    <i class="fa fa-users ml-2"></i>
                    اتاق هیئت مدیره
                </h4>

                <div class="board-member-page-subtitle">
                    ثبت، مدیریت و نمایش اعضای هیئت مدیره، سمت‌ها و اطلاعات تماس
                </div>
            </div>

            <a href="{{ route('admin.board-members.index') }}" class="btn board-member-back-btn">
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست
            </a>
        </div>

        <form action="{{ route('admin.board-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('back.admin.board-members.partials.form', [
                'member' => null,
                'submitText' => 'ذخیره عضو هیئت مدیره'
            ])
        </form>

    </div>
@endsection
