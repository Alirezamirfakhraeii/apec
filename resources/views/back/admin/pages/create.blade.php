@extends('back.admin.layouts.master')

@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>

                <h4 class="admin-page-title">
                    <i class="fa fa-file-text-o ml-2"></i>
                    ساخت صفحه جدید
                </h4>

                <div class="admin-page-subtitle">
                    در این بخش می‌توانید یک صفحه جدید با تمپلیت مشخص ایجاد کنید.
                </div>

            </div>


            <a
                href="{{ route('admin.pages.index') }}"
                class="btn admin-back-btn"
            >
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست صفحات
            </a>

        </div>


        {{-- Page Form --}}
        @include('back.admin.pages.partials.form', [
            'page' => $page,
            'templates' => $templates,
            'templateFields' => $templateFields,
            'action' => route('admin.pages.store'),
            'method' => 'POST',
        ])

    </div>

@endsection
