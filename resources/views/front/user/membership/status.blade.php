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

@extends('front.user.layouts.app')

@section('title', 'پیگیری درخواست عضویت')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/membership-wizard/style.css') }}"
    >
@endsection

@section('content')

    <div class="membership-wizard-page">

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
                        پس از بررسی این مرحله، وضعیت درخواست شما در همین صفحه به‌روزرسانی خواهد شد.
                    </p>

                </div>


            @elseif($state === MembershipApplicationState::NeedsCorrection)

                <div class="membership-alert membership-alert--error">

                    <strong>
                        درخواست شما نیاز به اصلاح دارد.
                    </strong>

                    @if($displayStage)
                        <p>
                            مرحله بررسی:
                            {{ $displayStage->name }}
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
                        href="{{ route(
                        'user.membership.basic',
                        $application
                    ) }}"
                        class="membership-btn membership-btn--primary"
                    >
                        اصلاح درخواست
                    </a>

                </div>


            @elseif($state === MembershipApplicationState::Rejected)

                <div class="membership-alert membership-alert--error">

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


            @elseif($state === MembershipApplicationState::Approved)

                <div class="membership-alert membership-alert--success">

                    <strong>
                        درخواست عضویت شما تأیید شده است.
                    </strong>

                    <p>
                        فرآیند بررسی درخواست با موفقیت تکمیل شده است.
                    </p>

                </div>


            @elseif($state === MembershipApplicationState::Submitted)

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

                <div>

                <span>
                    نام شرکت
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
                    شماره درخواست
                </span>

                    <strong>
                        #{{ $application->id }}
                    </strong>

                </div>


                <div>

                <span>
                    وضعیت
                </span>

                    <strong>
                        {{ $state->label() }}
                    </strong>

                </div>


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


        {{-- =========================================================
            Review Timeline
        ========================================================== --}}

        @if($application->reviews->isNotEmpty())

            <div class="membership-card">

                <div class="membership-section-heading">

                    <div>

                        <h2>
                            تاریخچه بررسی
                        </h2>

                        <p>
                            تصمیم‌های ثبت‌شده روی درخواست
                        </p>

                    </div>

                </div>


                @foreach($application->reviews as $review)

                    <div class="membership-review-row">

                        <div>

                            <strong>
                                {{ $review->stage?->name ?: 'مرحله بررسی' }}
                            </strong>

                            @if($review->comment)

                                <p>
                                    {{ $review->comment }}
                                </p>

                            @endif

                        </div>


                        <strong>
                            {{ $review->decision->label() }}
                        </strong>

                    </div>

                @endforeach

            </div>

        @endif

    </div>

@endsection
