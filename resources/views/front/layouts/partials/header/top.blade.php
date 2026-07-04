<!--begin header area -->
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

            {{-- Date + Language --}}
            <div class="col-lg-3 col-md-9 col-6 order-2 order-lg-3 text-left">

                <div class="d-inline-flex align-items-center justify-content-end header-left-actions">

                    {{-- Date --}}
                    <div class="d-none d-md-inline-flex align-items-center header-date-pill ml-2">
                        <i class="fa fa-calendar-alt ml-1"></i>

                        <span>
                            {{ verta()->format('Y/m/d') }}
                        </span>

                        <span class="mx-1 text-muted">|</span>

                        <strong>
                            {{ verta()->format('H:i') }}
                        </strong>
                    </div>

                    {{-- Language --}}
                    <div class="dropdown header-lang-dropdown">
                        <button class="btn header-lang-btn dropdown-toggle"
                                type="button"
                                data-toggle="dropdown"
                                aria-expanded="false">

                            @if(app()->getLocale() === 'en')
                                <span class="ml-1">🇬🇧</span>
                                <span>EN</span>
                            @else
                                <span class="ml-1">🇮🇷</span>
                                <span>FA</span>
                            @endif

                        </button>

                        <div class="dropdown-menu dropdown-menu-left text-right header-lang-menu">
                            <a class="dropdown-item font_12 {{ app()->getLocale() === 'fa' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'fa') }}">
                                <span class="ml-1">🇮🇷</span>
                                فارسی
                            </a>

                            <a class="dropdown-item font_12 {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                               href="{{ route('lang.switch', 'en') }}">
                                <span class="ml-1">🇬🇧</span>
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
    .clean-news-header .header-lang-dropdown {
        position: relative;
        z-index: 10000;
    }

    .clean-news-header .dropdown-menu,
    .header-lang-menu {
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

    .header-date-pill {
        height: 40px;
        padding: 0 11px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-size: 11px;
        white-space: nowrap;
    }

    .header-date-pill i {
        color: #2563eb;
    }

    .header-date-pill strong {
        color: #0f172a;
        font-size: 11px;
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

        .header-lang-btn {
            height: 38px;
            min-width: 72px;
        }
    }
</style>
