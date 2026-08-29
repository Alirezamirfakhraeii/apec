@extends('front.user.layouts.app')

@section('title', 'درخواست عضویت')

@section('page_title', 'درخواست عضویت')

@section(
    'page_description',
    'اطلاعات مورد نیاز عضویت در انجمن را تکمیل و ارسال کنید.'
)

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/user/membership.css') }}"
    >
@endpush


@section('content')

    <div class="membership-page">

        @if(session('success'))
            <div class="membership-alert membership-alert--success">
                {{ session('success') }}
            </div>
        @endif


        <div class="membership-heading">

            <div>
                <span class="membership-heading__eyebrow">
                    عضویت در انجمن
                </span>

                <h2>
                    درخواست عضویت
                </h2>

                <p>
                    برای عضویت، ابتدا یک درخواست ایجاد کرده و سپس اطلاعات و مدارک مورد نیاز را تکمیل کنید.
                </p>
            </div>

        </div>


        @if($application)

            <div class="membership-application-card">

                <div class="membership-application-card__header">

                    <div>
                        <span>
                            شماره درخواست
                        </span>

                        <strong>
                            #{{ $application->id }}
                        </strong>
                    </div>


                    <div class="membership-status">
                        {{ $application->state->value }}
                    </div>

                </div>


                <div class="membership-application-card__body">

                    <div class="membership-info">

                        <span>
                            وضعیت فعلی
                        </span>

                        <strong>
                            @switch($application->state)

                                @case(\App\Enums\MembershipApplicationState::Draft)
                                    پیش‌نویس
                                    @break

                                @case(\App\Enums\MembershipApplicationState::Submitted)
                                    ارسال شده
                                    @break

                                @case(\App\Enums\MembershipApplicationState::InReview)
                                    در حال بررسی
                                    @break

                                @case(\App\Enums\MembershipApplicationState::NeedsCorrection)
                                    نیاز به اصلاح
                                    @break

                                @case(\App\Enums\MembershipApplicationState::Rejected)
                                    رد شده
                                    @break

                                @case(\App\Enums\MembershipApplicationState::Approved)
                                    تایید شده
                                    @break

                            @endswitch
                        </strong>

                    </div>


                    <div class="membership-info">

                        <span>
                            مرحله بررسی
                        </span>

                        <strong>
                            {{ $application->currentStage?->name ?? 'هنوز ارسال نشده' }}
                        </strong>

                    </div>


                    <div class="membership-info">

                        <span>
                            تاریخ ایجاد
                        </span>

                        <strong>
                            {{ $application->created_at?->format('Y/m/d H:i') }}
                        </strong>

                    </div>

                </div>


                @if(
                    $application->state ===
                    \App\Enums\MembershipApplicationState::Draft
                )

                    <div class="membership-application-card__footer">

                        <a
                            href="{{ route('user.membership.edit', $application) }}"
                            class="membership-primary-button"
                        >
                            تکمیل فرم درخواست
                        </a>

                    </div>

                @endif

            </div>

        @else

            <div class="membership-start-card">

                <div class="membership-start-card__icon">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <path d="M14 2v6h6"/>
                        <path d="M9 13h6"/>
                        <path d="M12 10v6"/>
                    </svg>

                </div>


                <h3>
                    هنوز درخواست عضویتی ثبت نکرده‌اید
                </h3>


                <p>
                    برای شروع فرآیند عضویت، ابتدا یک درخواست جدید ایجاد کنید.
                    پس از ایجاد درخواست می‌توانید فرم اطلاعات شرکت را مرحله‌به‌مرحله تکمیل کنید.
                </p>


                <form
                    action="{{ route('user.membership.store') }}"
                    method="POST"
                >
                    @csrf

                    <button
                        type="submit"
                        class="membership-primary-button"
                    >
                        شروع درخواست عضویت
                    </button>

                </form>

            </div>

        @endif

    </div>

@endsection
