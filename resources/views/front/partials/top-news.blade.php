<div class="row mx-0 home-featured-row" dir="rtl">

    <div class="col-lg-6 col-md-12 col-12 px-2 pb-2" style="text-align: right;">
        <div id="premiumNewsCarousel"
             class="carousel slide premium-carousel-wrapper"
             data-bs-ride="carousel"
             data-bs-interval="6000">

            <div class="premium-carousel-inner-box">

                <div class="premium-visuals position-relative">
                    <div class="carousel-inner h-100">

                        @foreach($featuredPosts as $index => $post)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                <div class="position-relative h-100 w-100 overflow-hidden main-img-wrapper">

                                    <img src="{{ $post->main_image_url }}"
                                         class="d-block w-100 h-100 premium-img"
                                         alt="{{ $post->title }}">

                                    <div class="premium-overlay d-flex flex-column justify-content-end">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge premium-badge font_10 shadow-sm">
                                                <i class="fa fa-star text-warning ml-1"></i>
                                                خبر ویژه
                                            </span>
                                        </div>

                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="text-decoration-none">
                                            <h2 class="h5 font-weight-bold text-white line-height-text-custom mb-0 text-shadow-md premium-title-hover">
                                                {{ $post->title }}
                                            </h2>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="premium-nav-list">
                    <div class="d-flex flex-column premium-indicators">

                        @foreach($featuredPosts as $index => $post)
                            <button type="button"
                                    data-bs-target="#premiumNewsCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="premium-list-item border-0 text-right d-flex align-items-center w-100 {{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                <div class="flex-shrink-0 premium-thumb overflow-hidden rounded-lg shadow-sm">
                                    <img src="{{ $post->main_image_url }}"
                                         alt="{{ $post->title }}">
                                </div>

                                <div class="flex-grow-1 overflow-hidden pr-1">
                                    <h4 class="font_12 font-weight-bold mb-1 text-truncate-2 premium-list-title transition-all text-dark">
                                        {{ $post->title }}
                                    </h4>

                                    <span class="text-muted font_10 d-flex align-items-center mt-1">
                                        <i class="fa fa-clock ml-1 font_9"></i>
                                        {{ jdate($post->created_at)->ago() }}
                                    </span>
                                </div>

                                <div class="nav-progress-bar"></div>
                            </button>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-6 col-12 px-2">
        <div class="row mx-0 home-featured-inner-row">

            <div class="col-md-6 col-12 px-2 mb-4">
                <div class="sticky-top col_z_index" style="top: 20px;">
                    <div class="bg-content-whit border rounded shadow-sm overflow-hidden">

                        <ul class="nav nav-tabs aaa border-bottom-0 bg-light">
                            <li class="nav-item flex-fill text-center">
                                <a class="nav-link active color-btn font_12 py-2.5 border-0 rounded-0"
                                   data-toggle="tab"
                                   href="#home">
                                    پربازدیدترین ها
                                </a>
                            </li>

                            <li class="nav-item flex-fill text-center">
                                <a class="nav-link color-btn font_12 py-2.5 border-0 rounded-0"
                                   data-toggle="tab"
                                   href="#menu1">
                                    پربحث ترین ها
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content bg-white">
                            <div class="tab-pane active" id="home">
                                @foreach($mostVisited as $post)
                                    <div class="px-3 py-2 border-bottom last-border-0">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="text-decoration-none d-flex align-items-center">
                                            <div class="circle-titr flex-shrink-0"></div>

                                            <span class="font_12 color-text text-truncate mr-2">
                                                {{ $post->title }}
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>

                            <div class="tab-pane fade" id="menu1">
                                @foreach($mostCommented as $post)
                                    <div class="px-3 py-2 border-bottom last-border-0">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="text-decoration-none d-flex align-items-center">
                                            <div class="circle-titr flex-shrink-0"></div>

                                            <span class="font_12 color-text text-truncate mr-2">
                                                {{ $post->title }}
                                            </span>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 col-12 px-2">
                <div class="sticky-top col_z_index" style="top: 20px;">

                    <div class="bg-style-title p-2 rounded-top border border-bottom-0">
                        <div class="text-p d-flex align-items-center">
                            <div class="circle-title2 ml-2"></div>
                            <span class="font_11 font-weight-bold style-tittle text-dark">
                                سوژه روز
                            </span>
                        </div>
                    </div>

                    @if($subjectOfTheDay)
                        <div class="style-text bg-sozhe-rooz p-3 border rounded-bottom shadow-sm">
                            <div class="row mx-0">
                                <div class="col-12 px-0">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="img-top-news-2 d-block overflow-hidden rounded mb-2 shadow-sm">

                                        <img src="{{ $subjectOfTheDay->main_image_url }}"
                                             class="img-fluid text-center w-100 subject-day-img"
                                             alt="{{ $subjectOfTheDay->title }}">
                                    </a>
                                </div>

                                <div class="col-12 px-0">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="text-p text-decoration-none d-block mb-2">
                                        <h4 class="font_12 font-weight-bold style-tittle line-height-text text-dark hover-emerald mb-0">
                                            {{ $subjectOfTheDay->title }}
                                        </h4>
                                    </a>

                                    <div class="row mx-0">
                                        <div class="col-12 px-0">
                                            <div class="bg-style-soozhe p-2 bg-light rounded" style="border: 1px solid #edf2f7;">
                                                <div class="row mx-0">
                                                    <div class="col-6 px-1 d-flex align-items-center justify-content-start text-muted">
                                                        <i class="fa fa-eye ml-1.5 font_10"></i>
                                                        <span class="font_11">
                                                            {{ $subjectOfTheDay->views_count ?? 0 }}
                                                        </span>
                                                    </div>

                                                    <div class="col-6 px-1 d-flex align-items-center justify-content-end text-muted">
                                                        <i class="fa fa-comment ml-1.5 font_10"></i>
                                                        <span class="font_11">
                                                            {{ $subjectOfTheDay->comments_count ?? 0 }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Adv --}}
                    <div class="row mx-0 mt-3" dir="rtl">
                        <div class="col-12 px-0 mb-3">
                            <div class="bg-white p-2 border rounded shadow-sm hover-shadow transition-all">
                                <a href="URL_LINK_1" target="_blank" class="d-block overflow-hidden rounded">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         class="img-fluid w-100 adv-img"
                                         alt="تبلیغات">
                                </a>
                            </div>
                        </div>

                        <div class="col-12 px-0">
                            <div class="bg-white p-2 border rounded shadow-sm hover-shadow transition-all">
                                <a href="URL_LINK_2" target="_blank" class="d-block overflow-hidden rounded">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         class="img-fluid w-100 adv-img"
                                         alt="تبلیغات">
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<style>
    .home-featured-row,
    .home-featured-row *,
    .home-featured-inner-row,
    .home-featured-inner-row * {
        box-sizing: border-box;
    }

    .home-featured-row {
        width: 100%;
        max-width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
        overflow: hidden;
    }

    .home-featured-inner-row {
        width: 100%;
        max-width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .home-featured-row > [class*="col-"],
    .home-featured-inner-row > [class*="col-"] {
        min-width: 0 !important;
        max-width: 100% !important;
    }

    .home-featured-row .row {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .home-featured-row img {
        max-width: 100%;
    }

    .premium-carousel-wrapper {
        width: 100%;
        max-width: 100%;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        height: 460px;
    }

    .premium-carousel-inner-box {
        display: flex;
        flex-direction: column;
        height: 100%;
        max-width: 100%;
        overflow: hidden;
    }

    .premium-visuals {
        width: 100%;
        height: 240px;
        min-height: 240px;
        overflow: hidden;
        background: #fff;
    }

    .premium-visuals .carousel-inner,
    .premium-visuals .carousel-item,
    .premium-visuals .main-img-wrapper {
        width: 100%;
        height: 100%;
        max-width: 100%;
    }

    .premium-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transform: scale(1);
        transition: transform 7s ease-in-out;
    }

    .carousel-item.active .premium-img {
        transform: scale(1.08);
    }

    .premium-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 85%;
        padding: 24px;
        background: linear-gradient(
            to top,
            rgba(15, 23, 42, 0.95) 0%,
            rgba(15, 23, 42, 0.5) 55%,
            transparent 100%
        );
    }

    .premium-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        padding: 5px 10px;
        border-radius: 6px;
    }

    .text-shadow-md {
        text-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
    }

    .premium-title-hover {
        transition: color 0.3s;
    }

    .premium-title-hover:hover {
        color: #10b981 !important;
    }

    .premium-nav-list {
        width: 100%;
        max-width: 100%;
        flex: 1;
        background-color: #f8fafc;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 12px;
    }

    .premium-indicators {
        width: 100%;
        max-width: 100%;
        gap: 10px;
    }

    .premium-nav-list::-webkit-scrollbar {
        width: 5px;
    }

    .premium-nav-list::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .premium-nav-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .premium-nav-list::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .premium-list-item {
        width: 100%;
        max-width: 100%;
        background: #ffffff;
        border-radius: 12px;
        padding: 12px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    }

    .premium-list-item:hover {
        transform: translateX(-5px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    }

    .premium-list-item > div {
        min-width: 0;
    }

    .premium-thumb {
        width: 65px;
        height: 65px;
        flex: 0 0 65px;
        margin-left: 12px;
    }

    .premium-thumb img {
        width: 100%;
        height: 100%;
        transition: transform 0.4s ease;
        border-radius: 3px;
        object-fit: contain;
    }

    .premium-list-item:hover .premium-thumb img {
        transform: scale(1.15);
    }

    .premium-list-item.active {
        background: linear-gradient(90deg, #ffffff 0%, rgba(16, 185, 129, 0.08) 100%);
        border-right: 4px solid #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .premium-list-item.active .premium-list-title {
        color: #10b981 !important;
    }

    .nav-progress-bar {
        position: absolute;
        bottom: 0;
        right: 0;
        height: 3px;
        background: #10b981;
        width: 0;
    }

    .premium-list-item.active .nav-progress-bar {
        animation: progressSlide 6s linear forwards;
    }

    @keyframes progressSlide {
        0% {
            width: 0;
        }

        100% {
            width: 100%;
        }
    }

    .line-height-text-custom {
        line-height: 1.55 !important;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.6;
    }

    .premium-list-title,
    .text-truncate,
    .text-truncate-2 {
        min-width: 0;
        max-width: 100%;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .hover-emerald {
        transition: color 0.15s ease-in-out;
    }

    .hover-emerald:hover {
        color: #10b981 !important;
    }

    .last-border-0:last-child {
        border-bottom: 0 !important;
    }

    .nav-tabs .nav-link.active {
        background-color: #ffffff !important;
        color: #10b981 !important;
        font-weight: bold;
        border-bottom: 2px solid #10b981 !important;
    }

    .subject-day-img,
    .adv-img {
        object-fit: cover;
        max-height: 150px;
        transition: transform 0.3s;
    }

    @media (max-width: 991.98px) {
        .premium-carousel-wrapper {
            height: auto !important;
            margin-bottom: 20px;
        }

        .premium-carousel-inner-box {
            height: auto !important;
        }

        .premium-visuals {
            height: 260px;
            min-height: 260px;
        }

        .premium-nav-list {
            max-height: 260px;
        }

        .sticky-top,
        .col_z_index {
            position: static !important;
            top: auto !important;
        }
    }

    @media (max-width: 575.98px) {
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .home-featured-row {
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            overflow-x: hidden !important;
        }

        .home-featured-row > [class*="col-"] {
            flex: 0 0 100% !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .home-featured-inner-row {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            overflow-x: hidden !important;
        }

        .home-featured-inner-row > [class*="col-"] {
            flex: 0 0 100% !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        .premium-carousel-wrapper {
            width: 100% !important;
            max-width: 100% !important;
            height: auto !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
            border-radius: 14px !important;
            overflow: hidden !important;
        }

        .premium-carousel-inner-box {
            height: auto !important;
        }

        .premium-visuals {
            width: 100% !important;
            height: 210px !important;
            min-height: 210px !important;
            overflow: hidden !important;
        }

        .premium-visuals .carousel-inner,
        .premium-visuals .carousel-item,
        .premium-visuals .main-img-wrapper {
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
        }

        .premium-img {
            width: 100% !important;
            height: 100% !important;
            object-fit: contain !important;
            transform: none !important;
        }

        .carousel-item.active .premium-img {
            transform: none !important;
        }

        .premium-overlay {
            height: 72% !important;
            padding: 14px !important;
            background: linear-gradient(
                to top,
                rgba(15, 23, 42, 0.88) 0%,
                rgba(15, 23, 42, 0.36) 55%,
                transparent 100%
            ) !important;
        }

        .premium-badge {
            font-size: 10px !important;
            padding: 4px 8px !important;
        }

        .premium-overlay h2 {
            font-size: 13px !important;
            line-height: 1.8 !important;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .premium-nav-list {
            width: 100% !important;
            max-width: 100% !important;
            max-height: 230px !important;
            padding: 10px !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
        }

        .premium-indicators {
            width: 100% !important;
            max-width: 100% !important;
            gap: 8px !important;
        }

        .premium-list-item {
            width: 100% !important;
            max-width: 100% !important;
            padding: 9px !important;
            border-radius: 10px !important;
            transform: none !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .premium-list-item:hover {
            transform: none !important;
        }

        .premium-list-item.active {
            border-right-width: 3px !important;
        }

        .premium-thumb {
            width: 48px !important;
            height: 48px !important;
            flex: 0 0 48px !important;
            margin-left: 9px !important;
        }

        .premium-thumb img {
            object-fit: contain !important;
            transform: none !important;
        }

        .premium-list-item:hover .premium-thumb img {
            transform: none !important;
        }

        .premium-list-title {
            font-size: 11px !important;
            line-height: 1.7 !important;
            word-break: break-word;
        }

        .premium-list-item span {
            font-size: 9px !important;
        }

        .nav-tabs {
            max-width: 100% !important;
            overflow: hidden !important;
            flex-wrap: nowrap !important;
        }

        .nav-tabs .nav-item {
            min-width: 0 !important;
        }

        .nav-tabs .nav-link {
            font-size: 11px !important;
            white-space: nowrap;
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .subject-day-img,
        .adv-img {
            max-height: 170px !important;
            object-fit: cover !important;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myPremiumCarousel = document.getElementById('premiumNewsCarousel');
        var premiumIndicators = document.querySelectorAll('.premium-indicators .premium-list-item');

        if (myPremiumCarousel) {
            myPremiumCarousel.addEventListener('slide.bs.carousel', function (e) {
                var nextIdx = e.to;

                premiumIndicators.forEach(function (btn, idx) {
                    if (idx === nextIdx) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-current', 'true');

                        var progressBar = btn.querySelector('.nav-progress-bar');

                        if (progressBar) {
                            progressBar.style.animation = 'none';
                            progressBar.offsetHeight;
                            progressBar.style.animation = null;
                        }

                        var container = btn.parentElement;

                        if (container) {
                            var containerVisibleHeight = container.clientHeight;
                            var itemTop = btn.offsetTop;
                            var itemHeight = btn.clientHeight;

                            container.scrollTo({
                                top: itemTop - (containerVisibleHeight / 2) + (itemHeight / 2),
                                behavior: 'smooth'
                            });
                        }
                    } else {
                        btn.classList.remove('active');
                        btn.removeAttribute('aria-current');
                    }
                });
            });
        }
    });
</script>
