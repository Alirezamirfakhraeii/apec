@extends('front.user.layouts.app')

@section('title', 'پیگیری عضویت')
@section('page_title', 'پیگیری درخواست عضویت')
@section('page_description', 'وضعیت درخواست عضویت و مرحله فعلی بررسی پرونده خود را مشاهده کنید.')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/user/membership/membership-tracking.css') }}"
    >
@endpush

@section('content')

    @php

        /*
        |--------------------------------------------------------------------------
        | Application State
        |--------------------------------------------------------------------------
        */

        $stateValue = null;
        $stateLabel = null;

        if ($application) {

            $stateValue = $application->state instanceof \BackedEnum
                ? $application->state->value
                : $application->state;

            $stateLabel = is_object($application->state)
                && method_exists($application->state, 'label')
                    ? $application->state->label()
                    : match ($stateValue) {
                        'draft' => 'پیش‌نویس',
                        'submitted' => 'ثبت شده',
                        'in_review' => 'در حال بررسی',
                        'needs_correction' => 'نیازمند اصلاح',
                        'rejected' => 'رد شده',
                        'approved' => 'تأیید نهایی',
                        default => 'نامشخص',
                    };
        }


        /*
        |--------------------------------------------------------------------------
        | Review Status
        |--------------------------------------------------------------------------
        */

        $approvedStageIds = collect();

        $latestReview = null;

        if ($application) {

            $approvedStageIds = $application->reviews
                ->filter(function ($review) {

                    $decision = $review->decision instanceof \BackedEnum
                        ? $review->decision->value
                        : $review->decision;

                    return $decision === 'approved';
                })
                ->pluck('stage_id')
                ->map(fn ($id) => (int) $id);


            $latestReview = $application->reviews
                ->sortByDesc('id')
                ->first();
        }


        /*
        |--------------------------------------------------------------------------
        | Rejected Stage
        |--------------------------------------------------------------------------
        */

        $rejectedStageId = null;

        if ($application) {

            $rejectedReview = $application->reviews
                ->filter(function ($review) {

                    $decision = $review->decision instanceof \BackedEnum
                        ? $review->decision->value
                        : $review->decision;

                    return $decision === 'rejected';
                })
                ->sortByDesc('id')
                ->first();

            $rejectedStageId = $rejectedReview?->stage_id;
        }


        /*
        |--------------------------------------------------------------------------
        | Correction Review
        |--------------------------------------------------------------------------
        */

        $correctionReview = null;

        if ($application && $stateValue === 'needs_correction') {

            $correctionReview = $application->reviews
                ->filter(function ($review) {

                    $decision = $review->decision instanceof \BackedEnum
                        ? $review->decision->value
                        : $review->decision;

                    return $decision === 'needs_correction';
                })
                ->sortByDesc('id')
                ->first();
        }

    @endphp


    <div class="membership-tracking">


        {{-- =========================================================
            No Application
        ========================================================== --}}

        @if(!$application)

            <section class="membership-tracking__empty">

                <div class="membership-tracking__empty-icon">

                    <i class="fa fa-file-text-o"></i>

                </div>


                <h2>
                    هنوز درخواست عضویتی ثبت نکرده‌اید
                </h2>


                <p>
                    برای شروع فرآیند عضویت، ابتدا اطلاعات شرکت و مدارک مورد نیاز
                    را تکمیل و درخواست خود را ثبت کنید.
                </p>


                @if(Route::has('user.membership.create'))

                    <a
                        href="{{ route('user.membership.create') }}"
                        class="membership-tracking__primary-btn"
                    >

                        <i class="fa fa-plus"></i>

                        ثبت درخواست عضویت

                    </a>

                @endif

            </section>


        @else


            {{-- =====================================================
                Application Header
            ====================================================== --}}

            <section class="membership-tracking__overview">

                <div class="membership-tracking__overview-main">

                    <div class="membership-tracking__application-icon">

                        <i class="fa fa-file-text-o"></i>

                    </div>


                    <div>

                    <span class="membership-tracking__application-number">
                        درخواست شماره
                        #{{ $application->id }}
                    </span>


                        <h2>

                            {{
                                $application->companyProfile?->registered_name
                                ?: $application->intake_company_name
                                ?: 'درخواست عضویت'
                            }}

                        </h2>


                        <p>
                            وضعیت پرونده عضویت شما در این صفحه قابل پیگیری است.
                        </p>

                    </div>

                </div>


                <div
                    class="
                    membership-tracking__state
                    membership-tracking__state--{{ $stateValue }}
                "
                >

                    <span class="membership-tracking__state-dot"></span>

                    {{ $stateLabel }}

                </div>

            </section>


            {{-- =====================================================
                Needs Correction Alert
            ====================================================== --}}

            @if($stateValue === 'needs_correction')

                <section class="membership-tracking__alert membership-tracking__alert--warning">

                    <div class="membership-tracking__alert-icon">

                        <i class="fa fa-exclamation-triangle"></i>

                    </div>


                    <div class="membership-tracking__alert-content">

                        <h3>
                            پرونده شما نیازمند اصلاح است
                        </h3>


                        <p>
                            درخواست شما از مرحله

                            <strong>
                                {{
                                    $application->returnStage?->name
                                    ?: $application->currentStage?->name
                                    ?: 'بررسی پرونده'
                                }}
                            </strong>

                            برای اصلاح بازگردانده شده است.
                        </p>


                        @if($correctionReview?->comment)

                            <div class="membership-tracking__review-message">

                                <strong>
                                    توضیحات کارشناس:
                                </strong>

                                <span>
                                {{ $correctionReview->comment }}
                            </span>

                            </div>

                        @endif


                        @if(Route::has('user.membership.edit'))

                            <a
                                href="{{ route('user.membership.edit', $application) }}"
                                class="membership-tracking__warning-btn"
                            >
                                اصلاح اطلاعات درخواست
                            </a>

                        @endif

                    </div>

                </section>

            @endif


            {{-- =====================================================
                Rejected Alert
            ====================================================== --}}

            @if($stateValue === 'rejected')

                <section class="membership-tracking__alert membership-tracking__alert--danger">

                    <div class="membership-tracking__alert-icon">

                        <i class="fa fa-times-circle"></i>

                    </div>


                    <div class="membership-tracking__alert-content">

                        <h3>
                            درخواست عضویت رد شده است
                        </h3>


                        <p>
                            فرآیند بررسی این درخواست متوقف شده است.
                        </p>


                        @if($latestReview?->comment)

                            <div class="membership-tracking__review-message">

                                <strong>
                                    توضیحات:
                                </strong>

                                <span>
                                {{ $latestReview->comment }}
                            </span>

                            </div>

                        @endif

                    </div>

                </section>

            @endif


            {{-- =====================================================
                Approved Alert
            ====================================================== --}}

            @if($stateValue === 'approved')

                <section class="membership-tracking__alert membership-tracking__alert--success">

                    <div class="membership-tracking__alert-icon">

                        <i class="fa fa-check-circle"></i>

                    </div>


                    <div class="membership-tracking__alert-content">

                        <h3>
                            درخواست عضویت شما تأیید شد
                        </h3>


                        <p>
                            فرآیند بررسی پرونده با موفقیت به پایان رسیده است.
                        </p>

                    </div>

                </section>

            @endif


            {{-- =====================================================
                Current Stage
            ====================================================== --}}

            @if(
                $application->currentStage
                && !in_array($stateValue, ['approved', 'rejected'])
            )

                <section class="membership-tracking__current">

                    <div class="membership-tracking__current-icon">

                        <i class="fa fa-clock-o"></i>

                    </div>


                    <div>

                    <span>
                        مرحله فعلی بررسی
                    </span>

                        <h3>
                            {{ $application->currentStage->name }}
                        </h3>

                    </div>

                </section>

            @endif


            {{-- =====================================================
                Workflow
            ====================================================== --}}

            <section class="membership-tracking__card">

                <div class="membership-tracking__card-header">

                    <div>

                        <h2>
                            مراحل بررسی درخواست
                        </h2>

                        <p>
                            پرونده شما به ترتیب مراحل زیر بررسی می‌شود.
                        </p>

                    </div>

                </div>


                <div class="membership-tracking__timeline">

                    @foreach($workflowStages as $index => $stage)

                        @php

                            $isApproved = $stateValue === 'approved'
                                || $approvedStageIds->contains((int) $stage->id);

                            $isCurrent = (int) $application->current_stage_id
                                === (int) $stage->id;

                            $isRejected = $stateValue === 'rejected'
                                && (int) $rejectedStageId === (int) $stage->id;

                            $isCorrection = $stateValue === 'needs_correction'
                                && (
                                    (int) $application->return_stage_id === (int) $stage->id
                                    || (int) $application->current_stage_id === (int) $stage->id
                                );

                            $stepClass = 'pending';

                            if ($isApproved) {
                                $stepClass = 'completed';
                            }

                            if ($isCurrent) {
                                $stepClass = 'current';
                            }

                            if ($isCorrection) {
                                $stepClass = 'correction';
                            }

                            if ($isRejected) {
                                $stepClass = 'rejected';
                            }

                        @endphp


                        <div
                            class="
                            membership-tracking__step
                            membership-tracking__step--{{ $stepClass }}
                        "
                        >

                            <div class="membership-tracking__step-line">

                                <div class="membership-tracking__step-circle">

                                    @if($isApproved)

                                        <i class="fa fa-check"></i>

                                    @elseif($isRejected)

                                        <i class="fa fa-times"></i>

                                    @elseif($isCorrection)

                                        <i class="fa fa-pencil"></i>

                                    @elseif($isCurrent)

                                        <i class="fa fa-clock-o"></i>

                                    @else

                                        {{ $index + 1 }}

                                    @endif

                                </div>


                                @if(!$loop->last)

                                    <span class="membership-tracking__connector"></span>

                                @endif

                            </div>


                            <div class="membership-tracking__step-content">

                                <div class="membership-tracking__step-top">

                                    <h3>
                                        {{ $stage->name }}
                                    </h3>


                                    @if($isApproved)

                                        <span class="membership-tracking__step-badge membership-tracking__step-badge--completed">
                                        تأیید شده
                                    </span>

                                    @elseif($isRejected)

                                        <span class="membership-tracking__step-badge membership-tracking__step-badge--rejected">
                                        رد شده
                                    </span>

                                    @elseif($isCorrection)

                                        <span class="membership-tracking__step-badge membership-tracking__step-badge--correction">
                                        نیازمند اصلاح
                                    </span>

                                    @elseif($isCurrent)

                                        <span class="membership-tracking__step-badge membership-tracking__step-badge--current">
                                        در حال بررسی
                                    </span>

                                    @else

                                        <span class="membership-tracking__step-badge">
                                        در انتظار
                                    </span>

                                    @endif

                                </div>


                                <p>

                                    @if($isApproved)

                                        بررسی این مرحله انجام شده و پرونده به مرحله بعد منتقل شده است.

                                    @elseif($isRejected)

                                        فرآیند بررسی پرونده در این مرحله متوقف شده است.

                                    @elseif($isCorrection)

                                        این مرحله درخواست اصلاح اطلاعات یا مدارک کرده است.

                                    @elseif($isCurrent)

                                        پرونده در حال حاضر توسط این بخش در حال بررسی است.

                                    @else

                                        این مرحله پس از تکمیل مرحله قبلی آغاز می‌شود.

                                    @endif

                                </p>

                            </div>

                        </div>

                    @endforeach

                </div>

            </section>


            {{-- =====================================================
                Application Information
            ====================================================== --}}

            <section class="membership-tracking__card">

                <div class="membership-tracking__card-header">

                    <div>

                        <h2>
                            اطلاعات پرونده
                        </h2>

                        <p>
                            خلاصه وضعیت درخواست عضویت ثبت‌شده
                        </p>

                    </div>

                </div>


                <div class="membership-tracking__info-grid">

                    <div class="membership-tracking__info">

                    <span>
                        شماره درخواست
                    </span>

                        <strong>
                            #{{ $application->id }}
                        </strong>

                    </div>


                    <div class="membership-tracking__info">

                    <span>
                        وضعیت درخواست
                    </span>

                        <strong>
                            {{ $stateLabel }}
                        </strong>

                    </div>


                    <div class="membership-tracking__info">

                    <span>
                        نام شرکت
                    </span>

                        <strong>
                            {{
                                $application->companyProfile?->registered_name
                                ?: $application->intake_company_name
                                ?: 'ثبت نشده'
                            }}
                        </strong>

                    </div>


                    <div class="membership-tracking__info">

                    <span>
                        مرحله فعلی
                    </span>

                        <strong>

                            @if($stateValue === 'approved')

                                تکمیل فرآیند

                            @elseif($stateValue === 'rejected')

                                پرونده بسته شده

                            @else

                                {{
                                    $application->currentStage?->name
                                    ?: 'در انتظار شروع بررسی'
                                }}

                            @endif

                        </strong>

                    </div>

                </div>

            </section>

        @endif

    </div>

@endsection
