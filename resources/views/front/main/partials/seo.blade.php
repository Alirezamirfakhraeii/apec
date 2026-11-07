@section(
    'seo_title',
    'IRAPEC | انجمن اپک'
)

@section(
    'seo_description',
    'وب‌سایت رسمی IRAPEC؛ اخبار، رویدادها، اعضای انجمن و محتوای تخصصی حوزه صنعت و پروژه‌های مرتبط.'
)

@section(
    'seo_canonical',
    route('home')
)

@section(
    'seo_type',
    'website'
)

@section(
    'seo_image',
    asset('front/img/logo-irapec-min2.png')
)


@push('seo_schema')

    @php

        $homeUrl = route('home');

        $logoUrl = asset(
            'front/img/logo-irapec-min2.png'
        );


        /*
        |--------------------------------------------------------------------------
        | Organization
        |--------------------------------------------------------------------------
        */

        $organizationSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'Organization',

            '@id' =>
                $homeUrl . '#organization',

            'name' =>
                'IRAPEC',

            'alternateName' =>
                'انجمن اپک',

            'url' =>
                $homeUrl,

            'logo' => [

                '@type' =>
                    'ImageObject',

                'url' =>
                    $logoUrl,

            ],

        ];


        /*
        |--------------------------------------------------------------------------
        | WebSite
        |--------------------------------------------------------------------------
        */

        $websiteSchema = [

            '@context' =>
                'https://schema.org',

            '@type' =>
                'WebSite',

            '@id' =>
                $homeUrl . '#website',

            'url' =>
                $homeUrl,

            'name' =>
                'IRAPEC',

            'alternateName' =>
                'انجمن اپک',

            'inLanguage' =>
                'fa-IR',

            'publisher' => [

                '@id' =>
                    $homeUrl . '#organization',

            ],

        ];

    @endphp


    <script type="application/ld+json">
        {!! json_encode(
            $organizationSchema,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        ) !!}
    </script>


    <script type="application/ld+json">
        {!! json_encode(
            $websiteSchema,
            JSON_UNESCAPED_UNICODE
            | JSON_UNESCAPED_SLASHES
        ) !!}
    </script>

@endpush
