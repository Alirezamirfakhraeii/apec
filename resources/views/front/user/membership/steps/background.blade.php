@php
    use App\Enums\MembershipDocumentType;
    $docs = $application->documents->keyBy(fn($d) => $d->type->value);
    $documentTypes = [
        MembershipDocumentType::LatestGeneralAssemblyMinutes,
        MembershipDocumentType::LatestCapitalGazette,
        MembershipDocumentType::OriginalCertificate,
        MembershipDocumentType::Resume,
    ];
@endphp
@extends('front.user.layouts.app')

@section('title', 'سوابق و مدارک')
@section('styles')
<link rel="stylesheet" href="{{ asset('front/css/membership-wizard/style.css') }}">
@endsection

@section('content')
<div class="membership-wizard-page">
    @include('front.user.membership.partials.progress', ['currentStep' => 3])

    <div class="membership-page-heading">
        <div>
            <span class="membership-eyebrow">مرحله ۳ از ۴</span>
            <h1>سوابق و مدارک</h1>
            <p>سابقه تخصصی شرکت و مدارک پشتیبان را تکمیل کنید.</p>
        </div>
        <span class="membership-save-status" data-global-save-status>ذخیره خودکار فعال است</span>
    </div>

    <form class="membership-card" action="{{ route('user.membership.draft.background', $application) }}" method="POST" data-autosave-form>
        @csrf
        <div class="membership-grid">
            <div class="membership-field">
                <label>سابقه فعالیت شرکت (سال)</label>
                <input name="activity_history_years" inputmode="numeric" value="{{ $application->companyProfile?->activity_history_years }}">
                <span class="membership-error" data-error-for="activity_history_years"></span>
            </div>
            <div class="membership-field membership-field--full">
                <label>نوع تخصص در صنایع نفت، گاز و پتروشیمی</label>
                <textarea name="oil_gas_petro_specialty" rows="5">{{ $application->companyProfile?->oil_gas_petro_specialty }}</textarea>
                <span class="membership-error" data-error-for="oil_gas_petro_specialty"></span>
            </div>
            <div class="membership-field membership-field--full">
                <label>شرکت عضو اتاق بازرگانی می‌باشد؟</label>
                <div class="membership-radio-group">
                    <label><input type="radio" name="is_chamber_member" value="1" data-chamber-member @checked($application->companyProfile?->is_chamber_member === true)> بله</label>
                    <label><input type="radio" name="is_chamber_member" value="0" data-chamber-member @checked($application->companyProfile?->is_chamber_member === false)> خیر</label>
                </div>
                <span class="membership-error" data-error-for="is_chamber_member"></span>
            </div>
        </div>

        <div class="membership-actions">
            <a class="membership-btn membership-btn--secondary" href="{{ route('user.membership.step.registration', $application) }}">مرحله قبل</a>
            <span class="membership-save-status" data-form-status></span>
            <button type="button" class="membership-btn membership-btn--primary" data-save-and-go="{{ route('user.membership.step.review', $application) }}">ذخیره و ادامه</button>
        </div>
    </form>

    <div class="membership-card">
        <div class="membership-section-heading"><h2>مدارک</h2><p>فایل جدید، فایل قبلی همان نوع مدرک را جایگزین می‌کند.</p></div>
        <div class="membership-document-grid">
            @foreach($documentTypes as $type)
                @php $doc = $docs->get($type->value); @endphp
                <form class="membership-document-item" action="{{ route('user.membership.documents.store', $application) }}" method="POST" enctype="multipart/form-data" data-upload-form>
                    @csrf
                    <input type="hidden" name="type" value="{{ $type->value }}">
                    <strong>{{ $type->label() }}</strong>
                    <input type="file" name="file" @if($type === MembershipDocumentType::Resume) accept=".pdf,.doc,.docx" @else accept="application/pdf,image/jpeg,image/png" @endif data-auto-upload>
                    <span class="membership-save-status" data-upload-status>{{ $doc?->original_name }}</span>
                    <span class="membership-error" data-error-for="file"></span>
                </form>
            @endforeach

            <form class="membership-document-item" action="{{ route('user.membership.documents.store', $application) }}" method="POST" enctype="multipart/form-data" data-upload-form data-chamber-card>
                @csrf
                <input type="hidden" name="type" value="{{ MembershipDocumentType::ChamberMembershipCard->value }}">
                <strong>{{ MembershipDocumentType::ChamberMembershipCard->label() }}</strong>
                <input type="file" name="file" accept="application/pdf,image/jpeg,image/png" data-auto-upload>
                <span class="membership-save-status" data-upload-status>{{ $docs->get(MembershipDocumentType::ChamberMembershipCard->value)?->original_name }}</span>
                <span class="membership-error" data-error-for="file"></span>
            </form>
        </div>
    </div>

    <div class="membership-info-note">
        <strong>تاریخ عضویت در انجمن اپک</strong>
        <span>این تاریخ توسط متقاضی تعیین نمی‌شود و پس از تأیید نهایی درخواست توسط انجمن ثبت خواهد شد.</span>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('front/js/membership-wizard/app.js') }}"></script>
@endpush
