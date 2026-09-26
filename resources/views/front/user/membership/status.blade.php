@extends('front.user.layouts.app')

@php
    use App\Enums\MembershipApplicationState;
    use App\Enums\ApplicationReviewDecision;

    $state = $application->state;

    $displayStage = $state === MembershipApplicationState::NeedsCorrection
        ? ($application->returnStage ?? $application->currentStage)
        : $application->currentStage;

    $latestCorrection = $application->reviews
        ->first(function ($review) {
            return $review->decision ===
                ApplicationReviewDecision::NeedsCorrection;
        });

    $latestRejection = $application->reviews
        ->first(function ($review) {
            return $review->decision ===
                ApplicationReviewDecision::Rejected;
        });
@endphp


@section('title', 'پیگیری درخواست عضویت')

@section('page_title', 'پیگیری درخواست عضویت')

@section(
    'page_description',
    'وضعیت بررسی درخواست عضویت شرکت را از این بخش مشاهده کنید.'
)


@push('styles')

    <link
        rel="stylesheet"
        href="{{ asset('front/css/membership-wizard/style.css') }}"
    >

@endpush


@section('content')

    <div class="membership-wizard-page">


        {{-- =========================================================
            Page Header
        ========================================================== --}}

        <div class="membership-page-heading">

            <div>

                <span class="membership-eyebrow">
                    پرونده عضویت
                </span>


                <h1>
                    پیگیری درخواست عضویت
                </h1>


                <p>
                    وضعیت بررسی درخواست عضویت شرکت را از این بخش مشاهده کنید.
                </p>

            </div>


            <span class="membership-form-state">

                {{ $state->label() }}

            </span>

        </div>


        {{-- =========================================================
            Main Status
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        وضعیت فعلی درخواست
                    </h2>

                </div>

            </div>


            {{-- In Review --}}
            @if($state === MembershipApplicationState::InReview)

                <div class="membership-status-box">

                    <span>
                        درخواست شما در حال بررسی است.
                    </span>


                    <strong>

                        مرحله فعلی:

                        {{ $displayStage?->name ?: 'در حال تعیین مرحله بررسی' }}

                    </strong>


                    <p>
                        پس از بررسی این مرحله، وضعیت درخواست شما
                        در همین صفحه به‌روزرسانی خواهد شد.
                    </p>

                </div>


                {{-- Needs Correction --}}
            @elseif(
                $state ===
                MembershipApplicationState::NeedsCorrection
            )

                <div
                    class="
                        membership-alert
                        membership-alert--error
                    "
                >

                    <strong>
                        درخواست شما نیاز به اصلاح دارد.
                    </strong>


                    @if($displayStage)

                        <p>

                            مرحله بررسی:

                            <strong>
                                {{ $displayStage->name }}
                            </strong>

                        </p>

                    @endif


                    @if($latestCorrection?->comment)

                        <p>

                            <strong>
                                توضیح کارشناس:
                            </strong>

                            {{ $latestCorrection->comment }}

                        </p>

                    @endif

                </div>


                <div class="membership-final-actions">

                    <a
                        href="{{
                            route(
                                'user.membership.basic',
                                $application
                            )
                        }}"
                        class="
                            membership-btn
                            membership-btn--primary
                        "
                    >
                        اصلاح درخواست
                    </a>

                </div>


                {{-- Rejected --}}
            @elseif(
                $state ===
                MembershipApplicationState::Rejected
            )

                <div
                    class="
                        membership-alert
                        membership-alert--error
                    "
                >

                    <strong>
                        درخواست عضویت رد شده است.
                    </strong>


                    @if($latestRejection?->comment)

                        <p>

                            <strong>
                                دلیل رد:
                            </strong>

                            {{ $latestRejection->comment }}

                        </p>

                    @endif

                </div>


                {{-- Approved --}}
            @elseif(
                $state ===
                MembershipApplicationState::Approved
            )

                <div
                    class="
                        membership-alert
                        membership-alert--success
                    "
                >

                    <strong>
                        درخواست عضویت شما تأیید شده است.
                    </strong>


                    <p>
                        فرآیند بررسی درخواست با موفقیت تکمیل شده است.
                    </p>

                </div>


                {{-- Submitted --}}
            @elseif(
                $state ===
                MembershipApplicationState::Submitted
            )

                <div class="membership-status-box">

                    <strong>
                        درخواست شما ثبت شده است.
                    </strong>


                    <p>
                        درخواست در انتظار شروع فرآیند بررسی قرار دارد.
                    </p>

                </div>

            @endif

        </div>


        {{-- =========================================================
            Application Info
        ========================================================== --}}

        <div class="membership-card">

            <div class="membership-section-heading">

                <div>

                    <h2>
                        اطلاعات درخواست
                    </h2>

                </div>

            </div>


            <div class="membership-review-grid">


                {{-- Company Name --}}
                <div>

                    <span>
                        نام شرکت
                    </span>

                    <strong>

                        {{
                            $application->intake_company_name
                            ?: '—'
                        }}

                    </strong>

                </div>


                {{-- Representative --}}
                <div>

                    <span>
                        نماینده شرکت
                    </span>

                    <strong>

                        {{
                            $application->representative_name
                            ?: '—'
                        }}

                    </strong>

                </div>


                {{-- Application ID --}}
                <div>

                    <span>
                        شماره درخواست
                    </span>

                    <strong>
                        #{{ $application->id }}
                    </strong>

                </div>


                {{-- State --}}
                <div>

                    <span>
                        وضعیت
                    </span>

                    <strong>
                        {{ $state->label() }}
                    </strong>

                </div>


                {{-- Submitted At --}}
                @if($application->submitted_at)

                    <div>

                        <span>
                            زمان ارسال
                        </span>

                        <strong>
                            {{ $application->submitted_at }}
                        </strong>

                    </div>

                @endif


                {{-- Current Stage --}}
                @if($displayStage)

                    <div>

                        <span>
                            مرحله فعلی
                        </span>

                        <strong>
                            {{ $displayStage->name }}
                        </strong>

                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection
