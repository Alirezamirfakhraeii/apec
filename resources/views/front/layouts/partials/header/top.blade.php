{{-- =========================================================
     APEC EXTRAORDINARY GENERAL ASSEMBLY COUNTDOWN
========================================================= --}}

@php
    $assemblyDate = \Carbon\Carbon::create(
        2026,
        9,
        30,
        0,
        0,
        0,
        'Asia/Tehran'
    );
@endphp




{{-- =========================================================
     LOGIN + LANGUAGE TOP BAR
========================================================= --}}


<div
    id="apec-assembly-countdown"
    class="apec-countdown-bar"
    data-target="{{ $assemblyDate->toIso8601String() }}"
    dir="rtl"
>
    <div class="container">

        <div class="apec-countdown-content">

            <div class="apec-countdown-title">

                <i class="fa fa-calendar-alt"></i>

                <span>
                    روزشمار برگزاری مجمع عمومی فوق‌العاده انجمن اپک
                </span>

            </div>

            <div class="apec-countdown-separator"></div>

            <div
                id="apec-countdown-value"
                class="apec-countdown-value"
            >
                ۷ روز تا مجمع
            </div>

        </div>

    </div>
</div>


{{-- =========================================================
     MAIN HEADER
========================================================= --}}

<div class="container my-3 clean-news-header" dir="rtl">

    <div class="px-0 py-2">

        <div class="row align-items-center">

            {{-- =====================================================
                 LOGO
            ====================================================== --}}
            <div class="col-lg-2 col-md-3 col-6 order-1 text-right">

                <a
                    href="{{ route('home') }}"
                    class="d-inline-block"
                >

                    <img
                        src="{{ asset('front/img/logo-irapec-min2.png') }}"
                        class="img-fluid header-logo"
                        alt="لوگو"
                    >

                </a>

            </div>


            {{-- =====================================================
                 SEARCH
            ====================================================== --}}
            <div class="col-lg-7 col-md-12 col-12 order-3 order-lg-2 mt-3 mt-lg-0">

                <form
                    method="GET"
                    action="#"
                    class="header-search-form"
                >

                    <div class="header-search-box">

                        <span class="header-search-icon">

                            <i class="fa fa-search"></i>

                        </span>


                        <input
                            name="search"
                            type="text"
                            class="header-search-input"
                            placeholder="جستجو در اخبار، تحلیل‌ها، گزارش‌ها و پادکست‌ها..."
                        >


                        <button
                            type="submit"
                            class="header-search-submit"
                        >
                            جستجو
                        </button>

                    </div>

                </form>

            </div>


            {{-- =====================================================
                 LOGIN + LANGUAGE
            ====================================================== --}}
            <div class="col-lg-3 col-md-9 col-6 order-2 order-lg-3 text-left">

                <div
                    class="d-inline-flex align-items-center justify-content-end header-left-actions"
                >

                    {{-- Login --}}
                    @guest

                        <a
                            href="{{ route('login') }}"
                            class="header-login-btn ml-2"
                        >

                            <i class="fa fa-sign-in-alt ml-1"></i>

                            <span>ورود</span>

                            <span class="login-divider"></span>

                            <span>ثبت‌نام</span>

                        </a>

                    @else

                        @php
                            $user = auth()->user();
                            $isAdmin = $user && $user->hasRole('admin');
                        @endphp


                        <div
                            class="btn-group dropdown header-user-dropdown ml-2"
                        >

                            @if($isAdmin)

                                <a
                                    href="{{ route('admin.dashboard') }}"
                                    class="btn header-user-btn header-user-main-btn"
                                    title="ورود به داشبورد مدیریت"
                                >

                                    <i class="fa fa-user ml-1"></i>

                                    <span>
                                        {{ $user->name ?? 'حساب کاربری' }}
                                    </span>

                                </a>

                            @else

                                <span
                                    class="btn header-user-btn header-user-main-btn"
                                >

                                    <i class="fa fa-user ml-1"></i>

                                    <span>
                                        {{ $user->name ?? 'حساب کاربری' }}
                                    </span>

                                </span>

                            @endif


                            <button
                                class="btn header-user-btn header-user-toggle-btn dropdown-toggle dropdown-toggle-split"
                                type="button"
                                data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false"
                            >

                                <span class="sr-only">
                                    بازکردن منوی حساب کاربری
                                </span>

                            </button>


                            <div
                                class="dropdown-menu dropdown-menu-left text-right header-user-menu"
                            >

                                @if($isAdmin)

                                    <a
                                        class="dropdown-item font_12"
                                        href="{{ route('admin.dashboard') }}"
                                    >

                                        <i class="fa fa-tachometer-alt ml-1"></i>

                                        داشبورد مدیریت

                                    </a>

                                @else

                                    <a
                                        class="dropdown-item font_12"
                                        href="{{ route('user.dashboard') }}"
                                    >

                                        <i class="fa fa-user-circle ml-1"></i>

                                        پروفایل

                                    </a>

                                @endif


                                <div class="dropdown-divider"></div>


                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item font_12 text-danger"
                                    >

                                        <i class="fa fa-sign-out-alt ml-1"></i>

                                        خروج

                                    </button>

                                </form>

                            </div>

                        </div>

                    @endguest


                    {{-- Language --}}
                    <div class="dropdown header-lang-dropdown">

                        <button
                            class="btn header-lang-btn dropdown-toggle header-lang-flag-only"
                            type="button"
                            data-toggle="dropdown"
                            aria-expanded="false"
                        >

                            @if(app()->getLocale() === 'en')

                                <img
                                    src="{{ asset('front/img/flags/en.png') }}"
                                    alt="EN"
                                    class="header-flag-img"
                                >

                            @else

                                <img
                                    src="{{ asset('front/img/flags/ir.png') }}"
                                    alt="FA"
                                    class="header-flag-img"
                                >

                            @endif

                        </button>


                        <div
                            class="dropdown-menu dropdown-menu-left text-right header-lang-menu"
                        >

                            <a
                                class="dropdown-item font_12 {{ app()->getLocale() === 'fa' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'fa') }}"
                            >

                                <img
                                    src="{{ asset('front/img/flags/ir.png') }}"
                                    alt="FA"
                                    class="lang-menu-flag"
                                >

                                فارسی

                            </a>


                            <a
                                class="dropdown-item font_12 {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                                href="{{ route('lang.switch', 'en') }}"
                            >

                                <img
                                    src="{{ asset('front/img/flags/en.png') }}"
                                    alt="EN"
                                    class="lang-menu-flag"
                                >

                                English

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>



