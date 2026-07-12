<?php

return [
    'default' => [
        'label' => 'صفحه ساده',
        'view' => 'front.pages.templates.default',
        'fields' => [],
    ],

    'contact' => [
        'label' => 'تماس با ما',
        'view' => 'front.pages.templates.contact',
        'fields' => [
            [
                'key' => 'phone',
                'label' => 'شماره تماس',
                'type' => 'text',
            ],
            [
                'key' => 'email',
                'label' => 'ایمیل',
                'type' => 'text',
            ],
            [
                'key' => 'address',
                'label' => 'آدرس',
                'type' => 'textarea',
            ],
            [
                'key' => 'map_url',
                'label' => 'لینک یا iframe نقشه',
                'type' => 'textarea',
            ],
        ],
    ],

    'about' => [
        'label' => 'درباره ما',
        'view' => 'front.pages.templates.about',
        'fields' => [
            [
                'key' => 'main_image',
                'label' => 'تصویر اصلی',
                'type' => 'image',
            ],
            [
                'key' => 'mission',
                'label' => 'ماموریت',
                'type' => 'textarea',
            ],
            [
                'key' => 'vision',
                'label' => 'چشم‌انداز',
                'type' => 'textarea',
            ],
        ],
    ],

    'news_index' => [
        'label' => 'لیست اخبار',
        'view' => 'front.pages.templates.news-index',
        'fields' => [
            [
                'key' => 'hero_title',
                'label' => 'عنوان بالای صفحه',
                'type' => 'text',
            ],
            [
                'key' => 'hero_description',
                'label' => 'توضیح بالای صفحه',
                'type' => 'textarea',
            ],
        ],
    ],

    'podcast_index' => [
        'label' => 'لیست پادکست‌ها',
        'view' => 'front.pages.templates.podcast-index',
        'fields' => [
            [
                'key' => 'hero_title',
                'label' => 'عنوان بالای صفحه',
                'type' => 'text',
            ],
            [
                'key' => 'hero_description',
                'label' => 'توضیح بالای صفحه',
                'type' => 'textarea',
            ],
        ],
    ],
];
