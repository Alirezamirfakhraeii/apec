<div class="main-header sticky side-header nav nav-item">
    <div class="container-fluid">
        <div class="main-header-left">
            <!-- لوگوهای واکنش‌گرا -->
            <div class="responsive-logo">
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('back/img/brand/logo.png') }}"
                                                              class="logo-1" alt="لوگو"></a>
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('back/img/brand/logo-white.png') }}"
                                                              class="dark-logo-1" alt="لوگو"></a>
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('back/img/brand/favicon.png') }}"
                                                              class="logo-2" alt="لوگو"></a>
                <a href="{{ route('admin.dashboard') }}"><img src="{{ asset('back/img/brand/favicon.png') }}"
                                                              class="dark-logo-2" alt="لوگو"></a>
            </div>
            <!-- دکمه همبرگری سایدبار -->
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
                <a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
            </div>
            <!-- باکس جستجوی ادمین -->
            <div class="main-header-center mr-3 d-sm-none d-md-none d-lg-block">
                <input class="form-control" placeholder="جستجو در سیستم ..." type="search">
                <button class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
            </div>
        </div>

        <div class="main-header-right">
            <div class="nav nav-item navbar-nav-right ml-auto">

                <!-- دراپ‌داون اعلان‌ها (Notifications) -->
                <div class="dropdown nav-item main-header-notification">
                    <a class="new nav-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span class="pulse"></span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="menu-header-content bg-primary text-right">
                            <div class="d-flex">
                                <h6 class="dropdown-title mb-1 tx-15 text-white font-weight-semibold">اطلاعیه‌ها</h6>
                            </div>
                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12">شما اعلان جدیدی
                                ندارید</p>
                        </div>
                        <div class="main-notification-list Notification-scroll">
                        </div>
                    </div>
                </div>

                <!-- دکمه تمام صفحه کردن پنل -->
                <div class="nav-item full-screen fullscreen-button">
                    <a class="new nav-link full-screen-link" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path>
                        </svg>
                    </a>
                </div>

                <!-- منوی پروفایل ادمین لاگین شده -->
                <div class="dropdown main-profile-menu nav nav-item nav-link">
                    <a class="profile-user d-flex" href="#"><img alt="avatar" src="{{ asset('back/img/faces/6.jpg') }}"></a>
                    <div class="dropdown-menu">
                        <div class="main-header-profile bg-primary p-3">
                            <div class="d-flex wd-100p">
                                <div class="main-img-user"><img alt="avatar" src="{{ asset('back/img/faces/6.jpg') }}">
                                </div>
                                <div class="ms-3 my-auto">
                                    <h6>{{ auth()->user()->name ?? 'مدیر سیستم' }}</h6>
                                    <span>{{ auth()->user()->getRoleNames()->first() ?? 'Admin' }}</span>
                                </div>
                            </div>
                        </div>
                        <a class="dropdown-item" href="#"><i class="bx bx-user-circle"></i>مشخصات حساب</a>
                        <a class="dropdown-item" href="#"><i class="bx bx-cog"></i> ویرایش پروفایل</a>

                        <!-- دکمه خروج امنیتی متصل به روت POST -->
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();">
                            <i class="bx bx-log-out"></i> خروج از سیستم
                        </a>

                        <form id="header-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
