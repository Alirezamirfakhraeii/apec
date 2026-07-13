<div class="notice-premium-section bg-white-content" dir="rtl">
    <div class="notice-premium-shell">

        <div class="notice-premium-head">
            <div class="notice-premium-title-box">
                <span class="notice-premium-icon">
                    <i class="fa fa-bullhorn"></i>
                </span>

                <div>
                    <span class="notice-premium-kicker">تابلوی اطلاع‌رسانی</span>
                    <h2>اطلاع‌رسانی</h2>
                </div>
            </div>

            @if(isset($announcementCategory))
                <a href="/news/notification" class="notice-premium-archive-link">
                    مشاهده همه مطالب
                    <i class="fa fa-arrow-left"></i>
                </a>
            @endif
        </div>

        @if(isset($announcementPosts) && $announcementPosts->count() > 0)
            <div id="announcementNewsCarousel"
                 class="carousel slide notice-premium-carousel"
                 data-bs-ride="carousel"
                 data-bs-interval="6000"
                 data-ride="carousel"
                 data-interval="6000">

                <div class="row mx-0 notice-premium-grid">

                    <div class="col-lg-5 col-md-5 col-12 px-0 notice-premium-list-col order-md-1 order-2">
                        <div class="notice-premium-list">
                            @php $faNumbers = ['۰۱', '۰۲', '۰۳', '۰۴', '۰۵']; @endphp

                            @foreach($announcementPosts->take(5) as $index => $post)
                                <button type="button"
                                        data-bs-target="#announcementNewsCarousel"
                                        data-bs-slide-to="{{ $index }}"
                                        data-target="#announcementNewsCarousel"
                                        data-slide-to="{{ $index }}"
                                        class="notice-premium-list-item {{ $index == 0 ? 'active' : '' }}"
                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                    <span class="notice-premium-number">
                                        {{ $faNumbers[$index] ?? ($index + 1) }}
                                    </span>

                                    <span class="notice-premium-list-content">
                                        <strong>{{ $post->title }}</strong>

                                        <small>
                                            <i class="fa fa-clock"></i>
                                            {{ $post->published_at ? verta($post->published_at)->format('Y/m/d') : verta($post->created_at)->format('Y/m/d') }}
                                        </small>
                                    </span>

                                    <span class="notice-premium-progress"></span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-lg-7 col-md-7 col-12 px-0 notice-premium-visual-col order-md-2 order-1">
                        <div class="carousel-inner notice-premium-carousel-inner">
                            @foreach($announcementPosts->take(5) as $index => $post)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                    <article class="notice-premium-slide">

                                        <div class="notice-premium-image-wrap">
                                            <img src="{{ $post->main_image_url }}"
                                                 class="notice-premium-image"
                                                 alt="{{ $post->title }}">
                                        </div>

                                        <div class="notice-premium-overlay">
                                            <span class="notice-premium-badge">
                                                <i class="fa fa-volume-up"></i>
                                                اطلاعیه رسمی
                                            </span>

                                            <a href="{{ route('front.posts.show', $post->slug) }}"
                                               class="notice-premium-slide-title">
                                                {{ $post->title }}
                                            </a>

                                            <div class="notice-premium-slide-meta">
                                                <span>
                                                    <i class="fa fa-calendar-alt"></i>
                                                    {{ $post->published_at ? verta($post->published_at)->format('Y/m/d') : verta($post->created_at)->format('Y/m/d') }}
                                                </span>

                                                <a href="{{ route('front.posts.show', $post->slug) }}">
                                                    مشاهده اطلاعیه
                                                    <i class="fa fa-chevron-left"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="notice-premium-empty">
                <i class="fa fa-info-circle"></i>
                <h3>هنوز اطلاعیه‌ای ثبت نشده است</h3>
                <p>بعد از انتشار اطلاعیه‌ها، مطالب این بخش در همین قسمت نمایش داده می‌شوند.</p>
            </div>
        @endif

    </div>
</div>

