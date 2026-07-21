@php
    $websiteUrl = null;

    if ($company->website) {
        $websiteUrl = preg_match('/^https?:\/\//i', $company->website)
            ? $company->website
            : 'https://' . ltrim($company->website, '/');
    }

    $statusClass = 'unknown';

    if ($company->membership_status === 'فعال') {
        $statusClass = 'active';
    } elseif ($company->membership_status === 'تعلیق') {
        $statusClass = 'suspended';
    } elseif ($company->membership_status === 'لغو') {
        $statusClass = 'cancelled';
    }
@endphp

<div class="modal fade company-modal"
     id="companyModal{{ $company->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header company-modal-header">

                <div class="company-modal-heading">

                    <div class="company-modal-logo">

                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}"
                                 alt="{{ $company->registered_name }}">
                        @else
                            <div class="company-modal-logo-empty">
                                <i class="fa fa-building"></i>
                            </div>
                        @endif

                    </div>

                    <div>
                        <h4 class="modal-title">
                            {{ $company->registered_name ?: 'نام شرکت ثبت نشده' }}
                        </h4>

                        @if($company->company_name_en)
                            <div class="company-modal-en-name"
                                 dir="ltr">

                                {{ $company->company_name_en }}
                            </div>
                        @endif
                    </div>

                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="بستن">
                </button>

            </div>

            <div class="modal-body company-modal-body">

                <div class="company-modal-status-row">

                    <span class="companies-status {{ $statusClass }}">
                        وضعیت:
                        {{ $company->membership_status ?: 'نامشخص' }}
                    </span>

                    <span class="companies-type-badge">
                        نوع عضویت:
                        {{ $company->membership_type ?: 'نامشخص' }}
                    </span>

                </div>

                <div class="company-information-grid">

                    <div class="company-info-item">
                        <span class="company-info-label">
                            نام اختصاری
                        </span>

                        <strong class="company-info-value">
                            {{ $company->company_short_name ?: 'ثبت نشده' }}
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            شماره عضویت
                        </span>

                        <strong class="company-info-value">
                            {{ $company->membership_number ?: 'ثبت نشده' }}
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            شماره ثبت
                        </span>

                        <strong class="company-info-value">
                            {{ $company->registration_number ?: 'ثبت نشده' }}
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            محل ثبت
                        </span>

                        <strong class="company-info-value">
                            {{ $company->registration_place ?: 'ثبت نشده' }}
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            تلفن شرکت
                        </span>

                        <strong class="company-info-value"
                                dir="ltr">

                            @if($company->phone)
                                <a href="tel:{{ $company->phone }}">
                                    {{ $company->phone }}
                                </a>
                            @else
                                ثبت نشده
                            @endif
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            ایمیل شرکت
                        </span>

                        <strong class="company-info-value"
                                dir="ltr">

                            @if($company->email)
                                <a href="mailto:{{ $company->email }}">
                                    {{ $company->email }}
                                </a>
                            @else
                                ثبت نشده
                            @endif
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            وب‌سایت
                        </span>

                        <strong class="company-info-value"
                                dir="ltr">

                            @if($websiteUrl)
                                <a href="{{ $websiteUrl }}"
                                   target="_blank"
                                   rel="noopener">

                                    {{ $company->website }}
                                </a>
                            @else
                                ثبت نشده
                            @endif
                        </strong>
                    </div>

                    <div class="company-info-item">
                        <span class="company-info-label">
                            نوع شرکت
                        </span>

                        <strong class="company-info-value">
                            {{ $company->company_type ?: 'ثبت نشده' }}
                        </strong>
                    </div>

                </div>

                @if($company->activity_type)
                    <div class="company-modal-section">

                        <h5>
                            <i class="fa fa-industry ml-1"></i>
                            حوزه و نوع فعالیت
                        </h5>

                        <div class="company-modal-text">
                            {!! nl2br(e($company->activity_type)) !!}
                        </div>

                    </div>
                @endif

                @if($company->address)
                    <div class="company-modal-section">

                        <h5>
                            <i class="fa fa-map-marker ml-1"></i>
                            آدرس شرکت
                        </h5>

                        <div class="company-modal-text">
                            {!! nl2br(e($company->address)) !!}
                        </div>

                    </div>
                @endif

            </div>

            <div class="modal-footer company-modal-footer">

                @if($websiteUrl)
                    <a href="{{ $websiteUrl }}"
                       target="_blank"
                       rel="noopener"
                       class="btn company-website-btn">

                        <i class="fa fa-globe ml-1"></i>
                        مشاهده وب‌سایت
                    </a>
                @endif

                <button type="button"
                        class="btn company-modal-close-btn"
                        data-bs-dismiss="modal">

                    بستن
                </button>

            </div>

        </div>
    </div>
</div>
