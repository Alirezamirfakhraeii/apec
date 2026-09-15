@extends('front.user.layouts.app')

@section('title', 'شروع درخواست عضویت')

@section('styles')
    <link rel="stylesheet" href="{{ asset('front/css/membership-wizard/style.css') }}">
@endsection

@section('content')
<div class="membership-wizard-page membership-intake-page">
    <div class="membership-intro-card">
        <span class="membership-eyebrow">APEC / Membership</span>
        <h1>شروع درخواست عضویت</h1>
        <p>ابتدا مشخصات شرکت و نماینده‌ای که این پرسشنامه را تکمیل می‌کند ثبت کنید.</p>
    </div>

    <form
        class="membership-card"
        action="{{ route('user.membership.intake.store') }}"
        method="POST"
        data-intake-form
    >
        @csrf

        <div class="membership-grid">
            <div class="membership-field membership-field--full">
                <label for="company_name">نام شرکت</label>
                <input id="company_name" name="company_name" type="text" value="{{ old('company_name', $application->intake_company_name) }}" autocomplete="organization">
                <span class="membership-error" data-error-for="company_name"></span>
            </div>

            <div class="membership-field">
                <label for="representative_name">نام و نام خانوادگی نماینده شرکت</label>
                <input id="representative_name" name="representative_name" type="text" value="{{ old('representative_name', $application->representative_name) }}" autocomplete="name">
                <span class="membership-error" data-error-for="representative_name"></span>
            </div>

            <div class="membership-field">
                <label for="representative_mobile">شماره تماس نماینده</label>
                <input id="representative_mobile" name="representative_mobile" type="text" inputmode="numeric" dir="ltr" value="{{ old('representative_mobile', $application->representative_mobile) }}" placeholder="09123456789">
                <span class="membership-error" data-error-for="representative_mobile"></span>
            </div>
        </div>

        <div class="membership-actions">
            <button class="membership-btn membership-btn--primary" type="submit">
                تأیید و ورود به پرسشنامه
            </button>
            <span class="membership-save-status" data-form-status></span>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('front/js/membership-wizard/app.js') }}"></script>
@endpush
