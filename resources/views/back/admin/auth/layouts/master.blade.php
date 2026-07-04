<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>

    <!-- استایل‌های مشترک و ثابت قالب ولکس -->
    <link rel="icon" href="{{ asset('back/img/brand/favicon.png') }}" type="image/x-icon"/>
    <link href="{{ asset('back/plugins/icons/icons.css') }}" rel="stylesheet">
    <link href="{{ asset('back/css-rtl/skin-modes.css') }}" rel="stylesheet" />
    <link href="{{ asset('back/css/animate.css') }}" rel="stylesheet">

    <!-- لود داینامیک بوت‌استرپ و استایل اصلی بر اساس زبان -->
    @if(app()->getLocale() == 'fa')
        <link href="{{ asset('back/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
        <link href="{{ asset('back/css-rtl/style.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('back/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('back/css/style.css') }}" rel="stylesheet">
    @endif
</head>

<body class="main-body">

<!-- Loader -->
<div id="global-loader">
    <img src="{{ asset('back/img/loader.svg') }}" class="loader-img" alt="Loader">
</div>

<!-- Page -->
<div class="page">
    <div class="container-fluid">
        <div class="row no-gutter">

            <!-- نیمه تصویر سمت چپ (مشترک در ورود و ثبت نام) -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p m-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto m-auto wd-100p">
                        <img src="{{ asset('back/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p m-auto" alt="logo">
                    </div>
                </div>
            </div>

            <!-- نیمه فرم سمت راست (متغیر بر اساس صفحه) -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 m-auto">
                                <div class="card-sigin">

                                    <!-- هدر لوگو واحد -->
                                    <div class="mb-5 d-flex">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('back/img/brand/favicon.png') }}" class="sign-favicon-a ht-40" alt="logo">
                                        </a>
                                        <h1 class="main-logo1 ms-1 me-0 my-auto tx-28">Va<span>le</span>x</h1>
                                    </div>

                                    <!-- تزریق فرم‌های ورود یا ثبت نام -->
                                    @yield('form_content')

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End content half -->

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('global-loader');

        if (loader) {
            loader.style.display = 'none';
        }
    });
</script>
</body>
</html>
