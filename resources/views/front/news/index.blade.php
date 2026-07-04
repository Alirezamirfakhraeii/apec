@extends('front.layouts.master')

@section('content')

    <section class="news-services-page">

        <div class="news-services-hero">
            <div class="container">
                <div class="news-services-hero-content">
                    <span class="news-services-label">مرکز اخبار</span>

                    <h1>سرویس‌های خبری</h1>

                    <p>
                        از میان دسته‌بندی‌های خبری، موضوع مورد علاقه خود را انتخاب کنید و تازه‌ترین خبرها، گزارش‌ها و تحلیل‌ها را دنبال کنید.
                    </p>

                    <div class="news-services-info">
                    <span>
                        <i class="fa fa-newspaper"></i>
                        {{ $categories->count() }} سرویس خبری
                    </span>

                        <span>
                        <i class="fa fa-clock"></i>
                        به‌روزرسانی لحظه‌ای
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">

            @if($categories->count())
                <div class="news-services-grid">
                    @foreach($categories as $category)
                        <a href="{{ route('front.news.show', $category->slug) }}" class="news-service-card">

                            <div class="news-service-glow"></div>

                            <div class="news-service-card-header">
                                <div class="news-service-icon">
                                    <i class="fa fa-layer-group"></i>
                                </div>

                                <div class="news-service-count">
                                    {{ $category->published_posts_count ?? 0 }}
                                    <small>خبر</small>
                                </div>
                            </div>

                            <div class="news-service-content">
                                <h2>{{ $category->title ?? $category->name }}</h2>

                                @if(!empty($category->description))
                                    <p>{{ Str::limit($category->description, 120) }}</p>
                                @else
                                    <p>
                                        تازه‌ترین اخبار و گزارش‌های مربوط به {{ $category->title ?? $category->name }} را در این بخش دنبال کنید.
                                    </p>
                                @endif
                            </div>

                            <div class="news-service-footer">
                                <span>ورود به سرویس</span>
                                <i class="fa fa-arrow-left"></i>
                            </div>

                        </a>
                    @endforeach
                </div>
            @else
                <div class="news-services-empty">
                    <i class="fa fa-folder-open"></i>
                    <h3>هنوز دسته‌بندی خبری ثبت نشده است</h3>
                    <p>بعد از ثبت دسته‌بندی‌ها، این صفحه به‌صورت خودکار پر می‌شود.</p>
                </div>
            @endif

        </div>

    </section>

    <style>
        .news-services-page {
            direction: rtl;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.10), transparent 34%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 54%, #f8fafc 100%);
            padding-bottom: 70px;
        }

        .news-services-hero {
            position: relative;
            padding: 90px 0 76px;
            margin-bottom: 44px;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.97), rgba(30, 41, 59, 0.92)),
                url('/front/images/news-bg.jpg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        .news-services-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(245, 158, 11, 0.20), transparent 28%),
                linear-gradient(90deg, rgba(37, 99, 235, 0.17), transparent);
        }

        .news-services-hero-content {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }

        .news-services-label {
            display: inline-flex;
            padding: 7px 15px;
            border-radius: 999px;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.16);
            color: #bfdbfe;
            font-size: 13px;
            margin-bottom: 18px;
        }

        .news-services-hero h1 {
            font-size: 40px;
            font-weight: 900;
            line-height: 1.4;
            margin-bottom: 15px;
            color: #fff;
        }

        .news-services-hero p {
            max-width: 650px;
            font-size: 15px;
            line-height: 2;
            color: #cbd5e1;
            margin-bottom: 24px;
        }

        .news-services-info {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .news-services-info span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,0.09);
            color: #e2e8f0;
            font-size: 13px;
        }

        .news-services-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .news-service-card {
            position: relative;
            overflow: hidden;
            min-height: 255px;
            padding: 24px;
            border-radius: 28px;
            background: #fff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
            color: #0f172a;
            text-decoration: none;
            transition: all 0.28s ease;
        }

        .news-service-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 28px 75px rgba(15, 23, 42, 0.14);
            border-color: rgba(37, 99, 235, 0.34);
            color: #0f172a;
            text-decoration: none;
        }

        .news-service-glow {
            position: absolute;
            width: 175px;
            height: 175px;
            left: -70px;
            top: -70px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.13), rgba(245, 158, 11, 0.11));
            transition: 0.28s ease;
        }

        .news-service-card:hover .news-service-glow {
            transform: scale(1.18);
        }

        .news-service-card-header {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .news-service-icon {
            width: 58px;
            height: 58px;
            border-radius: 20px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .news-service-count {
            min-width: 68px;
            padding: 8px 10px;
            border-radius: 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
            text-align: center;
        }

        .news-service-count small {
            display: block;
            margin-top: 2px;
            font-size: 11px;
            font-weight: 500;
            color: #64748b;
        }

        .news-service-content {
            position: relative;
            z-index: 2;
        }

        .news-service-content h2 {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 12px;
            color: #0f172a;
        }

        .news-service-content p {
            min-height: 62px;
            font-size: 13px;
            line-height: 1.95;
            color: #64748b;
            margin-bottom: 20px;
        }

        .news-service-footer {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 17px;
            border-top: 1px solid #f1f5f9;
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
        }

        .news-service-footer i {
            transition: 0.25s ease;
        }

        .news-service-card:hover .news-service-footer i {
            transform: translateX(-5px);
        }

        .news-services-empty {
            background: #fff;
            border: 1px dashed #cbd5e1;
            border-radius: 28px;
            padding: 60px 24px;
            text-align: center;
            color: #64748b;
        }

        .news-services-empty i {
            font-size: 46px;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .news-services-empty h3 {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .news-services-empty p {
            font-size: 13px;
            margin-bottom: 0;
        }

        @media (max-width: 991px) {
            .news-services-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .news-services-hero h1 {
                font-size: 31px;
            }
        }

        @media (max-width: 575px) {
            .news-services-hero {
                padding: 62px 0 52px;
                margin-bottom: 28px;
            }

            .news-services-hero h1 {
                font-size: 25px;
            }

            .news-services-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }

            .news-service-card {
                border-radius: 22px;
                padding: 20px;
            }
        }
    </style>

@endsection
