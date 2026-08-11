
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
    <link href="{{ asset('back/css/auth/auth.css') }}" rel="stylesheet">
    <!-- Auth CSS -->
    <link
        href="{{ asset('back/css/auth/auth.css') }}" rel="stylesheet">

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


<script
    src="{{ asset('back/js/auth/auth.js') }}"
    defer
></script>
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
