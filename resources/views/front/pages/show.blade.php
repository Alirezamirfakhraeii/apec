@extends('front.layouts.master')

@section('title', $page->meta_title ?: $page->title)

@section('content')
    <main class="static-page-wrapper" dir="rtl">

        <section class="static-page-hero">
            <div class="container">
                <div class="static-page-hero-inner">
                    <div class="static-page-breadcrumb">
                        <a href="{{ url('/') }}">خانه</a>
                        <span>/</span>
                        <span>{{ $page->title }}</span>
                    </div>

                    <h1>{{ $page->title }}</h1>

                    <p>{{ $page->summary }}</p>

                </div>
            </div>
        </section>

        <section class="static-page-section">
            <div class="container">
                <div class="static-page-layout">

                    <article class="static-page-card">
                        <div class="static-page-meta">
                            <span>صفحه ثابت</span>

                            @if($page->updated_at)
                                <span>
                                    آخرین بروزرسانی:
                                    {{ $page->updated_at->format('Y/m/d') }}
                                </span>
                            @endif
                        </div>

                        <div class="static-page-content">
                            {!! $page->body !!}
                        </div>
                    </article>

                    <aside class="static-page-sidebar">
                        <div class="sidebar-box">
                            <h3>دسترسی سریع</h3>

                            <ul>
                                <li>
                                    <a href="{{ url('/') }}">صفحه اصلی</a>
                                </li>

                                <li>
                                    <a href="javascript:history.back()">بازگشت به صفحه قبل</a>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-box sidebar-highlight">
                            <h3>اطلاعات صفحه</h3>

                            <p>
                                این صفحه جهت معرفی، اطلاع‌رسانی و دسترسی بهتر کاربران به محتوای سایت ایجاد شده است.
                            </p>
                        </div>
                    </aside>

                </div>
            </div>
        </section>

    </main>
@endsection

@push('styles')
    <style>
        .static-page-wrapper {
            background: #f6f7fb;
            color: #1f2937;
        }

        .static-page-hero {
            background:
                radial-gradient(circle at top left, rgba(13, 110, 253, 0.12), transparent 35%),
                linear-gradient(135deg, #ffffff 0%, #f2f5fb 100%);
            padding: 70px 0 55px;
            border-bottom: 1px solid #e5e7eb;
        }

        .static-page-hero-inner {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }

        .static-page-breadcrumb {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 8px 18px;
            margin-bottom: 22px;
            font-size: 13px;
            color: #6b7280;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
        }

        .static-page-breadcrumb a {
            color: #2563eb;
            text-decoration: none;
        }

        .static-page-hero h1 {
            font-size: 36px;
            font-weight: 800;
            line-height: 1.5;
            color: #111827;
            margin-bottom: 16px;
        }

        .static-page-hero p {
            font-size: 16px;
            line-height: 2;
            color: #6b7280;
            margin: 0 auto;
            max-width: 760px;
        }

        .static-page-section {
            padding: 45px 0 70px;
        }

        .static-page-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 300px;
            gap: 25px;
            align-items: start;
        }

        .static-page-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 34px;
            box-shadow: 0 15px 45px rgba(15, 23, 42, 0.06);
        }

        .static-page-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 26px;
            padding-bottom: 18px;
            border-bottom: 1px solid #eef0f4;
        }

        .static-page-meta span {
            background: #f3f4f6;
            color: #6b7280;
            font-size: 12px;
            padding: 7px 13px;
            border-radius: 999px;
        }

        .static-page-content {
            font-size: 15px;
            line-height: 2.25;
            color: #374151;
        }

        .static-page-content h2,
        .static-page-content h3,
        .static-page-content h4 {
            color: #111827;
            font-weight: 800;
            margin-top: 32px;
            margin-bottom: 14px;
            line-height: 1.7;
        }

        .static-page-content h2 {
            font-size: 24px;
            padding-right: 14px;
            border-right: 4px solid #2563eb;
        }

        .static-page-content h3 {
            font-size: 20px;
        }

        .static-page-content p {
            margin-bottom: 18px;
        }

        .static-page-content ul,
        .static-page-content ol {
            padding-right: 22px;
            margin-bottom: 22px;
        }

        .static-page-content li {
            margin-bottom: 8px;
        }

        .static-page-content blockquote {
            background: #f8fafc;
            border-right: 4px solid #2563eb;
            margin: 28px 0;
            padding: 18px 22px;
            border-radius: 12px;
            color: #4b5563;
            font-weight: 600;
        }

        .static-page-content img {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            margin: 22px 0;
        }

        .static-page-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
            overflow: hidden;
            border-radius: 12px;
        }

        .static-page-content table th,
        .static-page-content table td {
            border: 1px solid #e5e7eb;
            padding: 12px;
        }

        .static-page-content table th {
            background: #f3f4f6;
            color: #111827;
        }

        .static-page-sidebar {
            position: sticky;
            top: 20px;
        }

        .sidebar-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, 0.05);
        }

        .sidebar-box h3 {
            font-size: 17px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 16px;
        }

        .sidebar-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-box ul li {
            margin-bottom: 10px;
        }

        .sidebar-box ul li a {
            display: block;
            background: #f8fafc;
            border-radius: 12px;
            padding: 10px 13px;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar-box ul li a:hover {
            background: #2563eb;
            color: #ffffff;
        }

        .sidebar-highlight {
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            border: none;
        }

        .sidebar-highlight h3,
        .sidebar-highlight p {
            color: #ffffff;
        }

        .sidebar-highlight p {
            line-height: 2;
            margin-bottom: 0;
            font-size: 14px;
        }

        @media (max-width: 991px) {
            .static-page-layout {
                grid-template-columns: 1fr;
            }

            .static-page-sidebar {
                position: static;
            }

            .static-page-hero {
                padding: 50px 0 40px;
            }

            .static-page-hero h1 {
                font-size: 28px;
            }

            .static-page-card {
                padding: 24px;
            }
        }

        @media (max-width: 575px) {
            .static-page-hero h1 {
                font-size: 24px;
            }

            .static-page-hero p {
                font-size: 14px;
            }

            .static-page-card {
                padding: 20px;
                border-radius: 14px;
            }

            .static-page-content {
                font-size: 14px;
            }
        }
    </style>
@endpush
