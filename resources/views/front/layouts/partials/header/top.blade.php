<div class="container my-3 clean-news-header" dir="rtl">
    <div class="px-0 py-2">

        <div class="row align-items-center">

            {{-- Logo --}}
            <div class="col-lg-2 col-md-3 col-6 order-1 text-right">
                <a href="{{ route('home') }}" class="d-inline-block">
                    <img src="{{ asset('front/img/logo-irapec-min2.png') }}"
                         class="img-fluid header-logo"
                         alt="لوگو">
                </a>
            </div>

            {{-- Search --}}
            <div class="col-lg-7 col-md-12 col-12 order-3 order-lg-2 mt-3 mt-lg-0">
                <form method="GET" action="#" class="header-search-form">
                    <div class="header-search-box">
                        <span class="header-search-icon">
                            <i class="fa fa-search"></i>
                        </span>

                        <input name="search"
                               type="text"
                               class="header-search-input"
                               placeholder="جستجو در اخبار، تحلیل‌ها، گزارش‌ها و پادکست‌ها...">

                        <button type="submit" class="header-search-submit">
                            جستجو
                        </button>
                    </div>
                </form>
            </div>

            {{-- Login + Language --}}
            <div class="col-lg-3 col-md-9 col-6 order-2 order-lg-3 text-left">

                <div class="d-inline-flex align-items-center justify-content-end header-left-actions">

                    {{-- Login Button --}}
                    @guest
                        <a href="{{ route('login') }}" class="header-login-btn ml-2">
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

                        <div class="btn-group dropdown header-user-dropdown ml-2">

                            {{-- نام کاربر؛ برای ادمین لینک داشبورد است --}}
                            @if($isAdmin)
                                <a href="{{ route('admin.dashboard') }}"
                                   class="btn header-user-btn header-user-main-btn"
                                   title="ورود به داشبورد مدیریت">

                                    <i class="fa fa-user ml-1"></i>

                                    <span>
                                        {{ $user->name ?? 'حساب کاربری' }}
                                    </span>
                                </a>
                            @else
                                <span class="btn header-user-btn header-user-main-btn">

                                    <i class="fa fa-user ml-1"></i>

                                    <span>
                                        {{ $user->name ?? 'حساب کاربری' }}
                                    </span>
                                </span>
                            @endif

                            {{-- فلش بازکردن منوی حساب کاربری --}}
                            <button class="btn header-user-btn header-user-toggle-btn dropdown-toggle dropdown-toggle-split"
                                    type="button"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false">

                                <span class="sr-only">
                                    بازکردن منوی حساب کاربری
                                </span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-left text-right header-user-menu">

                                @if($isAdmin)
                                    <a class="dropdown-item font_12"
                                       href="{{ route('admin.dashboard') }}">

                                        <i class="fa fa-tachometer-alt ml-1"></i>
                                        داشبورد مدیریت
                                    </a>
                                @else
                                    <a class="dropdown-item font_12"
                                       href="{{ route('user.dashboard') }}">

                                        <i class="fa fa-user-circle ml-1"></i>
                                        پروفایل
                                    </a>
                                @endif

                                <div class="dropdown-divider"></div>

                                <form method="POST"
                                      action="{{ route('logout') }}">

                                    @csrf

                                    <button type="submit"
                                            class="dropdown-item font_12 text-danger">

                                        <i class="fa fa-sign-out-alt ml-1"></i>
                                        خروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    {{-- Language --}}
                    <div class="dropdown header-lang-dropdown">
                        <button class="btn header-lang-btn dropdown-toggle header-lang-flag-only"
                                type="button"
                                data-toggle="dropdown"
                                aria-expanded="false">

                            @if(app()->getLocale() === 'en')
                                <img src="{{ asset('front/img/flags/en.png') }}" alt="EN" class="header-flag-img">
                            @else
                                <img src="{{ asset('front/img/flags/ir.png') }}" alt="FA" class="header-flag-img">
                            @endif

                        </button>

                        <div class="dropdown-menu dropdown-menu-left text-right header-lang-menu">
                            <a class="dropdown-item font_12 {{ app()->getLocale() === 'fa' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'fa') }}">
                                <img src="{{ asset('front/img/flags/ir.png') }}" alt="FA" class="lang-menu-flag">
                                فارسی
                            </a>

                            <a class="dropdown-item font_12 {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'en') }}">
                                <img src="{{ asset('front/img/flags/en.png') }}" alt="EN" class="lang-menu-flag">
                                English
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
<!--end header area -->

<style>
    .clean-news-header {
        position: relative;
        z-index: 9999;
    }

    .clean-news-header .dropdown,
    .clean-news-header .header-lang-dropdown,
    .clean-news-header .header-user-dropdown {
        position: relative;
        z-index: 10000;
    }

    .clean-news-header .dropdown-menu,
    .header-lang-menu,
    .header-user-menu {
        z-index: 10001 !important;
        border: 0;
        border-radius: 14px;
        padding: 7px;
        margin-top: 10px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.18);
    }

    .header-search-form {
        width: 100%;
    }

    .header-search-box {
        position: relative;
        height: 52px;
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        box-shadow: 0 10px 28px rgba(15, 23, 42, 0.07);
        transition: all 0.25s ease;
        overflow: hidden;
    }

    .header-search-box:focus-within {
        border-color: rgba(37, 99, 235, 0.55);
        box-shadow: 0 12px 34px rgba(37, 99, 235, 0.14);
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

    .header-login-btn {
        height: 40px;
        padding: 0 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid #d0d7de;
        background: #ffffff;
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        white-space: nowrap;
        transition: all 0.25s ease;
    }

    .header-login-btn i {
        font-size: 14px;
        color: #0f172a;
    }

    .header-login-btn:hover {
        color: #ef394e;
        border-color: #ef394e;
        box-shadow: 0 8px 22px rgba(239, 57, 78, 0.12);
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

    .header-user-btn {
        height: 40px;
        max-width: 145px;
        padding: 0 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 1px solid #d0d7de;
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
        box-shadow: 0 8px 22px rgba(239, 57, 78, 0.12);
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
        border-radius: 0 10px 10px 0 !important;
        text-decoration: none !important;
    }

    .header-user-main-btn span {
        display: block;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .header-user-main-btn:hover,
    .header-user-main-btn:focus {
        text-decoration: none !important;
    }

    .header-user-toggle-btn {
        width: 38px;
        min-width: 38px;
        max-width: 38px;
        padding: 0;
        border-right: 0;
        border-radius: 10px 0 0 10px !important;
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

    .header-lang-btn {
        height: 40px;
        min-width: 78px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #0f172a;
        font-size: 12px;
        font-weight: 700;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
    }

    .header-lang-btn:hover,
    .header-lang-btn:focus {
        background: #f8fafc;
        border-color: rgba(37, 99, 235, 0.45);
        box-shadow: 0 10px 26px rgba(15, 23, 42, 0.10);
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

    @media (max-width: 575px) {
        .header-search-box {
            height: 48px;
            border-radius: 15px;
        }

        .header-search-submit {
            height: 36px;
            padding: 0 13px;
            border-radius: 12px;
            font-size: 11px;
        }

        .header-search-input {
            font-size: 12px;
        }

        .header-login-btn {
            height: 38px;
            padding: 0 10px;
            font-size: 11px;
        }

        .header-login-btn i {
            font-size: 13px;
        }

        .login-divider {
            margin: 0 6px;
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

        .header-user-main-btn {
            max-width: 115px;
        }

        .header-user-toggle-btn {
            width: 34px;
            min-width: 34px;
            max-width: 34px;
        }
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


</style>
