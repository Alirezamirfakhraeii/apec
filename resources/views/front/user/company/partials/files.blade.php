@php
    $documentTypes = \App\Enums\MembershipDocumentType::cases();
    $documentsByType = $documentsByType ?? collect();
@endphp

<div class="company-edit-section">
    <div class="company-edit-section__title">لوگو و مدارک شرکت</div>

    <div class="company-edit-grid">
        <div class="company-edit-field">
            <label class="company-edit-label" for="company_logo">لوگوی شرکت</label>

            <input
                id="company_logo"
                type="file"
                name="company[logo]"
                class="company-edit-file"
                accept="image/*"
            >

            @if($company?->logo)
                <div class="company-current-file company-current-file--with-preview">
                    <img
                        src="{{ $company->logo_url }}"
                        alt="لوگوی فعلی شرکت"
                        class="company-current-logo"
                    >

                    <div>
                        <strong>لوگوی فعلی</strong>
                        <a href="{{ $company->logo_url }}" target="_blank">مشاهده فایل</a>
                    </div>
                </div>
            @endif

            @error('company.logo')
                <span class="company-edit-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="company-edit-field">
            <label class="company-edit-label" for="company_membership_card">کارت عضویت شرکت</label>

            <input
                id="company_membership_card"
                type="file"
                name="company[membership_card]"
                class="company-edit-file"
                accept="image/*,.pdf"
            >

            @if($company?->membership_card)
                <div class="company-current-file">
                    <div class="company-current-file__name">کارت عضویت فعلی</div>

                    <a
                        href="{{ asset('storage/' . $company->membership_card) }}"
                        target="_blank"
                    >
                        مشاهده فایل فعلی
                    </a>
                </div>
            @endif

            @error('company.membership_card')
                <span class="company-edit-error">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="company-edit-section__hint">
        مدارک زیر از جدول مدارک جاری شرکت خوانده می‌شوند و با بارگذاری فایل جدید قابل جایگزینی هستند.
    </div>

    <div class="company-edit-documents-grid">
        @foreach($documentTypes as $type)
            @php
                $currentDocument = $documentsByType->get($type->value);
            @endphp

            <div class="company-document-box">
                <div class="company-document-box__head">
                    <strong>{{ $type->label() }}</strong>

                    @if($currentDocument)
                        <span class="company-document-status company-document-status--exists">ثبت شده</span>
                    @else
                        <span class="company-document-status">بدون فایل</span>
                    @endif
                </div>

                @if($currentDocument)
                    <div class="company-current-file">
                        <div class="company-current-file__name">
                            {{ $currentDocument->original_name ?: basename($currentDocument->path) }}
                        </div>

                        <a
                            href="{{ asset('storage/' . $currentDocument->path) }}"
                            target="_blank"
                        >
                            مشاهده فایل فعلی
                        </a>
                    </div>
                @endif

                <label class="company-edit-label" for="document_{{ $type->value }}">
                    {{ $currentDocument ? 'جایگزینی فایل' : 'بارگذاری فایل' }}
                </label>

                <input
                    id="document_{{ $type->value }}"
                    type="file"
                    name="documents[{{ $type->value }}]"
                    class="company-edit-file"
                >

                @error('documents.' . $type->value)
                    <span class="company-edit-error">{{ $message }}</span>
                @enderror
            </div>
        @endforeach
    </div>
</div>
