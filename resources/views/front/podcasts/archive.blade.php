@extends('front.layouts.master')

@section('content')

    <style>
        .podcast-archive-page {
            direction: rtl;
            min-height: 100vh;
            padding-bottom: 80px;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 34%),
                radial-gradient(circle at 12% 10%, rgba(245, 158, 11, 0.10), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 48%, #f8fafc 100%);
        }

        .podcast-archive-hero {
            position: relative;
            padding: 86px 0 64px;
            margin-bottom: 34px;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.94));
            color: #fff;
        }

        .podcast-archive-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 18% 20%, rgba(245, 158, 11, 0.20), transparent 28%),
                radial-gradient(circle at 85% 0%, rgba(37, 99, 235, 0.20), transparent 34%);
            pointer-events: none;
        }

        .podcast-archive-hero-inner {
            position: relative;
            z-index: 2;
            max-width: 780px;
        }

        .podcast-archive-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 15px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.16);
            color: #bfdbfe;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .podcast-archive-hero h1 {
            font-size: 40px;
            font-weight: 950;
            line-height: 1.45;
            color: #fff;
            margin-bottom: 14px;
        }

        .podcast-archive-hero p {
            max-width: 680px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 2;
            margin-bottom: 22px;
        }

        .podcast-archive-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .podcast-archive-meta span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,0.09);
            color: #e2e8f0;
            font-size: 12px;
            border: 1px solid rgba(255,255,255,0.08);
        }

        .podcast-filter-box {
            margin-bottom: 24px;
            padding: 18px 20px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
        }

        .podcast-filter-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 16px;
        }

        .podcast-filter-head h2 {
            margin: 0;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
        }

        .podcast-filter-head span {
            color: #64748b;
            font-size: 12px;
        }

        .podcast-category-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .podcast-category-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 999px;
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: 0.22s ease;
        }

        .podcast-category-pill:hover,
        .podcast-category-pill.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .podcast-category-pill small {
            font-size: 10px;
            opacity: 0.75;
        }

        .podcast-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .podcast-card {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
            transition: all 0.28s ease;
        }

        .podcast-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 28px 75px rgba(15, 23, 42, 0.13);
            border-color: rgba(37, 99, 235, 0.32);
        }

        .podcast-card-cover {
            position: relative;
            height: 230px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .podcast-card-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.35s ease;
        }

        .podcast-card:hover .podcast-card-cover img {
            transform: scale(1.06);
        }

        .podcast-card-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 45%, rgba(15, 23, 42, 0.72));
        }

        .podcast-play-mark {
            position: absolute;
            z-index: 2;
            right: 18px;
            bottom: 18px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: #fff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.25);
        }

        .podcast-category-badge {
            position: absolute;
            z-index: 2;
            right: 16px;
            top: 16px;
            padding: 6px 11px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.78);
            color: #fff;
            backdrop-filter: blur(8px);
            font-size: 11px;
            font-weight: 800;
        }

        .podcast-card-body {
            padding: 20px 20px 19px;
        }

        .podcast-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 11px;
            color: #64748b;
            font-size: 11px;
        }

        .podcast-card-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .podcast-card-title {
            display: block;
            color: #0f172a;
            font-size: 17px;
            font-weight: 950;
            line-height: 1.75;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .podcast-card-title:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .podcast-card-summary {
            min-height: 54px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 16px;
        }

        .podcast-card-player {
            padding: 10px;
            border-radius: 18px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            margin-bottom: 15px;
        }

        .podcast-card-player audio {
            width: 100%;
            height: 38px;
            display: block;
        }

        .podcast-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
        }

        .podcast-card-footer a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #2563eb;
            font-size: 12px;
            font-weight: 850;
            text-decoration: none;
        }

        .podcast-card-footer a:hover {
            color: #1d4ed8;
            text-decoration: none;
        }

        .podcast-card-footer .podcast-status {
            color: #94a3b8;
            font-size: 11px;
        }

        .podcast-empty-box {
            background: #fff;
            border: 1px dashed #cbd5e1;
            border-radius: 28px;
            padding: 62px 24px;
            text-align: center;
            color: #64748b;
        }

        .podcast-empty-box i {
            font-size: 46px;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .podcast-empty-box h3 {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .podcast-empty-box p {
            font-size: 13px;
            margin: 0;
        }

        .podcast-pagination-wrapper {
            margin-top: 34px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .podcast-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .podcast-archive-hero h1 {
                font-size: 31px;
            }
        }

        @media (max-width: 575px) {
            .podcast-archive-hero {
                padding: 60px 0 48px;
                margin-bottom: 26px;
            }

            .podcast-archive-hero h1 {
                font-size: 25px;
            }

            .podcast-filter-head {
                flex-direction: column;
                align-items: flex-start;
            }

            .podcast-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .podcast-card {
                border-radius: 22px;
            }

            .podcast-card-cover {
                height: 215px;
            }
        }
    </style>

    <section class="podcast-archive-page">

        <div class="podcast-archive-hero">
            <div class="container">
                <div class="podcast-archive-hero-inner">
                <span class="podcast-archive-label">
                    <i class="fa fa-podcast"></i>
                    آرشیو صوتی
                </span>

                    <h1>آرشیو پادکست‌ها</h1>

                    <p>
                        مجموعه‌ای از تازه‌ترین پادکست‌ها، گفت‌وگوها، روایت‌ها و تحلیل‌های صوتی را در این بخش دنبال کنید.
                    </p>

                    <div class="podcast-archive-meta">
                    <span>
                        <i class="fa fa-headphones"></i>
                        {{ $podcasts->total() }} پادکست منتشر شده
                    </span>

                        <span>
                        <i class="fa fa-layer-group"></i>
                        {{ $categories->count() }} دسته‌بندی فعال
                    </span>

                        <span>
                        <i class="fa fa-clock"></i>
                        قابل پخش آنلاین
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            <div class="podcast-filter-box">
                <div class="podcast-filter-head">
                    <h2>
                        @if($activeCategory)
                            پادکست‌های {{ $activeCategory->title }}
                        @else
                            همه پادکست‌ها
                        @endif
                    </h2>

                    <span>برای مشاهده آرشیو هر موضوع، دسته‌بندی را انتخاب کنید.</span>
                </div>

                <div class="podcast-category-pills">


                    @foreach($categories as $category)
                        <a href="{{ route('front.podcasts.archive', ['category' => $category->slug]) }}"
                           class="podcast-category-pill {{ $activeCategory && $activeCategory->id === $category->id ? 'active' : '' }}">
                            {{ $category->title }}
                            <small>{{ $category->published_podcasts_count }}</small>
                        </a>
                    @endforeach
                </div>
            </div>

            @if($podcasts->count())
                <div class="podcast-grid">
                    @foreach($podcasts as $podcast)

                        @php
                            $podcastImage = $podcast->image
                                ? asset('storage/' . $podcast->image)
                                : asset('front/images/default-podcast.jpg');

                            $audioUrl = $podcast->audio_url
                                ? asset('storage/' . $podcast->audio_url)
                                : null;
                        @endphp

                        <article class="podcast-card">
                            <div class="podcast-card-cover">
                                <img src="{{ $podcastImage }}" alt="{{ $podcast->title }}">

                                <span class="podcast-category-badge">
                                {{ $podcast->category->name ?? 'پادکست' }}
                            </span>

                                <span class="podcast-play-mark">
                                <i class="fa fa-play"></i>
                            </span>
                            </div>

                            <div class="podcast-card-body">
                                <div class="podcast-card-meta">
                                <span>
                                    <i class="fa fa-calendar-alt"></i>
                                    {{ $podcast->published_at ? $podcast->published_at->format('Y/m/d') : 'بدون تاریخ' }}
                                </span>

                                    @if($podcast->duration)
                                        <span>
                                        <i class="fa fa-clock"></i>
                                        {{ $podcast->duration }}
                                    </span>
                                    @endif
                                </div>

                                <a href="#" class="podcast-card-title">
                                    {{ $podcast->title }}
                                </a>

                                <p class="podcast-card-summary">
                                    {{ Str::limit($podcast->summary ?? '', 120) }}
                                </p>

                                @if($audioUrl)
                                    <div class="podcast-card-player">
                                        <audio controls preload="none">
                                            <source src="{{ $audioUrl }}" type="audio/mpeg">
                                            مرورگر شما از پخش فایل صوتی پشتیبانی نمی‌کند.
                                        </audio>
                                    </div>
                                @endif

                                <div class="podcast-card-footer">
                                    <span class="podcast-status">منتشر شده</span>

                                    @if($audioUrl)
                                        <a href="{{ $audioUrl }}" target="_blank">
                                            باز کردن فایل صوتی
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    @else
                                        <a href="#">
                                            مشاهده جزئیات
                                            <i class="fa fa-arrow-left"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </article>

                    @endforeach
                </div>

                <div class="podcast-pagination-wrapper">
                    {{ $podcasts->links() }}
                </div>
            @else
                <div class="podcast-empty-box">
                    <i class="fa fa-podcast"></i>
                    <h3>هنوز پادکستی منتشر نشده است</h3>
                    <p>بعد از انتشار پادکست‌ها، آرشیو صوتی در همین بخش نمایش داده می‌شود.</p>
                </div>
            @endif

        </div>

    </section>

@endsection
