@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div>
            <h4 class="content-title mb-0">افزودن تماس با ما</h4>
        </div>

        <a href="{{ route('admin.contact-pages.index') }}" class="btn btn-secondary">
            بازگشت
        </a>
    </div>

    <form action="{{ route('admin.contact-pages.store') }}" method="POST">
        @csrf

        @include('back.admin.contact-pages._form')
    </form>
@endsection
