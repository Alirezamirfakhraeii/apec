@section(
    'seo_title',
    $page->meta_title ?: $page->title
)


@section(
    'seo_description',
    $page->meta_description
        ?: config(
            'seo.default_description',
            ''
        )
)


@section(
    'seo_canonical',
    url()->current()
)


@section('seo_type', 'website')


@push('seo_schema')

    @php

        $pageUrl = url()->current();

        $pageDescription =
            $page->meta_description
                ?: config(
                    'seo.default_description',
                    ''
                );


        /*
        |--------------------------------------------------------------------------
        | WebPage Schema
        |--------------------------------------------------------------------------
        */

        $pageSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'WebPage',

            '@id' =>
                $pageUrl . '#webpage',

            'url' =>
                $pageUrl,

            'name' =>
                $page->meta_title
                    ?: $page->title,

            'description' =>
                $pageDescription,

            'inLanguage' =>
                'fa-IR',

            'isPartOf' => [

                '@id' =>
                    route('home') . '#website',

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
                        $page->title,

                    'item' =>
                        $pageUrl,

                ],

            ],

        ];

    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $pageSchema,
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
