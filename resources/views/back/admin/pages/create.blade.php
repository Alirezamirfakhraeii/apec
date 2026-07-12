@extends('back.admin.layouts.master')

<head>
    <link rel="stylesheet" href="{{ asset('back/css/pages/index.css') }}">
</head>

@section('content')
    <div class="news-admin-wrapper" dir="rtl">
        <div class="news-page-header">
            <div>
                <h1>ساخت صفحه جدید</h1>
                <p>در این بخش می‌توانید یک صفحه جدید با تمپلیت مشخص ایجاد کنید.</p>
            </div>

            <a href="{{ route('admin.pages.index') }}" class="news-create-btn">
                بازگشت به لیست صفحات
            </a>
        </div>

        @include('back.admin.pages.partials.form', [
            'page' => $page,
            'templates' => $templates,
            'templateFields' => $templateFields,
            'action' => route('admin.pages.store'),
            'method' => 'POST',
        ])
    </div>
@endsection
