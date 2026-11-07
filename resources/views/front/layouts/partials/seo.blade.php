@php

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    */

    $siteName = config(
        'seo.site_name',
        config('app.name', 'IRAPEC')
    );


    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | ابتدا seo_title
    | سپس title قدیمی صفحات
    | سپس عنوان پیش‌فرض
    |
    */

    $seoTitle = trim(
        $__env->yieldContent(
            'seo_title',
            $__env->yieldContent(
                'title',
                config('seo.default_title', $siteName)
            )
        )
    );

    $documentTitle =
        $seoTitle === $siteName
            ? $siteName
            : $seoTitle . ' | ' . $siteName;


    /*
    |--------------------------------------------------------------------------
    | Description
    |--------------------------------------------------------------------------
    */

    $seoDescription = trim(
        $__env->yieldContent(
            'seo_description',
            config('seo.default_description', '')
        )
    );

    $seoDescription = preg_replace(
        '/\s+/u',
        ' ',
        strip_tags($seoDescription)
    );

    $seoDescription = \Illuminate\Support\Str::limit(
        $seoDescription,
        160,
        ''
    );


    /*
    |--------------------------------------------------------------------------
    | Canonical
    |--------------------------------------------------------------------------
    */

    $seoCanonical = trim(
        $__env->yieldContent(
            'seo_canonical',
            url()->current()
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Robots
    |--------------------------------------------------------------------------
    */

    $seoRobots = trim(
        $__env->yieldContent(
            'seo_robots',
            'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1'
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Open Graph
    |--------------------------------------------------------------------------
    */

    $seoType = trim(
        $__env->yieldContent(
            'seo_type',
            'website'
        )
    );

    $defaultImage = asset(
        config(
            'seo.default_image',
            'front/img/logo-irapec-min2.png'
        )
    );

    $seoImage = trim(
        $__env->yieldContent(
            'seo_image',
            $defaultImage
        )
    );


    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    */

    $seoLocale = app()->getLocale() === 'fa'
        ? 'fa_IR'
        : 'en_US';

@endphp


{{-- =========================================================
    Basic SEO
========================================================= --}}

<title>{{ $documentTitle }}</title>

@if($seoDescription)
    <meta
        name="description"
        content="{{ $seoDescription }}"
    >
@endif

<meta
    name="robots"
    content="{{ $seoRobots }}"
>

<link
    rel="canonical"
    href="{{ $seoCanonical }}"
>


{{-- =========================================================
    Open Graph
========================================================= --}}

<meta
    property="og:title"
    content="{{ $documentTitle }}"
>

@if($seoDescription)
    <meta
        property="og:description"
        content="{{ $seoDescription }}"
    >
@endif

<meta
    property="og:type"
    content="{{ $seoType }}"
>

<meta
    property="og:url"
    content="{{ $seoCanonical }}"
>

<meta
    property="og:image"
    content="{{ $seoImage }}"
>

<meta
    property="og:site_name"
    content="{{ $siteName }}"
>

<meta
    property="og:locale"
    content="{{ $seoLocale }}"
>


{{-- =========================================================
    Twitter
========================================================= --}}

<meta
    name="twitter:card"
    content="summary_large_image"
>

<meta
    name="twitter:title"
    content="{{ $documentTitle }}"
>

@if($seoDescription)
    <meta
        name="twitter:description"
        content="{{ $seoDescription }}"
    >
@endif

<meta
    name="twitter:image"
    content="{{ $seoImage }}"
>


{{-- =========================================================
    Extra SEO / Schema
========================================================= --}}

@stack('seo_schema')
