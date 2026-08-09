{{-- Header --}}
<div class="modal-header company-modal-header">
    <div class="company-modal-heading">
        <div class="company-modal-logo">
            @if($company->logo)
                <img src="{{ asset('storage/' . ltrim($company->logo, '/')) }}"
                     alt="{{ $company->registered_name ?: 'لوگوی شرکت' }}">
            @else
                <div class="company-modal-logo-empty">
                    <i class="fa fa-building"></i>
                </div>
            @endif
        </div>

        <div class="company-modal-title-wrapper">
            <span class="company-modal-eyebrow">پروفایل شرکت عضو</span>

            <h4 class="modal-title"
                id="companyModalLabel{{ $company->id }}">
                {{ $displayValue($company->registered_name) }}
            </h4>

            <div class="company-modal-en-name" dir="ltr">
                {{ $displayValue($company->company_name_en) }}
            </div>

            <div class="company-modal-header-badges">
                <span class="companies-status {{ $statusClass }}">
                    وضعیت: {{ $displayValue($company->membership_status) }}
                </span>

                <span class="companies-type-badge">
                    نوع عضویت: {{ $displayValue($company->membership_type) }}
                </span>

                <span class="company-membership-number">
                    شماره عضویت: {{ $displayValue($company->membership_number) }}
                </span>
            </div>
        </div>
    </div>

    <button type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="بستن"></button>
</div>
