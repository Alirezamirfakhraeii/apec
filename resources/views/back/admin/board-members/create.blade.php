@extends('back.admin.layouts.master')

@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>

                <h4 class="admin-page-title">
                    <i class="fa fa-users ml-2"></i>
                    اتاق هیئت مدیره
                </h4>

                <div class="admin-page-subtitle">
                    ثبت، مدیریت و نمایش اعضای هیئت مدیره، سمت‌ها و اطلاعات تماس
                </div>

            </div>


            <a
                href="{{ route('admin.board-members.index') }}"
                class="btn admin-back-btn"
            >
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست
            </a>

        </div>


        {{-- Create Form --}}
        <form
            action="{{ route('admin.board-members.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            @include('back.admin.board-members.partials.form', [
                'member' => null,
                'submitText' => 'ذخیره عضو هیئت مدیره'
            ])

        </form>

    </div>

@endsection
