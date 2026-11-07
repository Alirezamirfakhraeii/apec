@php

    $categoryTitle =
        $category->name
            ?? $category->title
            ?? 'اخبار';

    $categoryUrl = route(
        'front.news.show',
        $category->slug
    );

    $categoryDescription =
        'آخرین اخبار، گزارش‌ها و مطالب مرتبط با '
        . $categoryTitle
        . ' در وب‌سایت IRAPEC.';

@endphp


@section(
    'seo_title',
    $categoryTitle
)


@section(
    'seo_description',
    $categoryDescription
)


@section(
    'seo_canonical',
    $categoryUrl
)


@section(
    'seo_type',
    'website'
)


@push('seo_schema')

    @php

        $collectionSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'CollectionPage',

            '@id' =>
                $categoryUrl . '#webpage',

            'url' =>
                $categoryUrl,

            'name' =>
                $categoryTitle,

            'description' =>
                $categoryDescription,

            'inLanguage' =>
                'fa-IR',

            'isPartOf' => [

                '@id' =>
                    route('home') . '#website',

            ],

        ];


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
                        $categoryTitle,

                    'item' =>
                        $categoryUrl,

                ],

            ],

        ];

    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $collectionSchema,
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
