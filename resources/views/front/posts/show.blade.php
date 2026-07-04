@extends('front.layouts.master')

@section('content')
    <div class="article-reading-progress sticky-top">
        <div id="reading-progress" class="article-reading-progress-bar"></div>
    </div>

    <main class="premium-article-page" dir="rtl">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-12 col-12 pb-4">
                    <article id="main-news-box" class="premium-article-card">

                        <div class="article-breadcrumb">
                            <a href="{{ route('home') }}">خانه</a>
                            <i class="fa fa-chevron-left"></i>
                            @if($post->blogCategory ?? false)
                                <span>{{ $post->blogCategory->name ?? $post->blogCategory->title }}</span>
                            @else
                                <span>خبر</span>
                            @endif
                        </div>

                        <header class="article-header-box">
                            <div class="article-category-pill">
                                <i class="fa fa-newspaper"></i>
                                <span>
                                    {{ $post->blogCategory->name ?? $post->blogCategory->title ?? 'اخبار' }}
                                </span>
                            </div>

                            <h1 id="news-title" class="premium-article-title">
                                {{ $post->title }}
                            </h1>

                            <div class="premium-article-meta">
                                <span>
                                    <i class="fa fa-calendar-alt"></i>
                                    {{ $post->published_at ? verta($post->published_at)->format('Y/m/d') : verta($post->created_at)->format('Y/m/d') }}
                                </span>

                                <span>
                                    <i class="fa fa-eye"></i>
                                    {{ $post->views ?? $post->views_count ?? 0 }} بازدید
                                </span>

                                <span>
                                    <i class="fa fa-user-edit"></i>
                                    {{ $post->user->name ?? 'مدیر سایت' }}
                                </span>

                                <button id="toggle-dark-reader" type="button" class="reader-mode-btn">
                                    <i class="fa fa-moon"></i>
                                    حالت مطالعه
                                </button>
                            </div>
                        </header>

                        @if($post->blog_category_id == 6)
                        @else
                            @if($post->main_image_url)
                                <figure class="premium-article-cover">
                                    <img src="{{ $post->main_image_url }}"
                                         alt="{{ $post->title }}">

                                    <figcaption>
                                        <i class="fa fa-camera"></i>
                                        تصویر شاخص خبر
                                    </figcaption>
                                </figure>
                            @endif
                        @endif

                        @if($post->summary)
                            <section id="news-summary" class="premium-article-summary">
                                <div class="summary-icon">
                                    <i class="fa fa-quote-right"></i>
                                </div>

                                <div>
                                    <strong>خلاصه خبر</strong>
                                    <p>{{ $post->summary }}</p>
                                </div>
                            </section>
                        @endif

                        <section id="news-body" class="premium-article-body">
                            {!! $post->body !!}
                        </section>

                        <footer class="premium-article-footer">
                            <div class="article-share-title">
                                <i class="fa fa-share-alt"></i>
                                <span>اشتراک‌گذاری این مطلب</span>
                            </div>

                            <div class="article-share-actions">
                                <a href="https://telegram.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                   target="_blank"
                                   class="share-btn telegram-share">
                                    <i class="fab fa-telegram-plane"></i>
                                    تلگرام
                                </a>

                                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                                   target="_blank"
                                   class="share-btn whatsapp-share">
                                    <i class="fab fa-whatsapp"></i>
                                    واتساپ
                                </a>
                            </div>
                        </footer>

                    </article>
                </div>

                <aside class="col-lg-4 col-md-12 col-12">
                    <div class="premium-article-sidebar">

                        <div class="sidebar-widget today-widget">
                            <div class="sidebar-widget-title">
                                <i class="fa fa-calendar-check"></i>
                                <span>امروز در یک نگاه</span>
                            </div>

                            <div class="today-widget-grid">
                                <div class="today-clock-box">
                                    <strong id="live-clock">00:00:00</strong>
                                    <small>ساعت رسمی</small>
                                </div>

                                <div class="today-date-box">
                                    <span id="persian-date">در حال بارگذاری...</span>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget sidebar-search-widget">
                            <div class="sidebar-widget-title">
                                <i class="fa fa-search"></i>
                                <span>جستجو در مطالب</span>
                            </div>

                            <form action="#" method="GET" class="sidebar-search-form">
                                <input type="text"
                                       name="search"
                                       placeholder="کلمه کلیدی را وارد کنید...">

                                <button type="submit">
                                    جستجو
                                </button>
                            </form>
                        </div>

                        <div class="sidebar-widget latest-news-widget">
                            <div class="sidebar-widget-title with-action">
                                <div>
                                    <i class="fa fa-bolt"></i>
                                    <span>آخرین اخبار سایت</span>
                                </div>
                            </div>

                            @foreach($latestPosts->take(5) as $item)
                                <article class="sidebar-latest-item">
                                    @if($item->main_image_url)
                                        <a href="{{ route('front.posts.show', $item->slug) }}" class="sidebar-latest-img">
                                            <img src="{{ $item->main_image_url }}" alt="{{ $item->title }}">
                                        </a>
                                    @endif

                                    <div class="sidebar-latest-content">
                                        <a href="{{ route('front.posts.show', $item->slug) }}">
                                            {{ \Illuminate\Support\Str::limit($item->title, 62) }}
                                        </a>

                                        <small>
                                            <i class="fa fa-calendar-alt"></i>
                                            {{ $item->published_at ? verta($item->published_at)->format('Y/m/d') : verta($item->created_at)->format('Y/m/d') }}
                                        </small>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="sidebar-widget tags-widget">
                            <div class="sidebar-widget-title">
                                <i class="fa fa-tags"></i>
                                <span>برچسب‌های کلیدی</span>
                            </div>

                            <div class="article-tags-list">
                                @if(isset($post->tags) && $post->tags->count() > 0)
                                    @foreach($post->tags as $tag)
                                        <a href="#">#{{ $tag->name }}</a>
                                    @endforeach
                                @else
                                    <a href="#">#اخبار_روز</a>
                                    <a href="#">#اقتصاد_و_تجارت</a>
                                    <a href="#">#گزارش_اختصاصی</a>
                                @endif
                            </div>
                        </div>

                        <div class="sidebar-widget poll-widget">
                            <div class="sidebar-widget-title">
                                <i class="fa fa-chart-pie"></i>
                                <span>نظرسنجی روز</span>
                            </div>

                            <p>کیفیت و پوشش اخبار مجموعه را چگونه ارزیابی می‌کنید؟</p>

                            <div class="poll-options">
                                <label>
                                    <input type="radio" name="poll_option">
                                    <span>عالی و به‌موقع</span>
                                </label>

                                <label>
                                    <input type="radio" name="poll_option">
                                    <span>متوسط و نیازمند بهبود</span>
                                </label>
                            </div>

                            <button type="button" class="poll-submit-btn">
                                ثبت رأی
                            </button>
                        </div>

                    </div>
                </aside>

            </div>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .article-reading-progress {
            height: 4px;
            top: 0;
            z-index: 1050;
            background: rgba(15, 23, 42, 0.05);
            border-radius: 0 !important;
        }

        .article-reading-progress-bar {
            width: 0%;
            height: 100%;
            background: linear-gradient(90deg, #2563eb, #10b981, #f59e0b);
            transition: width 0.22s ease;
            box-shadow: 0 0 16px rgba(37, 99, 235, 0.55);
        }

        .premium-article-page {
            text-align: right;
            padding: 28px 0 70px;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.07), transparent 34%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 45%, #f8fafc 100%);
        }

        .premium-article-card {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 30px;
            padding: 28px;
            box-shadow: 0 22px 65px rgba(15, 23, 42, 0.08);
            transition: background-color 0.28s ease, color 0.28s ease, border-color 0.28s ease;
        }

        .article-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            color: #94a3b8;
            font-size: 12px;
            margin-bottom: 18px;
        }

        .article-breadcrumb a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 800;
        }

        .article-breadcrumb i {
            font-size: 9px;
        }

        .article-header-box {
            position: relative;
            padding: 4px 0 22px;
            margin-bottom: 24px;
            border-bottom: 1px solid #eef2f7;
        }

        .article-category-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            padding: 7px 13px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 900;
        }

        .premium-article-title {
            color: #0f172a;
            font-size: 30px;
            font-weight: 950;
            line-height: 1.65;
            margin-bottom: 16px;
            letter-spacing: -0.7px;
        }

        .premium-article-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            color: #64748b;
            font-size: 12px;
        }

        .premium-article-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 11px;
            border-radius: 13px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
        }

        .premium-article-meta i {
            color: #2563eb;
        }

        .reader-mode-btn {
            margin-right: auto;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            height: 37px;
            padding: 0 12px;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
            background: #ffffff;
            color: #475569;
            font-size: 11px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 8px 22px rgba(15, 23, 42, 0.05);
            transition: 0.22s ease;
        }

        .reader-mode-btn:hover {
            color: #0f172a;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.10);
        }

        .premium-article-cover {
            position: relative;
            overflow: hidden;
            margin: 0 0 24px;
            border-radius: 26px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            box-shadow: 0 18px 48px rgba(15, 23, 42, 0.08);
        }

        .premium-article-cover img {
            display: block;
            width: 100%;
            max-height: 470px;
            object-fit: contain;
            object-position: center;
            background: #f8fafc;
        }

        .premium-article-cover figcaption {
            position: absolute;
            right: 16px;
            bottom: 16px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.78);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            backdrop-filter: blur(9px);
        }

        .premium-article-summary {
            display: flex;
            gap: 14px;
            margin-bottom: 26px;
            padding: 18px;
            border-radius: 22px;
            background: linear-gradient(135deg, #f8fafc, #ffffff);
            border: 1px solid #e2e8f0;
            border-right: 5px solid #2563eb;
        }

        .summary-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 16px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .premium-article-summary strong {
            display: block;
            color: #0f172a;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .premium-article-summary p {
            color: #475569;
            font-size: 13px;
            line-height: 2;
            margin: 0;
            text-align: justify;
        }

        .premium-article-body {
            color: #1f2937;
            font-size: 15px;
            line-height: 2.35;
            text-align: justify;
        }

        .premium-article-body p {
            margin-bottom: 18px;
        }

        .premium-article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 20px;
            margin: 16px auto;
            display: block;
        }

        .premium-article-body h2,
        .premium-article-body h3,
        .premium-article-body h4 {
            color: #0f172a;
            font-weight: 900;
            line-height: 1.8;
            margin-top: 28px;
            margin-bottom: 14px;
        }

        .premium-article-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-top: 34px;
            padding-top: 20px;
            border-top: 1px solid #eef2f7;
        }

        .article-share-title {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .article-share-title i {
            color: #2563eb;
        }

        .article-share-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .share-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 13px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 850;
            text-decoration: none;
            transition: 0.22s ease;
        }

        .telegram-share {
            background: #eff6ff;
            color: #2563eb;
        }

        .whatsapp-share {
            background: #ecfdf5;
            color: #059669;
        }

        .share-btn:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .telegram-share:hover {
            background: #2563eb;
            color: #ffffff;
        }

        .whatsapp-share:hover {
            background: #059669;
            color: #ffffff;
        }

        .premium-article-sidebar {
            position: sticky;
            top: 20px;
            z-index: 10;
        }

        .sidebar-widget {
            overflow: hidden;
            margin-bottom: 18px;
            padding: 18px;
            border-radius: 24px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 16px 42px rgba(15, 23, 42, 0.06);
        }

        .sidebar-widget-title {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 15px;
            padding-bottom: 13px;
            border-bottom: 1px solid #eef2f7;
            color: #0f172a;
            font-size: 13px;
            font-weight: 950;
        }

        .sidebar-widget-title i {
            width: 30px;
            height: 30px;
            border-radius: 11px;
            background: #eff6ff;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .today-widget {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #ffffff;
            border: 0;
        }

        .today-widget .sidebar-widget-title {
            color: #ffffff;
            border-color: rgba(255,255,255,0.11);
        }

        .today-widget .sidebar-widget-title i {
            background: rgba(255,255,255,0.10);
            color: #93c5fd;
        }

        .today-widget-grid {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 10px;
        }

        .today-clock-box,
        .today-date-box {
            min-height: 78px;
            padding: 12px;
            border-radius: 18px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.10);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .today-clock-box strong {
            font-family: monospace, sans-serif;
            color: #bfdbfe;
            font-size: 21px;
            letter-spacing: 1px;
        }

        .today-clock-box small,
        .today-date-box span {
            color: rgba(255,255,255,0.74);
            font-size: 11px;
            line-height: 1.9;
        }

        .sidebar-search-form {
            display: flex;
            overflow: hidden;
            height: 46px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .sidebar-search-form input {
            flex: 1;
            border: 0;
            outline: 0;
            background: transparent;
            padding: 0 13px;
            font-size: 12px;
            color: #0f172a;
        }

        .sidebar-search-form button {
            border: 0;
            padding: 0 14px;
            background: #0f172a;
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .sidebar-latest-item {
            display: flex;
            gap: 12px;
            padding-bottom: 13px;
            margin-bottom: 13px;
            border-bottom: 1px solid #eef2f7;
        }

        .sidebar-latest-item:last-child {
            padding-bottom: 0;
            margin-bottom: 0;
            border-bottom: 0;
        }

        .sidebar-latest-img {
            width: 72px;
            height: 62px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 15px;
            background: #e2e8f0;
        }

        .sidebar-latest-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: 0.3s ease;
        }

        .sidebar-latest-item:hover .sidebar-latest-img img {
            transform: scale(1.07);
        }

        .sidebar-latest-content {
            flex: 1;
            min-width: 0;
        }

        .sidebar-latest-content a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            color: #0f172a;
            font-size: 12px;
            font-weight: 850;
            line-height: 1.75;
            margin-bottom: 6px;
            text-decoration: none;
        }

        .sidebar-latest-content a:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .sidebar-latest-content small {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #94a3b8;
            font-size: 10px;
        }

        .article-tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .article-tags-list a {
            display: inline-flex;
            padding: 7px 11px;
            border-radius: 999px;
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 11px;
            font-weight: 750;
            text-decoration: none;
            transition: 0.22s ease;
        }

        .article-tags-list a:hover {
            background: #0f172a;
            color: #ffffff;
            border-color: #0f172a;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .poll-widget p {
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 13px;
        }

        .poll-options {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 13px;
        }

        .poll-options label {
            display: flex;
            align-items: center;
            gap: 9px;
            margin: 0;
            padding: 10px 11px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            color: #475569;
            font-size: 12px;
            cursor: pointer;
        }

        .poll-submit-btn {
            width: 100%;
            height: 40px;
            border: 0;
            border-radius: 14px;
            background: #2563eb;
            color: #ffffff;
            font-size: 12px;
            font-weight: 850;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .poll-submit-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .premium-article-card.reader-dark {
            background: #111827;
            color: #e5e7eb;
            border-color: #1f2937;
            box-shadow: 0 22px 65px rgba(0, 0, 0, 0.22);
        }

        .premium-article-card.reader-dark .article-header-box,
        .premium-article-card.reader-dark .premium-article-footer {
            border-color: rgba(255,255,255,0.10);
        }

        .premium-article-card.reader-dark .article-breadcrumb,
        .premium-article-card.reader-dark .premium-article-meta,
        .premium-article-card.reader-dark .article-share-title,
        .premium-article-card.reader-dark .premium-article-body {
            color: #d1d5db;
        }

        .premium-article-card.reader-dark .premium-article-title,
        .premium-article-card.reader-dark .premium-article-body h2,
        .premium-article-card.reader-dark .premium-article-body h3,
        .premium-article-card.reader-dark .premium-article-body h4,
        .premium-article-card.reader-dark .premium-article-summary strong {
            color: #ffffff;
        }

        .premium-article-card.reader-dark .premium-article-meta span,
        .premium-article-card.reader-dark .reader-mode-btn,
        .premium-article-card.reader-dark .premium-article-summary {
            background: #1f2937;
            border-color: #374151;
            color: #e5e7eb;
        }

        .premium-article-card.reader-dark .premium-article-summary p {
            color: #d1d5db;
        }

        @media (max-width: 991.98px) {
            .premium-article-sidebar {
                position: static;
            }

            .premium-article-card {
                border-radius: 24px;
                padding: 22px;
            }

            .premium-article-title {
                font-size: 24px;
            }
        }

        @media (max-width: 575.98px) {
            .premium-article-page {
                padding-top: 18px;
            }

            .premium-article-card {
                padding: 17px;
                border-radius: 20px;
            }

            .premium-article-title {
                font-size: 20px;
                line-height: 1.75;
            }

            .premium-article-meta span {
                width: 100%;
            }

            .reader-mode-btn {
                margin-right: 0;
            }

            .premium-article-cover {
                border-radius: 18px;
            }

            .premium-article-cover img {
                max-height: 310px;
            }

            .premium-article-summary {
                flex-direction: column;
                border-right-width: 4px;
            }

            .premium-article-footer {
                align-items: flex-start;
                flex-direction: column;
            }

            .article-share-actions {
                width: 100%;
            }

            .share-btn {
                flex: 1;
                justify-content: center;
            }

            .today-widget-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function updateClockAndDate() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const clockEl = document.getElementById('live-clock');
            if (clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds}`;

            const dateEl = document.getElementById('persian-date');
            if (dateEl) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateEl.textContent = new Intl.DateTimeFormat('fa-IR', options).format(now);
            }
        }

        updateClockAndDate();
        setInterval(updateClockAndDate, 1000);

        window.addEventListener('scroll', function () {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = height > 0 ? (winScroll / height) * 100 : 0;
            const progressEl = document.getElementById('reading-progress');
            if (progressEl) progressEl.style.width = scrolled + '%';
        });

        document.getElementById('toggle-dark-reader')?.addEventListener('click', function () {
            const mainBox = document.getElementById('main-news-box');
            if (!mainBox) return;

            mainBox.classList.toggle('reader-dark');

            if (mainBox.classList.contains('reader-dark')) {
                this.innerHTML = '<i class="fa fa-sun"></i> روز روشن';
                this.classList.add('active-reader-mode');
            } else {
                this.innerHTML = '<i class="fa fa-moon"></i> حالت مطالعه';
                this.classList.remove('active-reader-mode');
            }
        });
    </script>
@endpush
