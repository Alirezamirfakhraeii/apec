@php
    use App\Enums\MembershipDocumentType;

    $profile = $application->companyProfile;

    $assemblyMinutes = $documents->get(
        MembershipDocumentType::LatestGeneralAssemblyMinutes->value
    );

    $capitalGazette = $documents->get(
        MembershipDocumentType::LatestCapitalGazette->value
    );

    $originalCertificate = $documents->get(
        MembershipDocumentType::OriginalCertificate->value
    );

    $companyResume = $documents->get(
        MembershipDocumentType::CompanyResume->value
    );

    $chamberCard = $documents->get(
        MembershipDocumentType::ChamberMembershipCard->value
    );
@endphp

@extends('front.user.layouts.app')

@section('title', 'سوابق و مدارک')

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
            ['currentStep' => 3]
        )

        <div class="membership-page-heading">
            <div>
            <span class="membership-eyebrow">
                مرحله ۳ از ۴
            </span>

                <h1>
                    سوابق، تخصص و مدارک
                </h1>

                <p>
                    اطلاعات مربوط به سابقه فعالیت شرکت و مدارک مورد نیاز را تکمیل کنید.
                </p>
            </div>
        </div>


        <div
            id="qualifications-success"
            class="membership-alert membership-alert--success"
            style="display:none;"
        ></div>


        <div
            id="qualifications-error"
            class="membership-alert membership-alert--error"
            style="display:none;"
        ></div>


        <form
            id="qualifications-form"
            class="membership-card"
            action="{{ route(
            'user.membership.qualifications.update',
            $application
        ) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            {{-- =========================================================
                سوابق شرکت
            ========================================================== --}}

            <div class="membership-section-heading">
                <div>
                    <h2>
                        سوابق و تخصص شرکت
                    </h2>

                    <p>
                        سابقه فعالیت و حوزه تخصصی شرکت را مشخص کنید.
                    </p>
                </div>
            </div>


            <div class="membership-grid">

                <div class="membership-field">

                    <label for="activity_experience_years">
                        سابقه فعالیت شرکت
                        <span>*</span>
                    </label>

                    <input
                        type="number"
                        id="activity_experience_years"
                        name="activity_experience_years"
                        min="0"
                        max="200"
                        value="{{ old(
                        'activity_experience_years',
                        $profile?->activity_experience_years
                    ) }}"
                        placeholder="سال"
                    >

                    <span
                        class="membership-error"
                        data-error-for="activity_experience_years"
                    ></span>

                </div>


                <div class="membership-field membership-field--full">

                    <label for="oil_gas_petchem_specialty">
                        تخصص شرکت در حوزه نفت، گاز و پتروشیمی
                        <span>*</span>
                    </label>

                    <textarea
                        id="oil_gas_petchem_specialty"
                        name="oil_gas_petchem_specialty"
                        rows="6"
                        placeholder="توضیح کوتاهی درباره حوزه‌های تخصصی شرکت وارد کنید..."
                    >{{ old(
                    'oil_gas_petchem_specialty',
                    $profile?->oil_gas_petchem_specialty
                ) }}</textarea>

                    <span
                        class="membership-error"
                        data-error-for="oil_gas_petchem_specialty"
                    ></span>

                </div>

            </div>


            {{-- =========================================================
                مدارک
            ========================================================== --}}

            <div class="membership-section-heading">
                <div>
                    <h2>
                        مدارک شرکت
                    </h2>

                    <p>
                        در صورت وجود فایل قبلی، انتخاب فایل جدید الزامی نیست.
                    </p>
                </div>
            </div>


            <div class="membership-grid">

                {{-- صورتجلسه مجمع --}}
                <div class="membership-field">

                    <label for="latest_general_assembly_minutes">
                        آخرین صورتجلسه مجمع عمومی
                        @unless($assemblyMinutes)
                            <span>*</span>
                        @endunless
                    </label>

                    <input
                        type="file"
                        id="latest_general_assembly_minutes"
                        name="latest_general_assembly_minutes"
                        accept=".pdf,.jpg,.jpeg,.png"
                    >

                    @if($assemblyMinutes)
                        <div class="membership-existing-file">
                            <a
                                href="{{ asset(
                                'storage/' . $assemblyMinutes->path
                            ) }}"
                                target="_blank"
                            >
                                {{ $assemblyMinutes->original_name }}
                            </a>
                        </div>
                    @endif

                    <span
                        class="membership-error"
                        data-error-for="latest_general_assembly_minutes"
                    ></span>

                </div>


                {{-- روزنامه سرمایه --}}
                <div class="membership-field">

                    <label for="latest_capital_gazette">
                        روزنامه رسمی آخرین میزان سرمایه
                        @unless($capitalGazette)
                            <span>*</span>
                        @endunless
                    </label>

                    <input
                        type="file"
                        id="latest_capital_gazette"
                        name="latest_capital_gazette"
                        accept=".pdf,.jpg,.jpeg,.png"
                    >

                    @if($capitalGazette)
                        <div class="membership-existing-file">
                            <a
                                href="{{ asset(
                                'storage/' . $capitalGazette->path
                            ) }}"
                                target="_blank"
                            >
                                {{ $capitalGazette->original_name }}
                            </a>
                        </div>
                    @endif

                    <span
                        class="membership-error"
                        data-error-for="latest_capital_gazette"
                    ></span>

                </div>


                {{-- گواهینامه --}}
                <div class="membership-field">

                    <label for="original_certificate">
                        اصل گواهینامه
                        @unless($originalCertificate)
                            <span>*</span>
                        @endunless
                    </label>

                    <input
                        type="file"
                        id="original_certificate"
                        name="original_certificate"
                        accept=".pdf,.jpg,.jpeg,.png"
                    >

                    @if($originalCertificate)
                        <div class="membership-existing-file">
                            <a
                                href="{{ asset(
                                'storage/' . $originalCertificate->path
                            ) }}"
                                target="_blank"
                            >
                                {{ $originalCertificate->original_name }}
                            </a>
                        </div>
                    @endif

                    <span
                        class="membership-error"
                        data-error-for="original_certificate"
                    ></span>

                </div>


                {{-- رزومه --}}
                <div class="membership-field">

                    <label for="company_resume">
                        رزومه شرکت
                        @unless($companyResume)
                            <span>*</span>
                        @endunless
                    </label>

                    <input
                        type="file"
                        id="company_resume"
                        name="company_resume"
                        accept=".pdf,.doc,.docx"
                    >

                    @if($companyResume)
                        <div class="membership-existing-file">
                            <a
                                href="{{ asset(
                                'storage/' . $companyResume->path
                            ) }}"
                                target="_blank"
                            >
                                {{ $companyResume->original_name }}
                            </a>
                        </div>
                    @endif

                    <span
                        class="membership-error"
                        data-error-for="company_resume"
                    ></span>

                </div>

            </div>


            {{-- =========================================================
                اتاق بازرگانی
            ========================================================== --}}

            <div class="membership-section-heading">
                <div>
                    <h2>
                        عضویت در اتاق بازرگانی
                    </h2>
                </div>
            </div>


            <div class="membership-field">

                <label>
                    آیا شرکت عضو اتاق بازرگانی است؟
                    <span>*</span>
                </label>

                <div class="membership-radio-group">

                    <label>
                        <input
                            type="radio"
                            name="is_chamber_member"
                            value="1"
                            {{ old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === true ||
                            old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === 1 ||
                            old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === '1'
                                ? 'checked'
                                : ''
                            }}
                        >

                        بله
                    </label>


                    <label>
                        <input
                            type="radio"
                            name="is_chamber_member"
                            value="0"
                            {{ old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === false ||
                            old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === 0 ||
                            old(
                                'is_chamber_member',
                                $profile?->is_chamber_member
                            ) === '0'
                                ? 'checked'
                                : ''
                            }}
                        >

                        خیر
                    </label>

                </div>

                <span
                    class="membership-error"
                    data-error-for="is_chamber_member"
                ></span>

            </div>


            <div
                id="chamber-card-wrapper"
                class="membership-field"
                style="display:none;"
            >

                <label for="chamber_membership_card">
                    کارت عضویت اتاق بازرگانی
                    @unless($chamberCard)
                        <span>*</span>
                    @endunless
                </label>

                <input
                    type="file"
                    id="chamber_membership_card"
                    name="chamber_membership_card"
                    accept=".pdf,.jpg,.jpeg,.png"
                >

                @if($chamberCard)
                    <div class="membership-existing-file">
                        <a
                            href="{{ asset(
                            'storage/' . $chamberCard->path
                        ) }}"
                            target="_blank"
                        >
                            {{ $chamberCard->original_name }}
                        </a>
                    </div>
                @endif

                <span
                    class="membership-error"
                    data-error-for="chamber_membership_card"
                ></span>

            </div>


            {{-- =========================================================
                Actions
            ========================================================== --}}

            <div class="membership-actions">

                <a
                    href="{{ route(
                    'user.membership.registration',
                    $application
                ) }}"
                    class="membership-btn membership-btn--secondary"
                >
                    مرحله قبل
                </a>


                <button
                    type="submit"
                    id="qualifications-submit-button"
                    class="membership-btn membership-btn--primary"
                >
                    ذخیره و ادامه
                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('qualifications-form');

            const submitButton =
                document.getElementById('qualifications-submit-button');

            const successBox =
                document.getElementById('qualifications-success');

            const errorBox =
                document.getElementById('qualifications-error');

            const chamberWrapper =
                document.getElementById('chamber-card-wrapper');


            /*
            |--------------------------------------------------------------------------
            | Chamber Member
            |--------------------------------------------------------------------------
            */

            function updateChamberCardVisibility() {

                const selected =
                    document.querySelector(
                        'input[name="is_chamber_member"]:checked'
                    );

                chamberWrapper.style.display =
                    selected && selected.value === '1'
                        ? 'block'
                        : 'none';
            }


            document
                .querySelectorAll(
                    'input[name="is_chamber_member"]'
                )
                .forEach(function (radio) {

                    radio.addEventListener(
                        'change',
                        updateChamberCardVisibility
                    );

                });


            updateChamberCardVisibility();


            /*
            |--------------------------------------------------------------------------
            | Errors
            |--------------------------------------------------------------------------
            */

            function clearErrors() {

                document
                    .querySelectorAll('[data-error-for]')
                    .forEach(function (element) {
                        element.textContent = '';
                    });

                successBox.style.display = 'none';

                errorBox.style.display = 'none';
                errorBox.textContent = '';
            }


            function showValidationErrors(errors) {

                Object.entries(errors).forEach(
                    function ([field, messages]) {

                        const element =
                            document.querySelector(
                                `[data-error-for="${field}"]`
                            );

                        if (element) {
                            element.textContent =
                                messages[0];
                        }

                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                async function (event) {

                    event.preventDefault();

                    clearErrors();

                    submitButton.disabled = true;
                    submitButton.textContent =
                        'در حال ذخیره...';

                    try {

                        const response =
                            await fetch(
                                form.action,
                                {
                                    method: 'POST',

                                    headers: {
                                        'Accept':
                                            'application/json',

                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                    },

                                    body:
                                        new FormData(form),
                                }
                            );


                        const data =
                            await response.json();


                        if (response.status === 422) {

                            showValidationErrors(
                                data.errors ?? {}
                            );

                            return;
                        }


                        if (!response.ok) {
                            throw new Error();
                        }


                        successBox.textContent =
                            data.message ??
                            'اطلاعات با موفقیت ذخیره شد.';

                        successBox.style.display =
                            'block';


                        if (data.redirect) {

                            setTimeout(function () {

                                window.location.href =
                                    data.redirect;

                            }, 400);

                        }

                    } catch (error) {

                        console.error(error);

                        errorBox.textContent =
                            'در ذخیره اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.';

                        errorBox.style.display =
                            'block';

                    } finally {

                        submitButton.disabled = false;

                        submitButton.textContent =
                            'ذخیره و ادامه';

                    }

                }
            );

        });
    </script>

@endpush
