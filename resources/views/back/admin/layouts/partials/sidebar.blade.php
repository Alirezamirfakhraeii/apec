<style>
    .app-sidebar .side-menu__item {
        display: flex;
        align-items: center;
    }

    .app-sidebar .side-menu__icon {
        margin-left: 10px;
        margin-right: 0;
        min-width: 24px;
    }

    .app-sidebar .side-menu__label {
        line-height: 1.6;
    }

    .app-sidebar .angle {
        margin-right: auto;
        margin-left: 0;
    }

    .app-sidebar .slide-item.disabled {
        opacity: 0.55;
        cursor: not-allowed;
        pointer-events: none;
    }

    .app-sidebar .slide-item .menu-soon-badge {
        float: left;
        font-size: 10px;
        background: rgba(100, 116, 139, 0.14);
        color: #64748b;
        border-radius: 999px;
        padding: 2px 7px;
        margin-right: 8px;
    }

    .user-avatar-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .user-avatar-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        flex-shrink: 0;
    }

    .user-avatar-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        object-position: center;
        display: block;
        border: 3px solid #ffffff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, 0.20);
        background: #f1f5f9;
    }

    .user-avatar-wrapper .avatar-status {
        position: absolute;
        width: 15px;
        height: 15px;
        right: 5px;
        bottom: 5px;
        border: 2px solid #ffffff;
        border-radius: 50%;
    }

</style>

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;

    $hasContactPagesRoute = Route::has('admin.contact-pages.index');
    $hasFaqPagesRoute = Route::has('admin.faq-pages.index');
    $hasAboutPagesRoute = Route::has('admin.about-pages.index');
    $hasAdvertisingPagesRoute = Route::has('admin.advertising-pages.index');
    $hasBoardMembersRoute = Route::has('admin.board-members.index');

    $hasCompanyIndexRoute = Route::has('admin.company.index');
    $hasCompanyCreateRoute = Route::has('admin.company.create');
    $hasCompanyReportsRoute = Route::has('admin.company.reports');

    $companyIsOpen = request()->routeIs('admin.company.*');

    $staticPagesIsOpen = request()->routeIs(
        'admin.contact-pages.*',
        'admin.faq-pages.*',
        'admin.about-pages.*',
        'admin.advertising-pages.*'
    );

    $user = Auth::user();
@endphp


