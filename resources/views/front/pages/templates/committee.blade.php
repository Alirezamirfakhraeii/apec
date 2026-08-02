@extends('front.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@push('styles')
    <link rel="stylesheet"
          href="{{ asset('front/css/pages/committee.css') }}">

    <style>
        /*
        |--------------------------------------------------------------------------
        | قائم‌مقام‌ها
        |--------------------------------------------------------------------------
        */

        .committee-deputies-wrapper {
            display: grid;
            gap: 18px;
            margin-top: 18px;
        }

        .deputy-profile-card {
            position: static !important;
            top: auto !important;
            width: 100%;
            margin: 0;
        }

        .deputy-profile-card .avatar-frame-box {
            margin-bottom: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | کارگروه‌ها
        |--------------------------------------------------------------------------
        */

        .committee-workgroups-section {
            padding: 65px 0 75px;
            background: linear-gradient(
                180deg,
                #f8fafc 0%,
                #f1f5f9 100%
            );
        }

        .committee-workgroups-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 25px;
        }

        .committee-workgroups-heading-main {
            min-width: 0;
        }

        .committee-workgroups-eyebrow {
            display: block;
            margin-bottom: 5px;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
        }

        .committee-workgroups-heading h2 {
            margin: 0;
            color: #0f172a;
            font-size: 27px;
            font-weight: 900;
            line-height: 1.7;
        }

        .committee-workgroups-heading p {
            max-width: 650px;
            margin: 5px 0 0;
            color: #64748b;
            font-size: 12px;
            line-height: 2;
        }

        .committee-workgroups-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
            padding: 7px 12px;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 800;
        }

        .committee-workgroups-count strong {
            color: #0f172a;
            font-size: 15px;
        }

        .committee-workgroups-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .committee-workgroup-card {
            display: grid;
            grid-template-columns: 165px minmax(0, 1fr);
            overflow: hidden;
            height: 175px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 7px 22px rgba(15, 23, 42, 0.055);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .committee-workgroup-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.1);
            transform: translateY(-3px);
        }

        .committee-workgroup-image {
            position: relative;
            height: 175px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .committee-workgroup-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .committee-workgroup-card:hover .committee-workgroup-image img {
            transform: scale(1.045);
        }

        .committee-workgroup-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            color: #94a3b8;
            background: linear-gradient(
                135deg,
                #f1f5f9,
                #e2e8f0
            );
        }

        .committee-workgroup-placeholder svg {
            width: 45px;
            height: 45px;
        }

        .committee-workgroup-number {
            position: absolute;
            right: 10px;
            bottom: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            color: #ffffff;
            background: rgba(15, 23, 42, 0.86);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9px;
            backdrop-filter: blur(7px);
            font-size: 10px;
            font-weight: 900;
        }

        .committee-workgroup-content {
            display: flex;
            justify-content: center;
            flex-direction: column;
            min-width: 0;
            padding: 15px 18px;
        }

        .committee-workgroup-topline {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 9px;
            font-weight: 800;
        }

        .committee-workgroup-topline::before {
            width: 13px;
            height: 2px;
            content: "";
            background: #475569;
            border-radius: 10px;
        }

        .committee-workgroup-title {
            display: -webkit-box;
            overflow: hidden;
            margin: 0;
            color: #0f172a;
            font-size: 15px;
            font-weight: 900;
            line-height: 1.8;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .committee-workgroup-description {
            display: -webkit-box;
            overflow: hidden;
            margin-top: 6px;
            color: #64748b;
            font-size: 10px;
            line-height: 1.95;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .committee-workgroups-empty {
            padding: 25px;
            color: #64748b;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 14px;
            text-align: center;
            font-size: 12px;
        }

        /*
        |--------------------------------------------------------------------------
        | محتوای CKEditor
        |--------------------------------------------------------------------------
        */

        .dynamic-wp-content img {
            max-width: 100%;
            height: auto;
            border-radius: 14px;
        }

        .dynamic-wp-content table {
            display: block;
            width: 100%;
            overflow-x: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | واکنش‌گرایی
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {
            .committee-workgroups-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .committee-deputies-wrapper {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .committee-workgroups-section {
                padding: 45px 0 55px;
            }

            .committee-workgroups-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .committee-workgroups-heading h2 {
                font-size: 22px;
            }

            .committee-workgroup-card {
                grid-template-columns: 125px minmax(0, 1fr);
                height: 155px;
            }

            .committee-workgroup-image {
                height: 155px;
            }

            .committee-workgroup-content {
                padding: 12px 14px;
            }

            .committee-workgroup-description {
                -webkit-line-clamp: 2;
            }
        }

        @media (max-width: 576px) {
            .committee-deputies-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .committee-workgroup-card {
                grid-template-columns: 105px minmax(0, 1fr);
                height: 145px;
                border-radius: 13px;
            }

            .committee-workgroup-image {
                height: 145px;
            }

            .committee-workgroup-content {
                padding: 10px 12px;
            }

            .committee-workgroup-title {
                font-size: 13px;
            }

            .committee-workgroup-description {
                font-size: 9px;
                -webkit-line-clamp: 2;
            }

            .committee-workgroup-number {
                right: 7px;
                bottom: 7px;
                width: 29px;
                height: 29px;
                font-size: 9px;
            }
        }
    </style>
@endpush

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | اطلاعات تمپلیت
        |--------------------------------------------------------------------------
        */

        if (is_array($page->template_data)) {
            $pageData = $page->template_data;
        } else {
            $pageData = json_decode(
                $page->template_data ?? '[]',
                true
            ) ?: [];
        }

        /*
        |--------------------------------------------------------------------------
        | ساخت آدرس تصاویر
        |--------------------------------------------------------------------------
        */

        $imageUrl = function ($path) {
            if (blank($path)) {
                return null;
            }

            if (preg_match('/^https?:\/\//i', $path)) {
                return $path;
            }

            $path = ltrim($path, '/');

            if (str_starts_with($path, 'storage/')) {
                return asset($path);
            }

            return asset('storage/' . $path);
        };

        /*
        |--------------------------------------------------------------------------
        | بررسی مقادیر checkbox
        |--------------------------------------------------------------------------
        */

        $isEnabled = function ($value) {
            return in_array(
                $value,
                [
                    1,
                    '1',
                    true,
                    'true',
                    'on',
                    'yes',
                    'بله',
                ],
                true
            );
        };

        /*
        |--------------------------------------------------------------------------
        | اطلاعات اصلی
        |--------------------------------------------------------------------------
        */

        $heroImage = $pageData['header_image'] ?? null;

        $committeeTitle =
            $pageData['committee_title']
            ?? $page->title
            ?? 'کمیته';

        $committeeDescription =
            $pageData['committee_description']
            ?? $page->summary
            ?? null;

        $hasMainContent =
            filled($page->body) ||
            filled($committeeDescription) ||
            filled($pageData['chairman_name'] ?? null) ||
            filled($pageData['chairman_image'] ?? null) ||
            filled($pageData['chairman_position'] ?? null) ||
            filled($pageData['chairman_degree'] ?? null) ||
            filled($pageData['chairman_company'] ?? null) ||
            filled($pageData['chairman_bio'] ?? null);

        /*
        |--------------------------------------------------------------------------
        | قائم‌مقام‌ها
        |--------------------------------------------------------------------------
        */

        $hasDeputies = $isEnabled(
            $pageData['has_deputies'] ?? 0
        );

        $hasSecondDeputy = $isEnabled(
            $pageData['has_second_deputy'] ?? 0
        );

        $deputies = collect();

        if ($hasDeputies) {
            $deputies->push([
                'name' => $pageData['deputy_1_name'] ?? null,
                'image' => $pageData['deputy_1_image'] ?? null,
            ]);

            if ($hasSecondDeputy) {
                $deputies->push([
                    'name' => $pageData['deputy_2_name'] ?? null,
                    'image' => $pageData['deputy_2_image'] ?? null,
                ]);
            }
        }

        $deputies = $deputies
            ->filter(function ($deputy) {
                return
                    filled($deputy['name']) ||
                    filled($deputy['image']);
            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | کارگروه‌ها
        |--------------------------------------------------------------------------
        */

        $hasWorkgroups = $isEnabled(
            $pageData['has_workgroups'] ?? 0
        );

        $workgroups = collect(range(1, 10))
            ->map(function ($number) use ($pageData) {
                return [
                    'number' => $number,

                    'title' =>
                        $pageData["workgroup_{$number}_title"]
                        ?? null,

                    'image' =>
                        $pageData["workgroup_{$number}_image"]
                        ?? null,

                    'description' =>
                        $pageData["workgroup_{$number}_description"]
                        ?? null,
                ];
            })
            ->filter(function ($workgroup) {
                return
                    filled($workgroup['title']) ||
                    filled($workgroup['image']) ||
                    filled($workgroup['description']);
            })
            ->values();
    @endphp

    <main class="premium-committee-wrapper"
          dir="rtl">

        {{-- هدر صفحه --}}
        <section
            class="premium-hero {{ $heroImage ? 'has-bg-image' : '' }}"
            @if($heroImage)
                style="background-image: url('{{ $imageUrl($heroImage) }}');"
            @endif
        >

            <div class="hero-blur-overlay"></div>
            <div class="hero-glow-spot"></div>

            <div class="container hero-container">

                <nav class="premium-breadcrumb"
                     aria-label="breadcrumb">

                    <a href="{{ url('/') }}"
                       class="breadcrumb-link">
                        صفحه اصلی
                    </a>

                    <span class="breadcrumb-separator">
                        /
                    </span>

                    <span class="breadcrumb-current">
                        {{ $committeeTitle }}
                    </span>

                </nav>

                <div class="hero-dynamic-content">

                    <div class="hero-badge">
                        <span class="pulse-dot"></span>
                        کمیته تخصصی
                    </div>

                    <h1 class="hero-main-title">
                        {{ $committeeTitle }}
                    </h1>

                    @if(!empty($page->summary))
                        <p class="hero-summary-text">
                            {{ $page->summary }}
                        </p>
                    @endif

                </div>

            </div>

            <div class="hero-bottom-curve"></div>

        </section>

        {{-- محتوای اصلی --}}
        @if($hasMainContent)

            <section class="main-content-layout">

                <div class="container">

                    <div class="layout-grid-container">

                        {{-- رئیس و قائم‌مقام‌ها --}}
                        <aside class="chairman-sidebar-card">

                            {{-- کارت رئیس کمیته --}}
                            <div class="sticky-card-wrapper">

                                <div class="avatar-frame-box">

                                    @if(!empty($pageData['chairman_image']))

                                        <img
                                            src="{{ $imageUrl($pageData['chairman_image']) }}"
                                            alt="{{ $pageData['chairman_name'] ?? 'رئیس کمیته' }}"
                                            class="chairman-avatar"
                                        >

                                    @else

                                        <div class="avatar-placeholder-svg">

                                            <svg viewBox="0 0 24 24"
                                                 fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">

                                                <circle
                                                    cx="12"
                                                    cy="8"
                                                    r="5"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                />

                                                <path
                                                    d="M3 22C3 17.5817 7.02944 14 12 14C16.9706 14 21 17.5817 21 22"
                                                    stroke="currentColor"
                                                    stroke-width="1.5"
                                                    stroke-linecap="round"
                                                />

                                            </svg>

                                        </div>

                                    @endif

                                    <div class="avatar-floating-badge">

                                        <span class="badge-title">
                                            رئیس کمیته
                                        </span>

                                        <span class="badge-name">
                                            {{ $pageData['chairman_name']
                                                ?? 'نام رئیس کمیته ثبت نشده' }}
                                        </span>

                                    </div>

                                </div>

                                @if(
                                    !empty($pageData['chairman_degree']) ||
                                    !empty($pageData['chairman_company'])
                                )

                                    <div class="chairman-meta-metrics">

                                        @if(!empty($pageData['chairman_degree']))

                                            <div class="metric-row-item">

                                                <div class="metric-icon-sphere">

                                                    <svg viewBox="0 0 24 24"
                                                         fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">

                                                        <path
                                                            d="M3 10L12 5L21 10L12 15L3 10Z"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                            stroke-linejoin="round"
                                                        />

                                                        <path
                                                            d="M7 12.5V17L12 20L17 17V12.5"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                            stroke-linejoin="round"
                                                        />

                                                    </svg>

                                                </div>

                                                <div class="metric-texts">

                                                    <span class="metric-label">
                                                        مرتبه علمی / تخصص
                                                    </span>

                                                    <span class="metric-value">
                                                        {{ $pageData['chairman_degree'] }}
                                                    </span>

                                                </div>

                                            </div>

                                        @endif

                                        @if(!empty($pageData['chairman_company']))

                                            <div class="metric-row-item">

                                                <div class="metric-icon-sphere">

                                                    <svg viewBox="0 0 24 24"
                                                         fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">

                                                        <path
                                                            d="M4 21V7L12 3V21"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />

                                                        <path
                                                            d="M12 10L20 7V21"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                        />

                                                        <path
                                                            d="M2 21H22"
                                                            stroke="currentColor"
                                                            stroke-width="1.6"
                                                            stroke-linecap="round"
                                                        />

                                                    </svg>

                                                </div>

                                                <div class="metric-texts">

                                                    <span class="metric-label">
                                                        سازمان / مجموعه وابسته
                                                    </span>

                                                    <span class="metric-value">
                                                        {{ $pageData['chairman_company'] }}
                                                    </span>

                                                </div>

                                            </div>

                                        @endif

                                    </div>

                                @endif

                            </div>

                            {{-- قائم‌مقام‌ها با همان استایل رئیس --}}
                            @if(
                                $hasDeputies &&
                                $deputies->isNotEmpty()
                            )

                                <div class="committee-deputies-wrapper">

                                    @foreach($deputies as $deputy)

                                        <div class="sticky-card-wrapper deputy-profile-card">

                                            <div class="avatar-frame-box">

                                                @if(!empty($deputy['image']))

                                                    <img
                                                        src="{{ $imageUrl($deputy['image']) }}"
                                                        alt="{{ $deputy['name'] ?: 'قائم‌مقام کمیته' }}"
                                                        class="chairman-avatar"
                                                        loading="lazy"
                                                    >

                                                @else

                                                    <div class="avatar-placeholder-svg">

                                                        <svg viewBox="0 0 24 24"
                                                             fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">

                                                            <circle
                                                                cx="12"
                                                                cy="8"
                                                                r="5"
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                            />

                                                            <path
                                                                d="M3 22C3 17.5817 7.02944 14 12 14C16.9706 14 21 17.5817 21 22"
                                                                stroke="currentColor"
                                                                stroke-width="1.5"
                                                                stroke-linecap="round"
                                                            />

                                                        </svg>

                                                    </div>

                                                @endif

                                                <div class="avatar-floating-badge">

                                                    <span class="badge-title">
                                                        قائم‌مقام کمیته
                                                    </span>

                                                    <span class="badge-name">
                                                        {{ $deputy['name']
                                                            ?: 'نام قائم‌مقام ثبت نشده' }}
                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                        </aside>

                        {{-- محتوای متنی --}}
                        <article class="content-main-area">

                            @if(!empty($pageData['chairman_bio']))

                                <div class="premium-text-block bio-block">

                                    <h3 class="block-inner-title">
                                        رزومه و بیوگرافی علمی
                                    </h3>

                                    <div class="rich-text-content">
                                        {!! nl2br(
                                            e($pageData['chairman_bio'])
                                        ) !!}
                                    </div>

                                </div>

                            @endif

                            @if(!empty($committeeDescription))

                                <div class="premium-text-block desc-block highlighted-card">

                                    <div class="abstract-quote-decoration">
                                        ”
                                    </div>

                                    <h3 class="block-inner-title">
                                        شرح وظایف و مأموریت کمیته
                                    </h3>

                                    <div class="rich-text-content">
                                        {!! nl2br(
                                            e($committeeDescription)
                                        ) !!}
                                    </div>

                                </div>

                            @endif

                            @if(!empty($page->body))

                                <div class="premium-text-block core-body-block">

                                    <div class="rich-text-content dynamic-wp-content">
                                        {!! $page->body !!}
                                    </div>

                                </div>

                            @endif

                        </article>

                    </div>

                </div>

            </section>

        @endif

        {{-- کارگروه‌ها --}}
        @if($hasWorkgroups)

            <section class="committee-workgroups-section">

                <div class="container">

                    <div class="committee-workgroups-heading">

                        <div class="committee-workgroups-heading-main">

                            <span class="committee-workgroups-eyebrow">
                                ساختار تخصصی کمیته
                            </span>

                            <h2>
                                کارگروه‌های کمیته
                            </h2>

                            <p>
                                معرفی کارگروه‌های تخصصی و حوزه فعالیت هر
                                کارگروه
                            </p>

                        </div>

                        <div class="committee-workgroups-count">

                            <strong>
                                {{ $workgroups->count() }}
                            </strong>

                            کارگروه

                        </div>

                    </div>

                    @if($workgroups->isNotEmpty())

                        <div class="committee-workgroups-grid">

                            @foreach($workgroups as $workgroup)

                                <article class="committee-workgroup-card">

                                    <div class="committee-workgroup-image">

                                        @if(!empty($workgroup['image']))

                                            <img
                                                src="{{ $imageUrl($workgroup['image']) }}"
                                                alt="{{ $workgroup['title'] ?: 'کارگروه کمیته' }}"
                                                loading="lazy"
                                            >

                                        @else

                                            <div class="committee-workgroup-placeholder">

                                                <svg viewBox="0 0 24 24"
                                                     fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">

                                                    <circle
                                                        cx="8"
                                                        cy="8"
                                                        r="3.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    />

                                                    <circle
                                                        cx="17"
                                                        cy="9"
                                                        r="2.5"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                    />

                                                    <path
                                                        d="M2 21C2 17.6863 4.68629 15 8 15C11.3137 15 14 17.6863 14 21"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />

                                                    <path
                                                        d="M14 16C17.3137 16 20 18.2386 20 21"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        stroke-linecap="round"
                                                    />

                                                </svg>

                                            </div>

                                        @endif

                                        <span class="committee-workgroup-number">
                                            {{ str_pad(
                                                $workgroup['number'],
                                                2,
                                                '0',
                                                STR_PAD_LEFT
                                            ) }}
                                        </span>

                                    </div>

                                    <div class="committee-workgroup-content">

                                        <div class="committee-workgroup-topline">
                                            کارگروه تخصصی
                                        </div>

                                        <h3 class="committee-workgroup-title">
                                            {{ $workgroup['title']
                                                ?: 'عنوان کارگروه ثبت نشده' }}
                                        </h3>

                                        @if(!empty($workgroup['description']))

                                            <div class="committee-workgroup-description">
                                                {!! nl2br(
                                                    e(
                                                        $workgroup[
                                                            'description'
                                                        ]
                                                    )
                                                ) !!}
                                            </div>

                                        @endif

                                    </div>

                                </article>

                            @endforeach

                        </div>

                    @else

                        <div class="committee-workgroups-empty">
                            گزینه کارگروه فعال شده است، اما هنوز اطلاعاتی
                            برای کارگروه‌ها ثبت نشده است.
                        </div>

                    @endif

                </div>

            </section>

        @endif

    </main>

@endsection
