<div class="row">

    <div class="col-lg-6 col-md-12 col-12 pb-2" dir="rtl" style="text-align: right;">
        <div id="premiumNewsCarousel" class="carousel slide premium-carousel-wrapper" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="d-flex flex-column h-100">

                <div class="premium-visuals position-relative">
                    <div class="carousel-inner h-100">

                        @foreach($featuredPosts as $index => $post)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                <div class="position-relative h-100 w-100 overflow-hidden main-img-wrapper">

                                    <img src="{{ $post->main_image_url }}"
                                         class="d-block w-100 h-100 premium-img"
                                         alt="{{ $post->title }}">

                                    <div class="premium-overlay d-flex flex-column justify-content-end p-4">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="badge premium-badge font_10 shadow-sm">
                                                <i class="fa fa-star text-warning ml-1"></i>
                                                خبر ویژه
                                            </span>
                                        </div>

                                        <a href="{{ route('front.posts.show', $post->slug) }}" class="text-decoration-none">
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

                <div class="premium-nav-list p-3" style="background-color: #f8fafc; overflow-y: auto; max-height: 240px;">
                    <div class="d-flex flex-column premium-indicators" style="gap: 10px;">

                        @foreach($featuredPosts as $index => $post)
                            <button type="button"
                                    data-bs-target="#premiumNewsCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="premium-list-item border-0 text-right d-flex align-items-center w-100 {{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                <div class="flex-shrink-0 premium-thumb overflow-hidden rounded-lg shadow-sm ml-3">
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

    <style>
        .premium-carousel-wrapper {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0,0,0,0.04);
            overflow: hidden;
            height: 460px;
        }

        .premium-visuals {
            height: 240px;
            min-height: 240px;
        }

        .premium-img {
            object-fit: cover;
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
            background: #ffffff;
            border-radius: 12px;
            padding: 12px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }

        .premium-list-item:hover {
            transform: translateX(-5px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.08);
        }

        .premium-thumb {
            width: 65px;
            height: 65px;
        }

        .premium-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
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

        .text-truncate-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.6;
        }

        .transition-all {
            transition: all 0.3s ease;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var myPremiumCarousel = document.getElementById('premiumNewsCarousel');
            var premiumIndicators = document.querySelectorAll('.premium-indicators .premium-list-item');

            if (myPremiumCarousel) {
                myPremiumCarousel.addEventListener('slide.bs.carousel', function (e) {
                    var nextIdx = e.to;

                    premiumIndicators.forEach(function(btn, idx) {
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

    <div class="col-lg-6 col-12">
        <div class="row">

            <div class="col-md-6 col-12 mb-4">
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

            <div class="col-md-6 col-12">
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
                            <div class="row">
                                <div class="col-12">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="img-top-news-2 d-block overflow-hidden rounded mb-2 shadow-sm">

                                        <img src="{{ $subjectOfTheDay->main_image_url }}"
                                             class="img-fluid text-center w-100"
                                             alt="{{ $subjectOfTheDay->title }}"
                                             style="object-fit: cover; max-height: 150px;">

                                    </a>
                                </div>

                                <div class="col-12">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="text-p text-decoration-none d-block mb-2">
                                        <h4 class="font_12 font-weight-bold style-tittle line-height-text text-dark hover-emerald mb-0">
                                            {{ $subjectOfTheDay->title }}
                                        </h4>
                                    </a>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="bg-style-soozhe p-2 bg-light rounded" style="border: 1px solid #edf2f7;">
                                                <div class="row">
                                                    <div class="col-6 d-flex align-items-center justify-content-start text-muted">
                                                        <i class="fa fa-eye ml-1.5 font_10"></i>
                                                        <span class="font_11">
                                                            {{ $subjectOfTheDay->views_count ?? 0 }}
                                                        </span>
                                                    </div>

                                                    <div class="col-6 d-flex align-items-center justify-content-end text-muted">
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
                    <div class="row mt-3" dir="rtl">
                        <div class="col-12 mb-3">
                            <div class="bg-white p-2 border rounded shadow-sm hover-shadow transition-all">
                                <a href="URL_LINK_1" target="_blank" class="d-block overflow-hidden rounded">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         class="img-fluid w-100"
                                         alt="تبلیغات"
                                         style="object-fit: cover; max-height: 150px; transition: transform 0.3s;">
                                </a>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="bg-white p-2 border rounded shadow-sm hover-shadow transition-all">
                                <a href="URL_LINK_2" target="_blank" class="d-block overflow-hidden rounded">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         class="img-fluid w-100"
                                         alt="تبلیغات"
                                         style="object-fit: cover; max-height: 150px; transition: transform 0.3s;">
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
    .line-height-text-custom {
        line-height: 1.55 !important;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
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
</style>
