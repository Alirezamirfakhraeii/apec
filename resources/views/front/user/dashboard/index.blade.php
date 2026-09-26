@extends('front.user.layouts.app')

@section('title', 'داشبورد کاربری')
@section('page_title', 'حساب کاربری من')
@section('page_description', 'اطلاعات حساب و درخواست عضویت خود را از این بخش مدیریت کنید.')

@php
    $user = auth()->user();

    $displayName = $user?->name ?: 'کاربر عزیز';
    $email = $user?->email ?: 'ثبت نشده';
    $mobile = $user?->mobile ?? $user?->phone_number ?? 'ثبت نشده';

    $initials = collect(
        preg_split('/\s+/', trim($displayName))
    )
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');

    // Controller can pass the latest application as $application.
    $application = $application ?? null;

    $stateValue = $application
        ? ($application->state instanceof \BackedEnum
            ? $application->state->value
            : $application->state)
        : null;

    $stateLabel = match ($stateValue) {
        'draft' => 'پیش‌نویس',
        'submitted' => 'ارسال شده',
        'in_review' => 'در حال بررسی',
        'needs_correction' => 'نیازمند اصلاح',
        'approved' => 'تأیید شده',
        'rejected' => 'رد شده',
        default => 'درخواستی ثبت نشده',
    };
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/user/dashboard.css') }}">
@endpush

@section('content')

    <div class="user-dashboard">

        <section class="user-dashboard-profile">

            <div class="user-dashboard-profile__cover">
                <span>حساب کاربری APEC</span>
                <strong>خوش آمدید، {{ $displayName }}</strong>
            </div>

            <div class="user-dashboard-profile__body">

                <div class="user-dashboard-profile__header">

                    <div class="user-dashboard-profile__identity">

                        <div class="user-dashboard-profile__avatar-wrap">
                            <div class="user-dashboard-profile__avatar">
                                {{ $initials ?: 'U' }}
                            </div>
                            <span class="user-dashboard-profile__online"></span>
                        </div>

                        <div class="user-dashboard-profile__name">
                            <div class="user-dashboard-profile__name-row">
                                <h2>{{ $displayName }}</h2>
                                <span>حساب فعال</span>
                            </div>
                            <p dir="ltr">{{ $email }}</p>
                        </div>

                    </div>

                    @if(Route::has('user.profile.edit'))
                        <a
                            href="{{ route('user.profile.edit') }}"
                            class="user-dashboard-profile__edit"
                        >
                            <i class="fa fa-pencil"></i>
                            <span>ویرایش اطلاعات</span>
                        </a>
                    @endif

                </div>

                <div class="user-dashboard-profile__info">

                    <div class="user-dashboard-info">
                    <span class="user-dashboard-info__icon">
                        <i class="fa fa-user-o"></i>
                    </span>
                        <div>
                            <small>نام و نام خانوادگی</small>
                            <strong>{{ $displayName }}</strong>
                        </div>
                    </div>

                    <div class="user-dashboard-info">
                    <span class="user-dashboard-info__icon">
                        <i class="fa fa-envelope-o"></i>
                    </span>
                        <div>
                            <small>ایمیل</small>
                            <strong dir="ltr">{{ $email }}</strong>
                        </div>
                    </div>

                    <div class="user-dashboard-info">
                    <span class="user-dashboard-info__icon">
                        <i class="fa fa-mobile"></i>
                    </span>
                        <div>
                            <small>شماره همراه</small>
                            <strong dir="ltr">{{ $mobile }}</strong>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <div class="user-dashboard__grid">

            <section class="user-dashboard-card">

                <header class="user-dashboard-card__header">
                    <span>دسترسی سریع</span>
                    <h2>اقدامات حساب</h2>
                    <p>بخش‌های پرکاربرد حساب کاربری</p>
                </header>

                <div class="user-dashboard-actions">

                    @if(Route::has('user.profile.edit'))
                        <a
                            href="{{ route('user.profile.edit') }}"
                            class="user-dashboard-action"
                        >
                        <span class="user-dashboard-action__icon">
                            <i class="fa fa-user-o"></i>
                        </span>
                            <span class="user-dashboard-action__content">
                            <strong>ویرایش اطلاعات حساب</strong>
                            <small>اطلاعات شخصی خود را بروزرسانی کنید.</small>
                        </span>
                            <i class="fa fa-angle-left"></i>
                        </a>
                    @endif

                    @if(Route::has('user.membership.create'))
                        <a
                            href="{{ route('user.membership.create') }}"
                            class="user-dashboard-action"
                        >
                        <span class="user-dashboard-action__icon">
                            <i class="fa fa-file-text-o"></i>
                        </span>
                            <span class="user-dashboard-action__content">
                            <strong>درخواست عضویت</strong>
                            <small>درخواست عضویت شرکت را مدیریت کنید.</small>
                        </span>
                            <i class="fa fa-angle-left"></i>
                        </a>
                    @endif

                    <a href="{{ url('/') }}" class="user-dashboard-action">
                    <span class="user-dashboard-action__icon">
                        <i class="fa fa-globe"></i>
                    </span>
                        <span class="user-dashboard-action__content">
                        <strong>وب‌سایت اصلی</strong>
                        <small>بازگشت به صفحه عمومی APEC</small>
                    </span>
                        <i class="fa fa-angle-left"></i>
                    </a>

                </div>

            </section>

            <section class="user-dashboard-card">

                <header class="user-dashboard-card__header">
                    <span>عضویت</span>
                    <h2>وضعیت درخواست عضویت</h2>
                    <p>آخرین وضعیت پرونده شما</p>
                </header>

                <div class="user-dashboard-membership">

                    @if($application)

                        <div class="user-dashboard-membership__status">
                            <div>
                                <small>وضعیت فعلی</small>
                                <strong>{{ $stateLabel }}</strong>
                            </div>

                            <span class="user-dashboard-membership__badge user-dashboard-membership__badge--{{ $stateValue }}">
                            {{ $stateLabel }}
                        </span>
                        </div>

                        <div class="user-dashboard-membership__details">

                            <div>
                                <small>شماره درخواست</small>
                                <strong>#{{ $application->id }}</strong>
                            </div>

                            <div>
                                <small>مرحله فعلی</small>
                                <strong>{{ $application->currentStage?->name ?: '—' }}</strong>
                            </div>

                        </div>

                    @else

                        <div class="user-dashboard-empty">
                        <span>
                            <i class="fa fa-file-o"></i>
                        </span>
                            <h3>درخواست عضویتی ثبت نشده است</h3>
                            <p>هنوز پرونده عضویتی برای حساب شما وجود ندارد.</p>
                        </div>

                    @endif

                </div>

            </section>

        </div>

    </div>

@endsection
