<div class="home-top-news-section" dir="rtl">
    <div class="row mx-0 home-featured-row-v2">

        {{-- Featured carousel --}}
        <div class="col-lg-6 col-md-12 col-12 px-2 mb-3 mb-lg-0">
            <div id="premiumNewsCarousel"
                 class="carousel slide hero-news-card"
                 data-bs-ride="carousel"
                 data-bs-interval="6000">

                @if(isset($featuredPosts) && $featuredPosts->count())
                    <div class="hero-news-main">
                        <div class="carousel-inner h-100">

                            @foreach($featuredPosts as $index => $post)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                    <article class="hero-news-slide">

                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="hero-news-image">
                                            <img src="{{ $post->main_image_url }}"
                                                 alt="{{ $post->title }}">
                                        </a>

                                        <div class="hero-news-overlay">
                                            <div class="hero-news-content">
                                                <div class="hero-news-meta">
                                                    <span class="hero-news-badge">
                                                        <i class="fa fa-bolt"></i>
                                                        خبر ویژه
                                                    </span>

                                                    <span class="hero-news-time">
                                                        <i class="fa fa-clock"></i>
                                                        {{ jdate($post->created_at)->ago() }}
                                                    </span>
                                                </div>

                                                <a href="{{ route('front.posts.show', $post->slug) }}"
                                                   class="hero-news-title">
                                                    {{ $post->title }}
                                                </a>

                                                @if(!empty($post->summary))
                                                    <p class="hero-news-summary">
                                                        {{ Str::limit($post->summary, 145) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                    </article>
                                </div>
                            @endforeach

                        </div>

                        <button class="carousel-control-prev hero-carousel-control hero-carousel-prev"
                                type="button"
                                data-bs-target="#premiumNewsCarousel"
                                data-bs-slide="prev">
                            <i class="fa fa-chevron-right"></i>
                        </button>

                        <button class="carousel-control-next hero-carousel-control hero-carousel-next"
                                type="button"
                                data-bs-target="#premiumNewsCarousel"
                                data-bs-slide="next">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    </div>

                    <div class="hero-news-list premium-indicators">
                        @foreach($featuredPosts as $index => $post)
                            <button type="button"
                                    data-bs-target="#premiumNewsCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="hero-news-list-item {{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                <span class="hero-list-number">
                                    {{ $index + 1 }}
                                </span>

                                <span class="hero-list-thumb">
                                    <img src="{{ $post->main_image_url }}"
                                         alt="{{ $post->title }}">
                                </span>

                                <span class="hero-list-content">
                                    <strong>
                                        {{ $post->title }}
                                    </strong>

                                    <small>
                                        <i class="fa fa-clock"></i>
                                        {{ jdate($post->created_at)->ago() }}
                                    </small>
                                </span>

                                <span class="hero-list-progress"></span>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="hero-news-empty">
                        <i class="fa fa-newspaper"></i>
                        <strong>هنوز خبر ویژه‌ای ثبت نشده است</strong>
                        <span>بعد از ثبت خبرهای ویژه، اسلایدر این بخش فعال می‌شود.</span>
                    </div>
                @endif

            </div>
        </div>

        {{-- Right widgets --}}
        <div class="col-lg-6 col-12 px-2">
            <div class="row mx-0 home-featured-side-row">

                {{-- Trending tabs --}}
                <div class="col-md-6 col-12 px-2 mb-3 mb-md-0">
                    <div class="news-widget-card sticky-top col_z_index" style="top: 20px;">

                        <div class="news-tabs-header">
                            <ul class="nav nav-tabs news-modern-tabs border-0" role="tablist">
                                <li class="nav-item flex-fill text-center" role="presentation">
                                    <a class="nav-link active"
                                       id="most-visited-tab"
                                       data-toggle="tab"
                                       data-bs-toggle="tab"
                                       href="#homeMostVisited"
                                       data-bs-target="#homeMostVisited"
                                       role="tab">
                                        <i class="fa fa-eye"></i>
                                        پربازدیدترین‌ها
                                    </a>
                                </li>

                                <li class="nav-item flex-fill text-center" role="presentation">
                                    <a class="nav-link"
                                       id="most-commented-tab"
                                       data-toggle="tab"
                                       data-bs-toggle="tab"
                                       href="#homeMostCommented"
                                       data-bs-target="#homeMostCommented"
                                       role="tab">
                                        <i class="fa fa-comments"></i>
                                        پربحث‌ترین‌ها
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content news-tabs-content">
                            <div class="tab-pane fade show active" id="homeMostVisited" role="tabpanel">
                                @forelse($mostVisited as $post)
                                    <article class="mini-rank-news">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="mini-rank-link">
                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </article>
                                @empty
                                    <div class="mini-widget-empty">
                                        خبری برای نمایش وجود ندارد.
                                    </div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="homeMostCommented" role="tabpanel">
                                @forelse($mostCommented as $post)
                                    <article class="mini-rank-news">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="mini-rank-link">
                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </article>
                                @empty
                                    <div class="mini-widget-empty">
                                        خبری برای نمایش وجود ندارد.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Subject of day + ads --}}
                <div class="col-md-6 col-12 px-2">
                    <div class="sticky-top col_z_index subject-stack-equal" style="top: 20px;">

                        <div class="subject-day-card">
                            <div class="subject-day-header">
                                <div>
                                    <span class="subject-day-kicker">
                                        پرونده ویژه
                                    </span>

                                    <h3>
                                        سوژه روز
                                    </h3>
                                </div>

                                <i class="fa fa-fire"></i>
                            </div>

                            @if($subjectOfTheDay)
                                <article class="subject-day-body">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="subject-day-image">
                                        <img src="{{ $subjectOfTheDay->main_image_url }}"
                                             alt="{{ $subjectOfTheDay->title }}">

                                        <span>
                                            امروز
                                        </span>
                                    </a>

                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="subject-day-title">
                                        {{ $subjectOfTheDay->title }}
                                    </a>

                                    <div class="subject-day-stats">
                                        <span>
                                            <i class="fa fa-eye"></i>
                                            {{ $subjectOfTheDay->views_count ?? 0 }}
                                        </span>

                                        <span>
                                            <i class="fa fa-comment"></i>
                                            {{ $subjectOfTheDay->comments_count ?? 0 }}
                                        </span>
                                    </div>
                                </article>
                            @else
                                <div class="subject-day-empty">
                                    <i class="fa fa-folder-open"></i>
                                    <span>سوژه روز انتخاب نشده است.</span>
                                </div>
                            @endif
                        </div>

                        {{-- Adv --}}
                        <div class="home-ads-stack">
                            <div class="adv-card-v2">
                                <span class="adv-label-v2">تبلیغات</span>

                                <a href="URL_LINK_1" target="_blank" class="adv-link-v2">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         alt="تبلیغات">
                                </a>
                            </div>

                            <div class="adv-card-v2">
                                <span class="adv-label-v2">تبلیغات</span>

                                <a href="URL_LINK_2" target="_blank" class="adv-link-v2">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
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
    .home-top-news-section,
    .home-top-news-section * {
        box-sizing: border-box;
    }

    .home-top-news-section {
        direction: rtl;
        width: 100%;
        max-width: 100%;
        overflow: visible;
        margin-top: 18px;
    }

    .home-featured-row-v2,
    .home-featured-side-row {
        width: 100%;
        max-width: 100%;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .home-featured-row-v2 > [class*="col-"],
    .home-featured-side-row > [class*="col-"] {
        min-width: 0;
    }

    .hero-news-card {
        height: 545px;
        overflow: hidden;
        border-radius: 28px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.96);
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.11);
    }

    .hero-news-main {
        position: relative;
        height: 355px;
        overflow: hidden;
        background: #0f172a;
    }

    .hero-news-slide,
    .hero-news-image {
        position: relative;
        display: block;
        width: 100%;
        height: 100%;
    }

    .hero-news-image img {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        object-position: center;
        transition: transform 6s ease;
    }

    .carousel-item.active .hero-news-image img {
        transform: scale(1.06);
    }

    .hero-news-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: flex-end;
        padding: 26px;
        background:
            linear-gradient(180deg, rgba(15, 23, 42, 0.08) 0%, rgba(15, 23, 42, 0.18) 34%, rgba(15, 23, 42, 0.94) 100%),
            radial-gradient(circle at top left, rgba(37, 99, 235, 0.22), transparent 32%);
        pointer-events: none;
    }

    .hero-news-content {
        width: 100%;
        max-width: 92%;
        pointer-events: auto;
    }

    .hero-news-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
        margin-bottom: 12px;
    }

    .hero-news-badge,
    .hero-news-time {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 11px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.18);
        backdrop-filter: blur(9px);
    }

    .hero-news-badge i {
        color: #f59e0b;
    }

    .hero-news-title {
        display: block;
        color: #ffffff;
        font-size: 23px;
        font-weight: 950;
        line-height: 1.75;
        text-decoration: none;
        text-shadow: 0 8px 22px rgba(0, 0, 0, 0.45);
        transition: color 0.22s ease;
    }

    .hero-news-title:hover {
        color: #bfdbfe;
        text-decoration: none;
    }

    .hero-news-summary {
        margin: 8px 0 0;
        color: #cbd5e1;
        font-size: 13px;
        line-height: 1.9;
    }

    .hero-carousel-control {
        top: 18px;
        bottom: auto;
        width: 42px;
        height: 42px;
        border-radius: 16px;
        background: rgba(15, 23, 42, 0.72);
        color: #ffffff;
        opacity: 1;
        backdrop-filter: blur(8px);
        transition: 0.25s ease;
    }

    .hero-carousel-control:hover {
        background: #2563eb;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .hero-carousel-prev {
        right: 18px;
        left: auto;
    }

    .hero-carousel-next {
        right: 68px;
        left: auto;
    }

    .hero-news-list {
        height: 190px;
        padding: 13px;
        overflow-y: auto;
        overflow-x: hidden;
        background:
            radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 35%),
            #f8fafc;
    }

    .hero-news-list::-webkit-scrollbar {
        width: 5px;
    }

    .hero-news-list::-webkit-scrollbar-track {
        background: #edf2f7;
        border-radius: 999px;
    }

    .hero-news-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    .hero-news-list-item {
        position: relative;
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        overflow: hidden;
        border: 1px solid transparent;
        outline: 0;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 18px;
        background: #ffffff;
        text-align: right;
        cursor: pointer;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.045);
        transition: all 0.25s ease;
    }

    .hero-news-list-item:last-child {
        margin-bottom: 0;
    }

    .hero-news-list-item:hover {
        transform: translateX(-4px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.09);
    }

    .hero-news-list-item.active {
        background: #ffffff;
        border-color: rgba(37, 99, 235, 0.32);
        box-shadow: 0 14px 34px rgba(37, 99, 235, 0.14);
    }

    .hero-news-list-item.active .hero-list-content strong {
        color: #0f172a;
    }

    .hero-news-list-item.active .hero-list-content small {
        color: #2563eb;
    }

    .hero-list-number {
        min-width: 26px;
        height: 26px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 950;
    }

    .hero-news-list-item.active .hero-list-number {
        background: #2563eb;
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(37, 99, 235, 0.24);
    }

    .hero-list-thumb {
        width: 58px;
        height: 50px;
        overflow: hidden;
        border-radius: 14px;
        flex-shrink: 0;
        background: #e2e8f0;
    }

    .hero-list-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: 0.3s ease;
    }

    .hero-news-list-item:hover .hero-list-thumb img {
        transform: scale(1.08);
    }

    .hero-list-content {
        flex: 1;
        min-width: 0;
    }

    .hero-list-content strong {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #0f172a;
        font-size: 12px;
        font-weight: 900;
        line-height: 1.65;
    }

    .hero-list-content small {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
        color: #64748b;
        font-size: 10px;
    }

    .hero-list-progress {
        position: absolute;
        right: 0;
        bottom: 0;
        height: 3px;
        width: 0;
        background: #60a5fa;
    }

    .hero-news-list-item.active .hero-list-progress {
        animation: heroProgress 6s linear forwards;
    }

    @keyframes heroProgress {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    .hero-news-empty {
        height: 100%;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #64748b;
        text-align: center;
        padding: 30px;
    }

    .hero-news-empty i {
        font-size: 42px;
        color: #94a3b8;
    }

    .hero-news-empty strong {
        color: #0f172a;
        font-size: 16px;
    }

    .hero-news-empty span {
        font-size: 12px;
    }

    .news-widget-card,
    .subject-day-card {
        overflow: hidden;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.96);
        box-shadow: 0 16px 46px rgba(15, 23, 42, 0.075);
    }

    /* هم‌تراز شدن ستون سوژه روز + تبلیغات با اسلایدر اصلی، بدون دست زدن به ستون وسط */
    @media (min-width: 992px) {
        .subject-stack-equal {
            height: 545px;
            display: flex;
            flex-direction: column;
        }

        .subject-stack-equal .subject-day-card {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
            margin-bottom: 14px;
        }

        .subject-stack-equal .subject-day-body {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .subject-stack-equal .subject-day-image {
            height: 138px;
            flex-shrink: 0;
        }

        .subject-stack-equal .subject-day-title {
            margin-bottom: 10px;
        }

        .subject-stack-equal .subject-day-stats {
            margin-top: auto;
        }

        .subject-stack-equal .home-ads-stack {
            flex: 0 0 auto;
            gap: 12px;
        }

        .subject-stack-equal .adv-link-v2 img {
            height: 92px;
        }
    }


    .news-tabs-header {
        display: flex;
        padding: 10px;
        background: #f8fafc;
        border-bottom: 1px solid #eef2f7;
    }

    .news-modern-tabs {
        display: flex;
        gap: 8px;
        background: transparent;
    }

    .news-modern-tabs .nav-link {
        border: 0 !important;
        border-radius: 15px !important;
        padding: 10px 8px;
        color: #64748b;
        background: transparent;
        font-size: 11px;
        font-weight: 850;
        white-space: nowrap;
        transition: 0.22s ease;
    }

    .news-modern-tabs .nav-link i {
        margin-left: 5px;
        font-size: 10px;
    }

    .news-modern-tabs .nav-link.active,
    .news-modern-tabs .nav-link:hover {
        background: #eff6ff !important;
        color: #2563eb !important;
        box-shadow: inset 0 0 0 1px rgba(37, 99, 235, 0.16);
    }

    .news-tabs-content {
        padding: 8px 12px;
        min-height: 322px;
    }

    .mini-rank-news {
        border-bottom: 1px solid #eef2f7;
    }

    .mini-rank-news:last-child {
        border-bottom: 0;
    }

    .mini-rank-link {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px 0;
        color: #0f172a;
        text-decoration: none;
        transition: 0.22s ease;
    }

    .mini-rank-link:hover {
        color: #2563eb;
        text-decoration: none;
        transform: translateX(-3px);
    }

    .mini-rank-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #2563eb;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10);
        flex-shrink: 0;
    }

    .mini-rank-title {
        flex: 1;
        min-width: 0;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 750;
    }

    .mini-rank-link i {
        color: #cbd5e1;
        font-size: 9px;
        transition: 0.22s ease;
    }

    .mini-rank-link:hover i {
        color: #2563eb;
    }

    .mini-widget-empty {
        padding: 35px 15px;
        color: #94a3b8;
        font-size: 12px;
        text-align: center;
    }

    .subject-day-card {
        margin-bottom: 16px;
    }

    .subject-day-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 16px;
        background:
            radial-gradient(circle at top left, rgba(245, 158, 11, 0.13), transparent 38%),
            #ffffff;
        border-bottom: 1px solid #eef2f7;
    }

    .subject-day-header h3 {
        margin: 3px 0 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 950;
    }

    .subject-day-kicker {
        color: #2563eb;
        font-size: 10px;
        font-weight: 850;
    }

    .subject-day-header > i {
        width: 38px;
        height: 38px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #f59e0b;
        background: #fffbeb;
    }

    .subject-day-body {
        padding: 14px;
    }

    .subject-day-image {
        position: relative;
        display: block;
        height: 152px;
        overflow: hidden;
        border-radius: 18px;
        background: #e2e8f0;
        margin-bottom: 12px;
    }

    .subject-day-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: 0.32s ease;
    }

    .subject-day-image:hover img {
        transform: scale(1.07);
    }

    .subject-day-image::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 48%, rgba(15, 23, 42, 0.70));
    }

    .subject-day-image span {
        position: absolute;
        right: 12px;
        bottom: 12px;
        z-index: 2;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.92);
        color: #0f172a;
        font-size: 10px;
        font-weight: 850;
    }

    .subject-day-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.8;
        text-decoration: none;
        margin-bottom: 12px;
        transition: 0.22s ease;
    }

    .subject-day-title:hover {
        color: #2563eb;
        text-decoration: none;
    }

    .subject-day-stats {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .subject-day-stats span {
        height: 38px;
        border-radius: 14px;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        color: #64748b;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .subject-day-stats i {
        color: #2563eb;
    }

    .subject-day-empty {
        min-height: 230px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 9px;
        color: #94a3b8;
        font-size: 12px;
        padding: 20px;
    }

    .subject-day-empty i {
        font-size: 32px;
    }

    .home-ads-stack {
        display: grid;
        gap: 14px;
    }

    .adv-card-v2 {
        position: relative;
        overflow: hidden;
        padding: 7px;
        border-radius: 20px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.96);
        box-shadow: 0 14px 36px rgba(15, 23, 42, 0.075);
        animation: advSoftPulseV2 3s ease-in-out infinite;
        transition: 0.28s ease;
    }

    .adv-card-v2:hover {
        transform: translateY(-4px);
        box-shadow: 0 22px 52px rgba(15, 23, 42, 0.14);
    }

    .adv-card-v2::before {
        content: "";
        position: absolute;
        top: 0;
        right: -85%;
        width: 48%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.48), transparent);
        z-index: 2;
        pointer-events: none;
        animation: advShineV2 3.7s ease-in-out infinite;
    }

    .adv-link-v2 {
        display: block;
        overflow: hidden;
        border-radius: 15px;
        background: #e2e8f0;
    }

    .adv-link-v2 img {
        width: 100%;
        height: 118px;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: 0.32s ease;
    }

    .adv-card-v2:hover .adv-link-v2 img {
        transform: scale(1.04);
    }

    .adv-label-v2 {
        position: absolute;
        top: 13px;
        right: 13px;
        z-index: 3;
        padding: 5px 10px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.78);
        color: #ffffff;
        font-size: 10px;
        font-weight: 800;
        backdrop-filter: blur(8px);
    }

    @keyframes advSoftPulseV2 {
        0%, 100% {
            box-shadow: 0 14px 36px rgba(15, 23, 42, 0.075);
        }

        50% {
            box-shadow: 0 18px 46px rgba(37, 99, 235, 0.17);
        }
    }

    @keyframes advShineV2 {
        0% {
            right: -85%;
        }

        45%, 100% {
            right: 130%;
        }
    }

    @media (max-width: 991.98px) {
        .hero-news-card {
            height: auto;
        }

        .hero-news-main {
            height: 330px;
        }

        .hero-news-list {
            height: 235px;
        }

        .sticky-top,
        .col_z_index {
            position: static !important;
            top: auto !important;
        }

        .news-tabs-content {
            min-height: auto;
        }
    }

    @media (max-width: 575.98px) {
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .home-top-news-section {
            overflow-x: hidden;
        }

        .home-featured-row-v2 > [class*="col-"],
        .home-featured-side-row > [class*="col-"] {
            padding-left: 6px !important;
            padding-right: 6px !important;
        }

        .hero-news-card,
        .news-widget-card,
        .subject-day-card {
            border-radius: 20px;
        }

        .hero-news-main {
            height: 255px;
        }

        .hero-news-overlay {
            padding: 16px;
        }

        .hero-news-content {
            max-width: 100%;
        }

        .hero-news-title {
            font-size: 16px;
            line-height: 1.8;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .hero-news-summary {
            display: none;
        }

        .hero-news-badge,
        .hero-news-time {
            padding: 5px 9px;
            font-size: 10px;
        }

        .hero-carousel-control {
            width: 36px;
            height: 36px;
            border-radius: 13px;
            top: 12px;
        }

        .hero-carousel-prev {
            right: 12px;
        }

        .hero-carousel-next {
            right: 54px;
        }

        .hero-news-list {
            height: 228px;
            padding: 10px;
        }

        .hero-news-list-item {
            padding: 8px;
            border-radius: 14px;
            gap: 8px;
        }

        .hero-list-number {
            min-width: 23px;
            height: 23px;
            border-radius: 8px;
            font-size: 10px;
        }

        .hero-list-thumb {
            width: 48px;
            height: 44px;
            border-radius: 12px;
        }

        .hero-list-content strong {
            font-size: 11px;
            line-height: 1.65;
        }

        .hero-list-content small {
            font-size: 9px;
        }

        .news-modern-tabs .nav-link {
            padding: 9px 5px;
            font-size: 10px;
        }

        .subject-day-image {
            height: 170px;
        }

        .adv-link-v2 img {
            height: 150px;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var premiumCarousel = document.getElementById('premiumNewsCarousel');
        var premiumIndicators = document.querySelectorAll('.premium-indicators .hero-news-list-item');

        if (premiumCarousel && premiumIndicators.length) {
            premiumCarousel.addEventListener('slide.bs.carousel', function (e) {
                var nextIdx = e.to;

                premiumIndicators.forEach(function (btn, idx) {
                    if (idx === nextIdx) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-current', 'true');

                        var progressBar = btn.querySelector('.hero-list-progress');

                        if (progressBar) {
                            progressBar.style.animation = 'none';
                            progressBar.offsetHeight;
                            progressBar.style.animation = null;
                        }

                        var list = btn.parentElement;

                        if (list) {
                            var visibleHeight = list.clientHeight;
                            var itemTop = btn.offsetTop;
                            var itemHeight = btn.clientHeight;

                            list.scrollTo({
                                top: itemTop - (visibleHeight / 2) + (itemHeight / 2),
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
