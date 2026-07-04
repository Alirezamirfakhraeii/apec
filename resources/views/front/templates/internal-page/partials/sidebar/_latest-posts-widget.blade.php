{{-- Sidebar: latest posts --}}
@if($latestPosts->count())
    <div class="komyte-widget">
        <div class="komyte-widget-title">
            <span></span>
            <h3>آخرین مطالب</h3>
        </div>

        <div class="komyte-latest-list">
            @foreach($latestPosts->take(5) as $item)
                <a href="{{ route('front.posts.show', $item->slug) }}" class="komyte-latest-item">
                    @if($item->main_image_url ?? $item->image ?? null)
                        <img
                            src="{{ $item->main_image_url ?? asset($item->image) }}"
                            alt="{{ $item->title }}"
                        >
                    @else
                        <span class="komyte-latest-placeholder">
                            {{ mb_substr($item->title, 0, 1) }}
                        </span>
                    @endif

                    <div>
                        <strong>{{ \Illuminate\Support\Str::limit($item->title, 58) }}</strong>
                        <small>
                            {{ optional($item->published_at ?? $item->created_at)->format('Y/m/d') }}
                        </small>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endif
