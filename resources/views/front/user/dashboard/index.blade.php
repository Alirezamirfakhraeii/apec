@extends('front.user.layouts.app')

@section('title', 'داشبورد کاربری')
@section('page_title', 'حساب کاربری من')
@section('page_description', 'اطلاعات حساب و درخواست‌های خود را از این بخش مدیریت کنید.')

@section('content')

    @include('front.user.dashboard.partials.profile-card')

    <div class="user-dashboard-grid">

        @include('front.user.dashboard.partials.quick-actions')

        @include('front.user.dashboard.partials.membership-status')

    </div>

@endsection
