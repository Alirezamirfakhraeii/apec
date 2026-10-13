@extends('front.layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="row">
            @include('front.main.slider')

            @include('front.main.top-news')

            @include('front.main.category-blog')

            @include('front.main.sidebar-tabs')
        </div>

        @include('front.main.teldio-videos')

        {{-- بخش مناقصات --}}
        @include('front.main.tenders')

        @include('front.main.multimedia')

        @include('front.main.podcast')

        @include('front.main.contact_us')
    </div>
@endsection
