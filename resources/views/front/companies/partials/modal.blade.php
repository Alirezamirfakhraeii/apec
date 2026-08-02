@php
    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    $emptyText = 'ثبت نشده';

    $getValue = function (...$keys) use ($company) {
        foreach ($keys as $key) {
            $value = data_get($company, $key);

            if (filled($value)) {
                return $value;
            }
        }

        return null;
    };

    $displayValue = static function ($value) use ($emptyText) {
        return filled($value) ? $value : $emptyText;
    };

    $displayYesNo = static function ($value) use ($emptyText) {
        if ($value === null || $value === '') {
            return $emptyText;
        }

        return in_array($value, [true, 1, '1', 'true', 'yes', 'بله'], true)
            ? 'بله'
            : 'خیر';
    };

    $website = $getValue('website');
    $websiteUrl = null;

    if ($website) {
        $websiteUrl = preg_match('/^https?:\/\//i', $website)
            ? $website
            : 'https://' . ltrim($website, '/');
    }

    $catalogPath = $getValue(
        'catalog',
        'catalog_path',
        'catalog_file',
        'catalog_pdf'
    );

    $catalogUrl = null;

    if ($catalogPath) {
        $catalogUrl = preg_match('/^https?:\/\//i', $catalogPath)
            ? $catalogPath
            : asset('storage/' . ltrim($catalogPath, '/'));
    }

    $statusClass = match ($company->membership_status) {
        'فعال' => 'active',
        'تعلیق' => 'suspended',
        'لغو' => 'cancelled',
        default => 'unknown',
    };

    $companyActivityFields = $company->relationLoaded('activityFields')
        ? $company->activityFields
        : collect();

    $companyActivityIds = $companyActivityFields
        ->pluck('id')
        ->map(fn ($id) => (int) $id)
        ->all();

    $modalActivitySections = [
        'industry' => [
            'title' => 'زمینه فعالیت در صنعت',
            'icon' => 'fa-industry',
        ],
        'work_field' => [
            'title' => 'زمینه‌های کاری',
            'icon' => 'fa-briefcase',
        ],
        'discipline' => [
            'title' => 'دیسیپلین تخصصی',
            'icon' => 'fa-cogs',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Basic fields
    |--------------------------------------------------------------------------
    */

    $identityFields = [
        [
            'label' => 'نام شرکت (فارسی)',
            'value' => $getValue('registered_name'),
        ],
        [
            'label' => 'نام شرکت (انگلیسی)',
            'value' => $getValue('company_name_en'),
            'dir' => 'ltr',
        ],
        [
            'label' => 'نام اختصاری یا شناخته‌شده',
            'value' => $getValue('company_short_name'),
        ],
        [
            'label' => 'تاریخ ثبت شرکت (شمسی)',
            'value' => $getValue('registration_date'),
        ],
        [
            'label' => 'شماره ثبت شرکت',
            'value' => $getValue('registration_number'),
            'dir' => 'ltr',
        ],
        [
            'label' => 'محل ثبت شرکت',
            'value' => $getValue('registration_place'),
        ],
        [
            'label' => 'شناسه ملی',
            'value' => $getValue('national_id'),
            'dir' => 'ltr',
        ],
        [
            'label' => 'نوع ثبت شرکت',
            'value' => $getValue('company_type'),
        ],
        [
            'label' => 'تاریخ عضویت در انجمن اپک',
            'value' => $getValue('association_join_date', 'membership_date'),
        ],
        [
            'label' => 'شماره عضویت',
            'value' => $getValue('membership_number'),
            'dir' => 'ltr',
        ],
        [
            'label' => 'نوع عضویت',
            'value' => $getValue('membership_type'),
        ],
        [
            'label' => 'وضعیت عضویت',
            'value' => $getValue('membership_status'),
        ],
        [
            'label' => 'سابقه فعالیت شرکت',
            'value' => $getValue(
                'activity_experience_years',
                'experience_years',
                'activity_history_years'
            ),
            'suffix' => 'سال',
        ],
        [
            'label' => 'عضو اتاق بازرگانی می‌باشد؟',
            'value' => $displayYesNo(
                $getValue(
                    'is_chamber_member',
                    'has_valid_chamber_membership_card'
                )
            ),
            'already_displayed' => true,
        ],
    ];

    $contactFields = [
        [
            'label' => 'تلفن ثابت',
            'value' => $getValue('phone', 'landline'),
            'type' => 'phone',
            'dir' => 'ltr',
        ],
        [
            'label' => 'تلفن همراه',
            'value' => $getValue('mobile', 'company_mobile'),
            'type' => 'phone',
            'dir' => 'ltr',
        ],
        [
            'label' => 'نمابر',
            'value' => $getValue('fax'),
            'dir' => 'ltr',
        ],
        [
            'label' => 'پست الکترونیک',
            'value' => $getValue('email'),
            'type' => 'email',
            'dir' => 'ltr',
        ],
        [
            'label' => 'وب‌سایت',
            'value' => $website,
            'type' => 'website',
            'dir' => 'ltr',
        ],
        [
            'label' => 'کد پستی',
            'value' => $getValue('postal_code'),
            'dir' => 'ltr',
        ],
    ];

    /*
    |--------------------------------------------------------------------------
    | Rank structure
    |--------------------------------------------------------------------------
    |
    | هر آیتم چند نام احتمالی ستون دارد تا با نام‌گذاری‌های مختلف دیتابیس
    | سازگار باشد. اگر بعدها رابطه ranks ساخته شود، مقدار آن رابطه نیز خوانده
    | خواهد شد.
    |
    */

    $loadedRanks = $company->relationLoaded('ranks')
        ? $company->ranks
        : collect();

    $getRankValue = function (array $keys, string $title) use ($getValue, $loadedRanks) {
        $columnValue = $getValue(...$keys);

        if (filled($columnValue)) {
            return $columnValue;
        }

        $rankRow = $loadedRanks->first(function ($rank) use ($keys, $title) {
            $rankKey = data_get($rank, 'slug')
                ?? data_get($rank, 'key')
                ?? data_get($rank, 'code');

            $rankTitle = data_get($rank, 'title')
                ?? data_get($rank, 'name');

            return in_array($rankKey, $keys, true) || $rankTitle === $title;
        });

        if (! $rankRow) {
            return null;
        }

        return data_get($rankRow, 'pivot.rank')
            ?? data_get($rankRow, 'pivot.grade')
            ?? data_get($rankRow, 'rank')
            ?? data_get($rankRow, 'grade')
            ?? data_get($rankRow, 'value');
    };

    $rankGroups = [
        [
            'key' => 'contractor',
            'title' => 'پیمانکار',
            'description' => 'رتبه‌های پیمانکاری شرکت در رشته‌های مختلف',
            'icon' => 'fa-hard-hat',
            'items' => [
                [
                    'title' => 'آب',
                    'description' => 'طراحی و اجرای سیستم‌های تأمین آب، ایجاد شبکه‌های توزیع و دفع آب',
                    'keys' => ['contractor_water_rank', 'contractor_water'],
                ],
                [
                    'title' => 'راه و ترابری',
                    'description' => null,
                    'keys' => ['contractor_transportation_rank', 'contractor_road_transport_rank'],
                ],
                [
                    'title' => 'ساختمان و ابنیه',
                    'description' => 'طراحی و اجرای سازه، نازک‌کاری، تأسیسات مکانیکی و برقی، محوطه‌سازی و فضای سبز',
                    'keys' => ['contractor_building_rank', 'contractor_buildings_rank'],
                ],
                [
                    'title' => 'نفت و گاز',
                    'description' => null,
                    'keys' => ['contractor_oil_gas_rank', 'contractor_oil_and_gas_rank'],
                ],
                [
                    'title' => 'نیرو',
                    'description' => 'طراحی و اجرای نیروگاه، پست‌های توزیع برق و شبکه‌های انتقال نیرو',
                    'keys' => ['contractor_power_rank', 'contractor_energy_rank'],
                ],
                [
                    'title' => 'صنعت',
                    'description' => null,
                    'keys' => ['contractor_industry_rank'],
                ],
                [
                    'title' => 'تأسیسات و تجهیزات',
                    'description' => null,
                    'keys' => ['contractor_facilities_equipment_rank', 'contractor_installations_equipment_rank'],
                ],
                [
                    'title' => 'معدن و کاوش‌های زمینی',
                    'description' => null,
                    'keys' => ['contractor_mining_exploration_rank', 'contractor_mining_rank'],
                ],
                [
                    'title' => 'ارتباطات و فناوری اطلاعات',
                    'description' => 'طراحی و اجرای شبکه‌های مخابراتی، تلویزیونی و رادیویی',
                    'keys' => ['contractor_communications_it_rank', 'contractor_ict_rank'],
                ],
                [
                    'title' => 'کشاورزی و فضای سبز',
                    'description' => 'سدها، شبکه‌های آبیاری و زهکشی، توسعه مزارع و باغ‌ها',
                    'keys' => ['contractor_agriculture_green_space_rank', 'contractor_agriculture_rank'],
                ],
                [
                    'title' => 'مدیریت پسماند',
                    'description' => null,
                    'keys' => ['contractor_waste_management_rank'],
                ],
                [
                    'title' => 'حفاظت، مرمت و احیای آثار فرهنگی و تاریخی',
                    'description' => null,
                    'keys' => ['contractor_cultural_heritage_rank', 'contractor_restoration_rank'],
                ],
            ],
        ],
        [
            'key' => 'consultant',
            'title' => 'مشاور',
            'description' => 'رتبه‌های مشاوره شرکت در گروه‌های تخصصی',
            'icon' => 'fa-user-tie',
            'items' => [
                [
                    'title' => 'گروه شهرسازی و معماری',
                    'description' => 'شهرسازی، ساختمان‌های آموزشی، ورزشی، درمانی، مسکونی، تجاری، اداری، صنعتی، معماری داخلی، بافت فرسوده و طراحی شهری',
                    'keys' => ['consultant_urban_architecture_rank', 'consulting_urban_architecture_rank'],
                ],
                [
                    'title' => 'گروه راه و ترابری',
                    'description' => 'راه‌سازی، راه‌آهن، فرودگاه، بندرسازی، سازه‌های دریایی، ترافیک و حمل‌ونقل',
                    'keys' => ['consultant_transportation_rank', 'consulting_transportation_rank'],
                ],
                [
                    'title' => 'گروه مهندسی آب',
                    'description' => 'سدسازی، آبیاری و زهکشی، آب و فاضلاب، حفاظت و مهندسی رودخانه',
                    'keys' => ['consultant_water_engineering_rank', 'consulting_water_rank'],
                ],
                [
                    'title' => 'گروه مطالعات کشاورزی',
                    'description' => 'کشاورزی، منابع طبیعی، دامپروری، شیلات، فضای سبز و گلخانه',
                    'keys' => ['consultant_agriculture_studies_rank', 'consulting_agriculture_rank'],
                ],
                [
                    'title' => 'گروه انرژی',
                    'description' => 'تولید، انتقال و توزیع نیرو، دیسپاچینگ، انرژی هسته‌ای، بهینه‌سازی و انرژی تجدیدپذیر',
                    'keys' => ['consultant_energy_rank', 'consulting_energy_rank'],
                ],
                [
                    'title' => 'گروه ارتباطات و فناوری اطلاعات',
                    'description' => 'امور پستی، طرح‌های جامع ICT، سوئیچینگ و انتقال مخابراتی',
                    'keys' => ['consultant_communications_it_rank', 'consulting_ict_rank'],
                ],
                [
                    'title' => 'گروه صنعت',
                    'description' => 'برق و الکترونیک، سلولزی، شیمیایی، نساجی، پلیمری، حمل‌ونقل، فلزات اساسی، ماشین‌سازی و کانی غیرفلزی',
                    'keys' => ['consultant_industry_rank', 'consulting_industry_rank'],
                ],
                [
                    'title' => 'گروه معدن',
                    'description' => 'پی‌جویی و اکتشاف، آماده‌سازی و بهره‌برداری، کانه‌آرایی و فرآوری مواد',
                    'keys' => ['consultant_mining_rank', 'consulting_mining_rank'],
                ],
                [
                    'title' => 'گروه نفت و گاز',
                    'description' => 'اکتشاف و استخراج، مخازن هیدروکربوری، پالایشگاه، پتروشیمی، خطوط انتقال، تأسیسات بالادستی و شبکه توزیع گاز',
                    'keys' => ['consultant_oil_gas_rank', 'consulting_oil_gas_rank'],
                ],
                [
                    'title' => 'گروه مطالعات آماری',
                    'description' => 'آمار اقتصادی، اجتماعی، صنعت، معدن، زیربنایی، کشاورزی و خدمات',
                    'keys' => ['consultant_statistical_studies_rank', 'consulting_statistics_rank'],
                ],
                [
                    'title' => 'گروه میراث فرهنگی',
                    'description' => 'پژوهش، حفاظت، مرمت، احیا و بهره‌برداری آثار، بناها، محوطه‌ها و بافت‌های تاریخی',
                    'keys' => ['consultant_cultural_heritage_rank', 'consulting_cultural_heritage_rank'],
                ],
                [
                    'title' => 'گروه خدمات مدیریت',
                    'description' => 'مدیریت عمومی، مالی، بازاریابی، منابع انسانی و تولید',
                    'keys' => ['consultant_management_services_rank', 'consulting_management_rank'],
                ],
                [
                    'title' => 'گروه خدمات برنامه‌ریزی و اقتصاد',
                    'description' => 'خدمات اقتصادی، برنامه‌ریزی آموزشی و توسعه منابع انسانی',
                    'keys' => ['consultant_planning_economics_rank', 'consulting_planning_economics_rank'],
                ],
                [
                    'title' => 'گروه تخصص‌های مشترک',
                    'description' => 'ژئوتکنیک، سازه، تأسیسات برق و مکانیک، ژئوفیزیک، محیط زیست، بازرسی فنی، کامپیوتر، ایمنی، زمین‌شناسی، اتوماسیون، مقاوم‌سازی، نقشه‌برداری، GIS، جغرافیا و هواشناسی',
                    'keys' => ['consultant_shared_specialties_rank', 'consulting_common_specialties_rank'],
                ],
            ],
        ],
        [
            'key' => 'industrial_design_build',
            'title' => 'طرح و ساخت صنعتی',
            'description' => 'رتبه‌های طرح و ساخت در حوزه‌های صنعتی',
            'icon' => 'fa-drafting-compass',
            'items' => [
                [
                    'title' => 'نفت و گاز',
                    'description' => 'تولید نفت و گاز، خطوط انتقال، مخازن، تلمبه‌خانه‌ها، شبکه‌ها، پالایشگاه‌ها و پتروشیمی',
                    'keys' => ['industrial_design_build_oil_gas_rank', 'design_build_industrial_oil_gas_rank'],
                ],
                [
                    'title' => 'نیرو',
                    'description' => 'تولید نیرو، پست‌ها، انتقال و توزیع',
                    'keys' => ['industrial_design_build_power_rank', 'design_build_industrial_power_rank'],
                ],
                [
                    'title' => 'صنعت و معدن',
                    'description' => 'صنعت و معدن',
                    'keys' => ['industrial_design_build_industry_mining_rank', 'design_build_industrial_industry_mining_rank'],
                ],
                [
                    'title' => 'ارتباطات',
                    'description' => 'ارتباطات',
                    'keys' => ['industrial_design_build_communications_rank', 'design_build_industrial_communications_rank'],
                ],
                [
                    'title' => 'اتوماسیون صنعتی',
                    'description' => 'کلیه زیررشته‌ها',
                    'keys' => ['industrial_design_build_automation_rank', 'design_build_industrial_automation_rank'],
                ],
            ],
        ],
        [
            'key' => 'non_industrial_design_build',
            'title' => 'طرح و ساخت غیرصنعتی',
            'description' => 'رتبه‌های طرح و ساخت در حوزه‌های غیرصنعتی',
            'icon' => 'fa-city',
            'items' => [
                [
                    'title' => 'ساختمان و ابنیه',
                    'description' => 'ساختمان و ابنیه',
                    'keys' => ['non_industrial_design_build_building_rank', 'design_build_non_industrial_building_rank'],
                ],
                [
                    'title' => 'آب',
                    'description' => 'سدسازی، خطوط انتقال آب، شبکه‌های آب و فاضلاب و سازه‌های دریایی',
                    'keys' => ['non_industrial_design_build_water_rank', 'design_build_non_industrial_water_rank'],
                ],
                [
                    'title' => 'راه و ترابری',
                    'description' => 'راه و ترابری',
                    'keys' => ['non_industrial_design_build_transportation_rank', 'design_build_non_industrial_transportation_rank'],
                ],
                [
                    'title' => 'کشاورزی',
                    'description' => 'کشاورزی',
                    'keys' => ['non_industrial_design_build_agriculture_rank', 'design_build_non_industrial_agriculture_rank'],
                ],
                [
                    'title' => 'حفاظت و مرمت آثار فرهنگی و تاریخی',
                    'description' => 'آثار تاریخی و فرهنگی منقول و غیرمنقول',
                    'keys' => ['non_industrial_design_build_cultural_heritage_rank', 'design_build_non_industrial_cultural_heritage_rank'],
                ],
            ],
        ],
    ];
@endphp

<div class="modal fade company-modal"
     id="companyModal{{ $company->id }}"
     tabindex="-1"
     aria-labelledby="companyModalLabel{{ $company->id }}"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            {{-- Header --}}
            <div class="modal-header company-modal-header">
                <div class="company-modal-heading">
                    <div class="company-modal-logo">
                        @if($company->logo)
                            <img src="{{ asset('storage/' . ltrim($company->logo, '/')) }}"
                                 alt="{{ $company->registered_name ?: 'لوگوی شرکت' }}">
                        @else
                            <div class="company-modal-logo-empty">
                                <i class="fa fa-building"></i>
                            </div>
                        @endif
                    </div>

                    <div class="company-modal-title-wrapper">
                        <span class="company-modal-eyebrow">پروفایل شرکت عضو</span>

                        <h4 class="modal-title"
                            id="companyModalLabel{{ $company->id }}">
                            {{ $displayValue($company->registered_name) }}
                        </h4>

                        <div class="company-modal-en-name" dir="ltr">
                            {{ $displayValue($company->company_name_en) }}
                        </div>

                        <div class="company-modal-header-badges">
                            <span class="companies-status {{ $statusClass }}">
                                وضعیت: {{ $displayValue($company->membership_status) }}
                            </span>

                            <span class="companies-type-badge">
                                نوع عضویت: {{ $displayValue($company->membership_type) }}
                            </span>

                            <span class="company-membership-number">
                                شماره عضویت: {{ $displayValue($company->membership_number) }}
                            </span>
                        </div>
                    </div>
                </div>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="بستن"></button>
            </div>

            {{-- Navigation --}}
            <div class="company-modal-navigation">
                <ul class="nav nav-pills company-modal-tabs"
                    id="companyTabs{{ $company->id }}"
                    role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active"
                                id="identity-tab-{{ $company->id }}"
                                data-bs-toggle="pill"
                                data-bs-target="#identity-panel-{{ $company->id }}"
                                type="button"
                                role="tab">
                            <i class="fa fa-building"></i>
                            <span>شناسنامه شرکت</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="ranks-tab-{{ $company->id }}"
                                data-bs-toggle="pill"
                                data-bs-target="#ranks-panel-{{ $company->id }}"
                                type="button"
                                role="tab">
                            <i class="fa fa-award"></i>
                            <span>رتبه‌ها و صلاحیت‌ها</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="activities-tab-{{ $company->id }}"
                                data-bs-toggle="pill"
                                data-bs-target="#activities-panel-{{ $company->id }}"
                                type="button"
                                role="tab">
                            <i class="fa fa-sitemap"></i>
                            <span>حوزه‌های فعالیت</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link"
                                id="contact-tab-{{ $company->id }}"
                                data-bs-toggle="pill"
                                data-bs-target="#contact-panel-{{ $company->id }}"
                                type="button"
                                role="tab">
                            <i class="fa fa-address-card"></i>
                            <span>تماس و فایل‌ها</span>
                        </button>
                    </li>
                </ul>
            </div>

            <div class="modal-body company-modal-body">
                <div class="tab-content" id="companyTabsContent{{ $company->id }}">

                    {{-- Identity tab --}}
                    <div class="tab-pane fade show active"
                         id="identity-panel-{{ $company->id }}"
                         role="tabpanel"
                         aria-labelledby="identity-tab-{{ $company->id }}">

                        <section class="company-modal-section">
                            <div class="company-modal-section-header">
                                <div class="company-modal-section-icon">
                                    <i class="fa fa-id-card"></i>
                                </div>

                                <div>
                                    <h5>اطلاعات ثبتی و عضویت</h5>
                                    <p>تمام فیلدها حتی در صورت خالی بودن نمایش داده می‌شوند.</p>
                                </div>
                            </div>

                            <div class="company-information-grid">
                                @foreach($identityFields as $field)
                                    @php
                                        $rawValue = $field['value'] ?? null;
                                        $isEmpty = ! filled($rawValue);
                                        $renderedValue = ($field['already_displayed'] ?? false)
                                            ? $rawValue
                                            : $displayValue($rawValue);
                                    @endphp

                                    <div class="company-info-item {{ $isEmpty ? 'is-empty' : '' }}">
                                        <span class="company-info-label">
                                            {{ $field['label'] }}
                                        </span>

                                        <strong class="company-info-value"
                                                dir="{{ $field['dir'] ?? 'rtl' }}">
                                            {{ $renderedValue }}

                                            @if(! $isEmpty && ! empty($field['suffix']))
                                                <small>{{ $field['suffix'] }}</small>
                                            @endif
                                        </strong>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        <section class="company-modal-section">
                            <div class="company-modal-section-header">
                                <div class="company-modal-section-icon">
                                    <i class="fa fa-oil-can"></i>
                                </div>

                                <div>
                                    <h5>تخصص شرکت</h5>
                                    <p>سابقه و تخصص در صنایع نفت، گاز و پتروشیمی</p>
                                </div>
                            </div>

                            @php
                                $oilGasSpecialty = $getValue(
                                    'oil_gas_petchem_specialty',
                                    'oil_gas_specialty',
                                    'industry_specialty',
                                    'specialty_description',
                                    'activity_type'
                                );
                            @endphp

                            <div class="company-long-value {{ filled($oilGasSpecialty) ? '' : 'is-empty' }}">
                                <span class="company-info-label">
                                    نوع تخصص در صنایع نفت، گاز و پتروشیمی
                                </span>

                                <div class="company-long-value-text">
                                    {!! nl2br(e($displayValue($oilGasSpecialty))) !!}
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- Ranks tab --}}
                    <div class="tab-pane fade"
                         id="ranks-panel-{{ $company->id }}"
                         role="tabpanel"
                         aria-labelledby="ranks-tab-{{ $company->id }}">

                        <div class="company-ranks-help">
                            <i class="fa fa-info-circle"></i>
                            <span>
                                رتبه‌ها باید عددی بین ۱ تا ۵ باشند. مقدارهای خالی با عنوان
                                «ثبت نشده» مشخص شده‌اند.
                            </span>
                        </div>

                        <div class="accordion company-ranks-accordion"
                             id="companyRanksAccordion{{ $company->id }}">

                            @foreach($rankGroups as $groupIndex => $rankGroup)
                                <div class="accordion-item company-rank-group">
                                    <h2 class="accordion-header"
                                        id="rankHeading{{ $company->id }}{{ $groupIndex }}">

                                        <button class="accordion-button {{ $groupIndex !== 0 ? 'collapsed' : '' }}"
                                                type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#rankCollapse{{ $company->id }}{{ $groupIndex }}"
                                                aria-expanded="{{ $groupIndex === 0 ? 'true' : 'false' }}">

                                            <span class="company-rank-group-icon">
                                                <i class="fa {{ $rankGroup['icon'] }}"></i>
                                            </span>

                                            <span class="company-rank-group-heading">
                                                <strong>{{ $rankGroup['title'] }}</strong>
                                                <small>{{ $rankGroup['description'] }}</small>
                                            </span>

                                            <span class="company-rank-group-count">
                                                {{ count($rankGroup['items']) }} رشته
                                            </span>
                                        </button>
                                    </h2>

                                    <div id="rankCollapse{{ $company->id }}{{ $groupIndex }}"
                                         class="accordion-collapse collapse {{ $groupIndex === 0 ? 'show' : '' }}"
                                         data-bs-parent="#companyRanksAccordion{{ $company->id }}">

                                        <div class="accordion-body">
                                            <div class="company-rank-list">
                                                @foreach($rankGroup['items'] as $rankItem)
                                                    @php
                                                        $rankValue = $getRankValue(
                                                            $rankItem['keys'],
                                                            $rankItem['title']
                                                        );

                                                        $numericRank = is_numeric($rankValue)
                                                            ? max(1, min(5, (int) $rankValue))
                                                            : null;
                                                    @endphp

                                                    <div class="company-rank-item {{ $numericRank ? 'has-rank' : 'is-empty' }}">
                                                        <div class="company-rank-content">
                                                            <strong class="company-rank-title">
                                                                {{ $rankItem['title'] }}
                                                            </strong>

                                                            @if($rankItem['description'])
                                                                <div class="company-rank-description">
                                                                    {{ $rankItem['description'] }}
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="company-rank-result">
                                                            <div class="company-rank-scale"
                                                                 aria-label="رتبه {{ $numericRank ?: 'ثبت نشده' }}">
                                                                @for($rankNumber = 1; $rankNumber <= 5; $rankNumber++)
                                                                    <span class="company-rank-point {{ $numericRank && $rankNumber <= $numericRank ? 'active' : '' }}">
                                                                        {{ $rankNumber }}
                                                                    </span>
                                                                @endfor
                                                            </div>

                                                            <span class="company-rank-badge {{ $numericRank ? 'has-value' : 'no-value' }}">
                                                                @if($numericRank)
                                                                    رتبه {{ $numericRank }}
                                                                @else
                                                                    ثبت نشده
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Activities tab --}}
                    <div class="tab-pane fade"
                         id="activities-panel-{{ $company->id }}"
                         role="tabpanel"
                         aria-labelledby="activities-tab-{{ $company->id }}">

                        <div class="company-activity-help">
                            <span class="company-activity-help-item selected">
                                <i class="fa fa-check"></i>
                                انتخاب‌شده برای شرکت
                            </span>

                            <span class="company-activity-help-item unselected">
                                <i class="fa fa-minus"></i>
                                انتخاب نشده
                            </span>
                        </div>

                        <div class="company-activity-groups">
                            @foreach($modalActivitySections as $sectionKey => $sectionInfo)
                                @php
                                    $sectionFields = collect(
                                        $activityFields->get($sectionKey, collect())
                                    )->sortBy('sort_order');
                                @endphp

                                <section class="company-activity-group">
                                    <div class="company-activity-group-header">
                                        <span class="company-activity-group-icon">
                                            <i class="fa {{ $sectionInfo['icon'] }}"></i>
                                        </span>

                                        <div>
                                            <h5>{{ $sectionInfo['title'] }}</h5>
                                            <p>
                                                تمام گزینه‌های تعریف‌شده این بخش نمایش داده شده‌اند.
                                            </p>
                                        </div>
                                    </div>

                                    <div class="company-activity-options-display">
                                        @forelse($sectionFields as $activityField)
                                            @php
                                                $isSelected = in_array(
                                                    (int) $activityField->id,
                                                    $companyActivityIds,
                                                    true
                                                );
                                            @endphp

                                            <div class="company-activity-display-item {{ $isSelected ? 'is-selected' : 'is-unselected' }}">
                                                <span class="company-activity-state-icon">
                                                    <i class="fa {{ $isSelected ? 'fa-check' : 'fa-minus' }}"></i>
                                                </span>

                                                <span>{{ $activityField->title }}</span>
                                            </div>
                                        @empty
                                            <div class="company-section-empty">
                                                گزینه‌ای برای این بخش تعریف نشده است.
                                            </div>
                                        @endforelse
                                    </div>
                                </section>
                            @endforeach
                        </div>
                    </div>

                    {{-- Contact tab --}}
                    <div class="tab-pane fade"
                         id="contact-panel-{{ $company->id }}"
                         role="tabpanel"
                         aria-labelledby="contact-tab-{{ $company->id }}">

                        <section class="company-modal-section">
                            <div class="company-modal-section-header">
                                <div class="company-modal-section-icon">
                                    <i class="fa fa-phone"></i>
                                </div>

                                <div>
                                    <h5>راه‌های ارتباطی</h5>
                                    <p>تلفن، ایمیل، وب‌سایت و کد پستی شرکت</p>
                                </div>
                            </div>

                            <div class="company-information-grid">
                                @foreach($contactFields as $field)
                                    @php
                                        $fieldValue = $field['value'] ?? null;
                                        $isEmpty = ! filled($fieldValue);
                                        $fieldType = $field['type'] ?? 'text';
                                    @endphp

                                    <div class="company-info-item {{ $isEmpty ? 'is-empty' : '' }}">
                                        <span class="company-info-label">
                                            {{ $field['label'] }}
                                        </span>

                                        <strong class="company-info-value"
                                                dir="{{ $field['dir'] ?? 'rtl' }}">
                                            @if($fieldType === 'phone' && ! $isEmpty)
                                                <a href="tel:{{ $fieldValue }}">
                                                    {{ $fieldValue }}
                                                </a>
                                            @elseif($fieldType === 'email' && ! $isEmpty)
                                                <a href="mailto:{{ $fieldValue }}">
                                                    {{ $fieldValue }}
                                                </a>
                                            @elseif($fieldType === 'website' && $websiteUrl)
                                                <a href="{{ $websiteUrl }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer">
                                                    {{ $fieldValue }}
                                                </a>
                                            @else
                                                {{ $displayValue($fieldValue) }}
                                            @endif
                                        </strong>
                                    </div>
                                @endforeach
                            </div>
                        </section>

                        @php
                            $addressFa = $getValue('address', 'address_fa');
                            $addressEn = $getValue('address_en', 'english_address');
                            $additionalDescription = $getValue(
                                'additional_description',
                                'description',
                                'notes'
                            );
                        @endphp

                        <section class="company-modal-section">
                            <div class="company-modal-section-header">
                                <div class="company-modal-section-icon">
                                    <i class="fa fa-map-marker-alt"></i>
                                </div>

                                <div>
                                    <h5>نشانی شرکت</h5>
                                    <p>نشانی فارسی و انگلیسی به‌صورت جداگانه</p>
                                </div>
                            </div>

                            <div class="company-address-grid">
                                <div class="company-long-value {{ filled($addressFa) ? '' : 'is-empty' }}">
                                    <span class="company-info-label">نشانی فارسی</span>
                                    <div class="company-long-value-text">
                                        {!! nl2br(e($displayValue($addressFa))) !!}
                                    </div>
                                </div>

                                <div class="company-long-value {{ filled($addressEn) ? '' : 'is-empty' }}"
                                     dir="ltr">
                                    <span class="company-info-label">English Address</span>
                                    <div class="company-long-value-text">
                                        {!! nl2br(e($displayValue($addressEn))) !!}
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="company-modal-section">
                            <div class="company-modal-section-header">
                                <div class="company-modal-section-icon">
                                    <i class="fa fa-file-alt"></i>
                                </div>

                                <div>
                                    <h5>کاتالوگ و توضیحات تکمیلی</h5>
                                    <p>فایل معرفی شرکت و اطلاعات تکمیلی</p>
                                </div>
                            </div>

                            <div class="company-file-card {{ $catalogUrl ? 'has-file' : 'is-empty' }}">
                                <div class="company-file-icon">
                                    <i class="fa fa-file-pdf"></i>
                                </div>

                                <div class="company-file-content">
                                    <strong>کاتالوگ شرکت</strong>
                                    <span>
                                        {{ $catalogUrl ? 'فایل PDF کاتالوگ در دسترس است.' : 'فایل کاتالوگ بارگذاری نشده است.' }}
                                    </span>
                                </div>

                                @if($catalogUrl)
                                    <a href="{{ $catalogUrl }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="company-file-button">
                                        مشاهده کاتالوگ
                                    </a>
                                @else
                                    <span class="company-file-button disabled">
                                        ثبت نشده
                                    </span>
                                @endif
                            </div>

                            <div class="company-long-value mt-3 {{ filled($additionalDescription) ? '' : 'is-empty' }}">
                                <span class="company-info-label">توضیحات تکمیلی</span>
                                <div class="company-long-value-text">
                                    {!! nl2br(e($displayValue($additionalDescription))) !!}
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            {{-- Footer --}}
            <div class="modal-footer company-modal-footer">
                <div class="company-modal-footer-actions">
                    @if($websiteUrl)
                        <a href="{{ $websiteUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn company-website-btn">
                            <i class="fa fa-globe"></i>
                            مشاهده وب‌سایت
                        </a>
                    @endif

                    @if($catalogUrl)
                        <a href="{{ $catalogUrl }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn company-catalog-btn">
                            <i class="fa fa-file-pdf"></i>
                            کاتالوگ شرکت
                        </a>
                    @endif
                </div>

                <button type="button"
                        class="btn company-modal-close-btn"
                        data-bs-dismiss="modal">
                    بستن
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    /* =========================================================
   Company Modal — full profile
========================================================= */

    .company-modal .modal-dialog {
        max-width: 1240px;
    }

    .company-modal .modal-content {
        overflow: hidden;
        background: #f5f7fb;
        border: 0;
        border-radius: 24px;
        box-shadow: 0 32px 90px rgba(15, 23, 42, 0.24);
    }

    .company-modal-header {
        align-items: flex-start;
        padding: 22px 26px;
        background: #fff;
        border-bottom: 1px solid #e6ebf2;
    }

    .company-modal-heading {
        display: flex;
        align-items: center;
        gap: 17px;
        min-width: 0;
    }

    .company-modal-logo {
        display: flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 82px;
        width: 82px;
        height: 82px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 19px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    .company-modal-logo img {
        width: 100%;
        height: 100%;
        padding: 8px;
        object-fit: contain;
    }

    .company-modal-logo-empty {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        color: #94a3b8;
        background: #f1f5f9;
        font-size: 31px;
    }

    .company-modal-title-wrapper {
        min-width: 0;
    }

    .company-modal-eyebrow {
        display: block;
        margin-bottom: 3px;
        color: #b45309;
        font-size: 11px;
        font-weight: 800;
    }

    .company-modal-title-wrapper .modal-title {
        margin: 0;
        color: #0f172a;
        font-size: 21px;
        font-weight: 900;
        line-height: 1.75;
    }

    .company-modal-en-name {
        min-height: 23px;
        margin-top: 1px;
        color: #64748b;
        font-size: 12px;
        text-align: right;
    }

    .company-modal-header-badges {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
        margin-top: 9px;
    }

    .company-membership-number,
    .companies-type-badge,
    .companies-status {
        display: inline-flex;
        align-items: center;
        min-height: 30px;
        padding: 4px 11px;
        border-radius: 9px;
        font-size: 11px;
        font-weight: 800;
    }

    .company-membership-number,
    .companies-type-badge {
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .companies-status.active {
        color: #166534;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .companies-status.suspended {
        color: #92400e;
        background: #fef3c7;
        border: 1px solid #fde68a;
    }

    .companies-status.cancelled {
        color: #991b1b;
        background: #fee2e2;
        border: 1px solid #fecaca;
    }

    .companies-status.unknown {
        color: #64748b;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    /* Navigation */

    .company-modal-navigation {
        padding: 11px 22px 0;
        background: #fff;
    }

    .company-modal-tabs {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px;
        padding: 7px;
        background: #f1f5f9;
        border-radius: 14px;
    }

    .company-modal-tabs .nav-item {
        min-width: 0;
    }

    .company-modal-tabs .nav-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        min-height: 43px;
        padding: 8px 10px;
        color: #64748b;
        background: transparent;
        border: 0;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        transition: 0.2s ease;
    }

    .company-modal-tabs .nav-link:hover {
        color: #0f172a;
        background: rgba(255, 255, 255, 0.7);
    }

    .company-modal-tabs .nav-link.active {
        color: #fff;
        background: #0f172a;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.17);
    }

    .company-modal-body {
        padding: 20px 22px 24px;
    }

    .company-modal-section,
    .company-activity-group {
        margin-bottom: 16px;
        padding: 19px;
        background: #fff;
        border: 1px solid #e4eaf1;
        border-radius: 17px;
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.035);
    }

    .company-modal-section:last-child,
    .company-activity-group:last-child {
        margin-bottom: 0;
    }

    .company-modal-section-header,
    .company-activity-group-header {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 16px;
        padding-bottom: 13px;
        border-bottom: 1px solid #edf1f5;
    }

    .company-modal-section-icon,
    .company-activity-group-icon,
    .company-rank-group-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 41px;
        width: 41px;
        height: 41px;
        color: #fff;
        background: #334155;
        border-radius: 11px;
        font-size: 15px;
    }

    .company-modal-section-header h5,
    .company-activity-group-header h5 {
        margin: 0;
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
    }

    .company-modal-section-header p,
    .company-activity-group-header p {
        margin: 3px 0 0;
        color: #94a3b8;
        font-size: 10px;
        line-height: 1.7;
    }

    /* Information cards */

    .company-information-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
    }

    .company-info-item,
    .company-long-value {
        min-width: 0;
        padding: 13px 14px;
        background: #f8fafc;
        border: 1px solid #e8edf3;
        border-radius: 12px;
    }

    .company-info-item.is-empty,
    .company-long-value.is-empty {
        background: #fafafa;
        border-style: dashed;
    }

    .company-info-label {
        display: block;
        margin-bottom: 6px;
        color: #7c8a9d;
        font-size: 10px;
        font-weight: 800;
    }

    .company-info-value {
        display: block;
        overflow-wrap: anywhere;
        color: #1e293b;
        font-size: 12px;
        font-weight: 800;
        line-height: 1.85;
    }

    .company-info-item.is-empty .company-info-value,
    .company-long-value.is-empty .company-long-value-text {
        color: #a1a9b5;
        font-weight: 600;
    }

    .company-info-value small {
        margin-right: 3px;
        color: #64748b;
        font-size: 10px;
    }

    .company-info-value a {
        color: #2563eb;
        text-decoration: none;
    }

    .company-info-value a:hover {
        text-decoration: underline;
    }

    .company-long-value-text {
        color: #475569;
        font-size: 12px;
        line-height: 2.05;
    }

    .company-address-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    /* Rank tab */

    .company-ranks-help,
    .company-activity-help {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 14px;
        padding: 12px 14px;
        color: #475569;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.8;
    }

    .company-ranks-help i {
        color: #2563eb;
        font-size: 15px;
    }

    .company-ranks-accordion {
        display: grid;
        gap: 11px;
    }

    .company-rank-group {
        overflow: hidden;
        background: #fff;
        border: 1px solid #dfe6ee;
        border-radius: 15px !important;
    }

    .company-rank-group .accordion-button {
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 14px 16px;
        color: #0f172a;
        background: #fff;
        box-shadow: none;
    }

    .company-rank-group .accordion-button:not(.collapsed) {
        background: #f8fafc;
        box-shadow: inset 0 -1px 0 #e5eaf0;
    }

    .company-rank-group .accordion-button::after {
        margin-right: auto;
        margin-left: 0;
    }

    .company-rank-group-heading {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .company-rank-group-heading strong {
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
    }

    .company-rank-group-heading small {
        margin-top: 3px;
        color: #94a3b8;
        font-size: 10px;
        font-weight: 600;
    }

    .company-rank-group-count {
        margin-right: auto;
        padding: 5px 9px;
        color: #64748b;
        background: #f1f5f9;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
    }

    .company-rank-group .accordion-body {
        padding: 10px;
        background: #f8fafc;
    }

    .company-rank-list {
        display: grid;
        gap: 8px;
    }

    .company-rank-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 13px 14px;
        background: #fff;
        border: 1px solid #e7ecf2;
        border-radius: 11px;
    }

    .company-rank-item.is-empty {
        background: #fcfcfd;
        border-style: dashed;
    }

    .company-rank-content {
        min-width: 0;
    }

    .company-rank-title {
        display: block;
        color: #1e293b;
        font-size: 12px;
        font-weight: 900;
    }

    .company-rank-description {
        margin-top: 4px;
        color: #7c8a9d;
        font-size: 10px;
        line-height: 1.85;
    }

    .company-rank-result {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .company-rank-scale {
        display: flex;
        align-items: center;
        gap: 4px;
        direction: ltr;
    }

    .company-rank-point {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 25px;
        height: 25px;
        color: #a1aab7;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        font-size: 9px;
        font-weight: 900;
    }

    .company-rank-point.active {
        color: #fff;
        background: #d97706;
        border-color: #d97706;
    }

    .company-rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 78px;
        min-height: 29px;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 900;
    }

    .company-rank-badge.has-value {
        color: #92400e;
        background: #fef3c7;
        border: 1px solid #fde68a;
    }

    .company-rank-badge.no-value {
        color: #94a3b8;
        background: #f1f5f9;
        border: 1px dashed #d8e0e9;
    }

    /* Activity tab */

    .company-activity-help {
        flex-wrap: wrap;
        background: #fff;
        border-color: #e5eaf0;
    }

    .company-activity-help-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 800;
    }

    .company-activity-help-item.selected {
        color: #166534;
        background: #dcfce7;
    }

    .company-activity-help-item.unselected {
        color: #64748b;
        background: #f1f5f9;
    }

    .company-activity-groups {
        display: grid;
        gap: 13px;
    }

    .company-activity-group {
        margin-bottom: 0;
    }

    .company-activity-options-display {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
    }

    .company-activity-display-item {
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 42px;
        padding: 9px 10px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: 800;
        line-height: 1.7;
    }

    .company-activity-display-item.is-selected {
        color: #166534;
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
    }

    .company-activity-display-item.is-unselected {
        color: #8b96a5;
        background: #f8fafc;
        border: 1px dashed #dce3eb;
    }

    .company-activity-state-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 24px;
        width: 24px;
        height: 24px;
        border-radius: 7px;
    }

    .is-selected .company-activity-state-icon {
        color: #fff;
        background: #16a34a;
    }

    .is-unselected .company-activity-state-icon {
        color: #94a3b8;
        background: #eef2f7;
    }

    .company-section-empty {
        grid-column: 1 / -1;
        padding: 17px;
        color: #94a3b8;
        background: #fafafa;
        border: 1px dashed #dce3eb;
        border-radius: 10px;
        font-size: 11px;
        text-align: center;
    }

    /* File */

    .company-file-card {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px;
        background: #fff7f7;
        border: 1px solid #fecaca;
        border-radius: 12px;
    }

    .company-file-card.is-empty {
        background: #fafafa;
        border-style: dashed;
        border-color: #dce3eb;
    }

    .company-file-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 43px;
        width: 43px;
        height: 43px;
        color: #fff;
        background: #b91c1c;
        border-radius: 11px;
        font-size: 17px;
    }

    .company-file-card.is-empty .company-file-icon {
        color: #94a3b8;
        background: #eef2f7;
    }

    .company-file-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        min-width: 0;
    }

    .company-file-content strong {
        color: #1e293b;
        font-size: 12px;
        font-weight: 900;
    }

    .company-file-content span {
        margin-top: 3px;
        color: #7c8a9d;
        font-size: 10px;
    }

    .company-file-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 35px;
        padding: 7px 12px;
        color: #fff;
        background: #b91c1c;
        border-radius: 9px;
        font-size: 10px;
        font-weight: 900;
        text-decoration: none;
    }

    .company-file-button:hover {
        color: #fff;
        background: #991b1b;
    }

    .company-file-button.disabled {
        color: #94a3b8;
        background: #eef2f7;
    }

    /* Footer */

    .company-modal-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 22px;
        background: #fff;
        border-top: 1px solid #e6ebf2;
    }

    .company-modal-footer-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .company-website-btn,
    .company-catalog-btn,
    .company-modal-close-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        min-height: 39px;
        padding: 8px 15px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 900;
    }

    .company-website-btn {
        color: #fff;
        background: #0f172a;
        border: 1px solid #0f172a;
    }

    .company-website-btn:hover {
        color: #fff;
        background: #334155;
    }

    .company-catalog-btn {
        color: #fff;
        background: #b91c1c;
        border: 1px solid #b91c1c;
    }

    .company-catalog-btn:hover {
        color: #fff;
        background: #991b1b;
    }

    .company-modal-close-btn {
        color: #475569;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
    }

    .company-modal-close-btn:hover {
        color: #0f172a;
        background: #e2e8f0;
    }

    @media (max-width: 992px) {
        .company-information-grid,
        .company-activity-options-display {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .company-modal-tabs {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .company-modal .modal-dialog {
            margin: 9px;
        }

        .company-modal-header {
            padding: 16px;
        }

        .company-modal-heading {
            align-items: flex-start;
        }

        .company-modal-logo {
            flex-basis: 63px;
            width: 63px;
            height: 63px;
        }

        .company-modal-title-wrapper .modal-title {
            font-size: 16px;
        }

        .company-modal-navigation {
            padding: 9px 12px 0;
        }

        .company-modal-tabs {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .company-modal-tabs .nav-item {
            flex: 0 0 auto;
            min-width: 145px;
        }

        .company-modal-body {
            padding: 12px;
        }

        .company-modal-section,
        .company-activity-group {
            padding: 14px;
            border-radius: 13px;
        }

        .company-information-grid,
        .company-address-grid,
        .company-activity-options-display {
            grid-template-columns: 1fr;
        }

        .company-rank-item,
        .company-rank-result {
            align-items: flex-start;
            flex-direction: column;
        }

        .company-rank-result {
            width: 100%;
        }

        .company-rank-group-count {
            display: none;
        }

        .company-file-card {
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .company-file-content {
            flex-basis: calc(100% - 58px);
        }

        .company-file-button {
            width: 100%;
        }

        .company-modal-footer {
            align-items: stretch;
            flex-direction: column;
        }

        .company-modal-footer-actions {
            width: 100%;
        }

        .company-modal-footer-actions .btn,
        .company-modal-close-btn {
            flex: 1;
        }
    }

</style>
