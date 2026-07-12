@extends('front.layouts.master')

@section('content')

    @php
        $page = $page ?? null;
        $members = $members ?? collect();

        $pageTitle = $page->title ?? 'هیئت مدیره';

        $pageDescription = null;

        if (!empty($page?->body)) {
            $pageDescription = strip_tags($page->body);
        } elseif (!empty($page?->content)) {
            $pageDescription = strip_tags($page->content);
        }

        if (empty($pageDescription)) {
            $pageDescription = 'در این بخش، اعضای هیئت مدیره، سمت‌ها و اطلاعات ارتباطی رسمی آن‌ها معرفی می‌شوند.';
        }
    @endphp

    <style>
        .board-directors-page {
            direction: rtl;
            background:
                radial-gradient(circle at top right, rgba(37, 99, 235, 0.08), transparent 35%),
                linear-gradient(180deg, #f8fafc 0%, #ffffff 46%, #f8fafc 100%);
            min-height: 100vh;
            padding-bottom: 80px;
        }

        .board-directors-hero {
            position: relative;
            padding: 78px 0 56px;
            margin-bottom: 36px;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(15, 23, 42, 0.98), rgba(30, 41, 59, 0.94));
            color: #fff;
        }

        .board-directors-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 15% 18%, rgba(245, 158, 11, 0.18), transparent 28%),
                radial-gradient(circle at 80% 5%, rgba(37, 99, 235, 0.18), transparent 32%);
            pointer-events: none;
        }

        .board-directors-hero-inner {
            position: relative;
            z-index: 2;
        }

        .board-breadcrumb {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
            margin-bottom: 18px;
            color: #cbd5e1;
            font-size: 13px;
        }

        .board-breadcrumb a {
            color: #bfdbfe;
            text-decoration: none;
        }

        .board-breadcrumb a:hover {
            color: #ffffff;
            text-decoration: none;
        }

        .board-breadcrumb i {
            font-size: 10px;
            color: #64748b;
        }

        .board-directors-hero h1 {
            font-size: 38px;
            font-weight: 900;
            line-height: 1.45;
            color: #fff;
            margin-bottom: 12px;
        }

        .board-directors-hero p {
            max-width: 760px;
            color: #cbd5e1;
            font-size: 14px;
            line-height: 2;
            margin-bottom: 22px;
        }

        .board-hero-meta {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .board-hero-meta span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.09);
            color: #e2e8f0;
            font-size: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .board-section-head {
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

        .board-section-head h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
        }

        .board-section-head span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
        }

        .board-directors-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .board-director-card {
            overflow: hidden;
            border-radius: 28px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.06);
            transition: all 0.28s ease;
            height: 100%;
        }

        .board-director-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.11);
            border-color: rgba(37, 99, 235, 0.30);
        }

        .board-director-media {
            position: relative;
            height: 310px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .board-director-media img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            display: block;
            transition: transform 0.35s ease;
        }

        .board-director-card:hover .board-director-media img {
            transform: scale(1.05);
        }

        .board-director-media::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 52%, rgba(15, 23, 42, 0.72));
        }

        .board-director-empty-media {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            color: #94a3b8;
            font-size: 62px;
        }

        .board-director-badge {
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

        .board-director-name-overlay {
            position: absolute;
            right: 20px;
            left: 20px;
            bottom: 18px;
            z-index: 2;
        }

        .board-director-name-overlay h3 {
            color: #ffffff;
            font-size: 20px;
            font-weight: 950;
            line-height: 1.6;
            margin: 0;
        }

        .board-director-content {
            padding: 22px 22px 20px;
        }

        .board-director-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            padding: 7px 12px;
            margin-bottom: 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 800;
        }

        .board-director-roles {
            list-style: none;
            padding: 0;
            margin: 0 0 18px;
        }

        .board-director-roles li {
            position: relative;
            color: #0f172a;
            font-size: 13px;
            font-weight: 850;
            line-height: 2;
            padding-right: 16px;
            margin-bottom: 6px;
        }

        .board-director-roles li::before {
            content: "";
            position: absolute;
            right: 0;
            top: 13px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2563eb;
        }

        .board-director-description {
            color: #64748b;
            font-size: 13px;
            line-height: 2;
            margin-bottom: 18px;
        }

        .board-director-contact {
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
        }

        .board-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
            margin-bottom: 10px;
            word-break: break-word;
        }

        .board-contact-item i {
            width: 30px;
            min-width: 30px;
            height: 30px;
            border-radius: 11px;
            background: #f1f5f9;
            color: #2563eb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-top: 1px;
        }

        .board-contact-item a,
        .board-contact-item span {
            color: #64748b;
            text-decoration: none;
        }

        .board-contact-item a:hover {
            color: #2563eb;
            text-decoration: none;
        }

        .board-empty-box {
            background: #fff;
            border: 1px dashed #cbd5e1;
            border-radius: 28px;
            padding: 62px 24px;
            text-align: center;
            color: #64748b;
        }

        .board-empty-box i {
            font-size: 46px;
            color: #94a3b8;
            margin-bottom: 16px;
        }

        .board-empty-box h3 {
            font-size: 20px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .board-empty-box p {
            font-size: 13px;
            margin: 0;
        }

        @media (max-width: 1199px) {
            .board-directors-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .board-director-media {
                height: 290px;
            }
        }

        @media (max-width: 991px) {
            .board-directors-hero h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 575px) {
            .board-directors-hero {
                padding: 58px 0 44px;
                margin-bottom: 26px;
            }

            .board-directors-hero h1 {
                font-size: 24px;
            }

            .board-section-head {
                flex-direction: column;
                align-items: flex-start;
                border-radius: 20px;
            }

            .board-directors-grid {
                grid-template-columns: 1fr;
            }

            .board-director-card {
                border-radius: 24px;
            }

            .board-director-media {
                height: 260px;
            }

            .board-director-content {
                padding: 20px;
            }
        }
    </style>

    <section class="board-directors-page">

        <div class="board-directors-hero">
            <div class="container">
                <div class="board-directors-hero-inner">

                    <div class="board-breadcrumb">
                        <a href="{{ route('home') }}">خانه</a>
                        <i class="fa fa-chevron-left"></i>
                        <span>{{ $pageTitle }}</span>
                    </div>

                    <h1>{{ $pageTitle }}</h1>

                    <p>
                        {{ $pageDescription }}
                    </p>

                    <div class="board-hero-meta">
                        <span>
                            <i class="fa fa-users"></i>
                            {{ $members->count() }} عضو فعال
                        </span>

                        <span>
                            <i class="fa fa-id-card"></i>
                            معرفی رسمی اعضا
                        </span>

                        <span>
                            <i class="fa fa-layer-group"></i>
                            صفحه سازمانی
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">

            <div class="board-section-head">
                <h2>اعضای هیئت مدیره</h2>

                <span>
                    اطلاعات رسمی و راه‌های ارتباطی
                    <i class="fa fa-arrow-left"></i>
                </span>
            </div>

            @if($members->count())

                <div class="board-directors-grid">
                    @foreach($members as $member)

                        <article class="board-director-card">

                            <div class="board-director-media">
                                @if($member->image)
                                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                                @else
                                    <div class="board-director-empty-media">
                                        <i class="fa fa-user"></i>
                                    </div>
                                @endif

                                <span class="board-director-badge">
                                    عضو هیئت مدیره
                                </span>

                                <div class="board-director-name-overlay">
                                    <h3>{{ $member->name }}</h3>
                                </div>
                            </div>

                            <div class="board-director-content">

                                @if(!empty($member->roles))
                                    <span class="board-director-kicker">
                                        <i class="fa fa-star"></i>
                                        سمت‌ها و مسئولیت‌ها
                                    </span>

                                    <ul class="board-director-roles">
                                        @foreach((array) $member->roles as $role)
                                            <li>{{ $role }}</li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if($member->description)
                                    <div class="board-director-description">
                                        {{ \Illuminate\Support\Str::limit($member->description, 180) }}
                                    </div>
                                @endif

                                <div class="board-director-contact">

                                    @if($member->email)
                                        <div class="board-contact-item">
                                            <i class="fa fa-envelope"></i>
                                            <a href="mailto:{{ $member->email }}">
                                                {{ $member->email }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($member->phone)
                                        <div class="board-contact-item">
                                            <i class="fa fa-phone"></i>
                                            <a href="tel:{{ $member->phone }}">
                                                {{ $member->phone }}
                                            </a>
                                        </div>
                                    @endif

                                    @if($member->fax)
                                        <div class="board-contact-item">
                                            <i class="fa fa-fax"></i>
                                            <span>{{ $member->fax }}</span>
                                        </div>
                                    @endif

                                    @if($member->address)
                                        <div class="board-contact-item">
                                            <i class="fa fa-map-marker"></i>
                                            <span>{{ $member->address }}</span>
                                        </div>
                                    @endif

                                    @if($member->postal_code)
                                        <div class="board-contact-item mb-0">
                                            <i class="fa fa-envelope-open"></i>
                                            <span>کد پستی: {{ $member->postal_code }}</span>
                                        </div>
                                    @endif

                                </div>

                            </div>

                        </article>

                    @endforeach
                </div>

            @else

                <div class="board-empty-box">
                    <i class="fa fa-users"></i>
                    <h3>هنوز عضوی ثبت نشده است</h3>
                    <p>پس از ثبت اعضا در پنل مدیریت، اطلاعات آن‌ها در این صفحه نمایش داده می‌شود.</p>
                </div>

            @endif

        </div>

    </section>

@endsection
