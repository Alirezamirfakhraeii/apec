<style>
    .header,
    .navbar,
    .navbar-collapse,
    .navbar-nav {
        overflow: visible !important;
    }

    .mega-nav-item {
        position: static;
    }

    .mega-main-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 6px;
        max-width: 170px;
    }

    .mega-main-title {
        display: inline-block;
        max-width: 135px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .menu_arrow {
        margin-right: 6px;
        font-size: 10px;
        transition: 0.2s ease;
        flex-shrink: 0;
    }

    .mega-nav-item:hover .menu_arrow {
        transform: rotate(180deg);
    }

    .mega-menu-panel {
        position: absolute;
        top: 100%;
        right: 50%;
        transform: translateX(50%);
        width: min(960px, calc(100vw - 30px));
        z-index: 9999;
        display: none;
    }

    @media (min-width: 992px) {
        .mega-nav-item:hover .mega-menu-panel {
            display: block;
        }
    }

    .mega-menu-box {
        height: min(430px, calc(100vh - 130px));
        min-height: 320px;
        background: #fff;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 18px 42px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        display: flex;
        border: 1px solid #f1f1f1;
    }

    .mega-menu-sidebar {
        width: 240px;
        min-width: 240px;
        background: #f8f9fb;
        border-left: 1px solid #eeeeee;
        padding: 10px 0;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .mega-menu-category {
        height: 40px;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #333;
        text-decoration: none;
        font-size: 12.5px;
        font-weight: 600;
        transition: 0.2s ease;
        border-right: 3px solid transparent;
        min-width: 0;
    }

    .mega-menu-category:hover,
    .mega-menu-category.active {
        background: #fff;
        color: #e53935;
        border-right-color: #e53935;
    }

    .mega-menu-category-right {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 0;
        flex: 1;
    }

    .mega-menu-category-right i {
        width: 18px;
        min-width: 18px;
        text-align: center;
        font-size: 14px;
        color: #888;
        transition: 0.2s ease;
    }

    .mega-menu-category:hover .mega-menu-category-right i,
    .mega-menu-category.active .mega-menu-category-right i {
        color: #e53935;
    }

    .mega-menu-category-text {
        display: block;
        min-width: 0;
        max-width: 165px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mega-menu-category-arrow {
        font-size: 10px;
        color: #aaa;
        margin-right: 8px;
        flex-shrink: 0;
    }

    .mega-menu-content-area {
        flex: 1;
        position: relative;
        background: #fff;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 20px 22px;
    }

    .mega-menu-content-panel {
        display: none;
    }

    .mega-menu-content-panel.active {
        display: block;
    }

    .mega-menu-content-area.has-active .mega-menu-empty {
        display: none;
    }

    .mega-menu-content-header {
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .mega-menu-content-header a {
        max-width: 100%;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12.5px;
        font-weight: 700;
        color: #e53935;
        text-decoration: none;
    }

    .mega-menu-content-header a span {
        display: block;
        max-width: 270px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mega-menu-empty {
        height: 100%;
        min-height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #aaa;
        background:
            radial-gradient(circle at top left, rgba(229, 57, 53, 0.04), transparent 35%),
            #fff;
    }

    .mega-menu-empty-inner {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        text-align: center;
        padding: 20px;
    }

    .mega-menu-empty-inner i {
        font-size: 30px;
        color: #ddd;
    }

    .mega-menu-empty-inner span {
        font-size: 12.5px;
        color: #aaa;
    }

    .mega-no-child {
        font-size: 13px;
        color: #999;
        padding: 10px;
    }

    .mega-tree-node {
        width: 100%;
        min-width: 0;
    }

    .mega-tree-title,
    .mega-tree-link {
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        transition: 0.2s ease;
        min-width: 0;
    }

    .mega-tree-title {
        color: #222;
        font-size: 13.5px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .mega-tree-title::before {
        content: "";
        width: 3px;
        min-width: 3px;
        height: 14px;
        border-radius: 10px;
        background: #e53935;
        display: inline-block;
    }

    .mega-tree-link {
        color: #666;
        font-size: 12.5px;
        font-weight: 500;
        margin-bottom: 5px;
    }

    .mega-tree-title span,
    .mega-tree-link span {
        display: block;
        max-width: 190px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .mega-tree-title i,
    .mega-tree-link i {
        font-size: 10px;
        color: #aaa;
        flex-shrink: 0;
    }

    .mega-tree-title:hover,
    .mega-tree-link:hover {
        color: #e53935;
        padding-right: 4px;
    }

    .mega-tree-list {
        list-style: none;
        margin: 6px 12px 8px 0;
        padding: 0 10px 0 0;
        border-right: 1px solid #eeeeee;
    }

    .mega-tree-list li {
        margin-bottom: 4px;
    }

    .mega-tree-level-2 .mega-tree-link {
        font-size: 12.2px;
        color: #777;
    }

    .mega-tree-level-3 .mega-tree-link {
        font-size: 12px;
        color: #888;
    }

    .mega-tree-level-4 .mega-tree-link,
    .mega-tree-level-5 .mega-tree-link,
    .mega-tree-level-6 .mega-tree-link,
    .mega-tree-level-7 .mega-tree-link,
    .mega-tree-level-8 .mega-tree-link,
    .mega-tree-level-9 .mega-tree-link,
    .mega-tree-level-10 .mega-tree-link {
        font-size: 11.8px;
        color: #999;
    }

    @media (max-width: 991px) {
        .navbar-nav {
            width: 100%;
            align-items: stretch !important;
            gap: 0 !important;
        }

        .navbar-nav .nav-item {
            width: 100%;
        }

        .mega-nav-item {
            position: relative !important;
        }

        .mega-main-link {
            max-width: 100%;
            justify-content: space-between;
        }

        .mega-main-title {
            max-width: calc(100vw - 110px);
        }

        .mega-menu-panel {
            position: static;
            display: none;
            width: 100%;
            transform: none;
            margin-top: 8px;
        }

        .mega-nav-item.open .mega-menu-panel {
            display: block;
        }

        .mega-nav-item.open .menu_arrow {
            transform: rotate(180deg);
        }

        .mega-menu-box {
            display: block;
            height: auto;
            min-height: auto;
            max-height: 70vh;
            overflow-y: auto;
            border-radius: 14px;
            box-shadow: none;
        }

        .mega-menu-sidebar {
            width: 100%;
            min-width: 100%;
            border-left: none;
            padding: 8px 0;
            overflow: visible;
        }

        .mega-menu-content-area {
            padding: 14px;
            border-top: 1px solid #eeeeee;
        }

        .mega-tree-title span,
        .mega-tree-link span {
            max-width: calc(100vw - 120px);
        }
    }
</style>

<!--begin header area -->
<div class="container my-3">
    <div class="row align-items-center">

        <div class="col-lg-2 col-md-3 col-6 order-1" style="text-align: right;">
            <a href="{{ route('home') }}">
                <img src="{{ asset('front/img/logo-irapec-min2.png') }}" class="img-fluid" alt="لوگو"
                     style="max-height: 65px;">
            </a>
        </div>

        <div class="col-lg-3 d-none d-lg-block order-2" style="border-left: 1px solid #e1e1e1; padding-left: 15px;">
            <div class="d-flex flex-column align-items-center text-center justify-content-center h-100">
                <span class="font_11 text-muted mb-2">ما را دنبال کنید:</span>

                <div class="social-links d-flex align-items-center justify-content-center" style="gap: 15px;">

                    <a href="https://www.instagram.com/irapec_info?igsh=MXczdDBzN2Nia2J1eQ==" target="_blank"
                       class="text-secondary custom-social-link" title="اینستاگرام">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>

                    <a href="https://x.com/irapec" target="_blank" class="text-secondary custom-social-link"
                       title="توییتر">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>

                    <a href="https://www.linkedin.com/in/apec-association?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                       target="_blank" class="text-secondary custom-social-link" title="لینکدین">
                        <i class="fab fa-linkedin-in fa-lg"></i>
                    </a>

                </div>
            </div>
        </div>

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

        <div class="col-lg-3 col-md-4 col-6 order-3 order-md-3" style="text-align: left;">
            <div class="d-inline-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2 justify-content-end">
                <span class="header-border-top p-1 low-font-mobile"
                      style="color: #5e5e5e; font-size: 13px; white-space: nowrap;">
                    {{ verta()->format('Y/m/d') }}
                    <span class="mx-1">
                        {{ verta()->format('H:i') }}
                    </span>
                </span>

                <span class="mt-1 mt-sm-0">
                    <a href="{{ route('lang.switch', 'en') }}" class="header-btn-border py-1 px-2"
                       style="font-size: 12px;">English</a>
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

                <li class="nav-item">
                    <a class="nav-link nav-text-color pb-3" href="{{ route('home') }}">
                        صفحه اصلی
                    </a>
                </li>

                @foreach($frontMenuItems as $item)

                    @if($item->children->count() > 0)

                        <li class="nav-item mega-nav-item">

                            <a class="nav-link nav-text-color pb-3 mega-main-link"
                               href="{{ $item->link ?? '#' }}"
                               title="{{ $item->title }}">

                                <span class="mega-main-title">
                                    {{ \Illuminate\Support\Str::limit($item->title, 24) }}
                                </span>

                                <i class="fa fa-chevron-down font_11 menu_arrow"></i>
                            </a>

                            <div class="mega-menu-panel" dir="rtl">

                                <div class="mega-menu-box">

                                    <div class="mega-menu-sidebar">

                                        @foreach($item->children as $child)

                                            @php
                                                $panelId = 'mega_panel_' . $item->id . '_' . $child->id;

                                                $icon = 'fa-folder-o';

                                                if(\Illuminate\Support\Str::contains($child->title, ['خبر', 'اخبار', 'مقاله'])) {
                                                    $icon = 'fa-newspaper-o';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['انجمن', 'کاربران', 'اعضا'])) {
                                                    $icon = 'fa-users';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['پادکست', 'صوت'])) {
                                                    $icon = 'fa-microphone';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['تماس', 'ارتباط'])) {
                                                    $icon = 'fa-envelope-o';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['سیاسی', 'سیاست'])) {
                                                    $icon = 'fa-university';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['اقتصاد', 'اقتصادی'])) {
                                                    $icon = 'fa-line-chart';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['فرهنگ', 'هنر'])) {
                                                    $icon = 'fa-paint-brush';
                                                } elseif(\Illuminate\Support\Str::contains($child->title, ['ورزش', 'ورزشی'])) {
                                                    $icon = 'fa-futbol-o';
                                                }
                                            @endphp

                                            <a href="{{ $child->link ?? '#' }}"
                                               class="mega-menu-category"
                                               data-mega-target="{{ $panelId }}"
                                               title="{{ $child->title }}">

                                                <span class="mega-menu-category-right">
                                                    <i class="fa {{ $icon }}"></i>

                                                    <span class="mega-menu-category-text">
                                                        {{ \Illuminate\Support\Str::limit($child->title, 24) }}
                                                    </span>
                                                </span>

                                                @if($child->children->count() > 0)
                                                    <i class="fa fa-chevron-left mega-menu-category-arrow"></i>
                                                @endif

                                            </a>

                                        @endforeach

                                    </div>

                                    <div class="mega-menu-content-area">

                                        <div class="mega-menu-empty">
                                            <div class="mega-menu-empty-inner">
                                                <i class="fa fa-mouse-pointer"></i>
                                                <span>برای مشاهده زیرمجموعه‌ها، موس را روی یکی از گزینه‌ها ببرید</span>
                                            </div>
                                        </div>

                                        @foreach($item->children as $child)

                                            @php
                                                $panelId = 'mega_panel_' . $item->id . '_' . $child->id;
                                            @endphp

                                            <div class="mega-menu-content-panel" id="{{ $panelId }}">

                                                <div class="mega-menu-content-header">
                                                    <a href="{{ $child->link ?? '#' }}"
                                                       title="مشاهده همه {{ $child->title }}">
                                                        <span>
                                                            مشاهده همه {{ \Illuminate\Support\Str::limit($child->title, 32) }}
                                                        </span>
                                                        <i class="fa fa-angle-left"></i>
                                                    </a>
                                                </div>

                                                @if($child->children->count() > 0)

                                                    <div class="row">
                                                        @foreach($child->children as $subChild)
                                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                                @include('front.layouts.partials.nav_mega_child', [
                                                                    'child' => $subChild,
                                                                    'level' => 1
                                                                ])
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                @else

                                                    <div class="mega-no-child">
                                                        زیرمجموعه‌ای برای این گزینه ثبت نشده است.
                                                    </div>

                                                @endif

                                            </div>

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                        </li>

                    @else

                        <li class="nav-item">
                            <a class="nav-link nav-text-color pb-3"
                               href="{{ $item->link ?? '#' }}"
                               title="{{ $item->title }}">
                                {{ \Illuminate\Support\Str::limit($item->title, 24) }}
                            </a>
                        </li>

                    @endif

                @endforeach

            </ul>
        </div>
    </div>
</nav>
<!--end menu-->
<!--end menu-->

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.mega-menu-panel').forEach(function (panel) {

            const categories = panel.querySelectorAll('.mega-menu-category');
            const contentArea = panel.querySelector('.mega-menu-content-area');
            const panels = panel.querySelectorAll('.mega-menu-content-panel');

            categories.forEach(function (category) {

                category.addEventListener('mouseenter', function () {
                    if (window.innerWidth <= 991) return;

                    const targetId = this.getAttribute('data-mega-target');
                    const targetPanel = panel.querySelector('#' + targetId);

                    categories.forEach(function (item) {
                        item.classList.remove('active');
                    });

                    panels.forEach(function (item) {
                        item.classList.remove('active');
                    });

                    this.classList.add('active');

                    if (targetPanel) {
                        targetPanel.classList.add('active');
                        contentArea.classList.add('has-active');
                    }
                });

                category.addEventListener('click', function (e) {
                    if (window.innerWidth <= 991) {
                        const targetId = this.getAttribute('data-mega-target');
                        const targetPanel = panel.querySelector('#' + targetId);

                        if (targetPanel) {
                            e.preventDefault();

                            categories.forEach(function (item) {
                                if (item !== category) {
                                    item.classList.remove('active');
                                }
                            });

                            panels.forEach(function (item) {
                                if (item !== targetPanel) {
                                    item.classList.remove('active');
                                }
                            });

                            category.classList.toggle('active');
                            targetPanel.classList.toggle('active');

                            if (panel.querySelector('.mega-menu-content-panel.active')) {
                                contentArea.classList.add('has-active');
                            } else {
                                contentArea.classList.remove('has-active');
                            }
                        }
                    }
                });

            });

            panel.addEventListener('mouseleave', function () {
                if (window.innerWidth <= 991) return;

                categories.forEach(function (item) {
                    item.classList.remove('active');
                });

                panels.forEach(function (item) {
                    item.classList.remove('active');
                });

                if (contentArea) {
                    contentArea.classList.remove('has-active');
                }
            });

        });

        document.querySelectorAll('.mega-main-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                if (window.innerWidth <= 991) {
                    const navItem = this.closest('.mega-nav-item');
                    const panel = navItem ? navItem.querySelector('.mega-menu-panel') : null;

                    if (panel) {
                        e.preventDefault();

                        document.querySelectorAll('.mega-nav-item.open').forEach(function (item) {
                            if (item !== navItem) {
                                item.classList.remove('open');
                            }
                        });

                        navItem.classList.toggle('open');
                    }
                }
            });
        });

    });
</script>
