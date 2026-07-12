@include('front.main.partials.top-news.home-top-news-styles')

<div class="home-top-news-section" dir="rtl">
    <div class="row mx-0 home-featured-row-v2">

        {{-- Featured carousel --}}
        <div class="col-lg-6 col-md-12 col-12 px-2 mb-3 mb-lg-0">
            <div id="premiumNewsCarousel"
                 class="carousel slide hero-news-card"
                 data-bs-ride="carousel"
                 data-bs-interval="6000">

                @if(isset($featuredPosts) && $featuredPosts->count())
                    <div class="hero-news-main">
                        <div class="carousel-inner h-100">

                            @foreach($featuredPosts as $index => $post)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                    <article class="hero-news-slide">

                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="hero-news-image">
                                            <img src="{{ $post->main_image_url }}"
                                                 alt="{{ $post->title }}">
                                        </a>

                                        <div class="hero-news-overlay">
                                            <div class="hero-news-content">
                                                <div class="hero-news-meta">
                                                    <span class="hero-news-badge">
                                                        <i class="fa fa-bolt"></i>
                                                        خبر ویژه
                                                    </span>

                                                    <span class="hero-news-time">
                                                        <i class="fa fa-clock"></i>
                                                        {{ jdate($post->created_at)->ago() }}
                                                    </span>
                                                </div>

                                                <a href="{{ route('front.posts.show', $post->slug) }}"
                                                   class="hero-news-title">
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

                        <button class="carousel-control-prev hero-carousel-control hero-carousel-prev"
                                type="button"
                                data-bs-target="#premiumNewsCarousel"
                                data-bs-slide="prev">
                            <i class="fa fa-chevron-right"></i>
                        </button>

                        <button class="carousel-control-next hero-carousel-control hero-carousel-next"
                                type="button"
                                data-bs-target="#premiumNewsCarousel"
                                data-bs-slide="next">
                            <i class="fa fa-chevron-left"></i>
                        </button>
                    </div>

                    <div class="hero-news-list premium-indicators">
                        @foreach($featuredPosts as $index => $post)
                            <button type="button"
                                    data-bs-target="#premiumNewsCarousel"
                                    data-bs-slide-to="{{ $index }}"
                                    class="hero-news-list-item {{ $index == 0 ? 'active' : '' }}"
                                    aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                <span class="hero-list-number">
                                    {{ $index + 1 }}
                                </span>

                                <span class="hero-list-thumb">
                                    <img src="{{ $post->main_image_url }}"
                                         alt="{{ $post->title }}">
                                </span>

                                <span class="hero-list-content">
                                    <strong>
                                        {{ $post->title }}
                                    </strong>

                                    <small>
                                        <i class="fa fa-clock"></i>
                                        {{ jdate($post->created_at)->ago() }}
                                    </small>
                                </span>

                                <span class="hero-list-progress"></span>
                            </button>
                        @endforeach
                    </div>
                @else
                    <div class="hero-news-empty">
                        <i class="fa fa-newspaper"></i>
                        <strong>هنوز خبر ویژه‌ای ثبت نشده است</strong>
                        <span>بعد از ثبت خبرهای ویژه، اسلایدر این بخش فعال می‌شود.</span>
                    </div>
                @endif

            </div>
        </div>

        {{-- Right widgets --}}
        <div class="col-lg-6 col-12 px-2">
            <div class="row mx-0 home-featured-side-row">

                {{-- Trending tabs --}}
                <div class="col-md-6 col-12 px-2 mb-3 mb-md-0">
                    <div class="news-widget-card sticky-top col_z_index home-sticky-widget">

                        <div class="news-tabs-header">
                            <ul class="nav nav-tabs news-modern-tabs border-0" role="tablist">
                                <li class="nav-item flex-fill text-center" role="presentation">
                                    <a class="nav-link active"
                                       id="most-visited-tab"
                                       data-toggle="tab"
                                       data-bs-toggle="tab"
                                       href="#homeMostVisited"
                                       data-bs-target="#homeMostVisited"
                                       role="tab">
                                        <i class="fa fa-eye"></i>
                                        پربازدیدترین‌ها
                                    </a>
                                </li>

                                <li class="nav-item flex-fill text-center" role="presentation">
                                    <a class="nav-link"
                                       id="most-commented-tab"
                                       data-toggle="tab"
                                       data-bs-toggle="tab"
                                       href="#homeMostCommented"
                                       data-bs-target="#homeMostCommented"
                                       role="tab">
                                        <i class="fa fa-comments"></i>
                                        پربحث‌ترین‌ها
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content news-tabs-content">
                            <div class="tab-pane fade show active" id="homeMostVisited" role="tabpanel">
                                @forelse($mostVisited as $post)
                                    <article class="mini-rank-news">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="mini-rank-link">
                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </article>
                                @empty
                                    <div class="mini-widget-empty">
                                        خبری برای نمایش وجود ندارد.
                                    </div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="homeMostCommented" role="tabpanel">
                                @forelse($mostCommented as $post)
                                    <article class="mini-rank-news">
                                        <a href="{{ route('front.posts.show', $post->slug) }}"
                                           class="mini-rank-link">
                                            <span class="mini-rank-dot"></span>

                                            <span class="mini-rank-title">
                                                {{ $post->title }}
                                            </span>

                                            <i class="fa fa-chevron-left"></i>
                                        </a>
                                    </article>
                                @empty
                                    <div class="mini-widget-empty">
                                        خبری برای نمایش وجود ندارد.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Subject of day + ads --}}
                <div class="col-md-6 col-12 px-2">
                    <div class="sticky-top col_z_index subject-stack-equal home-sticky-widget">

                        <div class="subject-day-card">
                            <div class="subject-day-header">
                                <div>
            <span class="subject-day-kicker">
                پرونده ویژه
            </span>

                                    <h3>
                                        سوژه روز
                                    </h3>
                                </div>

                                <i class="fa fa-fire"></i>
                            </div>

                            @if($subjectOfTheDay)
                                <article class="subject-day-body">
                                    <a href="{{ route('front.posts.show', $subjectOfTheDay->slug) }}"
                                       class="subject-day-image">

                                        <img src="{{ $subjectOfTheDay->main_image_url }}"
                                             alt="{{ $subjectOfTheDay->title }}">

                                        <span class="subject-day-badge">
                    امروز
                </span>

                                        <div class="subject-day-overlay">
                                            <h4 class="subject-day-title">
                                                {{ $subjectOfTheDay->title }}
                                            </h4>

                                            <div class="subject-day-stats">
                        <span>
                            <i class="fa fa-eye"></i>
                            {{ $subjectOfTheDay->views_count ?? 0 }}
                        </span>

                                                <span>
                            <i class="fa fa-comment"></i>
                            {{ $subjectOfTheDay->comments_count ?? 0 }}
                        </span>
                                            </div>
                                        </div>
                                    </a>
                                </article>
                            @else
                                <div class="subject-day-empty">
                                    <i class="fa fa-folder-open"></i>
                                    <span>سوژه روز انتخاب نشده است.</span>
                                </div>
                            @endif
                        </div>

                        {{-- Adv --}}
                        <div class="home-ads-stack">
                            <div class="adv-card-v2">
                                <span class="adv-label-v2">تبلیغات</span>

                                <a href="URL_LINK_1" target="_blank" class="adv-link-v2">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         alt="تبلیغات">
                                </a>
                            </div>

                            <div class="adv-card-v2">
                                <span class="adv-label-v2">تبلیغات</span>

                                <a href="URL_LINK_2" target="_blank" class="adv-link-v2">
                                    <img src="{{ asset('front/img/adv.jpg') }}"
                                         alt="تبلیغات">
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@include('front.main.partials.top-news.home-top-news-scripts')
