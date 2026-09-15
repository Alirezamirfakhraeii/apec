@php
    use App\Enums\CompanyType;
    use App\Support\PersianDate;

    $profile = $application->companyProfile;

    $registrationDate = $profile?->registration_date
        ? PersianDate::fromGregorian(
            $profile->registration_date->format('Y-m-d')
        )
        : null;

    $referenceGazetteDate = $profile?->reference_gazette_date
        ? PersianDate::fromGregorian(
            $profile->reference_gazette_date->format('Y-m-d')
        )
        : null;
@endphp

@extends('front.user.layouts.app')

@section('title', 'بازبینی درخواست عضویت')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/membership-wizard/style.css') }}"
    >
@endsection


@section('content')

    <div class="membership-wizard-page">

        @include(
            'front.user.membership.partials.progress',
            ['currentStep' => 4]
        )


        {{-- =========================================================
            Page Header
        ========================================================== --}}

        <div class="membership-page-heading">

            <div>

            <span class="membership-eyebrow">
                مرحله ۴ از ۴
            </span>

                <h1>
                    بازبینی و ارسال
                </h1>

                <p>
                    قبل از ارسال نهایی، اطلاعات پرونده را با دقت بررسی کنید.
                </p>

            </div>


            <span class="membership-form-state">
            {{ $application->state->label() }}
        </span>

        </div>


        {{-- =========================================================
            Messages
        ========================================================== --}}

        <div
            id="membership-submit-success"
            class="membership-alert membership-alert--success"
            style="display:none;"
        ></div>


        <div
            id="membership-submit-error"
            class="membership-alert membership-alert--error"
            style="display:none;"
        ></div>


        {{-- =========================================================
            Intake Information
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        اطلاعات اولیه
                    </h2>

                    <p>
                        اطلاعات ثبت‌شده در شروع درخواست
                    </p>

                </div>

            </div>


            <div class="membership-review-grid">

                <div>
                <span>
                    نام اولیه شرکت
                </span>

                    <strong>
                        {{ $application->intake_company_name ?: '—' }}
                    </strong>
                </div>


                <div>
                <span>
                    نماینده شرکت
                </span>

                    <strong>
                        {{ $application->representative_name ?: '—' }}
                    </strong>
                </div>


                <div>
                <span>
                    موبایل نماینده
                </span>

                    <strong dir="ltr">
                        {{ $application->representative_mobile ?: '—' }}
                    </strong>
                </div>

            </div>

        </div>


        {{-- =========================================================
            Company Basic Information
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        مشخصات شرکت
                    </h2>

                    <p>
                        اطلاعات پایه شرکت
                    </p>

                </div>


                <a
                    href="{{ route(
                    'user.membership.basic',
                    $application
                ) }}"
                    class="membership-btn membership-btn--secondary"
                >
                    ویرایش
                </a>

            </div>


            <div class="membership-review-grid">

                <div>

                <span>
                    نام فارسی شرکت
                </span>

                    <strong>
                        {{ $profile?->registered_name ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    نام انگلیسی
                </span>

                    <strong dir="ltr">
                        {{ $profile?->company_name_en ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    نام کوتاه شرکت
                </span>

                    <strong>
                        {{ $profile?->company_short_name ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    ملیت
                </span>

                    <strong>
                        {{ $profile?->nationality ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    نوع شرکت
                </span>

                    <strong>
                        {{
                            CompanyType::tryFrom(
                                $profile?->company_type ?? ''
                            )?->label() ?? '—'
                        }}
                    </strong>

                </div>


                <div>

                <span>
                    شرکت مادر
                </span>

                    <strong>
                        {{ $profile?->parent_company_name ?: '—' }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Registration Information
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        ثبت و مالکیت
                    </h2>

                    <p>
                        اطلاعات ثبتی و سهامداران
                    </p>

                </div>


                <a
                    href="{{ route(
                    'user.membership.registration',
                    $application
                ) }}"
                    class="membership-btn membership-btn--secondary"
                >
                    ویرایش
                </a>

            </div>


            <div class="membership-review-grid">

                <div>

                <span>
                    تاریخ ثبت شرکت
                </span>

                    <strong>
                        {{ $registrationDate ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    شماره ثبت
                </span>

                    <strong>
                        {{ $profile?->registration_number ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    محل ثبت
                </span>

                    <strong>
                        {{ $profile?->registration_place ?: '—' }}
                    </strong>

                </div>


                <div>

                <span>
                    سرمایه ثبت‌شده
                </span>

                    <strong>

                        @if($profile?->registered_capital_irr !== null)

                            {{
                                number_format(
                                    (float) $profile->registered_capital_irr
                                )
                            }}
                            ریال

                        @else
                            —
                        @endif

                    </strong>

                </div>


                <div>

                <span>
                    تاریخ روزنامه رسمی
                </span>

                    <strong>
                        {{ $referenceGazetteDate ?: '—' }}
                    </strong>

                </div>

            </div>


            <div class="membership-section-heading">

                <div>

                    <h3>
                        سهامداران
                    </h3>

                </div>

            </div>


            @forelse(
                $application->shareholders
                as $shareholder
            )

                <div class="membership-review-row">

                <span>
                    {{ $shareholder->full_name }}
                </span>

                    <strong>

                        {{
                            rtrim(
                                rtrim(
                                    number_format(
                                        (float) $shareholder->ownership_percentage,
                                        2,
                                        '.',
                                        ''
                                    ),
                                    '0'
                                ),
                                '.'
                            )
                        }}%

                    </strong>

                </div>

            @empty

                <div class="membership-empty">
                    سهامداری ثبت نشده است.
                </div>

            @endforelse

        </div>


        {{-- =========================================================
            Qualifications
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        سوابق و تخصص
                    </h2>

                    <p>
                        اطلاعات تخصصی شرکت
                    </p>

                </div>


                <a
                    href="{{ route(
                    'user.membership.qualifications',
                    $application
                ) }}"
                    class="membership-btn membership-btn--secondary"
                >
                    ویرایش
                </a>

            </div>


            <div class="membership-review-grid">

                <div>

                <span>
                    سابقه فعالیت
                </span>

                    <strong>

                        @if(
                            $profile?->activity_experience_years
                            !== null
                        )

                            {{
                                $profile->activity_experience_years
                            }}
                            سال

                        @else
                            —
                        @endif

                    </strong>

                </div>


                <div>

                <span>
                    عضویت در اتاق بازرگانی
                </span>

                    <strong>

                        @if($profile?->is_chamber_member === null)

                            —

                        @elseif($profile->is_chamber_member)

                            بله

                        @else

                            خیر

                        @endif

                    </strong>

                </div>

            </div>


            <div class="membership-review-text">

            <span>
                تخصص در حوزه نفت، گاز و پتروشیمی
            </span>

                <p>
                    {{
                        $profile?->oil_gas_petchem_specialty
                            ?: '—'
                    }}
                </p>

            </div>

        </div>


        {{-- =========================================================
            Documents
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        مدارک بارگذاری‌شده
                    </h2>

                    <p>
                        مدارک پرونده درخواست عضویت
                    </p>

                </div>

            </div>


            @forelse(
                $application->documents
                as $document
            )

                <div class="membership-review-row">

                <span>
                    {{ $document->type->label() }}
                </span>


                    <strong>

                        <a
                            href="{{ asset(
                            'storage/' . $document->path
                        ) }}"
                            target="_blank"
                        >
                            {{ $document->original_name }}
                        </a>

                    </strong>

                </div>

            @empty

                <div class="membership-empty">
                    مدرکی بارگذاری نشده است.
                </div>

            @endforelse

        </div>


        {{-- =========================================================
            Final Actions
        ========================================================== --}}

        <div class="membership-final-actions">

            <a
                class="membership-btn membership-btn--secondary"
                href="{{ route(
                'user.membership.qualifications',
                $application
            ) }}"
            >
                مرحله قبل
            </a>


            <button
                class="membership-btn membership-btn--primary"
                type="button"
                id="membership-final-submit"
            >
                ارسال نهایی برای بررسی
            </button>

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const button =
                    document.getElementById(
                        'membership-final-submit'
                    );

                const successBox =
                    document.getElementById(
                        'membership-submit-success'
                    );

                const errorBox =
                    document.getElementById(
                        'membership-submit-error'
                    );


                if (!button) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Final Submit
                |--------------------------------------------------------------------------
                */

                button.addEventListener(
                    'click',
                    async function () {

                        const confirmed =
                            window.confirm(
                                'پس از ارسال نهایی، امکان ویرایش درخواست تا زمان درخواست اصلاح وجود ندارد. آیا مطمئن هستید؟'
                            );


                        if (!confirmed) {
                            return;
                        }


                        successBox.style.display =
                            'none';

                        errorBox.style.display =
                            'none';

                        errorBox.innerHTML =
                            '';


                        button.disabled =
                            true;

                        button.textContent =
                            'در حال ارسال...';


                        try {

                            const response =
                                await fetch(
                                    '{{ route(
                                'user.membership.submit',
                                $application
                            ) }}',
                                    {
                                        method: 'POST',

                                        headers: {

                                            'Accept':
                                                'application/json',

                                            'Content-Type':
                                                'application/json',

                                            'X-Requested-With':
                                                'XMLHttpRequest',

                                            'X-CSRF-TOKEN':
                                                '{{ csrf_token() }}',
                                        },

                                        body:
                                            JSON.stringify({})
                                    }
                                );


                            const data =
                                await response.json();


                            /*
                            |--------------------------------------------------------------------------
                            | Validation Error
                            |--------------------------------------------------------------------------
                            */

                            if (
                                response.status === 422
                            ) {

                                const messages =
                                    Object
                                        .values(
                                            data.errors ?? {}
                                        )
                                        .flat();


                                if (
                                    messages.length
                                    > 0
                                ) {

                                    errorBox.innerHTML =
                                        '<strong>برای ارسال نهایی موارد زیر را تکمیل کنید:</strong>'
                                        +
                                        '<ul>'
                                        +
                                        messages
                                            .map(
                                                message =>
                                                    `<li>${message}</li>`
                                            )
                                            .join('')
                                        +
                                        '</ul>';

                                } else {

                                    errorBox.textContent =
                                        'اطلاعات درخواست کامل نیست.';

                                }


                                errorBox.style.display =
                                    'block';

                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Other Errors
                            |--------------------------------------------------------------------------
                            */

                            if (!response.ok) {
                                throw new Error(
                                    'Submit failed'
                                );
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Success
                            |--------------------------------------------------------------------------
                            */

                            successBox.textContent =
                                data.message
                                ??
                                'درخواست با موفقیت ارسال شد.';


                            successBox.style.display =
                                'block';


                            if (data.redirect) {

                                setTimeout(
                                    function () {

                                        window.location.href =
                                            data.redirect;

                                    },
                                    700
                                );

                            }

                        } catch (error) {

                            console.error(error);


                            errorBox.textContent =
                                'در ارسال درخواست مشکلی پیش آمد. لطفاً دوباره تلاش کنید.';


                            errorBox.style.display =
                                'block';

                        } finally {

                            button.disabled =
                                false;

                            button.textContent =
                                'ارسال نهایی برای بررسی';

                        }

                    }
                );

            }
        );
    </script>

@endpush
