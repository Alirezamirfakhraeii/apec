@extends('front.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            {{--اسلایدر --}}
            @include('front.main.slider')

            <!-- ستون سمت راست: اخبار برتر -->

            @include('front.main.top-news')

            <!-- ستون سمت راست: اخبار برتر -->
            @include('front.main.category-blog')

            <!-- ستون سمت چپ: تب‌ها و سوژه روز -->
            @include('front.main.sidebar-tabs')
        </div>

        <!-- بخش ویدیوهای تلدیو -->
        @include('front.main.teldio-videos')

        <!-- بخش چند رسانه‌ای -->
        @include('front.main.multimedia')

        <!-- بخش عکس روز -->
        @include('front.main.podcast')


        @include('front.main.contact_us')
    </div>
@endsection
