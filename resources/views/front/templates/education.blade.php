@extends('front.layouts.master')

@section('content')
    <main class="education-page-wrapper" dir="rtl">

        <section class="education-hero">
            <div class="container">
                <div class="education-breadcrumb">
                    <a href="{{ url('/') }}">خانه</a>

                    @foreach($segments as $segment)
                        <span>/</span>
                        <span>{{ str_replace('-', ' ', $segment) }}</span>
                    @endforeach
                </div>

                <h1 class="education-title">
                    @if($mode === 'page' && $page)
                        {{ $page->title }}
                    @elseif($mode === 'category' && $category)
                        {{ $category->title }}
                    @else
                        آموزش، پژوهش و فناوری
                    @endif
                </h1>

                @if($mode === 'page' && $page && $page->summary)
                    <p class="education-summary">{{ $page->summary }}</p>
                @elseif($mode === 'category' && $category && isset($category->description))
                    <p class="education-summary">{{ $category->description }}</p>
                @endif
            </div>
        </section>

        <section class="education-content-section">
            <div class="container">
                <div class="education-layout">

                    <aside class="education-sidebar">
                        <div class="education-sidebar-card">
                            <h3>بخش آموزش</h3>

                            <ul>
                                <li><a href="{{ url('/education/announcements') }}">اطلاعیه‌ها</a></li>
                                <li><a href="{{ url('/education/research') }}">پژوهش</a></li>
                                <li><a href="{{ url('/education/reports') }}">گزارشات آموزش</a></li>
                                <li><a href="{{ url('/education/events') }}">رویدادها</a></li>
                            </ul>
                        </div>
                    </aside>

                    <div class="education-main-content">

                        @if($mode === 'page' && $page)
                            <article class="education-page-body">
                                {!! $page->body !!}
                            </article>
                        @endif

                        @if($mode === 'category' && $category)
                            <div class="education-posts-grid">
                                @forelse($posts as $post)
                                    <article class="education-post-card">
                                        @if(!empty($post->main_image_url))
                                            <a href="{{ route('front.posts.show', $post->slug) }}">
                                                <img src="{{ $post->main_image_url }}" alt="{{ $post->title }}">
                                            </a>
                                        @endif

                                        <div class="education-post-content">
                                            <h2>
                                                <a href="{{ route('front.posts.show', $post->slug) }}">
                                                    {{ $post->title }}
                                                </a>
                                            </h2>

                                            @if(!empty($post->summary))
                                                <p>{{ $post->summary }}</p>
                                            @endif

                                            <a class="education-read-more" href="{{ route('front.posts.show', $post->slug) }}">
                                                مشاهده جزئیات
                                            </a>
                                        </div>
                                    </article>
                                @empty
                                    <div class="education-empty">
                                        محتوایی برای این بخش ثبت نشده است.
                                    </div>
                                @endforelse
                            </div>

                            <div class="education-pagination">
                                {{ $posts->links() }}
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection

@push('styles')
    <style>
        .education-page-wrapper {
            background: #f7f8fb;
            min-height: 100vh;
            color: #1f2937;
        }

        .education-hero {
            background: linear-gradient(135deg, #10233f, #1d4f7a);
            padding: 60px 0 70px;
            color: #fff;
        }

        .education-breadcrumb {
            font-size: 13px;
            margin-bottom: 18px;
            opacity: 0.85;
        }

        .education-breadcrumb a {
            color: #fff;
            text-decoration: none;
        }

        .education-breadcrumb span {
            margin: 0 5px;
        }

        .education-title {
            font-size: 34px;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .education-summary {
            max-width: 760px;
            line-height: 2;
            font-size: 15px;
            opacity: 0.95;
        }

        .education-content-section {
            padding: 45px 0;
        }

        .education-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 25px;
            align-items: start;
        }

        .education-sidebar-card,
        .education-main-content {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08);
            border: 1px solid #e8edf5;
        }

        .education-sidebar-card {
            padding: 22px;
        }

        .education-sidebar-card h3 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .education-sidebar-card ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .education-sidebar-card li {
            border-bottom: 1px solid #eef2f7;
        }

        .education-sidebar-card li:last-child {
            border-bottom: 0;
        }

        .education-sidebar-card a {
            display: block;
            padding: 12px 0;
            color: #334155;
            text-decoration: none;
            font-size: 14px;
        }

        .education-sidebar-card a:hover {
            color: #1d4f7a;
        }

        .education-main-content {
            padding: 28px;
        }

        .education-page-body {
            line-height: 2.2;
            font-size: 15px;
            color: #334155;
        }

        .education-posts-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .education-post-card {
            border: 1px solid #e8edf5;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            transition: 0.2s ease;
        }

        .education-post-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        }

        .education-post-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            display: block;
        }

        .education-post-content {
            padding: 18px;
        }

        .education-post-content h2 {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 10px;
            line-height: 1.8;
        }

        .education-post-content h2 a {
            color: #1f2937;
            text-decoration: none;
        }

        .education-post-content p {
            font-size: 14px;
            color: #64748b;
            line-height: 2;
            margin-bottom: 14px;
        }

        .education-read-more {
            color: #1d4f7a;
            font-weight: 700;
            font-size: 13px;
            text-decoration: none;
        }

        .education-empty {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            padding: 25px;
            border-radius: 14px;
            text-align: center;
            color: #64748b;
            grid-column: 1 / -1;
        }

        .education-pagination {
            margin-top: 25px;
        }

        @media (max-width: 992px) {
            .education-layout {
                grid-template-columns: 1fr;
            }

            .education-posts-grid {
                grid-template-columns: 1fr;
            }

            .education-title {
                font-size: 26px;
            }
        }
    </style>
@endpush
