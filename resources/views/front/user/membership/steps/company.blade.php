@php use App\Enums\CompanyType; @endphp
@extends('front.user.layouts.app')

@section('title', 'مشخصات شرکت')
@section('styles')
<link rel="stylesheet" href="{{ asset('front/css/membership-wizard/style.css') }}">
@endsection

@section('content')
<div class="membership-wizard-page">
    @include('front.user.membership.partials.progress', ['currentStep' => 1])

    <div class="membership-page-heading">
        <div>
            <span class="membership-eyebrow">مرحله ۱ از ۴</span>
            <h1>مشخصات شرکت</h1>
            <p>اطلاعات این صفحه به‌صورت Draft و بدون Refresh ذخیره می‌شود.</p>
        </div>
        <span class="membership-save-status" data-global-save-status>ذخیره خودکار فعال است</span>
    </div>

    <div class="membership-card">
        <div class="membership-section-heading">
            <h2>تصویر شاخص</h2>
            <p>لوگوی شرکت را به صورت JPG، PNG یا WebP بارگذاری کنید.</p>
        </div>

        <form action="{{ route('user.membership.logo.store', $application) }}" method="POST" enctype="multipart/form-data" data-upload-form>
            @csrf
            <div class="membership-logo-upload">
                <div class="membership-logo-preview" data-logo-preview>
                    @if($application->companyProfile?->logo_path)
                        <img src="{{ asset('storage/' . $application->companyProfile->logo_path) }}" alt="لوگوی شرکت">
                    @else
                        <span>LOGO</span>
                    @endif
                </div>
                <div>
                    <input type="file" name="logo" accept="image/png,image/jpeg,image/webp" data-auto-upload>
                    <span class="membership-save-status" data-upload-status></span>
                    <span class="membership-error" data-error-for="logo"></span>
                </div>
            </div>
        </form>
    </div>

    <form class="membership-card" action="{{ route('user.membership.draft.company', $application) }}" method="POST" data-autosave-form>
        @csrf
        <div class="membership-section-heading">
            <h2>اطلاعات پایه شرکت</h2>
            <p>نام فارسی از اطلاعات اولیه پر شده و قابل اصلاح است.</p>
        </div>

        <div class="membership-grid">
            <div class="membership-field">
                <label>نام کوتاه شرکت</label>
                <input name="company_short_name" value="{{ $application->companyProfile?->company_short_name }}">
                <span class="membership-error" data-error-for="company_short_name"></span>
            </div>

            <div class="membership-field">
                <label>نام شرکت (فارسی)</label>
                <input name="registered_name" value="{{ $application->companyProfile?->registered_name }}">
                <span class="membership-error" data-error-for="registered_name"></span>
            </div>

            <div class="membership-field">
                <label>نام شرکت (انگلیسی)</label>
                <input name="company_name_en" dir="ltr" value="{{ $application->companyProfile?->company_name_en }}">
                <span class="membership-error" data-error-for="company_name_en"></span>
            </div>

            <div class="membership-field">
                <label>تابعیت شرکت</label>
                <select name="nationality">
                    <option value="">انتخاب کنید</option>
                    <option value="ایرانی" @selected($application->companyProfile?->nationality === 'ایرانی')>ایرانی</option>
                    <option value="غیرایرانی" @selected($application->companyProfile?->nationality === 'غیرایرانی')>غیرایرانی</option>
                </select>
                <span class="membership-error" data-error-for="nationality"></span>
            </div>

            <div class="membership-field">
                <label>نوع ثبت شرکت</label>
                <select name="company_type">
                    <option value="">انتخاب کنید</option>
                    @foreach(CompanyType::cases() as $type)
                        <option value="{{ $type->value }}" @selected($application->companyProfile?->company_type === $type->value)>{{ $type->label() }}</option>
                    @endforeach
                </select>
                <span class="membership-error" data-error-for="company_type"></span>
            </div>

            <div class="membership-field">
                <label>نام شرکت مادر</label>
                <input name="parent_company_name" value="{{ $application->companyProfile?->parent_company_name }}" placeholder="در صورت وجود">
                <span class="membership-error" data-error-for="parent_company_name"></span>
            </div>
        </div>

        <div class="membership-actions">
            <span class="membership-save-status" data-form-status></span>
            <button type="button" class="membership-btn membership-btn--primary" data-save-and-go="{{ route('user.membership.step.registration', $application) }}">ذخیره و ادامه</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('front/js/membership-wizard/app.js') }}"></script>
@endpush
