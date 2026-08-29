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

<!-- تزریق فرم‌های ورود یا ثبت نام -->
@yield('form_content')

@include('front.auth.layouts.scripts')
</body>
</html>
