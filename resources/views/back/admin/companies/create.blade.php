@extends('back.admin.layouts.master')

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدیریت اعضا</h4>

                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    / تعریف و ثبت شرکت جدید
                </span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.company.index') }}"
                   class="btn btn-secondary fw-bold">

                    <i class="fa fa-arrow-right ml-1"></i>
                    بازگشت به لیست
                </a>
            </div>
        </div>
    </div>

    @include('back.admin.companies.partials.form', [
        'company' => null,
        'formAction' => route('admin.company.store'),
        'formMethod' => 'POST',
        'submitLabel' => 'ثبت و ذخیره نهایی شرکت',
    ])

@endsection