<style>
    .notice-premium-section,
    .notice-premium-section * {
        box-sizing: border-box;
    }

    .notice-premium-section {
        text-align: right;
        margin-bottom: 26px;
    }

    .notice-premium-shell {
        position: relative;
        overflow: hidden;
        padding: 18px;
        border-radius: 28px;
        background:
            radial-gradient(
                circle at top left,
                rgba(20, 37, 78, 0.12),
                transparent 30%
            ),
            linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 1px solid #e2e8f0;
        box-shadow: 0 20px 55px rgba(15, 23, 42, 0.08);
    }

    .notice-premium-shell::before {
        content: "";
        position: absolute;
        top: -80px;
        right: -80px;
        width: 190px;
        height: 190px;
        border-radius: 50%;
        background: rgba(20, 37, 78, 0.10);
        pointer-events: none;
    }

    .notice-premium-head {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 16px;
    }

    .notice-premium-title-box {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .notice-premium-icon {
        width: 48px;
        height: 48px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eef2f8;
        color: #14254e;
        border: 1px solid rgba(20, 37, 78, 0.18);
        box-shadow: 0 10px 26px rgba(20, 37, 78, 0.12);
        flex-shrink: 0;
    }

    .notice-premium-kicker {
        display: block;
        color: #14254e;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 4px;
    }

    .notice-premium-title-box h2 {
        margin: 0;
        color: #14254e;
        font-size: 20px;
        font-weight: 950;
        line-height: 1.4;
    }

    .notice-premium-archive-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 14px;
        border-radius: 999px;
        background: #14254e;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.25s ease;
    }

    .notice-premium-archive-link:hover {
        background: #0f1d3d;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(20, 37, 78, 0.22);
    }

    .notice-premium-archive-link i {
        font-size: 10px;
    }

    .notice-premium-carousel {
        position: relative;
        z-index: 2;
        overflow: hidden;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.07);
    }

    .notice-premium-grid {
        min-height: 382px;
    }

    .notice-premium-list-col {
        background: #ffffff;
        border-left: 1px solid #edf2f7;
    }

    .notice-premium-list {
        height: 100%;
        max-height: 382px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 12px;
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .notice-premium-list::-webkit-scrollbar {
        width: 5px;
    }

    .notice-premium-list::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 999px;
    }

    .notice-premium-list::-webkit-scrollbar-thumb {
        background: rgba(20, 37, 78, 0.25);
        border-radius: 999px;
    }

    .notice-premium-list::-webkit-scrollbar-thumb:hover {
        background: rgba(20, 37, 78, 0.45);
    }

    .notice-premium-list-item {
        position: relative;
        width: 100%;
        min-height: 68px;
        display: flex;
        align-items: center;
        gap: 11px;
        text-align: right;
        padding: 11px 12px;
        overflow: hidden;
        border: 1px solid #eef2f7;
        border-radius: 18px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .notice-premium-list-item:hover {
        background: #ffffff;
        border-color: rgba(20, 37, 78, 0.35);
        transform: translateX(-4px);
        box-shadow: 0 12px 28px rgba(20, 37, 78, 0.10);
    }

    .notice-premium-number {
        width: 38px;
        height: 38px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #ffffff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        font-size: 13px;
        font-weight: 950;
        flex: 0 0 38px;
        transition: 0.25s ease;
    }

    .notice-premium-list-content {
        min-width: 0;
        flex: 1;
        display: block;
    }

    .notice-premium-list-content strong {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 900;
        line-height: 1.65;
        margin-bottom: 5px;
        transition: 0.25s ease;
    }

    .notice-premium-list-content small {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 10px;
    }

    .notice-premium-list-item.active {
        background:
            linear-gradient(
                90deg,
                rgba(20, 37, 78, 0.13),
                #ffffff 72%
            );
        border-color: rgba(20, 37, 78, 0.35);
        box-shadow: 0 12px 30px rgba(20, 37, 78, 0.12);
    }

    .notice-premium-list-item.active .notice-premium-number {
        background: #14254e;
        color: #ffffff;
        border-color: #14254e;
        box-shadow: 0 10px 22px rgba(20, 37, 78, 0.28);
    }

    .notice-premium-list-item.active .notice-premium-list-content strong {
        color: #14254e;
    }

    .notice-premium-list-item.active .notice-premium-list-content small {
        color: rgba(20, 37, 78, 0.68);
    }

    .notice-premium-progress {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 3px;
        width: 0;
        background: #14254e;
        border-radius: 999px 0 0 999px;
    }

    .notice-premium-list-item.active .notice-premium-progress {
        animation: noticePremiumProgress 6s linear forwards;
    }

    @keyframes noticePremiumProgress {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    .notice-premium-visual-col {
        background:
            linear-gradient(
                135deg,
                #0f1d3d 0%,
                #14254e 55%,
                #203968 100%
            );
    }

    .notice-premium-carousel-inner,
    .notice-premium-slide {
        height: 100%;
        min-height: 382px;
    }

    .notice-premium-slide {
        position: relative;
        overflow: hidden;
    }

    .notice-premium-image-wrap {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(
                circle at center,
                rgba(255, 255, 255, 0.08),
                transparent 35%
            ),
            #14254e;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px;
    }

    .notice-premium-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        border-radius: 18px;
        transition: transform 6s ease;
    }

    .carousel-item.active .notice-premium-image {
        transform: scale(1.035);
    }

    .notice-premium-overlay {
        position: absolute;
        inset: 0;
        padding: 28px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        background:
            linear-gradient(
                180deg,
                rgba(20, 37, 78, 0.04) 0%,
                rgba(20, 37, 78, 0.38) 48%,
                rgba(15, 29, 61, 0.94) 100%
            );
    }

    .notice-premium-badge {
        width: fit-content;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 12px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(20, 37, 78, 0.92);
        color: #ffffff;
        font-size: 11px;
        font-weight: 850;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        box-shadow: 0 12px 28px rgba(20, 37, 78, 0.30);
    }

    .notice-premium-badge i {
        color: #dce5f5;
    }

    .notice-premium-slide-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #ffffff;
        font-size: 20px;
        font-weight: 950;
        line-height: 1.75;
        text-decoration: none;
        text-shadow: 0 6px 18px rgba(0, 0, 0, 0.35);
        margin-bottom: 14px;
        transition: 0.25s ease;
    }

    .notice-premium-slide-title:hover {
        color: #dce5f5;
        text-decoration: none;
    }

    .notice-premium-slide-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 14px;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
    }

    .notice-premium-slide-meta span,
    .notice-premium-slide-meta a {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: rgba(255, 255, 255, 0.78);
        font-size: 11px;
        font-weight: 750;
        text-decoration: none;
    }

    .notice-premium-slide-meta a {
        color: #dce5f5;
    }

    .notice-premium-slide-meta a:hover {
        color: #ffffff;
        text-decoration: none;
    }

    .notice-premium-empty {
        position: relative;
        z-index: 2;
        padding: 60px 20px;
        border-radius: 24px;
        background: #ffffff;
        border: 1px dashed rgba(20, 37, 78, 0.28);
        text-align: center;
        color: #64748b;
    }

    .notice-premium-empty i {
        color: #14254e;
        font-size: 42px;
        margin-bottom: 13px;
    }

    .notice-premium-empty h3 {
        color: #14254e;
        font-size: 18px;
        font-weight: 900;
        margin-bottom: 8px;
    }

    .notice-premium-empty p {
        margin: 0;
        font-size: 12px;
    }

    @media (max-width: 991.98px) {
        .notice-premium-grid {
            min-height: auto;
        }

        .notice-premium-carousel-inner,
        .notice-premium-slide {
            min-height: 320px;
        }

        .notice-premium-list {
            max-height: 280px;
        }
    }

    @media (max-width: 575.98px) {
        .notice-premium-shell {
            padding: 14px;
            border-radius: 22px;
        }

        .notice-premium-head {
            flex-direction: column;
            align-items: flex-start;
        }

        .notice-premium-archive-link {
            width: 100%;
            justify-content: center;
        }

        .notice-premium-carousel {
            border-radius: 20px;
        }

        .notice-premium-carousel-inner,
        .notice-premium-slide {
            min-height: 260px;
        }

        .notice-premium-overlay {
            padding: 18px;
        }

        .notice-premium-slide-title {
            font-size: 15px;
            line-height: 1.85;
        }

        .notice-premium-list {
            padding: 10px;
            max-height: 250px;
        }

        .notice-premium-list-item {
            min-height: 62px;
            border-radius: 15px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var myNoticeCarousel =
            document.getElementById('announcementNewsCarousel');

        var noticeIndicators =
            document.querySelectorAll(
                '.notice-premium-carousel .notice-premium-list-item'
            );

        if (myNoticeCarousel) {
            myNoticeCarousel.addEventListener(
                'slide.bs.carousel',
                function (e) {
                    var nextIdx = e.to;

                    noticeIndicators.forEach(function (btn, idx) {
                        if (idx === nextIdx) {
                            btn.classList.add('active');
                            btn.setAttribute('aria-current', 'true');

                            var progressBar =
                                btn.querySelector(
                                    '.notice-premium-progress'
                                );

                            if (progressBar) {
                                progressBar.style.animation = 'none';
                                progressBar.offsetHeight;
                                progressBar.style.animation = null;
                            }

                            var container = btn.parentElement;

                            if (container) {
                                var containerVisibleHeight =
                                    container.clientHeight;

                                var itemTop = btn.offsetTop;
                                var itemHeight = btn.clientHeight;

                                container.scrollTo({
                                    top:
                                        itemTop -
                                        (containerVisibleHeight / 2) +
                                        (itemHeight / 2),
                                    behavior: 'smooth'
                                });
                            }
                        } else {
                            btn.classList.remove('active');
                            btn.removeAttribute('aria-current');
                        }
                    });
                }
            );
        }
    });
</script>
