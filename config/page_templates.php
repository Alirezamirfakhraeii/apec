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


    'committee' => [
        'label' => 'صفحه کمیته',
        'view' => 'front.pages.templates.committee',

        'fields' => [
            [
                'key' => 'header_image',
                'label' => 'تصویر بالای صفحه',
                'type' => 'image',
            ],
            [
                'key' => 'committee_title',
                'label' => 'عنوان کمیته',
                'type' => 'text',
            ],
            [
                'key' => 'committee_description',
                'label' => 'توضیحات کمیته',
                'type' => 'textarea',
            ],

            [
                'key' => 'chairman_image',
                'label' => 'تصویر رئیس کمیته',
                'type' => 'image',
            ],
            [
                'key' => 'chairman_name',
                'label' => 'نام و نام خانوادگی رئیس کمیته',
                'type' => 'text',
            ],
            [
                'key' => 'chairman_position',
                'label' => 'سمت',
                'type' => 'text',
            ],
            [
                'key' => 'chairman_degree',
                'label' => 'مدرک یا تخصص',
                'type' => 'text',
            ],
            [
                'key' => 'chairman_company',
                'label' => 'شرکت یا سازمان',
                'type' => 'text',
            ],
            [
                'key' => 'chairman_bio',
                'label' => 'معرفی و سوابق رئیس کمیته',
                'type' => 'textarea',
            ],

            [
                'key' => 'gallery_image_1',
                'label' => 'تصویر اول گالری',
                'type' => 'image',
            ],
            [
                'key' => 'gallery_image_2',
                'label' => 'تصویر دوم گالری',
                'type' => 'image',
            ],
            [
                'key' => 'gallery_image_3',
                'label' => 'تصویر سوم گالری',
                'type' => 'image',
            ],
            [
                'key' => 'gallery_image_4',
                'label' => 'تصویر چهارم گالری',
                'type' => 'image',
            ],
        ],
    ],





];
