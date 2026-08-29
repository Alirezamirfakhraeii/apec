@extends('front.user.layouts.app')

@section('title', 'تکمیل درخواست عضویت')

@section('page_title', 'تکمیل درخواست عضویت')

@section(
    'page_description',
    'اطلاعات مورد نیاز را تکمیل کنید. اطلاعات شما تا زمان ارسال نهایی به صورت پیش‌نویس باقی می‌ماند.'
)

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('assets/user/css/membership.css') }}"
    >
@endpush


@section('content')

    <div class="membership-page">

        <div class="membership-heading">

            <div>

                <span class="membership-heading__eyebrow">
                    درخواست #{{ $application->id }}
                </span>

                <h2>
                    تکمیل اطلاعات عضویت
                </h2>

                <p>
                    فرم درخواست را تکمیل کنید. تا زمانی که ارسال نهایی انجام نشده،
                    درخواست شما در وضعیت پیش‌نویس باقی خواهد ماند.
                </p>

            </div>

        </div>


        <div class="membership-application-card">

            <div class="membership-application-card__body">

                <div>
                    فرم اصلی اطلاعات درخواست در این بخش قرار می‌گیرد.
                </div>

            </div>

        </div>

    </div>

@endsection
