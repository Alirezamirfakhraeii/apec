@php
    use Illuminate\Support\Str;

    $menuIcon = function ($title) {
        $icon = 'fa-folder-o';

        if (Str::contains($title, ['خبر', 'اخبار', 'مقاله'])) {
            $icon = 'fa-newspaper-o';
        } elseif (Str::contains($title, ['انجمن', 'کاربران', 'اعضا'])) {
            $icon = 'fa-users';
        } elseif (Str::contains($title, ['پادکست', 'صوت'])) {
            $icon = 'fa-microphone';
        } elseif (Str::contains($title, ['تماس', 'ارتباط'])) {
            $icon = 'fa-envelope-o';
        } elseif (Str::contains($title, ['سیاسی', 'سیاست'])) {
            $icon = 'fa-university';
        } elseif (Str::contains($title, ['اقتصاد', 'اقتصادی'])) {
            $icon = 'fa-line-chart';
        } elseif (Str::contains($title, ['فرهنگ', 'هنر'])) {
            $icon = 'fa-paint-brush';
        } elseif (Str::contains($title, ['ورزش', 'ورزشی'])) {
            $icon = 'fa-futbol-o';
        }

        return $icon;
    };
@endphp

    <!--begin main navigation menu -->
<nav class="navbar navbar-expand-lg bg-nav-color sticky-top header mt-2">
    <div class="container">

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#main_nav"
                aria-expanded="false"
                aria-label="Toggle navigation">
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

                    @php
                        $children = $item->activeChildren;
                        $hasChildren = $children && $children->count() > 0;
                        $itemHref = $item->href;
                    @endphp

                    @if($hasChildren)

                        <li class="nav-item mega-nav-item">

                            <a class="nav-link nav-text-color pb-3 mega-main-link"
                               href="{{ $itemHref }}"
                               title="{{ $item->title }}">

                                <span class="mega-main-title">
                                    {{ Str::limit($item->title, 24) }}
                                </span>

                                <i class="fa fa-chevron-down font_11 menu_arrow"></i>
                            </a>

                            <div class="mega-menu-panel" dir="rtl">
                                <div class="mega-menu-box">

                                    <div class="mega-menu-sidebar">

                                        @foreach($children as $child)

                                            @php
                                                $childChildren = $child->activeChildren;
                                                $panelId = 'mega_panel_' . $item->id . '_' . $child->id;
                                                $childHref = $child->href;
                                                $icon = $child->icon ?: $menuIcon($child->title);
                                                $childHasChildren = $childChildren && $childChildren->count() > 0;
                                            @endphp

                                            <a href="{{ $childHref }}"
                                               class="mega-menu-category"
                                               data-mega-target="{{ $panelId }}"
                                               title="{{ $child->title }}">

                                                <span class="mega-menu-category-right">
                                                    <i class="fa {{ $icon }}"></i>

                                                    <span class="mega-menu-category-text">
                                                        {{ Str::limit($child->title, 24) }}
                                                    </span>
                                                </span>

                                                @if($childHasChildren)
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

                                        @foreach($children as $child)

                                            @php
                                                $childChildren = $child->activeChildren;
                                                $panelId = 'mega_panel_' . $item->id . '_' . $child->id;
                                                $childHref = $child->href;
                                                $childHasChildren = $childChildren && $childChildren->count() > 0;
                                            @endphp

                                            <div class="mega-menu-content-panel" id="{{ $panelId }}">

                                                <div class="mega-menu-content-header">
                                                    <a href="{{ $childHref }}"
                                                       title="مشاهده همه {{ $child->title }}">
                                                        <span>
                                                            مشاهده همه {{ Str::limit($child->title, 32) }}
                                                        </span>

                                                        <i class="fa fa-angle-left"></i>
                                                    </a>
                                                </div>

                                                @if($childHasChildren)

                                                    <div class="row">
                                                        @foreach($childChildren as $subChild)
                                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                                @include('front.layouts.partials.header.nav_mega_child', [
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
                               href="{{ $itemHref }}"
                               title="{{ $item->title }}">
                                {{ Str::limit($item->title, 24) }}
                            </a>
                        </li>

                    @endif

                @endforeach

            </ul>
        </div>

    </div>
</nav>
<!--end main navigation menu -->
