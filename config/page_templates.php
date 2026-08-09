<?php


$committeeFields = [
    /*
    |--------------------------------------------------------------------------
    | تصویر اصلی
    |--------------------------------------------------------------------------
    */

    [
        'key' => 'header_image',
        'label' => 'تصویر اصلی صفحه کمیته',
        'type' => 'image',
        'group' => 'main',
        'col' => 'col-md-12',
    ],

    /*
    |--------------------------------------------------------------------------
    | رئیس کمیته
    |--------------------------------------------------------------------------
    */

    [
        'key' => 'chairman_image',
        'label' => 'تصویر رئیس کمیته',
        'type' => 'image',
        'group' => 'chairman',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'chairman_name',
        'label' => 'نام و نام خانوادگی رئیس کمیته',
        'type' => 'text',
        'group' => 'chairman',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'chairman_position',
        'label' => 'سمت رئیس کمیته',
        'type' => 'text',
        'group' => 'chairman',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'chairman_degree',
        'label' => 'مدرک یا تخصص رئیس کمیته',
        'type' => 'text',
        'group' => 'chairman',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'chairman_company',
        'label' => 'شرکت یا سازمان رئیس کمیته',
        'type' => 'text',
        'group' => 'chairman',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'chairman_bio',
        'label' => 'معرفی و سوابق رئیس کمیته',
        'type' => 'textarea',
        'group' => 'chairman',
        'col' => 'col-md-12',
    ],


    /*
|--------------------------------------------------------------------------
| دبیر کمیته
|--------------------------------------------------------------------------
*/

    [
        'key' => 'secretary_image',
        'label' => 'تصویر دبیر کمیته',
        'type' => 'image',
        'group' => 'secretary',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'secretary_name',
        'label' => 'نام و نام خانوادگی دبیر کمیته',
        'type' => 'text',
        'group' => 'secretary',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'secretary_position',
        'label' => 'سمت دبیر کمیته',
        'type' => 'text',
        'group' => 'secretary',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'secretary_degree',
        'label' => 'مدرک یا تخصص دبیر کمیته',
        'type' => 'text',
        'group' => 'secretary',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'secretary_company',
        'label' => 'شرکت یا سازمان دبیر کمیته',
        'type' => 'text',
        'group' => 'secretary',
        'col' => 'col-md-6',
    ],
    [
        'key' => 'secretary_bio',
        'label' => 'معرفی و سوابق دبیر کمیته',
        'type' => 'textarea',
        'group' => 'secretary',
        'col' => 'col-md-12',
    ],


    /*
    |--------------------------------------------------------------------------
    | قائم‌مقام‌ها
    |--------------------------------------------------------------------------
    */

    [
        'key' => 'has_deputies',
        'label' => 'این کمیته قائم‌مقام دارد',
        'type' => 'checkbox',
        'group' => 'deputies',
        'default' => 0,
        'col' => 'col-md-12',
        'help' => 'با فعال‌کردن این گزینه، اطلاعات قائم‌مقام اول نمایش داده می‌شود.',
    ],
    [
        'key' => 'deputy_1_name',
        'label' => 'نام و نام خانوادگی قائم‌مقام اول',
        'type' => 'text',
        'group' => 'deputies',
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_deputies',
            'value' => '1',
        ],
    ],
    [
        'key' => 'deputy_1_image',
        'label' => 'تصویر قائم‌مقام اول',
        'type' => 'image',
        'group' => 'deputies',
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_deputies',
            'value' => '1',
        ],
    ],
    [
        'key' => 'has_second_deputy',
        'label' => 'این کمیته قائم‌مقام دوم دارد',
        'type' => 'checkbox',
        'group' => 'deputies',
        'default' => 0,
        'col' => 'col-md-12',
        'condition' => [
            'field' => 'has_deputies',
            'value' => '1',
        ],
    ],
    [
        'key' => 'deputy_2_name',
        'label' => 'نام و نام خانوادگی قائم‌مقام دوم',
        'type' => 'text',
        'group' => 'deputies',
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_second_deputy',
            'value' => '1',
        ],
    ],
    [
        'key' => 'deputy_2_image',
        'label' => 'تصویر قائم‌مقام دوم',
        'type' => 'image',
        'group' => 'deputies',
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_second_deputy',
            'value' => '1',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | فعال‌سازی کارگروه‌ها
    |--------------------------------------------------------------------------
    */

    [
        'key' => 'has_workgroups',
        'label' => 'این کمیته کارگروه دارد',
        'type' => 'checkbox',
        'group' => 'workgroups',
        'default' => 0,
        'col' => 'col-md-12',
        'help' => 'با فعال‌کردن این گزینه، امکان ثبت حداکثر ۱۰ کارگروه فراهم می‌شود.',
    ],
];

/*
|--------------------------------------------------------------------------
| ساخت خودکار ۱۰ کارگروه
|--------------------------------------------------------------------------
*/

for ($number = 1; $number <= 10; $number++) {
    $committeeFields[] = [
        'key' => "workgroup_{$number}_title",
        'label' => "عنوان کارگروه {$number}",
        'type' => 'text',
        'group' => 'workgroups',
        'subgroup' => "workgroup_{$number}",
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_workgroups',
            'value' => '1',
        ],
    ];

    $committeeFields[] = [
        'key' => "workgroup_{$number}_image",
        'label' => "تصویر کارگروه {$number}",
        'type' => 'image',
        'group' => 'workgroups',
        'subgroup' => "workgroup_{$number}",
        'col' => 'col-md-6',
        'condition' => [
            'field' => 'has_workgroups',
            'value' => '1',
        ],
    ];

    $committeeFields[] = [
        'key' => "workgroup_{$number}_description",
        'label' => "توضیحات کارگروه {$number}",
        'type' => 'textarea',
        'group' => 'workgroups',
        'subgroup' => "workgroup_{$number}",
        'col' => 'col-md-12',
        'condition' => [
            'field' => 'has_workgroups',
            'value' => '1',
        ],
    ];
}



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

        'groups' => [
            'main' => [
                'label' => 'اطلاعات اصلی',
                'description' => 'تصویر اصلی صفحه کمیته',
                'icon' => 'fa fa-image',
            ],

            'chairman' => [
                'label' => 'رئیس کمیته',
                'description' => 'مشخصات و سوابق رئیس کمیته',
                'icon' => 'fa fa-user',
            ],

            'secretary' => [
                'label' => 'دبیر کمیته',
                'description' => 'مشخصات و سوابق دبیر کمیته',
                'icon' => 'fa fa-user-circle',
            ],

            'deputies' => [
                'label' => 'قائم‌مقام‌ها',
                'description' => 'امکان ثبت یک یا دو قائم‌مقام',
                'icon' => 'fa fa-users',
            ],

            'workgroups' => [
                'label' => 'کارگروه‌ها',
                'description' => 'امکان ثبت حداکثر ۱۰ کارگروه',
                'icon' => 'fa fa-sitemap',
            ],
        ],

        'fields' => $committeeFields,
    ],


    '3d-book' => [
        'label' => '3d-book',
        'view' => 'front.pages.templates.3d-book',
        'fields' => [],
    ],





];
