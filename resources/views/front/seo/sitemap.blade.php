<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <url>
        <loc>{{ route('home') }}</loc>
    </url>

    @if(Route::has('front.podcasts.archive'))
        <url>
            <loc>{{ route('front.podcasts.archive') }}</loc>
        </url>
    @endif

    @foreach($categories as $category)

        <url>

            <loc>{{
                route(
                    'front.news.show',
                    $category->slug
                )
            }}</loc>

            @if($category->updated_at)
                <lastmod>{{
                    $category
                        ->updated_at
                        ->toAtomString()
                }}</lastmod>
            @endif

        </url>

    @endforeach

    @foreach($posts as $post)

        <url>

            <loc>{{
                route(
                    'front.posts.show',
                    $post->slug
                )
            }}</loc>

            @if($post->updated_at)
                <lastmod>{{
                    $post
                        ->updated_at
                        ->toAtomString()
                }}</lastmod>
            @endif

        </url>

    @endforeach

    @foreach($pages as $page)

        <url>

            <loc>{{
                route(
                    'front.pages.show',
                    $page->slug
                )
            }}</loc>

            @if($page->updated_at)
                <lastmod>{{
                    $page
                        ->updated_at
                        ->toAtomString()
                }}</lastmod>
            @endif

        </url>

    @endforeach

</urlset>
