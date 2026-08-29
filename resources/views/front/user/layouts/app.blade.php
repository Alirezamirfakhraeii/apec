<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'پنل کاربری')</title>

    <link
        rel="stylesheet"
        href="{{ asset('front/css/user/dashboard.css') }}"
    >

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('back/img/brand/favicon.png') }}" type="image/x-icon"/>

    <!-- Icons css -->
    <link href="{{ asset('back/plugins/icons/icons.css') }}" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="{{ asset('back/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">

    <!-- Right-sidemenu css -->
    <link href="{{ asset('back/plugins/sidebar/sidebar.css') }}" rel="stylesheet">

    <!-- P-scroll bar css-->
    <link href="{{ asset('back/plugins/perfect-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

    <!-- Sidemenu css -->
    <link id="theme" rel="stylesheet" href="{{ asset('back/css-rtl/sidemenu.css') }}">

    <!-- Owl-carousel css-->
    <link href="{{ asset('back/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />

    <!-- Maps css -->
    <link href="{{ asset('back/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">

    <!--- Style css --->
    <link href="{{ asset('back/css-rtl/style.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css-rtl/style-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css-rtl/boxed.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css-rtl/dark-boxed.css') }}" rel="stylesheet">

    <!---Skinmodes css-->
    <link href="{{ asset('back/css-rtl/skin-modes.css') }}" rel="stylesheet" />

    <!--- Animations css-->
    <link href="{{ asset('back/css-rtl/animate.css') }}" rel="stylesheet">

    <!---Switcher css-->
    <link href="{{ asset('back/switcher/css/switcher-rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('back/switcher/demo.css') }}" rel="stylesheet">



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/persian-datepicker/dist/css/persian-datepicker.min.css">

    <link href="{{ asset('back/css/panel/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>

<div class="user-dashboard-shell">

    @include('front.user.partials.sidebar')

    <div
        class="user-sidebar-overlay"
        data-user-sidebar-overlay
    ></div>

    <main class="user-dashboard-main">

        @include('front.user.partials.topbar')

        <div class="user-dashboard-content">
            @yield('content')
        </div>

    </main>

</div>


<script src="{{ asset('front/js/user/dashboard.js') }}"></script>

@stack('scripts')

</body>
</html>