<style>

    /*
    |--------------------------------------------------------------------------
    | Countdown
    |--------------------------------------------------------------------------
    */

    .apec-countdown-bar {
        width: 100%;

        background: linear-gradient(
            110deg,
            #0f172a 0%,
            #172554 35%,
            #1e3a8a 50%,
            #172554 65%,
            #0f172a 100%
        );

        background-size: 250% 250%;

        color: #ffffff;

        position: relative;

        z-index: 10040;

        overflow: hidden;

        animation:
            apecSlideDown 0.7s ease-out,
            apecBackgroundMove 8s ease-in-out infinite;
    }


    .apec-countdown-bar::before {
        content: "";

        position: absolute;

        top: 0;

        right: 0;

        width: 4px;

        height: 100%;

        background: #ef394e;

        box-shadow:
            0 0 10px rgba(239, 57, 78, 0.7),
            0 0 20px rgba(239, 57, 78, 0.35);

        animation:
            apecRedGlow 2s ease-in-out infinite;
    }


    .apec-countdown-bar::after {
        content: "";

        position: absolute;

        top: 0;

        right: -150px;

        width: 100px;

        height: 100%;

        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.08),
            transparent
        );

        transform: skewX(-25deg);

        animation:
            apecShine 7s ease-in-out infinite;

        pointer-events: none;
    }


    .apec-countdown-content {
        min-height: 44px;

        display: flex;

        align-items: center;

        justify-content: center;

        gap: 18px;

        padding: 8px 0;

        position: relative;

        z-index: 2;
    }


    .apec-countdown-title {
        display: flex;

        align-items: center;

        gap: 8px;

        font-size: 13px;

        font-weight: 500;

        color: #f8fafc;
    }


    .apec-countdown-title i {
        color: #f87171;

        font-size: 14px;

        animation:
            apecIconMove 2s ease-in-out infinite;
    }


    .apec-countdown-separator {
        width: 1px;

        height: 20px;

        background:
            rgba(255, 255, 255, 0.25);
    }


    .apec-countdown-value {
        display: inline-flex;

        align-items: center;

        justify-content: center;

        min-width: 110px;

        height: 30px;

        padding: 0 14px;

        border-radius: 8px;

        background: linear-gradient(
            135deg,
            #ef394e,
            #dc2626
        );

        color: #ffffff;

        font-size: 13px;

        font-weight: 800;

        white-space: nowrap;

        box-shadow:
            0 5px 15px
            rgba(239, 57, 78, 0.25);

        animation:
            apecCountdownPulse 2.2s ease-in-out infinite;

        transition: all 0.3s ease;
    }


    .apec-countdown-value:hover {
        transform:
            translateY(-2px);

        box-shadow:
            0 8px 22px
            rgba(239, 57, 78, 0.4);
    }


    /*
    |--------------------------------------------------------------------------
    | Login / Language top bar
    |--------------------------------------------------------------------------
    */

    .header-top-actions-bar {
        width: 100%;

        min-height: 50px;

        display: flex;

        align-items: center;

        position: relative;

        z-index: 10020;

        background: #ffffff;

        border-bottom:
            1px solid #eef2f7;
    }


    .header-top-actions-inner {
        min-height: 50px;

        display: flex;

        align-items: center;

        justify-content: flex-end;
    }


    .header-left-actions {
        position: relative;

        z-index: 10021;
    }


    /*
    |--------------------------------------------------------------------------
    | Main header
    |--------------------------------------------------------------------------
    */

    .clean-news-header {
        position: relative;

        z-index: 9999;
    }


    /*
    |--------------------------------------------------------------------------
    | Dropdown
    |--------------------------------------------------------------------------
    */

    .header-top-actions-bar .dropdown,
    .header-user-dropdown,
    .header-lang-dropdown {
        position: relative;

        z-index: 10022;
    }


    .header-user-menu,
    .header-lang-menu {
        z-index: 10030 !important;

        border: 0;

        border-radius: 14px;

        padding: 7px;

        margin-top: 10px;

        box-shadow:
            0 18px 45px
            rgba(15, 23, 42, 0.18);
    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    .header-search-form {
        width: 100%;
    }


    .header-search-box {
        position: relative;

        height: 52px;

        display: flex;

        align-items: center;

        background: #ffffff;

        border:
            1px solid #e2e8f0;

        border-radius: 18px;

        box-shadow:
            0 10px 28px
            rgba(15, 23, 42, 0.07);

        transition: all 0.25s ease;

        overflow: hidden;
    }


    .header-search-box:focus-within {
        border-color:
            rgba(37, 99, 235, 0.55);

        box-shadow:
            0 12px 34px
            rgba(37, 99, 235, 0.14);
    }


    .header-search-icon {
        width: 48px;

        height: 100%;

        display: flex;

        align-items: center;

        justify-content: center;

        color: #2563eb;

        font-size: 14px;
    }


    .header-search-input {
        flex: 1;

        height: 100%;

        border: 0;

        outline: 0;

        background: transparent;

        color: #0f172a;

        font-size: 13px;

        padding: 0 4px;
    }


    .header-search-input::placeholder {
        color: #94a3b8;
    }


    .header-search-submit {
        height: 40px;

        margin-left: 6px;

        padding: 0 18px;

        border: 0;

        border-radius: 14px;

        background: #0f172a;

        color: #ffffff;

        font-size: 12px;

        font-weight: 700;

        cursor: pointer;

        transition: 0.25s ease;
    }


    .header-search-submit:hover {
        background: #2563eb;
    }


    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */

    .header-login-btn {
        height: 40px;

        padding: 0 14px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        border-radius: 10px;

        border:
            1px solid #d0d7de;

        background: #ffffff;

        color: #0f172a;

        font-size: 12px;

        font-weight: 700;

        text-decoration: none !important;

        white-space: nowrap;

        transition:
            all 0.25s ease;
    }


    .header-login-btn i {
        font-size: 14px;

        color: #0f172a;
    }


    .header-login-btn:hover {
        color: #ef394e;

        border-color: #ef394e;

        box-shadow:
            0 8px 22px
            rgba(239, 57, 78, 0.12);
    }


    .header-login-btn:hover i {
        color: #ef394e;
    }


    .login-divider {
        width: 1px;

        height: 14px;

        background: #cbd5e1;

        margin: 0 8px;

        display: inline-block;
    }


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    .header-user-btn {
        height: 40px;

        max-width: 145px;

        padding: 0 12px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        border-radius: 10px;

        border:
            1px solid #d0d7de;

        background: #ffffff;

        color: #0f172a;

        font-size: 12px;

        font-weight: 700;

        white-space: nowrap;

        overflow: hidden;

        text-overflow: ellipsis;
    }


    .header-user-btn:hover,
    .header-user-btn:focus {
        color: #ef394e;

        border-color: #ef394e;

        box-shadow:
            0 8px 22px
            rgba(239, 57, 78, 0.12);
    }


    .header-user-dropdown.btn-group {
        direction: rtl;

        display: inline-flex;

        align-items: stretch;

        vertical-align: middle;
    }


    .header-user-main-btn {
        max-width: 145px;

        min-width: 0;

        border-radius:
            0 10px 10px 0 !important;

        text-decoration:
            none !important;
    }


    .header-user-main-btn span {
        display: block;

        min-width: 0;

        overflow: hidden;

        text-overflow: ellipsis;

        white-space: nowrap;
    }


    .header-user-toggle-btn {
        width: 38px;

        min-width: 38px;

        max-width: 38px;

        padding: 0;

        border-right: 0;

        border-radius:
            10px 0 0 10px !important;

        overflow: visible;
    }


    .header-user-toggle-btn::after {
        margin: 0;
    }


    .header-user-menu .dropdown-item {
        border-radius: 10px;

        padding: 8px 10px;

        background: transparent;

        border: 0;

        width: 100%;

        text-align: right;

        cursor: pointer;
    }


    .header-user-menu .dropdown-item:hover {
        background: #f8fafc;
    }


    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    */

    .header-lang-btn {
        height: 40px;

        min-width: 78px;

        border-radius: 14px;

        border:
            1px solid #e2e8f0;

        background: #ffffff;

        color: #0f172a;

        font-size: 12px;

        font-weight: 700;

        box-shadow:
            0 8px 22px
            rgba(15, 23, 42, 0.06);
    }


    .header-lang-btn:hover,
    .header-lang-btn:focus {
        background: #f8fafc;

        border-color:
            rgba(37, 99, 235, 0.45);
    }


    .header-lang-menu .dropdown-item {
        border-radius: 10px;

        padding: 8px 10px;
    }


    .header-lang-menu .dropdown-item.active,
    .header-lang-menu .dropdown-item:hover {
        background: #eff6ff;

        color: #2563eb;
    }


    .header-lang-flag-only {
        width: 44px;

        min-width: 44px;

        height: 40px;

        padding: 0;

        border-radius: 14px;

        display: inline-flex;

        align-items: center;

        justify-content: center;
    }


    .header-lang-flag-only::after {
        display: none;
    }


    .header-flag-img {
        width: 24px;

        height: 24px;

        border-radius: 50%;

        object-fit: cover;

        display: block;
    }


    .lang-menu-flag {
        width: 20px;

        height: 20px;

        border-radius: 50%;

        object-fit: cover;

        margin-left: 6px;
    }


    /*
    |--------------------------------------------------------------------------
    | Animations
    |--------------------------------------------------------------------------
    */

    @keyframes apecSlideDown {

        from {
            opacity: 0;
            transform: translateY(-100%);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }

    }


    @keyframes apecBackgroundMove {

        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }

    }


    @keyframes apecCountdownPulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.035);
        }

    }


    @keyframes apecIconMove {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-2px);
        }

    }


    @keyframes apecShine {

        0% {
            right: -150px;
        }

        30%,
        100% {
            right: calc(100% + 150px);
        }

    }


    @keyframes apecRedGlow {

        0%,
        100% {
            box-shadow:
                0 0 5px
                rgba(239, 57, 78, 0.4);
        }

        50% {
            box-shadow:
                0 0 15px
                rgba(239, 57, 78, 0.9),
                0 0 25px
                rgba(239, 57, 78, 0.35);
        }

    }


    /*
    |--------------------------------------------------------------------------
    | Mobile
    |--------------------------------------------------------------------------
    */

    @media (max-width: 767px) {

        .apec-countdown-content {
            min-height: 46px;

            gap: 9px;

            padding: 7px 5px;
        }


        .apec-countdown-title {
            font-size: 11px;

            line-height: 1.7;
        }


        .apec-countdown-title i {
            font-size: 12px;
        }


        .apec-countdown-separator {
            height: 18px;
        }


        .apec-countdown-value {
            min-width: auto;

            height: 28px;

            padding: 0 10px;

            font-size: 11px;
        }

    }


    @media (max-width: 575px) {

        .header-top-actions-bar,
        .header-top-actions-inner {
            min-height: 46px;
        }


        .header-search-box {
            height: 48px;

            border-radius: 15px;
        }


        .header-search-submit {
            height: 36px;

            padding: 0 13px;

            font-size: 11px;
        }


        .header-login-btn {
            height: 38px;

            padding: 0 10px;

            font-size: 11px;
        }


        .header-lang-btn {
            height: 38px;

            min-width: 72px;
        }


        .header-user-btn {
            height: 38px;

            max-width: 115px;

            font-size: 11px;
        }

    }


    @media (max-width: 480px) {

        .apec-countdown-content {
            justify-content:
                space-between;
        }


        .apec-countdown-title {
            flex: 1;
        }


        .apec-countdown-separator {
            display: none;
        }


        .apec-countdown-value {
            flex-shrink: 0;
        }

    }


    @media (prefers-reduced-motion: reduce) {

        .apec-countdown-bar,
        .apec-countdown-bar::before,
        .apec-countdown-bar::after,
        .apec-countdown-value,
        .apec-countdown-title i {
            animation: none !important;
        }

    }

</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const countdownBar =
            document.getElementById(
                'apec-assembly-countdown'
            );

        const countdownValue =
            document.getElementById(
                'apec-countdown-value'
            );


        if (!countdownBar || !countdownValue) {
            return;
        }


        const targetDate =
            new Date(
                countdownBar.dataset.target
            );


        /**
         * Convert English number
         * to Persian number.
         */
        function toPersianNumber(number) {

            return new Intl.NumberFormat(
                'fa-IR',
                {
                    useGrouping: false
                }
            ).format(number);

        }


        /**
         * Update assembly countdown.
         */
        function updateCountdown() {

            const now =
                new Date();


            const difference =
                targetDate.getTime() -
                now.getTime();


            const oneDay =
                1000 * 60 * 60 * 24;


            const days =
                Math.ceil(
                    difference / oneDay
                );


            if (days > 0) {

                countdownValue.textContent =
                    `${toPersianNumber(days)} روز تا مجمع`;

                return;
            }


            if (days === 0) {

                countdownValue.textContent =
                    'امروز، روز برگزاری مجمع';

                return;
            }


            countdownBar.style.display =
                'none';

        }


        updateCountdown();


        setInterval(
            updateCountdown,
            60 * 1000
        );

    });
</script>