<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('front/img/logo-irapec-min2.png') }}" class="main-logo" alt="logo">
        </a>

        <a class="desktop-logo logo-dark active" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('back/img/brand/logo-white.png') }}" class="main-logo dark-theme" alt="logo">
        </a>

        <a class="logo-icon mobile-logo icon-light active" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('back/img/brand/favicon.png') }}" class="logo-icon" alt="logo">
        </a>

        <a class="logo-icon mobile-logo icon-dark active" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('back/img/brand/favicon-white.png') }}" class="logo-icon dark-theme" alt="logo">
        </a>
    </div>

    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="user-avatar-container">
                    <div class="user-avatar-wrapper">
                        @if($user->avatar)
                            <img
                                src="{{ asset('storage/' . $user->avatar) }}"
                                alt="{{ $user->name }}"
                                class="user-avatar-img"
                            >
                        @else
                            <img
                                src="{{ asset('back/assets/img/default-user.png') }}"
                                alt="بدون تصویر"
                                class="user-avatar-img"
                            >
                        @endif

                        <span class="avatar-status profile-status bg-green"></span>
                    </div>
                </div>

                <div class="user-info">
                    <h4 class="fw-semibold mt-3 mb-0">{{ auth()->user()->name ?? 'مدیر سیستم' }}</h4>
                    <span class="mb-0 text-muted">
                        {{ auth()->user()->getRoleNames()->first() == 'admin' ? 'مدیر کل' : 'دسترسی محدود' }}
                    </span>
                </div>
            </div>
        </div>

        <ul class="side-menu">

            {{-- اصلی --}}
            <li class="side-item side-item-category">اصلی</li>

            <li class="slide">
                <a class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/>
                        <path
                            d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/>
                    </svg>

                    <span class="side-menu__label">صفحه اصلی</span>
                </a>
            </li>

            {{-- مدیریت دسترسی‌ها --}}
            @role('admin')
            <li class="side-item side-item-category">مدیریت دسترسی‌ها</li>

            <li class="slide {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5-3-8-3z"/>
                    </svg>

                    <span class="side-menu__label">مدیریت کاربران</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ request()->routeIs('admin.users.*', 'admin.roles.*') ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                           href="{{ route('admin.users.index') }}">
                            لیست کاربران
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                           href="{{ route('admin.roles.index') }}">
                            نقش‌ها و دسترسی‌ها
                        </a>
                    </li>
                </ul>
            </li>
            @endrole

            {{-- مدیریت اعضا --}}
            <li class="side-item side-item-category">مدیریت اعضا</li>

            <li class="slide {{ $companyIsOpen ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="side-menu__icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>

                    <span class="side-menu__label">مدیریت اعضا</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ $companyIsOpen ? 'open' : '' }}">

                    {{-- لیست اعضا --}}
                    <li>
                        <a
                            class="slide-item
                    {{ request()->routeIs(
                        'admin.company.index',
                        'admin.company.show',
                        'admin.company.edit'
                    ) ? 'active' : '' }}
                    {{ ! $hasCompanyIndexRoute ? 'disabled' : '' }}"
                            href="{{ $hasCompanyIndexRoute ? route('admin.company.index') : '#' }}"
                            @unless($hasCompanyIndexRoute)
                                onclick="return false;"
                            @endunless
                        >
                            لیست اعضا

                            @unless($hasCompanyIndexRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    {{-- ثبت عضو جدید --}}
                    <li>
                        <a
                            class="slide-item
                    {{ request()->routeIs('admin.company.create') ? 'active' : '' }}
                    {{ ! $hasCompanyCreateRoute ? 'disabled' : '' }}"
                            href="{{ $hasCompanyCreateRoute ? route('admin.company.create') : '#' }}"
                            @unless($hasCompanyCreateRoute)
                                onclick="return false;"
                            @endunless
                        >
                            ثبت عضو جدید

                            @unless($hasCompanyCreateRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    {{-- گزارش اعضا --}}
                    <li>
                        <a
                            class="slide-item
                    {{ request()->routeIs('admin.company.reports') ? 'active' : '' }}
                    {{ ! $hasCompanyReportsRoute ? 'disabled' : '' }}"
                            href="{{ $hasCompanyReportsRoute ? route('admin.company.reports') : '#' }}"
                            @unless($hasCompanyReportsRoute)
                                onclick="return false;"
                            @endunless
                        >
                            گزارش اعضا

                            @unless($hasCompanyReportsRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                </ul>
            </li>


            {{-- بخش محتوا --}}
            <li class="side-item side-item-category">بخش محتوا</li>

            <li class="slide">
                <a class="side-menu__item {{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}"
                   href="{{ route('admin.menu-items.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M4 6h16v2H4V6zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"/>
                    </svg>

                    <span class="side-menu__label">مدیریت فهرست‌ها (منو)</span>
                </a>
            </li>

            <li class="slide">
                <a class="side-menu__item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}"
                   href="{{ route('admin.pages.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM13 9V3.5L18.5 9H13z"/>
                    </svg>

                    <span class="side-menu__label">مدیریت صفحات</span>
                </a>
            </li>

            <li class="slide {{ request()->routeIs('admin.blog-categories.*', 'admin.posts.*') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z"/>
                    </svg>

                    <span class="side-menu__label">مدیریت اتاق خبر</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ request()->routeIs('admin.blog-categories.*', 'admin.posts.*') ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.blog-categories.index') ? 'active' : '' }}"
                           href="{{ route('admin.blog-categories.index') }}">
                            دسته‌بندی موضوعی
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.posts.index', 'admin.posts.create') ? 'active' : '' }}"
                           href="{{ route('admin.posts.index') }}">
                            لیست و ثبت اخبار
                        </a>
                    </li>
                </ul>
            </li>

            <li class="slide {{ request()->routeIs('admin.podcasts.*', 'admin.categories.index') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="side-menu__icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
                        <path d="M19 10v1a7 7 0 0 1-14 0v-1"></path>
                        <line x1="12" x2="12" y1="19" y2="22"></line>
                    </svg>

                    <span class="side-menu__label">مدیریت پادکست‌ها</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ request()->routeIs('admin.podcasts.*', 'admin.categories.index') ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}"
                           href="{{ route('admin.categories.index', ['type' => 'podcast']) }}">
                            دسته‌بندی پادکست‌ها
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.podcasts.index', 'admin.podcasts.create') ? 'active' : '' }}"
                           href="{{ route('admin.podcasts.index') }}">
                            لیست و ثبت پادکست
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ارتباطات و صفحات ثابت --}}
            <li class="side-item side-item-category">ارتباطات و صفحات ثابت</li>

            <li class="slide {{ request()->routeIs('admin.contacts.*') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="side-menu__icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>

                    <span class="side-menu__label">پیام‌های ارتباط با ما</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ request()->routeIs('admin.contacts.*') ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.contacts.index', 'admin.contacts.show') ? 'active' : '' }}"
                           href="{{ route('admin.contacts.index') }}">
                            لیست پیام‌های دریافتی
                        </a>
                    </li>
                </ul>
            </li>

            <li class="slide {{ $staticPagesIsOpen ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="side-menu__icon"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <line x1="10" y1="9" x2="8" y2="9"></line>
                    </svg>

                    <span class="side-menu__label">صفحه‌های ثابت</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>

                <ul class="slide-menu {{ $staticPagesIsOpen ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.contact-pages.*') ? 'active' : '' }} {{ ! $hasContactPagesRoute ? 'disabled' : '' }}"
                           href="{{ $hasContactPagesRoute ? route('admin.contact-pages.index') : '#' }}"
                           @unless($hasContactPagesRoute) onclick="return false;" @endunless>
                            تماس با ما

                            @unless($hasContactPagesRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.board-members.*') ? 'active' : '' }} {{ ! $hasBoardMembersRoute ? 'disabled' : '' }}"
                           href="{{ $hasBoardMembersRoute ? route('admin.board-members.index') : '#' }}"
                           @unless($hasBoardMembersRoute) onclick="return false;" @endunless>
                            اعضای هیئت مدیره

                            @unless($hasBoardMembersRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.faq-pages.*') ? 'active' : '' }} {{ ! $hasFaqPagesRoute ? 'disabled' : '' }}"
                           href="{{ $hasFaqPagesRoute ? route('admin.faq-pages.index') : '#' }}"
                           @unless($hasFaqPagesRoute) onclick="return false;" @endunless>
                            سوالات متداول

                            @unless($hasFaqPagesRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.about-pages.*') ? 'active' : '' }} {{ ! $hasAboutPagesRoute ? 'disabled' : '' }}"
                           href="{{ $hasAboutPagesRoute ? route('admin.about-pages.index') : '#' }}"
                           @unless($hasAboutPagesRoute) onclick="return false;" @endunless>
                            درباره ما

                            @unless($hasAboutPagesRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>

                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.advertising-pages.*') ? 'active' : '' }} {{ ! $hasAdvertisingPagesRoute ? 'disabled' : '' }}"
                           href="{{ $hasAdvertisingPagesRoute ? route('admin.advertising-pages.index') : '#' }}"
                           @unless($hasAdvertisingPagesRoute) onclick="return false;" @endunless>
                            تبلیغات

                            @unless($hasAdvertisingPagesRoute)
                                <span class="menu-soon-badge">به‌زودی</span>
                            @endunless
                        </a>
                    </li>
                </ul>
            </li>

            {{-- عملیات --}}
            <li class="side-item side-item-category">عملیات</li>

            <li class="slide">
                <a class="side-menu__item"
                   href="#"
                   onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path
                            d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
                    </svg>

                    <span class="side-menu__label">خروج از سیستم</span>
                </a>

                <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
    </div>
</aside>
