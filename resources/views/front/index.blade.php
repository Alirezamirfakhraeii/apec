@extends('front.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <!-- ستون سمت راست: اخبار برتر -->
            @include('front.partials.top-news')

            <!-- ستون سمت چپ: تب‌ها و سوژه روز -->
            @include('front.partials.sidebar-tabs')
        </div>

        <!-- بخش ویدیوهای تلدیو -->
        @include('front.partials.teldio-videos')

        <!-- بخش چند رسانه‌ای -->
        @include('front.partials.multimedia')

        <!-- بخش عکس روز -->
        @include('front.partials.photo-of-day')
    </div>
@endsection
