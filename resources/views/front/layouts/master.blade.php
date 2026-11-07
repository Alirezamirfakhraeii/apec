<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    {{-- =========================================================
        SEO
    ========================================================== --}}

    @include('front.layouts.partials.seo')


    {{-- =========================================================
        Favicon
    ========================================================== --}}

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('front/img/logo-irapec-min2.png') }}"
    >


    {{-- =========================================================
        Theme
    ========================================================== --}}

    <meta
        name="theme-color"
        content="#ffffff"
    >


    {{-- =========================================================
        Styles
    ========================================================== --}}

    <link
        href="{{ asset('front/css/bootstrap.css') }}"
        rel="stylesheet"
        type="text/css"
    >

    <link
        href="{{ asset('front/css/all.min.css') }}"
        rel="stylesheet"
        type="text/css"
    >

    <link
        href="{{ asset('front/css/owl.carousel.css') }}"
        rel="stylesheet"
    >

    <link
        href="{{ asset('front/css/style001.css') }}"
        rel="stylesheet"
        type="text/css"
    >

    <link
        href="{{ asset('front/css/hircana.css') }}"
        rel="stylesheet"
        type="text/css"
    >

    <link
        rel="stylesheet"
        href="{{ asset('front/css/header-menu.css') }}"
    >


    {{-- Page specific head --}}

    @stack('head')


    {{-- Page specific styles --}}

    @stack('styles')

</head>


<body>


{{-- =========================================================
    Header
========================================================== --}}

@include('front.layouts.partials.header')


{{-- =========================================================
    Content
========================================================== --}}

<main class="main-content">

    @yield('content')

</main>


{{-- =========================================================
    Footer
========================================================== --}}

@include('front.layouts.partials.footer')


{{-- =========================================================
    Scripts
========================================================== --}}

<script
    src="{{ asset('front/js/jquery.2.1.0.min.js') }}"
    type="text/javascript"
></script>

<script
    src="{{ asset('front/js/popper.min.js') }}"
    type="text/javascript"
></script>

<script
    src="{{ asset('front/js/bootstrap.min.js') }}"
    type="text/javascript"
></script>

<script
    src="{{ asset('front/js/bootstrap.bundle.min.js') }}"
    type="text/javascript"
></script>

<script
    src="{{ asset('front/js/owl.carousel.js') }}"
></script>

<script
    src="{{ asset('front/js/js.js') }}"
    type="text/javascript"
></script>

<script
    src="{{ asset('front/js/header-menu.js') }}"
></script>


{{-- Page specific scripts --}}

@stack('scripts')

</body>

</html>
