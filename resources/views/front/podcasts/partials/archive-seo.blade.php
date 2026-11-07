@section(
    'seo_title',
    'پادکست‌ها'
)


@section(
    'seo_description',
    'آرشیو پادکست‌ها، گفت‌وگوها، روایت‌ها و فایل‌های صوتی تخصصی IRAPEC.'
)


@section(
    'seo_canonical',
    route('front.podcasts.archive')
)


@section(
    'seo_type',
    'website'
)


@section(
    'seo_image',
    asset(
        'front/img/logo-irapec-min2.png'
    )
)


@push('seo_schema')

    @php

        $podcastArchiveUrl =
            route(
                'front.podcasts.archive'
            );


        /*
        |--------------------------------------------------------------------------
        | Collection Page
        |--------------------------------------------------------------------------
        */

        $podcastSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'CollectionPage',

            '@id' =>
                $podcastArchiveUrl
                . '#webpage',

            'url' =>
                $podcastArchiveUrl,

            'name' =>
                'پادکست‌های IRAPEC',

            'description' =>
                'آرشیو پادکست‌ها، گفت‌وگوها و فایل‌های صوتی IRAPEC.',

            'inLanguage' =>
                'fa-IR',

            'isPartOf' => [

                '@id' =>
                    route('home')
                    . '#website',

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
                        'پادکست‌ها',

                    'item' =>
                        $podcastArchiveUrl,

                ],

            ],

        ];

    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $podcastSchema,
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
