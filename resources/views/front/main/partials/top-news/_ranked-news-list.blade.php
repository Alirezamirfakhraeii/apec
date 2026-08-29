@forelse($posts as $post)

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
        {{ __('home.no_news') }}
    </div>

@endforelse
