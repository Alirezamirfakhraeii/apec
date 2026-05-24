<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('back/img/brand/logo.png') }}" class="main-logo" alt="logo">
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
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround" src="{{ asset('back/img/faces/6.jpg') }}">
                    <span class="avatar-status profile-status bg-green"></span>
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
            <li class="side-item side-item-category">اصلی</li>

            <li class="slide">
                <a class="side-menu__item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M5 5h4v6H5zm10 8h4v6h-4zM5 17h4v2H5zM15 5h4v2h-4z" opacity=".3"/>
                        <path d="M3 13h8V3H3v10zm2-8h4v6H5V5zm8 16h8V11h-8v10zm2-8h4v6h-4v-6zM13 3v6h8V3h-8zm6 4h-4V5h4v2zM3 21h8v-6H3v6zm2-4h4v2H5v-2z"/>
                    </svg>
                    <span class="side-menu__label">صفحه اصلی</span>
                </a>
            </li>

            @role('admin')
            <li class="side-item side-item-category">مدیریت دسترسی‌ها</li>

            <!-- مدیریت کاربران -->
            <li class="slide">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5-3-8-3z"/>
                    </svg>
                    <span class="side-menu__label">مدیریت کاربران</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li><a class="slide-item" href="#">لیست کاربران</a></li>
                    <li><a class="slide-item" href="#">نقش‌ها و دسترسی‌ها</a></li>
                </ul>
            </li>
            @endrole

            <!-- منوی جدید: مدیریت محتوا (دسته بندی و بلاگ) -->
            <li class="side-item side-item-category">بخش محتوا</li>
            <li class="slide {{ request()->routeIs('admin.categories.*') ? 'is-expanded' : '' }}">
                <a class="side-menu__item" data-bs-toggle="slide" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H8V4h12v12z"/>
                    </svg>
                    <span class="side-menu__label">مدیریت محتوا</span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu {{ request()->routeIs('admin.categories.*') ? 'open' : '' }}">
                    <li>
                        <a class="slide-item {{ request()->routeIs('admin.categories.index') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">دسته‌بندی‌ها</a>                    </li>
                    <li>
                        <a class="slide-item" href="#">مدیریت اخبار و بلاگ</a>
                    </li>
                </ul>
            </li>

            <li class="side-item side-item-category">عملیات</li>
            <li class="slide">
                <a class="side-menu__item" href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/>
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
