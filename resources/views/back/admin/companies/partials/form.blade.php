@php
    $isEdit = isset($company) && $company?->exists;
@endphp

@if(session()->has('success'))
    <div class="alert alert-success font_13 border-0 shadow-sm rounded mb-4">
        <button type="button"
                class="close"
                data-bs-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <i class="fa fa-check-circle ml-2"></i>
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger font_13 border-0 shadow-sm rounded mb-4">
        <button type="button"
                class="close"
                data-bs-dismiss="alert"
                aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>

        <i class="fa fa-exclamation-circle ml-2"></i>
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <div class="fw-bold mb-2">
            <i class="fa fa-exclamation-circle ml-1"></i>
            لطفاً خطاهای فرم را بررسی کنید.
        </div>

        <ul class="mb-0 pr-3 font_12">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(!$isEdit)
    <form id="company-import-form"
          action="{{ route('admin.company.import-excel') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
    </form>
@endif

<form action="{{ $formAction }}"
      method="POST"
      enctype="multipart/form-data"
      id="company-form">

    @csrf

    @if(strtoupper($formMethod) !== 'POST')
        @method($formMethod)
    @endif

    <div class="row row-sm">

        <div class="col-xl-8 col-lg-8 col-md-12">

            @include('back.admin.companies.partials.sections.basic-information', [
                'company' => $company,
                'isEdit' => $isEdit,
            ])

            @include('back.admin.companies.partials.sections.registration-information', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.contact-information', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.managers-information', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.association-contact', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.activity-fields', [
          'company' => $company,
          'activityFields' => $activityFields,
          ])

        </div>

        <div class="col-xl-4 col-lg-4 col-md-12">

            @include('back.admin.companies.partials.sections.logo', [
                'company' => $company,
                'isEdit' => $isEdit,
            ])

            @include('back.admin.companies.partials.sections.membership-information', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.commercial-cards', [
                'company' => $company,
            ])

            @include('back.admin.companies.partials.sections.activity-information', [
                'company' => $company,
            ])




            @if(!$isEdit)
                @include('back.admin.companies.partials.sections.excel-import')
            @endif

            <button type="submit"
                    class="btn btn-primary btn-block btn-lg font_14 fw-bold box-shadow-3">
                <i class="fa fa-check-circle ml-1"></i>
                {{ $submitLabel }}
            </button>

        </div>

    </div>
</form>
