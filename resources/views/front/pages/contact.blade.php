@extends('front.layouts.master')

@push('styles')
    <style>
        .contact-page {
            direction: rtl;
            background:
                radial-gradient(circle at 15% 0%, rgba(29, 79, 122, 0.12), transparent 28%),
                linear-gradient(180deg, #f6f8fc 0%, #eef3f8 100%);
            min-height: 100vh;
            color: #0f172a;
        }

        .contact-hero {
            position: relative;
            overflow: hidden;
            padding: 74px 0 120px;
            background:
                linear-gradient(135deg, rgba(7, 20, 54, 0.98), rgba(16, 35, 63, 0.96) 48%, rgba(29, 79, 122, 0.94)),
                url("https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1600&q=80") center/cover no-repeat;
        }

        .contact-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.055) 1px, transparent 1px),
                linear-gradient(180deg, rgba(255,255,255,0.055) 1px, transparent 1px),
                radial-gradient(circle at 22% 35%, rgba(14, 165, 233, 0.22), transparent 28%);
            background-size: 48px 48px, 48px 48px, auto;
            opacity: 0.75;
        }

        .contact-hero .container {
            position: relative;
            z-index: 2;
        }

        .contact-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            color: rgba(255, 255, 255, 0.72);
            font-size: 13px;
            margin-bottom: 24px;
        }

        .contact-breadcrumb a {
            color: #fff;
            text-decoration: none;
            font-weight: 800;
        }

        .contact-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 999px;
            color: #e0f2fe;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 18px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .contact-hero h1 {
            margin: 0 0 14px;
            color: #fff;
            font-size: 38px;
            font-weight: 950;
            line-height: 1.6;
        }

        .contact-hero p {
            max-width: 720px;
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 15px;
            line-height: 2.1;
        }

        .contact-main {
            position: relative;
            z-index: 3;
            margin-top: -74px;
            padding-bottom: 70px;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 410px;
            gap: 24px;
            align-items: start;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.98);
            border: 1px solid #e2eaf4;
            border-radius: 24px;
            box-shadow: 0 18px 44px rgba(15, 23, 42, 0.09);
            overflow: hidden;
        }

        .contact-card-body {
            padding: 28px;
        }

        .contact-section-title {
            margin-bottom: 22px;
        }

        .contact-section-title span {
            display: inline-flex;
            color: #1d4f7a;
            background: rgba(29, 79, 122, 0.08);
            border: 1px solid rgba(29, 79, 122, 0.12);
            border-radius: 999px;
            padding: 6px 13px;
            font-size: 11px;
            font-weight: 950;
            margin-bottom: 10px;
        }

        .contact-section-title h2 {
            margin: 0;
            color: #0f172a;
            font-size: 24px;
            font-weight: 950;
            line-height: 1.7;
        }

        .contact-section-title p {
            margin: 8px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 2;
        }

        .contact-body-text {
            color: #475569;
            font-size: 14px;
            line-height: 2.25;
            margin-bottom: 24px;
            padding: 18px;
            border-radius: 18px;
            background:
                linear-gradient(135deg, rgba(29, 79, 122, 0.07), rgba(14, 165, 233, 0.035)),
                #f8fafc;
            border-right: 4px solid #1d4f7a;
        }

        .contact-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .contact-form-group {
            margin-bottom: 14px;
        }

        .contact-form-group.full {
            grid-column: 1 / -1;
        }

        .contact-form-group label {
            display: block;
            color: #334155;
            font-size: 12px;
            font-weight: 900;
            margin-bottom: 8px;
        }

        .contact-form-control {
            width: 100%;
            border: 1px solid #dbe5f1;
            background: #f8fafc;
            color: #0f172a;
            border-radius: 15px;
            padding: 13px 14px;
            font-size: 13px;
            outline: none;
            transition: 0.2s ease;
        }

        .contact-form-control:focus {
            background: #fff;
            border-color: rgba(29, 79, 122, 0.55);
            box-shadow: 0 0 0 4px rgba(29, 79, 122, 0.10);
        }

        textarea.contact-form-control {
            min-height: 145px;
            resize: vertical;
            line-height: 2;
        }

        .contact-field-error {
            display: block;
            margin-top: 6px;
            color: #dc2626;
            font-size: 11px;
            font-weight: 800;
        }

        .contact-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 170px;
            border: 0;
            border-radius: 15px;
            padding: 13px 22px;
            background: linear-gradient(135deg, #1d4f7a, #0f7db8);
            color: #fff;
            font-size: 13px;
            font-weight: 950;
            cursor: pointer;
            box-shadow: 0 12px 24px rgba(29, 79, 122, 0.22);
            transition: 0.2s ease;
        }

        .contact-submit-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(29, 79, 122, 0.28);
        }

        .contact-alert {
            border-radius: 16px;
            padding: 13px 15px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.8;
        }

        .contact-alert.success {
            color: #166534;
            background: #dcfce7;
            border: 1px solid #bbf7d0;
        }

        .contact-alert.error {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
        }

        .contact-side-card {
            position: sticky;
            top: 24px;
            overflow: hidden;
            border-radius: 28px;
            background: #fff;
            border: 1px solid #e2eaf4;
            box-shadow: 0 22px 50px rgba(15, 23, 42, 0.11);
        }

        .contact-side-hero {
            position: relative;
            overflow: hidden;
            padding: 28px 24px 34px;
            background:
                linear-gradient(135deg, rgba(7, 20, 54, 0.98), rgba(29, 79, 122, 0.96)),
                radial-gradient(circle at 10% 10%, rgba(56, 189, 248, 0.28), transparent 34%);
            color: #fff;
        }

        .contact-side-pattern {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(90deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                linear-gradient(180deg, rgba(255,255,255,0.06) 1px, transparent 1px),
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.20), transparent 28%);
            background-size: 34px 34px, 34px 34px, auto;
            opacity: 0.8;
        }

        .contact-side-hero > *:not(.contact-side-pattern) {
            position: relative;
            z-index: 2;
        }

        .contact-side-icon {
            width: 62px;
            height: 62px;
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.20);
            color: #e0f2fe;
            font-size: 24px;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.18);
        }

        .contact-side-hero span {
            display: inline-flex;
            padding: 6px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.13);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #bae6fd;
            font-size: 11px;
            font-weight: 950;
            margin-bottom: 12px;
        }

        .contact-side-hero h2 {
            margin: 0;
            color: #fff;
            font-size: 22px;
            font-weight: 950;
            line-height: 1.8;
        }

        .contact-side-hero p {
            margin: 8px 0 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 13px;
            line-height: 2;
        }

        .contact-side-body {
            padding: 20px;
        }

        .contact-info-pro-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .contact-info-pro-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 14px;
            border-radius: 20px;
            background:
                linear-gradient(135deg, rgba(248, 250, 252, 0.98), rgba(241, 245, 249, 0.92));
            border: 1px solid #e8edf5;
            text-decoration: none;
            color: inherit;
            overflow: hidden;
            transition: 0.22s ease;
        }

        .contact-info-pro-item::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #1d4f7a, #0ea5e9);
            opacity: 0;
            transition: 0.22s ease;
        }

        .contact-info-pro-item:hover {
            transform: translateY(-2px);
            border-color: rgba(29, 79, 122, 0.22);
            background:
                linear-gradient(135deg, rgba(29, 79, 122, 0.07), rgba(14, 165, 233, 0.04));
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.07);
        }

        .contact-info-pro-item:hover::before {
            opacity: 1;
        }

        .contact-info-pro-icon {
            width: 46px;
            height: 46px;
            flex: 0 0 46px;
            border-radius: 17px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1d4f7a;
            color: #fff;
            font-size: 16px;
            box-shadow: 0 12px 24px rgba(29, 79, 122, 0.20);
        }

        .contact-info-pro-item small {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .contact-info-pro-item strong {
            display: block;
            color: #0f172a;
            font-size: 13px;
            font-weight: 950;
            line-height: 1.9;
            word-break: break-word;
        }

        .contact-info-arrow {
            margin-right: auto;
            color: #94a3b8;
            font-size: 14px;
            transition: 0.22s ease;
        }

        .contact-info-pro-item:hover .contact-info-arrow {
            color: #1d4f7a;
            transform: translateX(-3px);
        }

        .contact-empty-info {
            display: flex;
            gap: 10px;
            padding: 14px;
            border-radius: 18px;
            color: #64748b;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            font-size: 13px;
            line-height: 2;
        }

        .contact-empty-info p {
            margin: 0;
        }

        .contact-quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-top: 16px;
        }

        .contact-quick-actions a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 44px;
            border-radius: 15px;
            color: #1d4f7a;
            background: rgba(29, 79, 122, 0.08);
            border: 1px solid rgba(29, 79, 122, 0.13);
            text-decoration: none;
            font-size: 12px;
            font-weight: 950;
            transition: 0.22s ease;
        }

        .contact-quick-actions a:hover {
            color: #fff;
            background: linear-gradient(135deg, #1d4f7a, #0f7db8);
            box-shadow: 0 12px 24px rgba(29, 79, 122, 0.20);
            transform: translateY(-2px);
        }

        .contact-map-pro-box {
            margin-top: 16px;
            overflow: hidden;
            border-radius: 22px;
            border: 1px solid #e2eaf4;
            background:
                radial-gradient(circle at top, rgba(29, 79, 122, 0.14), transparent 38%),
                linear-gradient(135deg, #f8fafc, #e8edf5);
        }

        .contact-map-pro-content {
            min-height: 240px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 13px;
            text-align: center;
        }

        .contact-map-pro-icon {
            width: 66px;
            height: 66px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #1d4f7a;
            color: #fff;
            font-size: 25px;
            box-shadow: 0 16px 30px rgba(29, 79, 122, 0.22);
        }

        .contact-map-pro-content h3 {
            margin: 0;
            color: #0f172a;
            font-size: 17px;
            font-weight: 950;
        }

        .contact-map-pro-content p {
            margin: 0;
            color: #64748b;
            font-size: 13px;
            line-height: 2;
        }

        .contact-map-pro-content a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 999px;
            padding: 11px 18px;
            background: linear-gradient(135deg, #1d4f7a, #0f7db8);
            color: #fff;
            font-size: 13px;
            font-weight: 950;
            text-decoration: none;
            transition: 0.22s ease;
        }

        .contact-map-pro-content a:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(29, 79, 122, 0.24);
        }

        .contact-map-iframe iframe {
            width: 100%;
            min-height: 300px;
            border: 0;
            display: block;
        }

        @media (max-width: 992px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .contact-side-card {
                position: static;
            }

            .contact-hero h1 {
                font-size: 30px;
            }
        }

        @media (max-width: 576px) {
            .contact-hero {
                padding: 52px 0 105px;
            }

            .contact-card-body {
                padding: 20px;
            }

            .contact-form-grid {
                grid-template-columns: 1fr;
            }

            .contact-section-title h2 {
                font-size: 21px;
            }

            .contact-side-hero {
                padding: 24px 20px 30px;
            }

            .contact-side-body {
                padding: 16px;
            }

            .contact-quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')
    @php
        $mapLink = trim($contactPage->map_link ?? '');
        $isIframe = \Illuminate\Support\Str::contains($mapLink, '<iframe');
        $isUrl = filter_var($mapLink, FILTER_VALIDATE_URL);
    @endphp

    <main class="contact-page">

        <section class="contact-hero">
            <div class="container">
                <div class="contact-breadcrumb">
                    <a href="{{ url('/') }}">خانه</a>
                    <span>/</span>
                    <span>{{ $contactPage->title ?? 'تماس با ما' }}</span>
                </div>

                <span class="contact-label">
                    <i class="fa fa-headset"></i>
                    ارتباط با انجمن
                </span>

                <h1>{{ $contactPage->title ?? 'تماس با ما' }}</h1>

                <p>
                    {{ $contactPage->subtitle ?? 'برای ارتباط با ما، ارسال پیام، دریافت اطلاعات بیشتر یا پیگیری درخواست‌های خود از راه‌های ارتباطی زیر استفاده کنید.' }}
                </p>
            </div>
        </section>

        <section class="contact-main">
            <div class="container">
                <div class="contact-grid">

                    <div class="contact-card">
                        <div class="contact-card-body">

                            <div class="contact-section-title">
                                <span>ارسال پیام</span>
                                <h2>با ما در ارتباط باشید</h2>
                                <p>فرم زیر را تکمیل کنید تا پیام شما برای بخش مربوطه ارسال شود.</p>
                            </div>

                            @if(session('success'))
                                <div class="contact-alert success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="contact-alert error">
                                    لطفاً خطاهای فرم را بررسی کنید.
                                </div>
                            @endif

                            @if($contactPage->body)
                                <div class="contact-body-text">
                                    {!! nl2br(e($contactPage->body)) !!}
                                </div>
                            @endif

                            <form action="{{ route('front.contact.store') }}" method="POST">
                                @csrf

                                <div class="contact-form-grid">
                                    <div class="contact-form-group">
                                        <label for="name">نام و نام خانوادگی</label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="contact-form-control"
                                            value="{{ old('name') }}"
                                            placeholder="مثلاً علی محمدی"
                                        >

                                        @error('name')
                                        <span class="contact-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="contact-form-group">
                                        <label for="email">ایمیل</label>
                                        <input
                                            type="email"
                                            id="email"
                                            name="email"
                                            class="contact-form-control"
                                            value="{{ old('email') }}"
                                            placeholder="example@email.com"
                                        >

                                        @error('email')
                                        <span class="contact-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="contact-form-group">
                                        <label for="phone">شماره تماس</label>
                                        <input
                                            type="text"
                                            id="phone"
                                            name="phone"
                                            class="contact-form-control"
                                            value="{{ old('phone') }}"
                                            placeholder="0912..."
                                        >

                                        @error('phone')
                                        <span class="contact-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="contact-form-group">
                                        <label for="subject">موضوع پیام</label>
                                        <input
                                            type="text"
                                            id="subject"
                                            name="subject"
                                            class="contact-form-control"
                                            value="{{ old('subject') }}"
                                            placeholder="موضوع درخواست شما"
                                        >

                                        @error('subject')
                                        <span class="contact-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="contact-form-group full">
                                        <label for="message">متن پیام</label>
                                        <textarea
                                            id="message"
                                            name="message"
                                            class="contact-form-control"
                                            placeholder="پیام خود را اینجا بنویسید..."
                                        >{{ old('message') }}</textarea>

                                        @error('message')
                                        <span class="contact-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="contact-submit-btn">
                                    <i class="fa fa-paper-plane"></i>
                                    ارسال پیام
                                </button>
                            </form>

                        </div>
                    </div>

                    <aside class="contact-side-card">

                        <div class="contact-side-hero">
                            <div class="contact-side-pattern"></div>

                            <div class="contact-side-icon">
                                <i class="fa fa-headset"></i>
                            </div>

                            <span>پاسخگوی شما هستیم</span>

                            <h2>راه‌های ارتباط با ما</h2>

                            <p>
                                از طریق اطلاعات زیر می‌توانید با بخش مربوطه ارتباط بگیرید یا موقعیت ما را روی نقشه مشاهده کنید.
                            </p>
                        </div>

                        <div class="contact-side-body">

                            <div class="contact-info-pro-list">

                                @if($contactPage->phone)
                                    <a href="tel:{{ $contactPage->phone }}" class="contact-info-pro-item">
                                        <div class="contact-info-pro-icon">
                                            <i class="fa fa-phone"></i>
                                        </div>

                                        <div>
                                            <small>تلفن ثابت</small>
                                            <strong>{{ $contactPage->phone }}</strong>
                                        </div>

                                        <i class="fa fa-angle-left contact-info-arrow"></i>
                                    </a>
                                @endif

                                @if($contactPage->mobile)
                                    <a href="tel:{{ $contactPage->mobile }}" class="contact-info-pro-item">
                                        <div class="contact-info-pro-icon">
                                            <i class="fa fa-mobile-alt"></i>
                                        </div>

                                        <div>
                                            <small>شماره همراه</small>
                                            <strong>{{ $contactPage->mobile }}</strong>
                                        </div>

                                        <i class="fa fa-angle-left contact-info-arrow"></i>
                                    </a>
                                @endif

                                @if($contactPage->email)
                                    <a href="mailto:{{ $contactPage->email }}" class="contact-info-pro-item">
                                        <div class="contact-info-pro-icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>

                                        <div>
                                            <small>پست الکترونیک</small>
                                            <strong>{{ $contactPage->email }}</strong>
                                        </div>

                                        <i class="fa fa-angle-left contact-info-arrow"></i>
                                    </a>
                                @endif

                                @if($contactPage->address)
                                    <div class="contact-info-pro-item">
                                        <div class="contact-info-pro-icon">
                                            <i class="fa fa-map-marker-alt"></i>
                                        </div>

                                        <div>
                                            <small>آدرس دفتر</small>
                                            <strong>{{ $contactPage->address }}</strong>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            @if(! $contactPage->phone && ! $contactPage->mobile && ! $contactPage->email && ! $contactPage->address)
                                <div class="contact-empty-info">
                                    <i class="fa fa-info-circle"></i>
                                    <p>اطلاعات تماس هنوز از پنل مدیریت ثبت نشده است.</p>
                                </div>
                            @endif

                            @if($contactPage->phone || $contactPage->email)
                                <div class="contact-quick-actions">

                                    @if($contactPage->phone)
                                        <a href="tel:{{ $contactPage->phone }}">
                                            <i class="fa fa-phone"></i>
                                            تماس سریع
                                        </a>
                                    @endif

                                    @if($contactPage->email)
                                        <a href="mailto:{{ $contactPage->email }}">
                                            <i class="fa fa-envelope"></i>
                                            ارسال ایمیل
                                        </a>
                                    @endif

                                </div>
                            @endif

                            <div class="contact-map-pro-box">
                                @if($mapLink)
                                    @if($isIframe)
                                        <div class="contact-map-iframe">
                                            {!! $mapLink !!}
                                        </div>
                                    @elseif($isUrl)
                                        <div class="contact-map-pro-content">
                                            <div class="contact-map-pro-icon">
                                                <i class="fa fa-map-marked-alt"></i>
                                            </div>

                                            <div>
                                                <h3>موقعیت روی نقشه</h3>
                                                <p>برای مشاهده مسیر و موقعیت دقیق، روی دکمه زیر بزنید.</p>
                                            </div>

                                            <a href="{{ $mapLink }}" target="_blank" rel="noopener">
                                                <i class="fa fa-location-arrow"></i>
                                                مشاهده در گوگل مپ
                                            </a>
                                        </div>
                                    @else
                                        <div class="contact-map-pro-content">
                                            <div class="contact-map-pro-icon">
                                                <i class="fa fa-exclamation-circle"></i>
                                            </div>

                                            <div>
                                                <h3>لینک نقشه معتبر نیست</h3>
                                                <p>لطفاً لینک صحیح گوگل مپ یا iframe نقشه را در پنل مدیریت وارد کنید.</p>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    <div class="contact-map-pro-content">
                                        <div class="contact-map-pro-icon">
                                            <i class="fa fa-map"></i>
                                        </div>

                                        <div>
                                            <h3>نقشه ثبت نشده</h3>
                                            <p>لینک نقشه هنوز از پنل مدیریت ثبت نشده است.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </aside>

                </div>
            </div>
        </section>

    </main>
@endsection
