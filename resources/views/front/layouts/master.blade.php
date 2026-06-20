<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'سایت اپک')</title>

    <!-- استایل‌های اختصاصی قالب اردیبهشت -->
    <link href="{{ asset('front/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('front/css/owl.carousel.css') }}" rel="stylesheet">
    <link href="{{ asset('front/css/style001.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('front/css/hircana.css') }}" type="text/css" rel="stylesheet">

    <!-- محل قرارگیری استایل‌های احتمالی صفحات خاص -->
    @stack('styles')
</head>
<body>

<!-- هدر سایت -->
@include('front.layouts.partials.header')

<!-- محتوای داینامیک صفحات سایت -->
<main class="main-content">
    @yield('content')
</main>

<!-- فوتر سایت -->
@include('front.layouts.partials.footer')


<!-- اسکریپت‌های اختصاصی قالب اردیبهشت -->
<script src="{{ asset('front/js/jquery.2.1.0.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('front/js/owl.carousel.js') }}"></script>
<script src="{{ asset('front/js/js.js') }}" type="text/javascript"></script>

<!-- محل قرارگیری اسکریپت‌های احتمالی صفحات خاص -->
@stack('scripts')
</body>
</html>
