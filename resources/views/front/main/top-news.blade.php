@php
    $isRtl = app()->isLocale('fa');
@endphp



@once
    <link rel="stylesheet" href="{{ asset('front/css/components/top-news.css') }}">
@endonce

<section
    class="home-top-news-section"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
>
    <div class="row mx-0 home-featured-row-v2">

        {{-- =====================================================
             FEATURED NEWS
        ====================================================== --}}
        <div class="col-lg-6 col-md-12 col-12 px-2 mb-3 mb-lg-0">

            <div
                id="premiumNewsCarousel"
                class="carousel slide hero-news-card"
                data-bs-ride="carousel"
                data-bs-interval="6000"
            >

                @if(isset($featuredPosts) && $featuredPosts->count())

                    <div class="hero-news-main">

                        <div class="carousel-inner h-100">

                            @foreach($featuredPosts as $index => $post)

                                <div
                                    class="carousel-item {{ $index === 0 ? 'active' : '' }} h-100"
                                >

                                    <article class="hero-news-slide">

                                        <a
                                            href="{{ route('front.posts.show', $post->slug) }}"
                                            class="hero-news-image"
                                        >
                                            <img
                                                src="{{ $post->main_image_url }}"
                                                alt="{{ $post->title }}"
                                                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                            >
                                        </a>

                                        <div class="hero-news-overlay">

                                            <div class="hero-news-content">

                                                <div class="hero-news-meta">

                                                    <span class="hero-news-badge">
                                                        <i
                                                            class="fa fa-bolt"
                                                            aria-hidden="true"
                                                        ></i>

                                                        {{ __('featured_news') }}
                                                    </span>

                                                    <span class="hero-news-time">
                                                        <i
                                                            class="fa fa-clock"
                                                            aria-hidden="true"
                                                        ></i>

                                                        {{
                                                            $post->created_at
                                                                ->locale(app()->getLocale())
                                                                ->diffForHumans()
                                                        }}
                                                    </span>

                                                </div>


                                                <a
                                                    href="{{ route('front.posts.show', $post->slug) }}"
                                                    class="hero-news-title"
                                                >
                                                    {{ $post->title }}
                                                </a>


                                                @if(!empty($post->summary))
                                                    <p class="hero-news-summary">
                                                        {{ Str::limit($post->summary, 145) }}
                                                    </p>
                                                @endif

                                            </div>

                                        </div>

                                    </article>

                                </div>

                            @endforeach

                        </div>


                        {{-- Previous --}}
                        <button
                            class="carousel-control-prev hero-carousel-control hero-carousel-prev"
                            type="button"
                            data-bs-target="#premiumNewsCarousel"
                            data-bs-slide="prev"
                            aria-label="{{ __('previous_slide') }}"
                        >
                            <i
                                class="fa {{ $isRtl ? 'fa-chevron-right' : 'fa-chevron-left' }}"
                                aria-hidden="true"
                            ></i>
                        </button>


                        {{-- Next --}}
                        <button
                            class="carousel-control-next hero-carousel-control hero-carousel-next"
                            type="button"
                            data-bs-target="#premiumNewsCarousel"
                            data-bs-slide="next"
                            aria-label="{{ __('next_slide') }}"
                        >
                            <i
                                class="fa {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"
                                aria-hidden="true"
                            ></i>
                        </button>

                    </div>


                    {{-- =================================================
                         CAROUSEL LIST
                    ================================================== --}}
                    <div class="hero-news-list premium-indicators">

                        @foreach($featuredPosts as $index => $post)

                            <button
                                type="button"
                                data-bs-target="#premiumNewsCarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="hero-news-list-item {{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="{{ $post->title }}"
                            >

                                <span class="hero-list-number">
                                    {{ $index + 1 }}
                                </span>


                                <span class="hero-list-thumb">
                                    <img
                                        src="{{ $post->main_image_url }}"
                                        alt=""
                                        loading="lazy"
                                    >
                                </span>


                                <span class="hero-list-content">

                                    <strong>
                                        {{ $post->title }}
                                    </strong>

                                    <small>
                                        <i
                                            class="fa fa-clock"
                                            aria-hidden="true"
                                        ></i>

                                        {{
                                            $post->created_at
                                                ->locale(app()->getLocale())
                                                ->diffForHumans()
                                        }}
                                    </small>

                                </span>


                                <span class="hero-list-progress"></span>

                            </button>

                        @endforeach

                    </div>

                @else

                    <div class="hero-news-empty">

                        <i
                            class="fa fa-newspaper"
                            aria-hidden="true"
                        ></i>

                        <strong>
                            {{ __('no_featured_news_title') }}
                        </strong>

                        <span>
                            {{ __('no_featured_news_description') }}
                        </span>

                    </div>

                @endif

            </div>

        </div>



        {{-- =====================================================
             SIDE WIDGETS
        ====================================================== --}}
        <div class="col-lg-6 col-12 px-2">

            <div class="row mx-0 home-featured-side-row">


                {{-- =================================================
                     TRENDING
                ================================================== --}}
                <div class="col-md-6 col-12 px-2 mb-3 mb-md-0">

                    <div
                        class="news-widget-card sticky-top col_z_index home-sticky-widget"
                    >

                        <div class="news-tabs-header">

                            <ul
                                class="nav nav-tabs news-modern-tabs border-0"
                                role="tablist"
                            >

                                <li
                                    class="nav-item flex-fill text-center"
                                    role="presentation"
                                >

                                    <button
                                        class="nav-link active"
                                        id="most-visited-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#homeMostVisited"
                                        type="button"
                                        role="tab"
                                        aria-controls="homeMostVisited"
                                        aria-selected="true"
                                    >
                                        <i
                                            class="fa fa-eye"
                                            aria-hidden="true"
                                        ></i>

                                        {{ __('most_visited') }}
                                    </button>

                                </li>


                                <li
                                    class="nav-item flex-fill text-center"
                                    role="presentation"
                                >

                                    <button
                                        class="nav-link"
                                        id="most-commented-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#homeMostCommented"
                                        type="button"
                                        role="tab"
                                        aria-controls="homeMostCommented"
                                        aria-selected="false"
                                    >
                                        <i
                                            class="fa fa-comments"
                                            aria-hidden="true"
                                        ></i>

                                        {{ __('most_commented') }}
                                    </button>

                                </li>

                            </ul>

                        </div>


                        <div class="tab-content news-tabs-content">


                            {{-- MOST VISITED --}}
                            <div
                                class="tab-pane fade show active"
                                id="homeMostVisited"
                                role="tabpanel"
                                aria-labelledby="most-visited-tab"
                            >

                                @forelse($mostVisited as $post)

                                    <article class="mini-rank-news">

                                        <a
                                            href="{{ route('front.posts.show', $post->slug) }}"
                                            class="mini-rank-link"
                                        >

                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i
                                                class="fa fa-chevron-left mini-rank-arrow"
                                                aria-hidden="true"
                                            ></i>

                                        </a>

                                    </article>

                                @empty

                                    <div class="mini-widget-empty">
                                        {{ __('no_news') }}
                                    </div>

                                @endforelse

                            </div>



                            {{-- MOST COMMENTED --}}
                            <div
                                class="tab-pane fade"
                                id="homeMostCommented"
                                role="tabpanel"
                                aria-labelledby="most-commented-tab"
                            >

                                @forelse($mostCommented as $post)

                                    <article class="mini-rank-news">

                                        <a
                                            href="{{ route('front.posts.show', $post->slug) }}"
                                            class="mini-rank-link"
                                        >

                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i
                                                class="fa fa-chevron-left mini-rank-arrow"
                                                aria-hidden="true"
                                            ></i>

                                        </a>

                                    </article>

                                @empty

                                    <div class="mini-widget-empty">
                                        {{ __('no_news') }}
                                    </div>

                                @endforelse

                            </div>

                        </div>

                    </div>

                </div>



                {{-- =================================================
                     SUBJECT OF THE DAY + ADS
                ================================================== --}}
                <div class="col-md-6 col-12 px-2">

                    <div
                        class="sticky-top col_z_index subject-stack-equal home-sticky-widget"
                    >


                        {{-- SUBJECT --}}
                        <div class="subject-day-card">

                            <div class="subject-day-header">

                                <div>

                                    <span class="subject-day-kicker">
                                        {{ __('special_file') }}
                                    </span>

                                    <h3>
                                        {{ __('subject_of_day') }}
                                    </h3>

                                </div>


                                <i
                                    class="fa fa-fire subject-day-fire-icon"
                                    aria-hidden="true"
                                ></i>

                            </div>


                            @if($subjectOfTheDay)

                                <article class="subject-day-body">

                                    <a
                                        href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                        class="subject-day-image"
                                    >

                                        <img
                                            src="{{ $subjectOfTheDay->main_image_url }}"
                                            alt="{{ $subjectOfTheDay->title }}"
                                            loading="lazy"
                                        >


                                        <span class="subject-day-badge">
                                            {{ __('today') }}
                                        </span>


                                        <div class="subject-day-overlay">

                                            <h4 class="subject-day-title">
                                                {{ $subjectOfTheDay->title }}
                                            </h4>


                                            <div class="subject-day-stats">

                                                <span>
                                                    <i
                                                        class="fa fa-eye"
                                                        aria-hidden="true"
                                                    ></i>

                                                    {{ $subjectOfTheDay->views_count ?? 0 }}
                                                </span>


                                                <span>
                                                    <i
                                                        class="fa fa-comment"
                                                        aria-hidden="true"
                                                    ></i>

                                                    {{ $subjectOfTheDay->comments_count ?? 0 }}
                                                </span>

                                            </div>

                                        </div>

                                    </a>

                                </article>

                            @else

                                <div class="subject-day-empty">

                                    <i
                                        class="fa fa-folder-open"
                                        aria-hidden="true"
                                    ></i>

                                    <span>
                                        {{ __('no_subject') }}
                                    </span>

                                </div>

                            @endif

                        </div>



                        {{-- =================================================
                             ADS
                        ================================================== --}}
                        <div class="home-ads-stack">


                            <div class="adv-card-v2">

                                <span class="adv-label-v2">
                                    {{ __('advertisement') }}
                                </span>

                                <a
                                    href="URL_LINK_1"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="adv-link-v2"
                                >

                                    <img
                                        src="{{ asset('front/img/adv.jpg') }}"
                                        alt="{{ __('advertisement') }}"
                                        loading="lazy"
                                    >

                                </a>

                            </div>



                            <div class="adv-card-v2">

                                <span class="adv-label-v2">
                                    {{ __('advertisement') }}
                                </span>

                                <a
                                    href="URL_LINK_2"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="adv-link-v2"
                                >

                                    <img
                                        src="{{ asset('front/img/adv.jpg') }}"
                                        alt="{{ __('advertisement') }}"
                                        loading="lazy"
                                    >

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</section>

<script src="{{asset('front/js/components/top-news.js')}}"></script>
