


<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'پنل کاربری') | APEC</title>

    <link rel="icon" href="{{ asset('back/img/brand/favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('back/plugins/icons/icons.css') }}">
    <link rel="stylesheet" href="{{ asset('back/plugins/bootstrap/css/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/user/dashboard/app.css') }}">

    @stack('styles')
</head>
<body class="user-panel-body">

<div class="user-panel">

    <aside class="user-panel__sidebar" data-user-sidebar aria-label="منوی کاربری">
        @include('front.user.partials.sidebar')
    </aside>

    <button
        type="button"
        class="user-panel__overlay"
        data-user-sidebar-overlay
        aria-label="بستن منوی کاربری"
    ></button>

    <div class="user-panel__main">

        <div class="user-panel__topbar">
            @include('front.user.partials.topbar')
        </div>

        <main class="user-panel__content">

            @if(session('success'))
                <div class="user-alert user-alert--success">
                    <span class="user-alert__icon">
                        <i class="fa fa-check"></i>
                    </span>
                    <div class="user-alert__content">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="user-alert user-alert--danger">
                    <span class="user-alert__icon">
                        <i class="fa fa-exclamation"></i>
                    </span>
                    <div class="user-alert__content">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="user-alert user-alert--danger">
                    <span class="user-alert__icon">
                        <i class="fa fa-exclamation-triangle"></i>
                    </span>
                    <div class="user-alert__content">
                        لطفاً خطاهای فرم را بررسی کنید.
                    </div>
                </div>
            @endif

            <div class="user-page-content">
                @yield('content')
            </div>

        </main>

        <footer class="user-panel__footer">
            <span>© {{ now()->year }} APEC</span>
            <span>تمامی حقوق محفوظ است.</span>
        </footer>

    </div>
</div>

<script src="{{ asset('front/js/user/dashboard/app.js') }}"></script>
@stack('scripts')

</body>
</html>
