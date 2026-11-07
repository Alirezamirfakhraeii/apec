@section(
    'seo_title',
    $post->meta_title ?: $post->title
)


@section(
    'seo_description',
    $post->meta_description
        ?: \Illuminate\Support\Str::limit(
            strip_tags(
                $post->summary ?: $post->body
            ),
            160,
            ''
        )
)


@section(
    'seo_canonical',
    route(
        'front.posts.show',
        $post->slug
    )
)


@section('seo_type', 'article')


@if($post->main_image_url)

    @section(
        'seo_image',
        $post->main_image_url
    )

@endif


@push('seo_schema')

    @php

        $articleUrl = route(
            'front.posts.show',
            $post->slug
        );


        $articleImage =
            $post->main_image_url
                ?: asset(
                    config(
                        'seo.default_image',
                        'front/img/logo-irapec-min2.png'
                    )
                );


        $articleDescription =
            $post->meta_description
                ?: \Illuminate\Support\Str::limit(
                    strip_tags(
                        $post->summary ?: $post->body
                    ),
                    160,
                    ''
                );


        /*
        |--------------------------------------------------------------------------
        | News Article
        |--------------------------------------------------------------------------
        */

        $articleSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'NewsArticle',

            'headline' =>
                $post->title,

            'description' =>
                $articleDescription,

            'image' => [
                $articleImage,
            ],

            'datePublished' => (
                $post->published_at
                    ?: $post->created_at
            )->toIso8601String(),

            'dateModified' =>
                $post->updated_at
                    ->toIso8601String(),

            'mainEntityOfPage' => [

                '@type' =>
                    'WebPage',

                '@id' =>
                    $articleUrl,

            ],

            'author' => [

                '@type' =>
                    'Person',

                'name' =>
                    $post->user->name
                        ?? 'تحریریه IRAPEC',

            ],

            'publisher' => [

                '@type' =>
                    'Organization',

                'name' =>
                    config(
                        'seo.site_name',
                        'IRAPEC'
                    ),

                'logo' => [

                    '@type' =>
                        'ImageObject',

                    'url' =>
                        asset(
                            'front/img/logo-irapec-min2.png'
                        ),

                ],

            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | Breadcrumb
        |--------------------------------------------------------------------------
        */

        $breadcrumbSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'BreadcrumbList',

            'itemListElement' => [

                [

                    '@type' =>
                        'ListItem',

                    'position' =>
                        1,

                    'name' =>
                        'خانه',

                    'item' =>
                        route('home'),

                ],

                [

                    '@type' =>
                        'ListItem',

                    'position' =>
                        2,

                    'name' =>
                        $post->blogCategory->name
                            ?? $post->blogCategory->title
                            ?? 'اخبار',

                ],

                [

                    '@type' =>
                        'ListItem',

                    'position' =>
                        3,

                    'name' =>
                        $post->title,

                    'item' =>
                        $articleUrl,

                ],

            ],

        ];

    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $articleSchema,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        ) !!}
    </script>


    <script type="application/ld+json">
        {!! json_encode(
            $breadcrumbSchema,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        ) !!}
    </script>

@endpush
