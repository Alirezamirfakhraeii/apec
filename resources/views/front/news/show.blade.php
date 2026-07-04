@extends('front.layouts.master')

@section('content')

    <style>
        .category-news-page {
            direction: rtl;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 35%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 46%, #f8fafc 100%);
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .category-news-hero {
            position: relative;
            padding: 78px 0 56px;
            margin-bottom: 36px;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.94));
            color: #fff;
        }

        .category-news-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 18%, rgba(245, 158, 11, 0.18), transparent 28%),
                radial-gradient(circle at 80% 5%, rgba(37, 99, 235, 0.18), transparent 32%);
            pointer-events: none;
        }

        .category-news-hero-inner {
            position: relative;
            z-index: 2;
        }

        .category-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-bottom: 18px;
            color: #cbd5e1;
            font-size: 13px;
        }

        .category-breadcrumb a {
            color: #bfdbfe;
            text-decoration: none;
        }

        .category-breadcrumb i {
            font-size: 10px;
            color: #64748b;
        }

        .category-news-hero h1 {
            font-size: 38px;
            font-weight: 900;
            line-height: 1.45;
            color: #fff;
            margin-bottom: 12px;
        }

        .category-news-hero p {
            max-width: 720px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 2;
            margin-bottom: 22px;
        }

        .category-hero-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .category-hero-meta span {
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

        .category-section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
            padding: 18px 20px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
        }

        .category-section-head h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
        }

        .category-section-head a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
        }

        .featured-news-card {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 0;
            overflow: hidden;
            margin-bottom: 28px;
            border-radius: 32px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.10);
        }

        .featured-news-media {
            position: relative;
            min-height: 430px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .featured-news-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.4s ease;
        }

        .featured-news-card:hover .featured-news-media img {
            transform: scale(1.04);
        }

        .featured-news-media::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 45%, rgba(15, 23, 42, 0.72));
        }

        .featured-badge {
            position: absolute;
            right: 18px;
            top: 18px;
            z-index: 2;
            padding: 7px 13px;
            border-radius: 999px;
            background: rgba(15, 23, 42, 0.78);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            backdrop-filter: blur(8px);
        }

        .featured-news-content {
            padding: 34px 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .featured-news-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 7px 12px;
            margin-bottom: 15px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 800;
        }

        .featured-news-title {
            display: block;
            color: #0f172a;
            font-size: 25px;
            font-weight: 950;
            line-height: 1.75;
            margin-bottom: 14px;
            text-decoration: none;
        }

        .featured-news-title:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .featured-news-summary {
            color: #64748b;
            font-size: 14px;
            line-height: 2.1;
            margin-bottom: 20px;
        }

        .featured-news-meta {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 24px;
        }

        .featured-news-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .featured-news-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: fit-content;
            padding: 12px 18px;
            border-radius: 16px;
            background: #0f172a;
            color: #fff;
            font-size: 13px;
            font-weight: 850;
            text-decoration: none;
            transition: 0.25s ease;
        }

        .featured-news-btn:hover {
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .news-list-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .compact-news-card {
            display: grid;
            grid-template-columns: 185px 1fr;
            overflow: hidden;
            min-height: 178px;
            border-radius: 24px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
            transition: all 0.28s ease;
        }

        .compact-news-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.11);
            border-color: rgba(37, 99, 235, 0.30);
        }

        .compact-news-image {
            position: relative;
            height: 100%;
            min-height: 178px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .compact-news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
            transition: transform 0.32s ease;
        }

        .compact-news-card:hover .compact-news-image img {
            transform: scale(1.06);
        }

        .compact-news-content {
            padding: 18px 18px 16px;
            display: flex;
            flex-direction: column;
        }

        .compact-news-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 11px;
            margin-bottom: 9px;
        }

        .compact-news-title {
            color: #0f172a;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.8;
            text-decoration: none;
            margin-bottom: 8px;
        }

        .compact-news-title:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .compact-news-summary {
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 14px;
            flex: 1;
        }

        .compact-news-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        .compact-news-footer span {
            font-size: 11px;
            color: #94a3b8;
        }

        .compact-news-footer a {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #2563eb;
            font-size: 12px;
            font-weight: 850;
            text-decoration: none;
        }

        .news-empty-box {
            background: #fff;
            border: 1px dashed #cbd5e1;
            border-radius: 28px;
            padding: 62px 24px;
            text-align: center;
            color: #64748b;
        }

        .news-empty-box i {
            font-size: 46px;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .news-empty-box h3 {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .news-empty-box p {
            font-size: 13px;
            margin: 0;
        }

        .news-pagination-wrapper {
            margin-top: 34px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 1199px) {
            .featured-news-card {
                grid-template-columns: 1fr;
            }

            .featured-news-media {
                min-height: 360px;
            }
        }

        @media (max-width: 991px) {
            .news-list-grid {
                grid-template-columns: 1fr;
            }

            .category-news-hero h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 575px) {
            .category-news-hero {
                padding: 58px 0 44px;
                margin-bottom: 26px;
            }

            .category-news-hero h1 {
                font-size: 24px;
            }

            .category-section-head {
                flex-direction: column;
                align-items: flex-start;
                border-radius: 20px;
            }

            .featured-news-card {
                border-radius: 24px;
            }

            .featured-news-media {
                min-height: 245px;
            }

            .featured-news-content {
                padding: 24px 20px;
            }

            .featured-news-title {
                font-size: 20px;
            }

            .compact-news-card {
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .compact-news-image {
                height: 210px;
            }
        }
    </style>

    <section class="category-news-page">

        <div class="category-news-hero">
            <div class="container">
                <div class="category-news-hero-inner">

                    <div class="category-breadcrumb">
                        <a href="{{ route('front.news.index') }}">اخبار</a>
                        <i class="fa fa-chevron-left"></i>
                        <span>{{ $blogCategory->title ?? $blogCategory->name }}</span>
                    </div>

                    <h1>{{ $blogCategory->title ?? $blogCategory->name }}</h1>

                    @if(!empty($blogCategory->description))
                        <p>{{ $blogCategory->description }}</p>
                    @else
                        <p>
                            آخرین خبرها، گزارش‌ها، تحلیل‌ها و روایت‌های مهم مربوط به {{ $blogCategory->title ?? $blogCategory->name }} را اینجا دنبال کنید.
                        </p>
                    @endif

                    <div class="category-hero-meta">
                    <span>
                        <i class="fa fa-newspaper"></i>
                        {{ $posts->total() }} خبر منتشر شده
                    </span>

                        <span>
                        <i class="fa fa-bolt"></i>
                        پوشش سریع اخبار
                    </span>

                        <span>
                        <i class="fa fa-layer-group"></i>
                        سرویس {{ $blogCategory->title ?? $blogCategory->name }}
                    </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">

            <div class="category-section-head">
                <h2>آخرین مطالب این سرویس</h2>

                <a href="{{ route('front.news.index') }}">
                    همه سرویس‌های خبری
                    <i class="fa fa-arrow-left"></i>
                </a>
            </div>

            @if($posts->count())

                @php
                    $featuredPost = $posts->first();
                    $otherPosts = $posts->skip(1);

                    $featuredImage = $featuredPost->main_image_url
                        ?? ($featuredPost->image ? asset('storage/' . $featuredPost->image) : asset('front/images/default-news.jpg'));

                    $featuredSummary = $featuredPost->summary
                        ?? $featuredPost->excerpt
                        ?? strip_tags($featuredPost->body ?? '');
                @endphp

                <article class="featured-news-card">
                    <a href="{{ route('front.posts.show', $featuredPost->slug) }}" class="featured-news-media">
                        <img src="{{ $featuredImage }}" alt="{{ $featuredPost->title }}">

                        <span class="featured-badge">
                        خبر شاخص
                    </span>
                    </a>

                    <div class="featured-news-content">
                    <span class="featured-news-kicker">
                        <i class="fa fa-star"></i>
                        تازه‌ترین خبر مهم
                    </span>

                        <a href="{{ route('front.posts.show', $featuredPost->slug) }}" class="featured-news-title">
                            {{ $featuredPost->title }}
                        </a>

                        <p class="featured-news-summary">
                            {{ Str::limit($featuredSummary, 210) }}
                        </p>

                        <div class="featured-news-meta">
                        <span>
                            <i class="fa fa-calendar-alt"></i>
                            {{ $featuredPost->published_at ? $featuredPost->published_at->format('Y/m/d') : 'بدون تاریخ انتشار' }}
                        </span>

                            <span>
                            <i class="fa fa-folder"></i>
                            {{ $blogCategory->title ?? $blogCategory->name }}
                        </span>
                        </div>

                        <a href="{{ route('front.posts.show', $featuredPost->slug) }}" class="featured-news-btn">
                            مطالعه کامل خبر
                            <i class="fa fa-chevron-left"></i>
                        </a>
                    </div>
                </article>

                @if($otherPosts->count())
                    <div class="news-list-grid">
                        @foreach($otherPosts as $post)

                            @php
                                $postImage = $post->main_image_url
                                    ?? ($post->image ? asset('storage/' . $post->image) : asset('front/images/default-news.jpg'));

                                $postSummary = $post->summary
                                    ?? $post->excerpt
                                    ?? strip_tags($post->body ?? '');
                            @endphp

                            <article class="compact-news-card">

                                <a href="{{ route('front.posts.show', $post->slug) }}" class="compact-news-image">
                                    <img src="{{ $postImage }}" alt="{{ $post->title }}">
                                </a>

                                <div class="compact-news-content">

                                    <div class="compact-news-meta">
                                        <i class="fa fa-calendar-alt"></i>
                                        <span>
                                        {{ $post->published_at ? $post->published_at->format('Y/m/d') : 'بدون تاریخ' }}
                                    </span>
                                    </div>

                                    <a href="{{ route('front.posts.show', $post->slug) }}" class="compact-news-title">
                                        {{ Str::limit($post->title, 78) }}
                                    </a>

                                    <p class="compact-news-summary">
                                        {{ Str::limit($postSummary, 105) }}
                                    </p>

                                    <div class="compact-news-footer">
                                        <span>{{ $blogCategory->title ?? $blogCategory->name }}</span>

                                        <a href="{{ route('front.posts.show', $post->slug) }}">
                                            ادامه خبر
                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </div>

                                </div>

                            </article>

                        @endforeach
                    </div>
                @endif

                <div class="news-pagination-wrapper">
                    {{ $posts->links() }}
                </div>

            @else

                <div class="news-empty-box">
                    <i class="fa fa-folder-open"></i>
                    <h3>هنوز خبری در این سرویس منتشر نشده است</h3>
                    <p>به‌محض انتشار اولین خبر، مطالب این دسته در همین صفحه نمایش داده می‌شوند.</p>
                </div>

            @endif

        </div>

    </section>

@endsection
