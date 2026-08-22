@php
    $isRtl = app()->isLocale('fa');
@endphp

@once
    <link
        rel="stylesheet"
        href="{{ asset('front/css/components/podcast.css') }}"
    >
@endonce


<section
    class="podcast-section mt-5"
    id="podcast-section"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"

    data-ready-text="{{ __('podcast.ready_to_play') }}"
    data-playing-text="{{ __('podcast.playing') }}"
    data-default-title="{{ __('podcast.default_title') }}"
    data-no-category="{{ __('podcast.no_category') }}"
>

    {{-- =====================================================
         HEADER
    ====================================================== --}}
    <div class="podcast-section-header">

        <div class="podcast-section-title-wrap">

            <div class="podcast-title-icon">
                <i
                    class="fa fa-headphones"
                    aria-hidden="true"
                ></i>
            </div>

            <div>
                <h2 class="podcast-section-title">
                    {{ __('podcast.title') }}
                </h2>

                <div class="podcast-section-subtitle">
                    {{ __('podcast.subtitle') }}
                </div>
            </div>

        </div>


        <a
            href="{{ route('front.podcasts.archive') }}"
            class="podcast-archive-link"
        >
            {{ __('podcast.archive') }}

            <i
                class="fa {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"
                aria-hidden="true"
            ></i>
        </a>

    </div>


    @if(isset($podcasts) && $podcasts->count())

        @php
            $firstPodcast = $podcasts->first();
        @endphp


        <div class="row">

            {{-- =================================================
                 MAIN PLAYER
            ================================================== --}}
            <div class="col-lg-5 col-12">

                <div class="podcast-feature-card">

                    <img
                        id="main-player-img"
                        src="{{ $firstPodcast->cover_image_url }}"
                        class="podcast-feature-img"
                        alt="{{ $firstPodcast->title }}"
                    >


                    <div class="podcast-feature-overlay"></div>


                    <div class="podcast-feature-content">

                        {{-- Badges --}}
                        <div class="podcast-badge-row">

                            <span class="podcast-badge is-live">

                                <span
                                    class="playing-dot"
                                    id="playing-dot"
                                ></span>

                                <span id="playing-status-text">
                                    {{ __('podcast.ready_to_play') }}
                                </span>

                            </span>


                            <span
                                id="main-player-cat"
                                class="podcast-badge"
                            >
                                <i
                                    class="fa fa-folder"
                                    aria-hidden="true"
                                ></i>

                                {{ $firstPodcast->category
                                    ? $firstPodcast->category->title
                                    : __('podcast.no_category') }}
                            </span>

                        </div>


                        <div>

                            <h3
                                id="main-player-title"
                                class="podcast-feature-title"
                            >
                                {{ $firstPodcast->title }}
                            </h3>


                            <p
                                id="main-player-summary"
                                class="podcast-feature-summary"
                            >
                                {{ $firstPodcast->summary }}
                            </p>


                            {{-- =========================================
                                 PLAYER
                            ========================================== --}}
                            <div class="custom-podcast-player">

                                <audio
                                    id="native-audio-element"
                                    preload="metadata"
                                >
                                    <source
                                        id="main-player-source"
                                        src="{{ $firstPodcast->audio_url
                                            ? asset('storage/' . $firstPodcast->audio_url)
                                            : '' }}"
                                        type="audio/mpeg"
                                    >
                                </audio>


                                <div class="player-main-row">

                                    {{-- Controls --}}
                                    <div class="player-controls">

                                        <button
                                            type="button"
                                            class="player-seek-btn"
                                            id="player-backward-btn"
                                            aria-label="{{ __('podcast.backward_15') }}"
                                        >
                                            <i
                                                class="fa fa-undo"
                                                aria-hidden="true"
                                            ></i>

                                            <span>15</span>
                                        </button>


                                        <button
                                            type="button"
                                            class="player-play-btn"
                                            id="player-play-btn"
                                            aria-label="{{ __('podcast.play') }}"
                                        >
                                            <i
                                                class="fa fa-play"
                                                id="player-play-icon"
                                                aria-hidden="true"
                                            ></i>
                                        </button>


                                        <button
                                            type="button"
                                            class="player-seek-btn"
                                            id="player-forward-btn"
                                            aria-label="{{ __('podcast.forward_15') }}"
                                        >
                                            <i
                                                class="fa fa-repeat"
                                                aria-hidden="true"
                                            ></i>

                                            <span>15</span>
                                        </button>

                                    </div>


                                    {{-- Info --}}
                                    <div class="player-info">

                                        <div class="player-label">
                                            {{ __('podcast.now_playing') }}
                                        </div>

                                        <div
                                            class="player-title"
                                            id="player-current-title"
                                        >
                                            {{ $firstPodcast->title
                                                ?? __('podcast.default_title') }}
                                        </div>

                                    </div>


                                    {{-- Time --}}
                                    <div class="player-time">

                                        <span id="current-time">
                                            00:00
                                        </span>

                                        /

                                        <span id="duration-time">
                                            00:00
                                        </span>

                                    </div>

                                </div>


                                {{-- Progress --}}
                                <div
                                    class="player-progress-wrap"
                                    id="player-progress-wrap"
                                >
                                    <div
                                        class="player-progress"
                                        id="player-progress"
                                    ></div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            {{-- =================================================
                 PODCAST LIST
            ================================================== --}}
            <div class="col-lg-7 col-12">

                <div class="podcast-side-panel">

                    <div class="podcast-panel-head">

                        <h3 class="podcast-panel-title">

                            <i
                                class="fa fa-list-ul"
                                aria-hidden="true"
                            ></i>

                            {{ __('podcast.list_title') }}

                        </h3>


                        <span class="podcast-panel-count">
                            {{ __('podcast.episodes_count', [
                                'count' => $podcasts->count()
                            ]) }}
                        </span>

                    </div>


                    {{-- =========================================
                         CATEGORY FILTER
                    ========================================== --}}
                    <div
                        class="podcast-tabs"
                        id="podcast-tabs-container"
                    >

                        <button
                            type="button"
                            class="podcast-tab-btn filter-tab-btn active"
                            data-target-cat="all"
                        >
                            {{ __('podcast.all_topics') }}
                        </button>


                        @foreach($podcastCategories as $cat)

                            <button
                                type="button"
                                class="podcast-tab-btn filter-tab-btn"
                                data-target-cat="{{ $cat->id }}"
                            >
                                {{ $cat->title }}
                            </button>

                        @endforeach

                    </div>


                    {{-- =========================================
                         PODCAST ITEMS
                    ========================================== --}}
                    <div
                        class="podcast-items-list"
                        id="podcast-items-list"
                    >

                        @foreach($podcasts as $index => $podcast)

                            <div
                                class="podcast-item-row {{ $index === 0 ? 'active-audio-row' : '' }}"

                                data-cat-id="{{ $podcast->category_id ?? 'none' }}"

                                data-title="{{ e($podcast->title) }}"

                                data-summary="{{ e($podcast->summary) }}"

                                data-category="{{ $podcast->category
                                    ? e($podcast->category->title)
                                    : __('podcast.no_category') }}"

                                data-image="{{ $podcast->cover_image_url }}"

                                data-audio="{{ $podcast->audio_url
                                    ? asset('storage/' . $podcast->audio_url)
                                    : '' }}"
                            >

                                <div class="podcast-item-main">

                                    <div class="podcast-item-cover">

                                        <img
                                            src="{{ $podcast->cover_image_url }}"
                                            alt="{{ $podcast->title }}"
                                            loading="lazy"
                                        >

                                    </div>


                                    <div class="podcast-item-body">

                                        @if($podcast->category)

                                            <span class="podcast-item-cat">

                                                <i
                                                    class="fa fa-tags"
                                                    aria-hidden="true"
                                                ></i>

                                                {{ $podcast->category->title }}

                                            </span>

                                        @endif


                                        <h4 class="podcast-item-title">
                                            {{ $podcast->title }}
                                        </h4>


                                        <div class="podcast-item-meta">

                                            <span>
                                                <i
                                                    class="fa fa-calendar"
                                                    aria-hidden="true"
                                                ></i>

                                                {{
                                                    ($podcast->published_at
                                                        ?? $podcast->created_at)
                                                        ->format('Y-m-d')
                                                }}
                                            </span>


                                            @if($podcast->duration)

                                                <span>
                                                    <i
                                                        class="fa fa-clock-o"
                                                        aria-hidden="true"
                                                    ></i>

                                                    {{ $podcast->duration }}
                                                </span>

                                            @endif

                                        </div>

                                    </div>

                                </div>


                                <div class="play-indicator-btn">

                                    <i
                                        class="fa {{ $index === 0
                                            ? 'fa-volume-up'
                                            : 'fa-play' }}"
                                        aria-hidden="true"
                                    ></i>

                                </div>

                            </div>

                        @endforeach


                        <div
                            id="no-podcast-alert"
                            class="podcast-empty-box d-none"
                        >
                            <i
                                class="fa fa-microphone-slash"
                                aria-hidden="true"
                            ></i>

                            {{ __('podcast.no_podcast_in_category') }}
                        </div>

                    </div>

                </div>

            </div>

        </div>


    @else

        {{-- =====================================================
             EMPTY STATE
        ====================================================== --}}
        <div class="podcast-empty-box">

            <i
                class="fa fa-microphone-slash"
                aria-hidden="true"
            ></i>

            {{ __('podcast.empty') }}

        </div>

    @endif

</section>


@once
    <script
        src="{{ asset('front/js/components/podcast.js') }}"
        defer
    ></script>
@endonce
