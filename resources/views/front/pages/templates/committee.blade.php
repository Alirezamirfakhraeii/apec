@extends('front.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/pages/committee.css') }}">
@endpush

@section('content')

    @php
        $pageData = $page->template_data ?? [];

        $heroImage = $pageData['header_image']
            ?? $pageData['hero_image']
            ?? null;

        $committeeTitle = $pageData['committee_title']
            ?? $pageData['hero_title']
            ?? $page->title;

        $committeeDescription = $pageData['committee_description']
            ?? $pageData['hero_description']
            ?? null;

        $galleryImages = array_values(array_filter([
            $pageData['gallery_image_1'] ?? null,
            $pageData['gallery_image_2'] ?? null,
            $pageData['gallery_image_3'] ?? null,
            $pageData['gallery_image_4'] ?? null,
        ]));

        $hasMainContent =
            !empty($pageData['chairman_name'])
            || !empty($pageData['chairman_image'])
            || !empty($pageData['chairman_position'])
            || !empty($pageData['chairman_degree'])
            || !empty($pageData['chairman_company'])
            || !empty($pageData['chairman_bio'])
            || !empty($committeeDescription)
            || !empty($page->body);
    @endphp

    <main class="premium-committee-wrapper" dir="rtl">

        {{-- بخش هدر سینمایی صفحه --}}
        <section class="premium-hero {{ $heroImage ? 'has-bg-image' : '' }}"
                 @if($heroImage) style="background-image: url('{{ asset('storage/' . $heroImage) }}');" @endif>
            <div class="hero-blur-overlay"></div>
            <div class="hero-glow-spot"></div>

            <div class="container hero-container">
                <nav class="premium-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ url('/') }}" class="breadcrumb-link">صفحه اصلی</a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">{{ $committeeTitle }}</span>
                </nav>

                <div class="hero-dynamic-content">
                    <div class="hero-badge">
                        <span class="pulse-dot"></span>
                        کمیته تخصصی پیشرو
                    </div>
                    <h1 class="hero-main-title">{{ $committeeTitle }}</h1>
                    @if(!empty($page->summary))
                        <p class="hero-summary-text">{{ $page->summary }}</p>
                    @endif
                </div>
            </div>

            <div class="hero-bottom-curve"></div>
        </section>

        {{-- بدنه اصلی و چیدمان مدرن لایه‌ها --}}
        @if($hasMainContent)
            <section class="main-content-layout">
                <div class="container">
                    <div class="layout-grid-container">

                        {{-- ستون اطلاعات رئیس (در دسکتاپ سمت چپ قرار می‌گیرد اما با ساختار منعطف) --}}
                        <aside class="chairman-sidebar-card">
                            <div class="sticky-card-wrapper">
                                <div class="avatar-frame-box">
                                    @if(!empty($pageData['chairman_image']))
                                        <img src="{{ asset('storage/' . $pageData['chairman_image']) }}"
                                             alt="{{ $pageData['chairman_name'] ?? 'رئیس کمیته' }}"
                                             class="chairman-avatar">
                                    @else
                                        <div class="avatar-placeholder-svg">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="8" r="5" stroke="currentColor" stroke-width="1.5"/>
                                                <path d="M3 22C3 17.5817 7.02944 14 12 14C16.9706 14 21 17.5817 21 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="avatar-floating-badge">
                                        <span class="badge-title">رئیس کمیته</span>
                                        @if(!empty($pageData['chairman_name']))
                                            <span class="badge-name">{{ $pageData['chairman_name'] }}</span>
                                        @endif
                                    </div>
                                </div>

                                @if(!empty($pageData['chairman_degree']) || !empty($pageData['chairman_company']))
                                    <div class="chairman-meta-metrics">
                                        @if(!empty($pageData['chairman_degree']))
                                            <div class="metric-row-item">
                                                <div class="metric-icon-sphere">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3 10L12 5L21 10L12 15L3 10Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                                        <path d="M7 12.5V17L12 20L17 17V12.5" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                                    </svg>
                                                </div>
                                                <div class="metric-texts">
                                                    <span class="metric-label">مرتبه علمی / تخصص</span>
                                                    <span class="metric-value">{{ $pageData['chairman_degree'] }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        @if(!empty($pageData['chairman_company']))
                                            <div class="metric-row-item">
                                                <div class="metric-icon-sphere">
                                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M4 21V7L12 3V21" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M12 10L20 7V21" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M2 21H22" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                                                    </svg>
                                                </div>
                                                <div class="metric-texts">
                                                    <span class="metric-label">سازمان / مجموعه وابستگی</span>
                                                    <span class="metric-value">{{ $pageData['chairman_company'] }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </aside>

                        {{-- ستون محتوای متنی و جزئیات کمیته (سمت راست) --}}
                        <article class="content-main-area">
                            <div class="main-title-group">
                                <span class="sub-accent-label">درباره و ارکان کانون</span>
                                @if(!empty($pageData['chairman_name']))
                                    <h2 class="section-display-title">{{ $pageData['chairman_name'] }} <small class="title-role">({{ $pageData['chairman_position'] ?? 'رئیس کمیته' }})</small></h2>
                                @else
                                    <h2 class="section-display-title">معرفی و اهداف کمیته</h2>
                                @endif
                            </div>

                            @if(!empty($pageData['chairman_bio']))
                                <div class="premium-text-block bio-block">
                                    <h3 class="block-inner-title">رزومه و بیوگرافی علمی</h3>
                                    <div class="rich-text-content">
                                        {!! nl2br(e($pageData['chairman_bio'])) !!}
                                    </div>
                                </div>
                            @endif

                            @if(!empty($committeeDescription))
                                <div class="premium-text-block desc-block highlighted-card">
                                    <div class="abstract-quote-decoration">”</div>
                                    <h3 class="block-inner-title">شرح وظایف و مأموریت کمیته</h3>
                                    <div class="rich-text-content">
                                        {!! nl2br(e($committeeDescription)) !!}
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

        {{-- بخش گالری تصاویر مدرن (بنتو گرید تعاملی) --}}
        @if(count($galleryImages))
            <section class="premium-gallery-section">
                <div class="container">
                    <div class="gallery-section-header">
                        <div class="header-titles">
                            <span class="sub-accent-label">رویدادها و مستندات</span>
                            <h2 class="section-display-title">گزارش تصویری و مستندات حضور</h2>
                        </div>
                        <div class="header-deco-line"></div>
                    </div>

                    <div class="bento-gallery-grid gallery-count-{{ count($galleryImages) }}">
                        @foreach($galleryImages as $index => $image)
                            <a href="{{ asset('storage/' . $image) }}" target="_blank" class="bento-gallery-item gallery-item-{{ $index + 1 }}">
                                <div class="item-image-wrapper">
                                    <img src="{{ asset('storage/' . $image) }}" alt="گزارش تصویری {{ $index + 1 }} - {{ $committeeTitle }}" loading="lazy">
                                    <div class="item-interactive-overlay">
                                        <div class="overlay-icon-circle">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" fill="currentColor"/>
                                            </svg>
                                        </div>
                                        <span class="overlay-text-label">بزرگنمایی تصویر</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>

@endsection
