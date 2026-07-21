@extends('front.layouts.master')

@section('content')
    <div class="container py-5">

        <h1>{{ $company->registered_name }}</h1>

        <div class="card mt-4">
            <div class="card-body">

                <p>
                    <strong>نام اختصاری:</strong>
                    {{ $company->company_short_name ?: 'ثبت نشده' }}
                </p>

                <p>
                    <strong>شماره عضویت:</strong>
                    {{ $company->membership_number ?: 'ثبت نشده' }}
                </p>

                <p>
                    <strong>نوع عضویت:</strong>
                    {{ $company->membership_type ?: 'ثبت نشده' }}
                </p>

                <p>
                    <strong>نوع فعالیت:</strong>
                    {{ $company->activity_type ?: 'ثبت نشده' }}
                </p>

            </div>
        </div>

    </div>
@endsection
