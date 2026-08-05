@extends('front.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/pages/committee.css') }}"
    >

    <style>
        /*
        |--------------------------------------------------------------------------
        | ستون اعضای کمیته
        |--------------------------------------------------------------------------
        */

        .chairman-sidebar-card {
            display: flex;
            flex-direction: column;
            gap: 16px;
            align-self: start;
        }

        .committee-members-heading {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 2px 0 -2px;
            color: #64748b;
            font-size: 10px;
            font-weight: 800;
        }

        .committee-members-heading::before,
        .committee-members-heading::after {
            width: 30px;
            height: 1px;
            content: "";
            background: #dbe4ee;
        }

        .committee-member-card {
            position: relative;
            width: 100%;
            max-width: 285px;
            margin: 0 auto;
            padding: 14px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #e6edf5;
            border-radius: 21px;
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.06);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .committee-member-card::before {
            position: absolute;
            top: 0;
            right: 20px;
            left: 20px;
            height: 3px;
            content: "";
            background: linear-gradient(90deg, #c9a44d, #e8d39b, #c9a44d);
            border-radius: 0 0 10px 10px;
            opacity: 0.9;
        }

        .committee-member-card:hover {
            border-color: #d8e2ec;
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.09);
            transform: translateY(-3px);
        }

        /*
        |--------------------------------------------------------------------------
        | قاب تصویر اعضا
        |--------------------------------------------------------------------------
        */

        .committee-member-media {
            position: relative;
            width: 100%;
            overflow: hidden;
            background:
                radial-gradient(circle at top right, rgba(255, 255, 255, 0.95), transparent 44%),
                linear-gradient(145deg, #f8fafc, #edf2f7);
            border: 1px solid #edf2f7;
            border-radius: 17px;
        }

        .committee-member-card--chairman .committee-member-media {
            height: 225px;
            padding: 10px;
        }

        .committee-member-card--deputy .committee-member-media,
        .committee-member-card--secretary .committee-member-media {
            width: 175px;
            height: 175px;
            margin: 0 auto;
            padding: 8px;
        }

        .committee-member-image-shell {
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #f8fafc;
            border: 1px solid #e9eef4;
            border-radius: 13px;
        }

        .committee-member-image,
        .committee-member-placeholder {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 0 !important;
            border-radius: 13px;
        }

        .committee-member-image {
            object-fit: cover;
            object-position: center top;
            background: #f8fafc;
            transition: transform 0.35s ease;
        }

        .committee-member-card:hover .committee-member-image {
            transform: scale(1.025);
        }

        .committee-member-card--secretary .committee-member-image {
            padding: 8px;
            object-fit: contain;
            object-position: center;
            background: #ffffff;
        }

        .committee-member-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            background: linear-gradient(145deg, #ffffff, #eef2f7);
        }

        .committee-member-card--chairman .committee-member-placeholder svg {
            width: 58px;
            height: 58px;
        }

        .committee-member-card--deputy .committee-member-placeholder svg,
        .committee-member-card--secretary .committee-member-placeholder svg {
            width: 44px;
            height: 44px;
        }

        /*
        |--------------------------------------------------------------------------
        | مشخصات زیر عکس
        |--------------------------------------------------------------------------
        */

        .committee-member-info {
            margin-top: 11px;
            padding: 11px 12px 10px;
            text-align: center;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #edf2f7;
            border-radius: 15px;
        }

        .committee-member-role {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 24px;
            padding: 3px 10px;
            color: #9a761f;
            background: #fff8e7;
            border: 1px solid #f0dfae;
            border-radius: 999px;
            font-size: 8.5px;
            font-weight: 900;
            line-height: 1;
        }

        .committee-member-name {
            margin-top: 7px;
            color: #0f172a;
            font-size: 13px;
            font-weight: 900;
            line-height: 1.75;
        }

        .committee-member-position {
            margin-top: 2px;
            color: #64748b;
            font-size: 9.5px;
            font-weight: 700;
            line-height: 1.8;
        }

        .committee-member-meta {
            margin-top: 10px;
            padding: 9px 11px;
            background: #f8fafc;
            border: 1px solid #e5edf5;
            border-radius: 14px;
        }

        .committee-meta-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding: 6px 0;
        }

        .committee-meta-row:not(:last-child) {
            border-bottom: 1px solid #e8eef5;
        }

        .committee-meta-label {
            flex-shrink: 0;
            color: #94a3b8;
            font-size: 8.5px;
            font-weight: 800;
            line-height: 1.8;
        }

        .committee-meta-value {
            color: #334155;
            font-size: 9.5px;
            font-weight: 800;
            line-height: 1.8;
            text-align: left;
        }

        .committee-deputies-wrapper {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .committee-secretary-wrapper {
            display: flex;
            justify-content: center;
        }

        /*
        |--------------------------------------------------------------------------
        | کوچک‌تر کردن عنوان‌های صفحه
        |--------------------------------------------------------------------------
        */

        .hero-main-title {
            font-size: 29px !important;
            line-height: 1.6 !important;
        }

        .hero-summary-text {
            font-size: 12px !important;
            line-height: 2 !important;
        }

        .block-inner-title {
            margin-bottom: 12px !important;
            font-size: 15px !important;
            line-height: 1.8 !important;
        }

        .rich-text-content {
            font-size: 12px !important;
            line-height: 2.05 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | کارگروه‌ها
        |--------------------------------------------------------------------------
        */

        .committee-workgroups-section {
            padding: 55px 0 65px;
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
            margin-bottom: 22px;
        }

        .committee-workgroups-heading-main {
            min-width: 0;
        }

        .committee-workgroups-eyebrow {
            display: block;
            margin-bottom: 4px;
            color: #64748b;
            font-size: 9px;
            font-weight: 800;
        }

        .committee-workgroups-heading h2 {
            margin: 0;
            color: #0f172a;
            font-size: 21px;
            font-weight: 900;
            line-height: 1.7;
        }

        .committee-workgroups-heading p {
            max-width: 650px;
            margin: 4px 0 0;
            color: #64748b;
            font-size: 10.5px;
            line-height: 2;
        }

        .committee-workgroups-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
            padding: 6px 11px;
            color: #475569;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            font-size: 9.5px;
            font-weight: 800;
        }

        .committee-workgroups-count strong {
            color: #0f172a;
            font-size: 13px;
        }

        .committee-workgroups-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .committee-workgroup-card {
            display: grid;
            grid-template-columns: 125px minmax(0, 1fr);
            overflow: hidden;
            height: 150px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 13px;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease;
        }

        .committee-workgroup-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 11px 27px rgba(15, 23, 42, 0.09);
            transform: translateY(-2px);
        }

        .committee-workgroup-image {
            position: relative;
            height: 150px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .committee-workgroup-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .committee-workgroup-card:hover
        .committee-workgroup-image img {
            transform: scale(1.04);
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
            width: 38px;
            height: 38px;
        }

        .committee-workgroup-number {
            position: absolute;
            right: 7px;
            bottom: 7px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 29px;
            height: 29px;
            color: #ffffff;
            background: rgba(15, 23, 42, 0.86);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 8px;
            font-size: 8.5px;
            font-weight: 900;
        }

        .committee-workgroup-content {
            display: flex;
            justify-content: center;
            flex-direction: column;
            min-width: 0;
            padding: 12px 14px;
        }

        .committee-workgroup-topline {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 3px;
            color: #94a3b8;
            font-size: 8px;
            font-weight: 800;
        }

        .committee-workgroup-topline::before {
            width: 11px;
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
            font-size: 12.5px;
            font-weight: 900;
            line-height: 1.75;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .committee-workgroup-description {
            display: -webkit-box;
            overflow: hidden;
            margin-top: 5px;
            color: #64748b;
            font-size: 9px;
            line-height: 1.9;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        .committee-workgroups-empty {
            padding: 22px;
            color: #64748b;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 13px;
            text-align: center;
            font-size: 11px;
        }

        /*
        |--------------------------------------------------------------------------
        | محتوای CKEditor
        |--------------------------------------------------------------------------
        */

        .dynamic-wp-content img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 15px auto;
            border-radius: 11px;
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

            .committee-secretary-wrapper {
                display: flex;
                justify-content: center;
            }

            .committee-member-card {
                max-width: 255px;
            }
        }

        @media (max-width: 768px) {
            .hero-main-title {
                font-size: 24px !important;
            }

            .block-inner-title {
                font-size: 14px !important;
            }

            .committee-workgroups-section {
                padding: 42px 0 50px;
            }

            .committee-workgroups-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .committee-workgroups-heading h2 {
                font-size: 18px;
            }

            .committee-workgroup-card {
                grid-template-columns: 110px minmax(0, 1fr);
                height: 140px;
            }

            .committee-workgroup-image {
                height: 140px;
            }

            .committee-workgroup-content {
                padding: 10px 12px;
            }

            .committee-member-card--chairman .committee-member-media {
                height: 205px;
            }

            .committee-member-card--deputy .committee-member-media,
            .committee-member-card--secretary .committee-member-media {
                width: 155px;
                height: 155px;
            }
        }

        @media (max-width: 576px) {
            .committee-deputies-wrapper {
                grid-template-columns: 1fr;
            }

            .committee-member-card {
                max-width: 235px;
            }
        }

        @media (max-width: 480px) {
            .hero-main-title {
                font-size: 21px !important;
            }

            .committee-workgroup-card {
                grid-template-columns: 90px minmax(0, 1fr);
                height: 130px;
                border-radius: 12px;
            }

            .committee-workgroup-image {
                height: 130px;
            }

            .committee-workgroup-content {
                padding: 9px 10px;
            }

            .committee-workgroup-title {
                font-size: 11.5px;
            }

            .committee-workgroup-description {
                font-size: 8.5px;
                -webkit-line-clamp: 2;
            }

            .committee-member-card--deputy .committee-member-media,
            .committee-member-card--secretary .committee-member-media {
                width: 140px;
                height: 140px;
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
        | بررسی مقادیر Checkbox
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

        $heroImage =
            $pageData['header_image']
            ?? null;

        $committeeTitle =
            $pageData['committee_title']
            ?? $page->title
            ?? 'کمیته';

        $committeeDescription =
            $pageData['committee_description']
            ?? $page->summary
            ?? null;

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
                'number' => 1,
                'name' =>
                    $pageData['deputy_1_name']
                    ?? null,
                'image' =>
                    $pageData['deputy_1_image']
                    ?? null,
            ]);

            if ($hasSecondDeputy) {
                $deputies->push([
                    'number' => 2,
                    'name' =>
                        $pageData['deputy_2_name']
                        ?? null,
                    'image' =>
                        $pageData['deputy_2_image']
                        ?? null,
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
        | دبیر کمیته
        |--------------------------------------------------------------------------
        */

        $secretary = [
            'name' =>
                $pageData['secretary_name']
                ?? null,

            'image' =>
                $pageData['secretary_image']
                ?? null,

            'position' =>
                $pageData['secretary_position']
                ?? null,

            'degree' =>
                $pageData['secretary_degree']
                ?? null,

            'company' =>
                $pageData['secretary_company']
                ?? null,

            'bio' =>
                $pageData['secretary_bio']
                ?? null,
        ];

        $hasSecretary = collect($secretary)
            ->contains(function ($value) {
                return filled($value);
            });

        /*
        |--------------------------------------------------------------------------
        | بررسی وجود محتوای اصلی
        |--------------------------------------------------------------------------
        */

        $hasMainContent =
            filled($page->body) ||
            filled($committeeDescription) ||

            filled($pageData['chairman_name'] ?? null) ||
            filled($pageData['chairman_image'] ?? null) ||
            filled($pageData['chairman_position'] ?? null) ||
            filled($pageData['chairman_degree'] ?? null) ||
            filled($pageData['chairman_company'] ?? null) ||
            filled($pageData['chairman_bio'] ?? null) ||

            $deputies->isNotEmpty() ||
            $hasSecretary;

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
                        $pageData[
                            "workgroup_{$number}_title"
                        ] ?? null,

                    'image' =>
                        $pageData[
                            "workgroup_{$number}_image"
                        ] ?? null,

                    'description' =>
                        $pageData[
                            "workgroup_{$number}_description"
                        ] ?? null,
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

    <main
        class="premium-committee-wrapper"
        dir="rtl"
    >

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

                <nav
                    class="premium-breadcrumb"
                    aria-label="breadcrumb"
                >

                    <a
                        href="{{ url('/') }}"
                        class="breadcrumb-link"
                    >
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

                        {{-- اعضای کمیته --}}
                        <aside class="chairman-sidebar-card">

                            {{-- رئیس کمیته --}}
                            <div class="committee-member-card committee-member-card--chairman">

                                <div class="committee-member-media">
                                    <div class="committee-member-image-shell">

                                        @if(!empty($pageData['chairman_image']))
                                            <img
                                                src="{{ $imageUrl($pageData['chairman_image']) }}"
                                                alt="{{ $pageData['chairman_name'] ?? 'رئیس کمیته' }}"
                                                class="committee-member-image"
                                            >
                                        @else
                                            <div class="committee-member-placeholder">
                                                <svg
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
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

                                    </div>
                                </div>

                                <div class="committee-member-info">
                                    <span class="committee-member-role">
                                        رئیس کمیته
                                    </span>

                                    <div class="committee-member-name">
                                        {{ $pageData['chairman_name']
                                            ?? 'نام رئیس کمیته ثبت نشده' }}
                                    </div>

                                    @if(!empty($pageData['chairman_position']))
                                        <div class="committee-member-position">
                                            {{ $pageData['chairman_position'] }}
                                        </div>
                                    @endif
                                </div>

                                @if(
                                    !empty($pageData['chairman_degree']) ||
                                    !empty($pageData['chairman_company'])
                                )
                                    <div class="committee-member-meta">

                                        @if(!empty($pageData['chairman_degree']))
                                            <div class="committee-meta-row">
                                                <span class="committee-meta-label">
                                                    تخصص
                                                </span>

                                                <span class="committee-meta-value">
                                                    {{ $pageData['chairman_degree'] }}
                                                </span>
                                            </div>
                                        @endif

                                        @if(!empty($pageData['chairman_company']))
                                            <div class="committee-meta-row">
                                                <span class="committee-meta-label">
                                                    سازمان
                                                </span>

                                                <span class="committee-meta-value">
                                                    {{ $pageData['chairman_company'] }}
                                                </span>
                                            </div>
                                        @endif

                                    </div>
                                @endif

                            </div>

                            {{-- قائم‌مقام‌ها --}}
                            @if(
                                $hasDeputies &&
                                $deputies->isNotEmpty()
                            )

                                <div class="committee-members-heading">
                                    قائم‌مقام‌ها
                                </div>

                                <div class="committee-deputies-wrapper">

                                    @foreach($deputies as $deputy)

                                        <div class="committee-member-card committee-member-card--deputy">

                                            <div class="committee-member-media">
                                                <div class="committee-member-image-shell">

                                                    @if(!empty($deputy['image']))
                                                        <img
                                                            src="{{ $imageUrl($deputy['image']) }}"
                                                            alt="{{ $deputy['name'] ?: 'قائم‌مقام کمیته' }}"
                                                            class="committee-member-image"
                                                            loading="lazy"
                                                        >
                                                    @else
                                                        <div class="committee-member-placeholder">
                                                            <svg
                                                                viewBox="0 0 24 24"
                                                                fill="none"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                            >
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

                                                </div>
                                            </div>

                                            <div class="committee-member-info">
                                                <span class="committee-member-role">
                                                    قائم‌مقام
                                                    {{ $deputy['number'] }}
                                                </span>

                                                <div class="committee-member-name">
                                                    {{ $deputy['name']
                                                        ?: 'نام قائم‌مقام ثبت نشده' }}
                                                </div>
                                            </div>

                                        </div>

                                    @endforeach

                                </div>

                            @endif

                            {{-- دبیر کمیته؛ زیر قائم‌مقام‌ها --}}
                            @if($hasSecretary)

                                <div class="committee-members-heading">
                                    دبیر کمیته
                                </div>

                                <div class="committee-secretary-wrapper">

                                    <div class="committee-member-card committee-member-card--secretary">

                                        <div class="committee-member-media">
                                            <div class="committee-member-image-shell">

                                                @if(!empty($secretary['image']))
                                                    <img
                                                        src="{{ $imageUrl($secretary['image']) }}"
                                                        alt="{{ $secretary['name'] ?: 'دبیر کمیته' }}"
                                                        class="committee-member-image"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="committee-member-placeholder">
                                                        <svg
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                            xmlns="http://www.w3.org/2000/svg"
                                                        >
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

                                            </div>
                                        </div>

                                        <div class="committee-member-info">
                                            <span class="committee-member-role">
                                                دبیر کمیته
                                            </span>

                                            <div class="committee-member-name">
                                                {{ $secretary['name']
                                                    ?: 'نام دبیر ثبت نشده' }}
                                            </div>

                                            @if(!empty($secretary['position']))
                                                <div class="committee-member-position">
                                                    {{ $secretary['position'] }}
                                                </div>
                                            @endif
                                        </div>

                                        @if(
                                            !empty($secretary['degree']) ||
                                            !empty($secretary['company'])
                                        )
                                            <div class="committee-member-meta">

                                                @if(!empty($secretary['degree']))
                                                    <div class="committee-meta-row">
                                                        <span class="committee-meta-label">
                                                            تخصص
                                                        </span>

                                                        <span class="committee-meta-value">
                                                            {{ $secretary['degree'] }}
                                                        </span>
                                                    </div>
                                                @endif

                                                @if(!empty($secretary['company']))
                                                    <div class="committee-meta-row">
                                                        <span class="committee-meta-label">
                                                            سازمان
                                                        </span>

                                                        <span class="committee-meta-value">
                                                            {{ $secretary['company'] }}
                                                        </span>
                                                    </div>
                                                @endif

                                            </div>
                                        @endif

                                    </div>

                                </div>

                            @endif

                        </aside>

                        {{-- محتوای متنی --}}
                        <article class="content-main-area">

                            @if(!empty($pageData['chairman_bio']))

                                <div class="premium-text-block bio-block">

                                    <h3 class="block-inner-title">
                                        رزومه و بیوگرافی علمی رئیس کمیته
                                    </h3>

                                    <div class="rich-text-content">
                                        {!! nl2br(
                                            e($pageData['chairman_bio'])
                                        ) !!}
                                    </div>

                                </div>

                            @endif

                            @if(!empty($secretary['bio']))

                                <div class="premium-text-block bio-block secretary-bio-block">

                                    <h3 class="block-inner-title">
                                        معرفی و سوابق دبیر کمیته
                                    </h3>

                                    <div class="rich-text-content">
                                        {!! nl2br(
                                            e($secretary['bio'])
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
                                معرفی کارگروه‌های تخصصی و حوزه فعالیت هر کارگروه
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

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                >
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
