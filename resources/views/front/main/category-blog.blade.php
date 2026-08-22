@php
    $isRtl = app()->isLocale('fa');
@endphp


<link rel="stylesheet" href="{{ asset('front/css/components/news-services.css') }}">


<section
    class="container my-5 home-news-services"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
>

    @if(isset($homeCategories) && $homeCategories->count())
        <div class="row">

            @foreach($homeCategories->take(3) as $category)
                <div class="col-lg-4 col-md-6 col-12 mb-4">

                    <div class="home-service-card h-100">

                        {{-- Header --}}
                        <div class="home-service-header">

                            <div class="home-service-title">
                                <span class="home-service-dot"></span>

                                <h3>
                                    {{ $category->name ?? $category->title }}
                                </h3>
                            </div>

                            <a
                                href="{{ route('front.news.show', $category->slug) }}"
                                class="home-service-link"
                            >
                                {{ __('home_services.view_all') }}

                                <i
                                    class="fa {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"
                                    aria-hidden="true"
                                ></i>
                            </a>

                        </div>

                        {{-- Posts --}}
                        <div class="home-service-posts">

                            @if($category->posts?->count())

                                @foreach($category->posts->take(3) as $index => $post)

                                    @php
                                        $postImage = $post->main_image_url
                                            ?? (
                                                $post->image
                                                    ? asset('storage/' . $post->image)
                                                    : asset('front/images/default-news.jpg')
                                            );

                                        $postDate = $post->published_at
                                            ?? $post->created_at;
                                    @endphp

                                    @if($index === 0)

                                        {{-- Featured Post --}}
                                        <article class="home-featured-mini-post">

                                            <a
                                                href="{{ route('front.posts.show', $post->slug) }}"
                                                class="home-featured-mini-img"
                                            >
                                                <img
                                                    src="{{ $postImage }}"
                                                    alt="{{ $post->title }}"
                                                    loading="lazy"
                                                >

                                                <span>
                                                    {{ $category->name ?? $category->title }}
                                                </span>
                                            </a>

                                            <div class="home-featured-mini-body">

                                                <a
                                                    href="{{ route('front.posts.show', $post->slug) }}"
                                                    class="home-featured-mini-title"
                                                >
                                                    {{ $post->title }}
                                                </a>

                                                <div class="home-post-date">
                                                    <i
                                                        class="fa fa-calendar-alt"
                                                        aria-hidden="true"
                                                    ></i>

                                                    @if($isRtl)
                                                        {{ verta($postDate)->format('Y/m/d') }}
                                                    @else
                                                        {{ $postDate->format('Y/m/d') }}
                                                    @endif
                                                </div>

                                            </div>

                                        </article>

                                    @else

                                        {{-- Normal Post --}}
                                        <article
                                            class="home-small-post {{ $index < 2 ? 'with-border' : '' }}"
                                        >

                                            <a
                                                href="{{ route('front.posts.show', $post->slug) }}"
                                                class="home-small-post-img"
                                            >
                                                <img
                                                    src="{{ $postImage }}"
                                                    alt="{{ $post->title }}"
                                                    loading="lazy"
                                                >
                                            </a>

                                            <div class="home-small-post-content">

                                                <a
                                                    href="{{ route('front.posts.show', $post->slug) }}"
                                                    class="home-small-post-title"
                                                >
                                                    {{ $post->title }}
                                                </a>

                                                <div class="home-post-date">
                                                    <i
                                                        class="fa fa-calendar-alt"
                                                        aria-hidden="true"
                                                    ></i>

                                                    @if($isRtl)
                                                        {{ verta($postDate)->format('Y/m/d') }}
                                                    @else
                                                        {{ $postDate->format('Y/m/d') }}
                                                    @endif
                                                </div>

                                            </div>

                                        </article>

                                    @endif

                                @endforeach

                            @else

                                <div class="home-service-empty">
                                    <i
                                        class="fa fa-folder-open"
                                        aria-hidden="true"
                                    ></i>

                                    <p>
                                        {{ __('home_services.no_posts') }}
                                    </p>
                                </div>

                            @endif

                        </div>

                    </div>

                </div>
            @endforeach

        </div>

    @else

        {{-- Placeholder Categories --}}
        <div class="row">

            @for($i = 1; $i <= 3; $i++)
                <div class="col-lg-4 col-md-6 col-12 mb-4">

                    <div class="home-service-card h-100">

                        <div class="home-service-header">

                            <div class="home-service-title">
                                <span class="home-service-dot"></span>

                                <h3>
                                    {{ __('home_services.sample_category', ['number' => $i]) }}
                                </h3>
                            </div>

                        </div>

                        <div class="home-service-empty">

                            <i
                                class="fa fa-newspaper"
                                aria-hidden="true"
                            ></i>

                            <p>
                                {{ __('home_services.sample_posts_message') }}
                            </p>

                        </div>

                    </div>

                </div>
            @endfor

        </div>

    @endif

</section>
