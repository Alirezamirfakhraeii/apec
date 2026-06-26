<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="Description" content="Valex – Laravel Admin & Dashboard Template">
    <meta name="Author" content="SPRUKO™">

    <!-- Title -->
    <title>@yield('title', 'پنل مدیریت')</title>

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

    <!-- محل قرارگیری استایل‌های اختصاصی صفحات فرعی -->
    @stack('styles')
</head>

<body class="main-body app sidebar-mini">



<!-- Page -->
<div class="page">

     @include('back.admin.layouts.partials.sidebar')
    <!-- main-content -->
    <div class="main-content app-content">

         @include('back.admin.layouts.partials.navbar')

        <!-- container -->
        <div class="container-fluid">
            <!-- محتوای اصلی صفحات فرعی اینجا رندر می‌شود -->
            @yield('content')
        </div>
        <!-- /container -->
    </div>
    <!-- /main-content -->
</div>
<!-- /Page -->

<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>

<!-- Jquery js-->
<script src="{{ asset('back/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('back/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('back/plugins/bootstrap/js/bootstrap-rtl.js') }}"></script>

<!-- Ionicons js-->
<script src="{{ asset('back/plugins/ionicons/ionicons.js') }}"></script>

<!-- Moment js -->
<script src="{{ asset('back/plugins/moment/moment.js') }}"></script>

<!-- P-scroll js -->
<script src="{{ asset('back/plugins/perfect-scrollbar/perfect-scrollbar.min-rtl.js') }}"></script>
<script src="{{ asset('back/plugins/perfect-scrollbar/p-scroll-rtl.js') }}"></script>

<!-- Rating js-->
<script src="{{ asset('back/plugins/rating/jquery.rating-stars.js') }}"></script>
<script src="{{ asset('back/plugins/rating/jquery.barrating.js') }}"></script>

<!-- Sticky js -->
<script src="{{ asset('back/js/sticky.js') }}"></script>

<!-- sidemenu js -->
<script id="sidemenu" src="{{ asset('back/plugins/side-menu/sidemenu.js') }}"></script>

<!-- Right-sidebar js -->
<script src="{{ asset('back/plugins/sidebar/sidebar-rtl.js') }}"></script>
<script src="{{ asset('back/plugins/sidebar/sidebar-custom.js') }}"></script>

<!-- eva-icons js -->
<script src="{{ asset('back/plugins/eva-icons/eva-icons.min.js') }}"></script>

<!-- Chart js -->
<script src="{{ asset('back/plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('back/plugins/chartjs/Chart.bundle.min.js') }}"></script>

<!-- Internal Sparkline js -->
<script src="{{ asset('back/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

<!-- Internal Apexchart js-->
<script src="{{ asset('back/js/apexcharts.js') }}"></script>

<!-- Internal Map -->
<script src="{{ asset('back/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('back/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

<!-- Internal index js -->
<script src="{{ asset('back/js/index.js') }}"></script>
<script src="{{ asset('back/js/jquery.vmap.sampledata.js') }}"></script>

<!-- custom js -->
<script src="{{ asset('back/js/custom.js') }}"></script>

<!-- Switcher js -->
<script src="{{ asset('back/switcher/js/switcher-rtl.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/persian-date/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker/dist/js/persian-datepicker.min.js"></script>

<script>
    $(document).ready(function () {
        $('#published_at').persianDatepicker({
            format: 'YYYY/MM/DD HH:mm',
            timePicker: {
                enabled: true
            }
        });
    });
</script>


@yield('scripts')
<!-- محل قرارگیری اسکریپت‌های اختصاصی صفحات فرعی -->
@stack('scripts')
</body>
</html>
