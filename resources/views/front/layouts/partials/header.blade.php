<!--begin header area -->
<div class="container my-3">
    <div class="row align-items-center">

        <!-- ۱. لوگوی سایت (سمت راست) -->
        <div class="col-lg-2 col-md-3 col-6 order-1" style="text-align: right;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('front/img/1111.png') }}" class="img-fluid" alt="لوگو" style="max-height: 65px;">
            </a>
        </div>

        <!-- بخش آیکون‌های شبکه‌های اجتماعی (با فاصله بیشتر و منظم) -->
        <!-- بخش آیکون‌های شبکه‌های اجتماعی (کاملاً وسط‌چین شده) -->
        <div class="col-lg-3 d-none d-lg-block order-2" style="border-left: 1px solid #e1e1e1; padding-left: 15px;">
            <!-- استفاده از text-center و align-items-center برای وسط‌چین کردن کامل -->
            <div class="d-flex flex-column gap-1 align-items-center text-center justify-content-center h-100">
                <span class="font_11 text-muted mb-2">ما را دنبال کنید:</span>
                <div class="social-links d-flex align-items-center gap-4">
                    <!-- اینستاگرام -->
                    <a href="#" target="_blank" class="text-secondary" title="اینستاگرام" style="transition: color 0.2s; padding-right: 5px;"><i class="fab fa-instagram fa-lg"></i></a>
                    <!-- تلگرام -->
                    <a href="#" target="_blank" class="text-secondary" title="تلگرام" style="transition: color 0.2s; padding-right: 5px;"><i class="fab fa-telegram-plane fa-lg"></i></a>
                    <!-- توییتر / ایکس -->
                    <a href="#" target="_blank" class="text-secondary" title="توییتر" style="transition: color 0.2s; padding-right: 5px;"><i class="fab fa-twitter fa-lg"></i></a>
                    <!-- ایتا یا روبیکا -->
                    <a href="#" target="_blank" class="text-secondary" title="ایتا" style="transition: color 0.2s; padding-right: 5px;"><i class="fa fa-share-alt fa-lg"></i></a>
                </div>
            </div>
        </div>

        <!-- ۲. باکس جستجو -->
        <div class="col-lg-4 col-md-5 col-12 order-4 order-md-2 mt-3 mt-md-0">
            <div class="top-search m-0">
                <form method="GET" action="#">
                    <input name="search" type="text" class="form-control" placeholder="جستجو در همه اخبار...">
                    <button type="submit" class="bg-search">
                        <i class="fa fa-search icon-header-color"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- ۳. تاریخ، ساعت و زبان (سمت چپ) -->
        <div class="col-lg-3 col-md-4 col-6 order-3 order-md-3" style="text-align: left;">
            <div class="d-inline-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2 justify-content-end">
                <!-- بخش تاریخ و ساعت -->
                <span class="header-border-top p-1 low-font-mobile" style="color: #5e5e5e; font-size: 13px; white-space: nowrap;">
                    {{ verta()->format('Y/m/d') }}
                    <span class="mx-1">
                        {{ verta()->format('H:i') }}
                    </span>
                </span>
                <!-- دکمه زبان -->
                <span class="mt-1 mt-sm-0">
                    <a href="{{ route('lang.switch', 'en') }}" class="header-btn-border py-1 px-2" style="font-size: 12px;">English</a>
                </span>
            </div>
        </div>

    </div>
</div>
<!--end header area -->

<!--begin main navigation menu -->
<!--begin main navigation menu -->
<nav class="navbar navbar-expand-lg bg-nav-color sticky-top header mt-2">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main_nav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fa fa-bars"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav pr-lg-0 align-items-center gap-1">

                <!-- آیتم ثابت صفحه اصلی -->
                <li class="nav-item">
                    <a class="nav-link nav-text-color pb-3" href="{{ route('home') }}">صفحه اصلی</a>
                </li>

                <!-- رندر پویای دسته‌بندی‌های دیتابیس -->
                @foreach($frontCategories as $frontCat)
                    @if($frontCat->children->where('status', 1)->count() > 0)
                        <!-- اگر دسته اصلی، زیردسته فعال دارد (کشویی شود) -->
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-text-color pb-3" href="#">
                                {{ $frontCat->title }}
                                <i class="fa fa-chevron-down font_11 menu_arrow"></i>
                            </a>
                            <ul class="dropdown-menu fade-up">
                                @foreach($frontCat->children->where('status', 1) as $childCat)
                                    <li>
                                        <a class="dropdown-item" href="#">{{ $childCat->title }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- اگر دسته اصلی بدون زیردسته است (منوی معمولی) -->
                        <li class="nav-item">
                            <a class="nav-link nav-text-color pb-3" href="#">{{ $frontCat->title }}</a>
                        </li>
                    @endif
                @endforeach

                <!-- منوی صفحات ثابت قبلی تو (در صورت نیاز) -->
                <li class="nav-item dropdown">
                    <a class="nav-link nav-text-color pb-3" href="#">صفحات
                        <i class="fa fa-chevron-down font_11 menu_arrow"></i>
                    </a>
                    <ul class="dropdown-menu fade-up">
                        <li><a class="dropdown-item" href="#">ارتباط با ما</a></li>
                        <li><a class="dropdown-item" href="#">درباره ی ما</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!--end menu-->
<!--end menu-->
