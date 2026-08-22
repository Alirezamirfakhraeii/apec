@php
    $isRtl = app()->isLocale('fa');
@endphp

@once
    <link
        rel="stylesheet"
        href="{{ asset('front/css/components/mutimedia.css') }}"
    >
@endonce


<section
    class="magazine-premium-section mt-5"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
>

    {{-- =====================================================
         HEADING
    ====================================================== --}}
    <div class="magazine-premium-heading">

        <div class="magazine-heading-right">

            <span class="magazine-heading-mark"></span>

            <div>
                <span class="magazine-kicker">
                    {{ __('magazine.specialized_archive') }}
                </span>

                <h2>
                    {{ __('magazine.title') }}
                </h2>
            </div>

        </div>


        @if(isset($magazineCategory))
            <a
                href="{{ route('front.categories.show', $magazineCategory->slug) }}"
                class="magazine-archive-btn"
            >
                {{ __('magazine.archive') }}

                <i
                    class="fa {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"
                    aria-hidden="true"
                ></i>
            </a>
        @endif

    </div>


    @if(isset($magazinePosts) && $magazinePosts->count())

        @php
            $mainMagazine = $magazinePosts->first();

            $mainDate = $mainMagazine->published_at
                ?? $mainMagazine->created_at;
        @endphp


        {{-- =====================================================
             MAIN MAGAZINE
        ====================================================== --}}
        <section class="magazine-hero-card">

            <div class="magazine-hero-content">

                <span class="magazine-issue-badge">

                    <i
                        class="fa fa-book-open"
                        aria-hidden="true"
                    ></i>

                    {{ __('magazine.latest_issue') }}

                </span>


                <a
                    href="{{ route('front.posts.show', $mainMagazine->slug) }}"
                    class="magazine-main-title"
                >
                    {{ $mainMagazine->title }}
                </a>


                @if($mainMagazine->summary)

                    <p class="magazine-main-summary">
                        {{ Str::limit($mainMagazine->summary, 220) }}
                    </p>

                @else

                    <p class="magazine-main-summary">
                        {{ __('magazine.default_summary') }}
                    </p>

                @endif


                {{-- =================================================
                     META
                ================================================== --}}
                <div class="magazine-main-meta">

                    <span>
                        <i
                            class="fa fa-calendar-alt"
                            aria-hidden="true"
                        ></i>

                        @if($isRtl)
                            {{ verta($mainDate)->format('Y/m/d') }}
                        @else
                            {{ \Carbon\Carbon::parse($mainDate)->format('Y/m/d') }}
                        @endif
                    </span>


                    <span>
                        <i
                            class="fa fa-layer-group"
                            aria-hidden="true"
                        ></i>

                        {{ __('magazine.publication_name') }}
                    </span>

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="magazine-main-actions">

                    <a
                        href="{{ route('front.posts.show', $mainMagazine->slug) }}"
                        class="magazine-read-btn"
                    >
                        {{ __('magazine.read_latest_issue') }}

                        <i
                            class="fa {{ $isRtl ? 'fa-chevron-left' : 'fa-chevron-right' }}"
                            aria-hidden="true"
                        ></i>
                    </a>


                    @if(isset($magazineCategory))
                        <a
                            href="{{ route('front.categories.show', $magazineCategory->slug) }}"
                            class="magazine-outline-btn"
                        >
                            {{ __('magazine.view_all_issues') }}
                        </a>
                    @endif

                </div>

            </div>



            {{-- =====================================================
                 COVER
            ====================================================== --}}
            <a
                href="{{ route('front.posts.show', $mainMagazine->slug) }}"
                class="magazine-cover-stage"
            >

                <span class="magazine-cover-shadow"></span>


                <div class="magazine-cover-frame">

                    <img
                        src="{{ $mainMagazine->main_image_url }}"
                        alt="{{ $mainMagazine->title }}"
                        loading="lazy"
                    >

                </div>


                <span class="magazine-cover-label">
                    {{ __('magazine.new') }}
                </span>

            </a>

        </section>



        {{-- =====================================================
             PREVIOUS ISSUES
        ====================================================== --}}
        @if($magazinePosts->count() > 1)

            <div class="magazine-mini-heading">

                <h3>
                    {{ __('magazine.previous_issues') }}
                </h3>

                <span>
                    {{ __('magazine.previous_issues_description') }}
                </span>

            </div>


            <div class="magazine-issues-grid">

                @foreach($magazinePosts->skip(1)->take(4) as $post)

                    @php
                        $postDate = $post->published_at
                            ?? $post->created_at;
                    @endphp


                    <article class="magazine-issue-card">

                        <a
                            href="{{ route('front.posts.show', $post->slug) }}"
                            class="magazine-issue-cover"
                        >
                            <img
                                src="{{ $post->main_image_url }}"
                                alt="{{ $post->title }}"
                                loading="lazy"
                            >
                        </a>


                        <div class="magazine-issue-body">

                            <a
                                href="{{ route('front.posts.show', $post->slug) }}"
                                class="magazine-issue-title"
                            >
                                {{ $post->title }}
                            </a>


                            <div class="magazine-issue-footer">

                                <span>
                                    <i
                                        class="fa fa-calendar-alt"
                                        aria-hidden="true"
                                    ></i>

                                    @if($isRtl)
                                        {{ verta($postDate)->format('Y/m/d') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($postDate)->format('Y/m/d') }}
                                    @endif
                                </span>


                                <a
                                    href="{{ route('front.posts.show', $post->slug) }}"
                                >
                                    {{ __('magazine.read') }}

                                    <i
                                        class="fa {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"
                                        aria-hidden="true"
                                    ></i>
                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

        @endif


    @else

        {{-- =====================================================
             EMPTY STATE
        ====================================================== --}}
        <div class="magazine-empty-state">

            <i
                class="fa fa-book-open"
                aria-hidden="true"
            ></i>

            <h3>
                {{ __('magazine.empty_title') }}
            </h3>

            <p>
                {{ __('magazine.empty_description') }}
            </p>

        </div>

    @endif

</section>
