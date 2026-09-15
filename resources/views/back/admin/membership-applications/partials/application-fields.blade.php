@php
    use App\Enums\CompanyType;
    use App\Enums\MembershipDocumentType;
    use App\Support\PersianDate;
    use Illuminate\Support\Collection;

    $mode = $mode ?? 'show';
    $editable = $mode === 'edit';

    $profile = $application->companyProfile;


    /*
    |--------------------------------------------------------------------------
    | Date Helpers
    |--------------------------------------------------------------------------
    */

    $dateText = static function ($value) {
        if (! $value) {
            return '—';
        }

        $date = $value instanceof \Carbon\CarbonInterface
            ? $value
            : \Carbon\Carbon::parse($value);

        return PersianDate::fromGregorian(
            $date->format('Y-m-d')
        );
    };


    $dateValue = static function ($value) {
        if (! $value) {
            return '';
        }

        $date = $value instanceof \Carbon\CarbonInterface
            ? $value
            : \Carbon\Carbon::parse($value);

        return $date->format('Y-m-d');
    };


    /*
    |--------------------------------------------------------------------------
    | Boolean Helper
    |--------------------------------------------------------------------------
    */

    $boolText = static function ($value) {
        if ($value === null) {
            return '—';
        }

        return $value
            ? 'بله'
            : 'خیر';
    };


    /*
    |--------------------------------------------------------------------------
    | Company Type
    |--------------------------------------------------------------------------
    */

    $companyTypeValue =
        $profile?->company_type instanceof CompanyType
            ? $profile->company_type->value
            : $profile?->company_type;


    $companyTypeLabel = $companyTypeValue
        ? CompanyType::tryFrom(
            $companyTypeValue
        )?->label()
        : null;


    /*
    |--------------------------------------------------------------------------
    | Activity Type Flags
    |--------------------------------------------------------------------------
    |
    | این‌ها نوع فعالیت هستند و با activity_fields فرق دارند.
    |
    */

    $activityFlags = [
        'activity_design_consulting' =>
            'طراحی و مشاوره',

        'activity_construction_installation' =>
            'ساخت و نصب',

        'activity_epc' =>
            'EPC',

        'activity_mc' =>
            'MC',

        'activity_manufacturing' =>
            'تولید',
    ];


    /*
    |--------------------------------------------------------------------------
    | Documents
    |--------------------------------------------------------------------------
    */

    $documentsByType = $application
        ->documents
        ->keyBy(function ($document) {
            return $document->type instanceof MembershipDocumentType
                ? $document->type->value
                : $document->type;
        });


    /*
    |--------------------------------------------------------------------------
    | Selected Activity Fields
    |--------------------------------------------------------------------------
    */

    $selectedActivityFieldIds = collect(
        old(
            'activity_fields',
            $application
                ->activityFields
                ->pluck('id')
                ->all()
        )
    )
        ->map(
            fn ($id) => (string) $id
        )
        ->all();


    /*
    |--------------------------------------------------------------------------
    | Activity Fields For Edit
    |--------------------------------------------------------------------------
    |
    | Controller ممکن است Collection ساده یا Grouped Collection بدهد.
    | اینجا هر دو حالت را پشتیبانی می‌کنیم.
    |
    */

    $activityFieldsCollection =
        isset($activityFields)
            ? collect($activityFields)
            : collect();


    if (
        $activityFieldsCollection->isNotEmpty()
        &&
        $activityFieldsCollection->first()
        instanceof Collection
    ) {
        $groupedActivityFields =
            $activityFieldsCollection;
    } else {
        $groupedActivityFields =
            $activityFieldsCollection
                ->groupBy(
                    fn ($field) =>
                        $field->section ?: 'سایر'
                );
    }


    /*
    |--------------------------------------------------------------------------
    | Selected Activity Fields For Show
    |--------------------------------------------------------------------------
    */

    $selectedActivityFieldsGrouped =
        $application
            ->activityFields
            ->groupBy(
                fn ($field) =>
                    $field->section ?: 'سایر'
            );

@endphp


{{-- =========================================================
    Intake
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-user-o ml-1"></i>

                اطلاعات اولیه درخواست
            </h2>

            <p>
                اطلاعات ثبت‌شده هنگام شروع درخواست
            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-form-grid">

                <div class="form-group">

                    <label for="intake_company_name">
                        نام شرکت
                    </label>

                    <input
                        type="text"
                        name="intake_company_name"
                        id="intake_company_name"
                        class="form-control"
                        value="{{ old(
                            'intake_company_name',
                            $application->intake_company_name
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="representative_name">
                        نام نماینده شرکت
                    </label>

                    <input
                        type="text"
                        name="representative_name"
                        id="representative_name"
                        class="form-control"
                        value="{{ old(
                            'representative_name',
                            $application->representative_name
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label for="representative_mobile">
                        موبایل نماینده
                    </label>

                    <input
                        type="text"
                        name="representative_mobile"
                        id="representative_mobile"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'representative_mobile',
                            $application->representative_mobile
                        ) }}"
                    >

                </div>

            </div>

        @else

            <div class="membership-show-grid">

                <div class="membership-info-item">

                    <span>
                        نام شرکت
                    </span>

                    <strong>
                        {{
                            $application->intake_company_name
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        نماینده شرکت
                    </span>

                    <strong>
                        {{
                            $application->representative_name
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        موبایل نماینده
                    </span>

                    <strong dir="ltr">
                        {{
                            $application->representative_mobile
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        کاربر ثبت‌کننده
                    </span>

                    <strong>
                        {{
                            $application->user?->name
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        ایمیل کاربر
                    </span>

                    <strong dir="ltr">
                        {{
                            $application->user?->email
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        تاریخ ارسال
                    </span>

                    <strong>
                        {{
                            $dateText(
                                $application->submitted_at
                            )
                        }}
                    </strong>

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
    Company Identity
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-building-o ml-1"></i>

                مشخصات شرکت
            </h2>

            <p>
                اطلاعات هویتی و عمومی شرکت
            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-form-grid">

                <div class="form-group">

                    <label>
                        نام ثبتی شرکت
                    </label>

                    <input
                        type="text"
                        name="profile[registered_name]"
                        class="form-control"
                        value="{{ old(
                            'profile.registered_name',
                            $profile?->registered_name
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        نام کوتاه
                    </label>

                    <input
                        type="text"
                        name="profile[company_short_name]"
                        class="form-control"
                        value="{{ old(
                            'profile.company_short_name',
                            $profile?->company_short_name
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        نام انگلیسی
                    </label>

                    <input
                        type="text"
                        name="profile[company_name_en]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.company_name_en',
                            $profile?->company_name_en
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        ملیت
                    </label>

                    <input
                        type="text"
                        name="profile[nationality]"
                        class="form-control"
                        value="{{ old(
                            'profile.nationality',
                            $profile?->nationality
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        شرکت مادر
                    </label>

                    <input
                        type="text"
                        name="profile[parent_company_name]"
                        class="form-control"
                        value="{{ old(
                            'profile.parent_company_name',
                            $profile?->parent_company_name
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        نوع شرکت
                    </label>

                    <select
                        name="profile[company_type]"
                        class="form-control"
                    >

                        <option value="">
                            انتخاب کنید
                        </option>

                        @foreach(
                            CompanyType::cases()
                            as $type
                        )

                            <option
                                value="{{ $type->value }}"
                                @selected(
                                    old(
                                        'profile.company_type',
                                        $companyTypeValue
                                    )
                                    ===
                                    $type->value
                                )
                            >
                                {{ $type->label() }}
                            </option>

                        @endforeach

                    </select>

                </div>

            </div>

        @else

            <div class="membership-show-grid">

                <div class="membership-info-item">
                    <span>نام ثبتی شرکت</span>
                    <strong>{{ $profile?->registered_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>نام کوتاه</span>
                    <strong>{{ $profile?->company_short_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>نام انگلیسی</span>
                    <strong dir="ltr">{{ $profile?->company_name_en ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>ملیت</span>
                    <strong>{{ $profile?->nationality ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>شرکت مادر</span>
                    <strong>{{ $profile?->parent_company_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>نوع شرکت</span>
                    <strong>{{ $companyTypeLabel ?: '—' }}</strong>
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
    Registration & Contact
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-id-card-o ml-1"></i>

                اطلاعات ثبتی و تماس
            </h2>

            <p>
                مشخصات ثبت رسمی و راه‌های ارتباطی شرکت
            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-form-grid">

                <div class="form-group">

                    <label>
                        تاریخ ثبت
                    </label>

                    <input
                        type="date"
                        name="profile[registration_date]"
                        class="form-control"
                        value="{{ old(
                            'profile.registration_date',
                            $dateValue(
                                $profile?->registration_date
                            )
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        شماره ثبت
                    </label>

                    <input
                        type="text"
                        name="profile[registration_number]"
                        class="form-control"
                        value="{{ old(
                            'profile.registration_number',
                            $profile?->registration_number
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        محل ثبت
                    </label>

                    <input
                        type="text"
                        name="profile[registration_place]"
                        class="form-control"
                        value="{{ old(
                            'profile.registration_place',
                            $profile?->registration_place
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        شناسه ملی
                    </label>

                    <input
                        type="text"
                        name="profile[national_id]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.national_id',
                            $profile?->national_id
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        سرمایه ثبت‌شده (ریال)
                    </label>

                    <input
                        type="number"
                        name="profile[registered_capital_irr]"
                        class="form-control"
                        value="{{ old(
                            'profile.registered_capital_irr',
                            $profile?->registered_capital_irr
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        تاریخ روزنامه رسمی
                    </label>

                    <input
                        type="date"
                        name="profile[reference_gazette_date]"
                        class="form-control"
                        value="{{ old(
                            'profile.reference_gazette_date',
                            $dateValue(
                                $profile?->reference_gazette_date
                            )
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        تلفن
                    </label>

                    <input
                        type="text"
                        name="profile[phone]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.phone',
                            $profile?->phone
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        فکس
                    </label>

                    <input
                        type="text"
                        name="profile[fax]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.fax',
                            $profile?->fax
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        ایمیل
                    </label>

                    <input
                        type="email"
                        name="profile[email]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.email',
                            $profile?->email
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        وب‌سایت
                    </label>

                    <input
                        type="text"
                        name="profile[website]"
                        class="form-control"
                        dir="ltr"
                        value="{{ old(
                            'profile.website',
                            $profile?->website
                        ) }}"
                    >

                </div>


                <div
                    class="
                        form-group
                        membership-form-span-3
                    "
                >

                    <label>
                        آدرس
                    </label>

                    <textarea
                        name="profile[address]"
                        class="form-control"
                        rows="3"
                    >{{ old(
                        'profile.address',
                        $profile?->address
                    ) }}</textarea>

                </div>

            </div>

        @else

            <div class="membership-show-grid">

                <div class="membership-info-item">
                    <span>تاریخ ثبت</span>
                    <strong>{{ $dateText($profile?->registration_date) }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>شماره ثبت</span>
                    <strong>{{ $profile?->registration_number ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>محل ثبت</span>
                    <strong>{{ $profile?->registration_place ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>شناسه ملی</span>
                    <strong dir="ltr">{{ $profile?->national_id ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">

                    <span>
                        سرمایه ثبت‌شده
                    </span>

                    <strong>

                        @if(
                            $profile?->registered_capital_irr
                            !== null
                        )

                            {{
                                number_format(
                                    (float)
                                    $profile
                                        ->registered_capital_irr
                                )
                            }}

                            ریال

                        @else

                            —

                        @endif

                    </strong>

                </div>

                <div class="membership-info-item">
                    <span>تاریخ روزنامه رسمی</span>
                    <strong>{{ $dateText($profile?->reference_gazette_date) }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>تلفن</span>
                    <strong dir="ltr">{{ $profile?->phone ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>فکس</span>
                    <strong dir="ltr">{{ $profile?->fax ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>ایمیل</span>
                    <strong dir="ltr">{{ $profile?->email ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>وب‌سایت</span>
                    <strong dir="ltr">{{ $profile?->website ?: '—' }}</strong>
                </div>

                <div class="membership-info-item membership-info-span-3">
                    <span>آدرس</span>
                    <strong>{{ $profile?->address ?: '—' }}</strong>
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
    Managers
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-address-card-o ml-1"></i>

                مدیران و رابط انجمن
            </h2>

            <p>
                اطلاعات مدیرعامل، رئیس هیئت‌مدیره و رابط شرکت
            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-form-grid">

                @foreach([
                    ['ceo_name', 'نام مدیرعامل'],
                    ['ceo_mobile', 'موبایل مدیرعامل'],
                    ['ceo_email', 'ایمیل مدیرعامل'],

                    ['chairman_name', 'نام رئیس هیئت‌مدیره'],
                    ['chairman_mobile', 'موبایل رئیس هیئت‌مدیره'],
                    ['chairman_email', 'ایمیل رئیس هیئت‌مدیره'],

                    ['association_contact_name', 'نام رابط انجمن'],
                    ['association_contact_position', 'سمت رابط انجمن'],
                    ['association_contact_mobile', 'موبایل رابط انجمن'],
                    ['association_contact_email', 'ایمیل رابط انجمن'],
                ] as [$field, $label])

                    <div class="form-group">

                        <label>
                            {{ $label }}
                        </label>

                        <input
                            type="{{ str_contains(
                                $field,
                                'email'
                            ) ? 'email' : 'text' }}"
                            name="profile[{{ $field }}]"
                            class="form-control"

                            @if(
                                str_contains($field, 'mobile')
                                ||
                                str_contains($field, 'email')
                            )
                                dir="ltr"
                            @endif

                            value="{{ old(
                                'profile.' . $field,
                                $profile?->{$field}
                            ) }}"
                        >

                    </div>

                @endforeach

            </div>

        @else

            <div class="membership-show-grid">

                <div class="membership-info-item">
                    <span>مدیرعامل</span>
                    <strong>{{ $profile?->ceo_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>موبایل مدیرعامل</span>
                    <strong dir="ltr">{{ $profile?->ceo_mobile ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>ایمیل مدیرعامل</span>
                    <strong dir="ltr">{{ $profile?->ceo_email ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>رئیس هیئت‌مدیره</span>
                    <strong>{{ $profile?->chairman_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>موبایل رئیس هیئت‌مدیره</span>
                    <strong dir="ltr">{{ $profile?->chairman_mobile ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>ایمیل رئیس هیئت‌مدیره</span>
                    <strong dir="ltr">{{ $profile?->chairman_email ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>رابط انجمن</span>
                    <strong>{{ $profile?->association_contact_name ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>سمت رابط</span>
                    <strong>{{ $profile?->association_contact_position ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>موبایل رابط</span>
                    <strong dir="ltr">{{ $profile?->association_contact_mobile ?: '—' }}</strong>
                </div>

                <div class="membership-info-item">
                    <span>ایمیل رابط</span>
                    <strong dir="ltr">{{ $profile?->association_contact_email ?: '—' }}</strong>
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
    Chamber & Activity
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-briefcase ml-1"></i>

                سوابق، عضویت‌ها و حوزه فعالیت
            </h2>

            <p>
                سوابق شرکت، کارت‌ها، تخصص و زمینه‌های کاری
            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-form-grid">

                <div class="form-group">

                    <label>
                        دارای کارت بازرگانی معتبر
                    </label>

                    <select
                        name="profile[has_valid_commercial_card]"
                        class="form-control"
                    >

                        <option value="">
                            نامشخص
                        </option>

                        <option
                            value="1"
                            @selected(
                                (string) old(
                                    'profile.has_valid_commercial_card',
                                    $profile?->has_valid_commercial_card
                                ) === '1'
                            )
                        >
                            بله
                        </option>

                        <option
                            value="0"
                            @selected(
                                (string) old(
                                    'profile.has_valid_commercial_card',
                                    $profile?->has_valid_commercial_card
                                ) === '0'
                            )
                        >
                            خیر
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        اعتبار کارت بازرگانی تا
                    </label>

                    <input
                        type="date"
                        name="profile[commercial_card_valid_until]"
                        class="form-control"
                        value="{{ old(
                            'profile.commercial_card_valid_until',
                            $dateValue(
                                $profile?->commercial_card_valid_until
                            )
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        دارای کارت عضویت اتاق معتبر
                    </label>

                    <select
                        name="profile[has_valid_chamber_membership_card]"
                        class="form-control"
                    >

                        <option value="">
                            نامشخص
                        </option>

                        <option
                            value="1"
                            @selected(
                                (string) old(
                                    'profile.has_valid_chamber_membership_card',
                                    $profile?->has_valid_chamber_membership_card
                                ) === '1'
                            )
                        >
                            بله
                        </option>

                        <option
                            value="0"
                            @selected(
                                (string) old(
                                    'profile.has_valid_chamber_membership_card',
                                    $profile?->has_valid_chamber_membership_card
                                ) === '0'
                            )
                        >
                            خیر
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        اعتبار کارت عضویت تا
                    </label>

                    <input
                        type="date"
                        name="profile[chamber_membership_valid_until]"
                        class="form-control"
                        value="{{ old(
                            'profile.chamber_membership_valid_until',
                            $dateValue(
                                $profile?->chamber_membership_valid_until
                            )
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        استان اتاق
                    </label>

                    <input
                        type="text"
                        name="profile[chamber_province]"
                        class="form-control"
                        value="{{ old(
                            'profile.chamber_province',
                            $profile?->chamber_province
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        عضو اتاق بازرگانی
                    </label>

                    <select
                        name="profile[is_chamber_member]"
                        class="form-control"
                    >

                        <option value="">
                            نامشخص
                        </option>

                        <option
                            value="1"
                            @selected(
                                (string) old(
                                    'profile.is_chamber_member',
                                    $profile?->is_chamber_member
                                ) === '1'
                            )
                        >
                            بله
                        </option>

                        <option
                            value="0"
                            @selected(
                                (string) old(
                                    'profile.is_chamber_member',
                                    $profile?->is_chamber_member
                                ) === '0'
                            )
                        >
                            خیر
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label>
                        سابقه فعالیت (سال)
                    </label>

                    <input
                        type="number"
                        min="0"
                        name="profile[activity_experience_years]"
                        class="form-control"
                        value="{{ old(
                            'profile.activity_experience_years',
                            $profile?->activity_experience_years
                        ) }}"
                    >

                </div>


                <div class="form-group">

                    <label>
                        نوع عضویت
                    </label>

                    <input
                        type="text"
                        name="profile[membership_type]"
                        class="form-control"
                        value="{{ old(
                            'profile.membership_type',
                            $profile?->membership_type
                        ) }}"
                    >

                </div>


                <div
                    class="
                        form-group
                        membership-form-span-3
                    "
                >

                    <label>
                        تخصص در حوزه نفت، گاز و پتروشیمی
                    </label>

                    <textarea
                        name="profile[oil_gas_petchem_specialty]"
                        class="form-control"
                        rows="4"
                    >{{ old(
                        'profile.oil_gas_petchem_specialty',
                        $profile?->oil_gas_petchem_specialty
                    ) }}</textarea>

                </div>


                <div
                    class="
                        form-group
                        membership-form-span-3
                    "
                >

                    <label>
                        شرح نوع فعالیت
                    </label>

                    <textarea
                        name="profile[activity_type]"
                        class="form-control"
                        rows="4"
                    >{{ old(
                        'profile.activity_type',
                        $profile?->activity_type
                    ) }}</textarea>

                </div>


                <div
                    class="
                        form-group
                        membership-form-span-3
                    "
                >

                    <label>
                        کمیته‌های انجمن
                    </label>

                    <textarea
                        name="profile[association_committees]"
                        class="form-control"
                        rows="3"
                    >{{ old(
                        'profile.association_committees',
                        $profile?->association_committees
                    ) }}</textarea>

                </div>

            </div>


            {{-- =====================================================
                Activity Type
            ====================================================== --}}

            <div style="margin-top: 22px;">

                <strong
                    style="
                        display:block;
                        margin-bottom:12px;
                        font-size:13px;
                        color:#344054;
                    "
                >
                    نوع فعالیت شرکت
                </strong>


                <div class="membership-checkbox-grid">

                    @foreach(
                        $activityFlags
                        as $field => $label
                    )

                        <label class="membership-checkbox-item">

                            {{-- همیشه مقدار 0 ارسال شود --}}
                            <input
                                type="hidden"
                                name="profile[{{ $field }}]"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="profile[{{ $field }}]"
                                value="1"
                                @checked(
                                    (bool) old(
                                        'profile.' . $field,
                                        $profile?->{$field}
                                    )
                                )
                            >

                            <span>
                                {{ $label }}
                            </span>

                        </label>

                    @endforeach

                </div>

            </div>


            {{-- =====================================================
                Activity Fields
            ====================================================== --}}

            <div
                class="membership-activity-fields-wrapper"
                style="margin-top:25px;"
            >

                <div style="margin-bottom:15px;">

                    <strong
                        style="
                            display:block;
                            font-size:14px;
                            color:#344054;
                            margin-bottom:4px;
                        "
                    >
                        حوزه‌ها و صنایع فعالیت
                    </strong>

                    <span
                        style="
                            font-size:11px;
                            color:#98a2b3;
                        "
                    >
                        حوزه‌های مرتبط با فعالیت شرکت را انتخاب کنید.
                    </span>

                </div>


                @forelse(
                    $groupedActivityFields
                    as $section => $fields
                )

                    <div
                        class="membership-activity-section"
                        style="
                            margin-bottom:15px;
                            padding:16px;
                            border:1px solid #e8ecf2;
                            border-radius:12px;
                            background:#fff;
                        "
                    >

                        <div
                            style="
                                margin-bottom:13px;
                                display:flex;
                                align-items:center;
                                justify-content:space-between;
                                gap:10px;
                            "
                        >

                            <strong
                                style="
                                    color:#344054;
                                    font-size:13px;
                                "
                            >
                                {{ $section }}
                            </strong>


                            <span
                                style="
                                    padding:4px 8px;
                                    border-radius:999px;
                                    background:#f2f4f7;
                                    color:#667085;
                                    font-size:10px;
                                "
                            >
                                {{ $fields->count() }}
                                مورد
                            </span>

                        </div>


                        <div class="membership-checkbox-grid">

                            @foreach(
                                $fields
                                as $field
                            )

                                <label class="membership-checkbox-item">

                                    <input
                                        type="checkbox"
                                        name="activity_fields[]"
                                        value="{{ $field->id }}"
                                        @checked(
                                            in_array(
                                                (string) $field->id,
                                                $selectedActivityFieldIds,
                                                true
                                            )
                                        )
                                    >

                                    <span>
                                        {{ $field->title }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>

                @empty

                    <div class="company-empty-state">

                        <p>
                            هیچ حوزه فعالیت فعالی تعریف نشده است.
                        </p>

                    </div>

                @endforelse

            </div>

        @else

            {{-- =====================================================
                Show General Activity Information
            ====================================================== --}}

            <div class="membership-show-grid">

                <div class="membership-info-item">

                    <span>
                        کارت بازرگانی معتبر
                    </span>

                    <strong>
                        {{
                            $boolText(
                                $profile?->has_valid_commercial_card
                            )
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        اعتبار کارت بازرگانی
                    </span>

                    <strong>
                        {{
                            $dateText(
                                $profile?->commercial_card_valid_until
                            )
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        کارت عضویت اتاق معتبر
                    </span>

                    <strong>
                        {{
                            $boolText(
                                $profile?->has_valid_chamber_membership_card
                            )
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        اعتبار کارت عضویت
                    </span>

                    <strong>
                        {{
                            $dateText(
                                $profile?->chamber_membership_valid_until
                            )
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        استان اتاق
                    </span>

                    <strong>
                        {{
                            $profile?->chamber_province
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        عضو اتاق بازرگانی
                    </span>

                    <strong>
                        {{
                            $boolText(
                                $profile?->is_chamber_member
                            )
                        }}
                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        سابقه فعالیت
                    </span>

                    <strong>

                        @if(
                            $profile?->activity_experience_years
                            !== null
                        )

                            {{
                                $profile
                                    ->activity_experience_years
                            }}

                            سال

                        @else

                            —

                        @endif

                    </strong>

                </div>


                <div class="membership-info-item">

                    <span>
                        نوع عضویت
                    </span>

                    <strong>
                        {{
                            $profile?->membership_type
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div
                    class="
                        membership-info-item
                        membership-info-span-3
                    "
                >

                    <span>
                        تخصص نفت، گاز و پتروشیمی
                    </span>

                    <strong>
                        {{
                            $profile
                                ?->oil_gas_petchem_specialty
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div
                    class="
                        membership-info-item
                        membership-info-span-3
                    "
                >

                    <span>
                        شرح نوع فعالیت
                    </span>

                    <strong>
                        {{
                            $profile?->activity_type
                            ?: '—'
                        }}
                    </strong>

                </div>


                <div
                    class="
                        membership-info-item
                        membership-info-span-3
                    "
                >

                    <span>
                        کمیته‌های انجمن
                    </span>

                    <strong>
                        {{
                            $profile?->association_committees
                            ?: '—'
                        }}
                    </strong>

                </div>

            </div>


            {{-- =====================================================
                Show Activity Flags
            ====================================================== --}}

            <div
                class="membership-activity-tags"
                style="margin-top:18px;"
            >

                @foreach(
                    $activityFlags
                    as $field => $label
                )

                    @if($profile?->{$field})

                        <span>
                            {{ $label }}
                        </span>

                    @endif

                @endforeach

            </div>


            {{-- =====================================================
                Show Selected Activity Fields
            ====================================================== --}}

            @if(
                $selectedActivityFieldsGrouped
                    ->isNotEmpty()
            )

                <div style="margin-top:22px;">

                    <strong
                        style="
                            display:block;
                            margin-bottom:12px;
                            color:#344054;
                            font-size:13px;
                        "
                    >
                        حوزه‌ها و صنایع فعالیت
                    </strong>


                    @foreach(
                        $selectedActivityFieldsGrouped
                        as $section => $fields
                    )

                        <div style="margin-bottom:15px;">

                            <span
                                style="
                                    display:block;
                                    margin-bottom:8px;
                                    color:#667085;
                                    font-size:11px;
                                    font-weight:700;
                                "
                            >
                                {{ $section }}
                            </span>


                            <div class="membership-activity-tags">

                                @foreach(
                                    $fields
                                    as $field
                                )

                                    <span>
                                        {{ $field->title }}
                                    </span>

                                @endforeach

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div
                    style="
                        margin-top:20px;
                        padding:12px;
                        border:1px dashed #d0d5dd;
                        border-radius:10px;
                        color:#98a2b3;
                        font-size:11px;
                    "
                >
                    حوزه یا صنعتی برای این درخواست انتخاب نشده است.
                </div>

            @endif

        @endif

    </div>

</div>


{{-- =========================================================
    Shareholders
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-users ml-1"></i>

                سهامداران
            </h2>

            <p>
                اطلاعات مالکیت و درصد سهام
            </p>

        </div>

    </div>


    @if($editable)

        <div class="membership-detail-body">

            <div id="shareholders-container">

                @php
                    $rows = old(
                        'shareholders',
                        $application
                            ->shareholders
                            ->map(
                                fn ($item) => [
                                    'id' =>
                                        $item->id,

                                    'full_name' =>
                                        $item->full_name,

                                    'ownership_percentage' =>
                                        $item->ownership_percentage,
                                ]
                            )
                            ->values()
                            ->all()
                    );
                @endphp


                @forelse(
                    $rows
                    as $index => $row
                )

                    <div class="membership-shareholder-row">

                        @if(! empty($row['id']))

                            <input
                                type="hidden"
                                name="shareholders[{{ $index }}][id]"
                                value="{{ $row['id'] }}"
                            >

                        @endif


                        <input
                            type="text"
                            name="shareholders[{{ $index }}][full_name]"
                            class="form-control"
                            placeholder="نام و نام خانوادگی"
                            value="{{ $row['full_name'] ?? '' }}"
                        >


                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            name="shareholders[{{ $index }}][ownership_percentage]"
                            class="form-control"
                            placeholder="درصد سهام"
                            value="{{ $row['ownership_percentage'] ?? '' }}"
                        >


                        <button
                            type="button"
                            class="membership-remove-row"
                            onclick="
                                this
                                    .closest(
                                        '.membership-shareholder-row'
                                    )
                                    .remove()
                            "
                        >

                            <i class="fa fa-trash"></i>

                        </button>

                    </div>

                @empty

                    <div class="membership-shareholder-row">

                        <input
                            type="text"
                            name="shareholders[0][full_name]"
                            class="form-control"
                            placeholder="نام و نام خانوادگی"
                        >


                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            max="100"
                            name="shareholders[0][ownership_percentage]"
                            class="form-control"
                            placeholder="درصد سهام"
                        >


                        <button
                            type="button"
                            class="membership-remove-row"
                            onclick="
                                this
                                    .closest(
                                        '.membership-shareholder-row'
                                    )
                                    .remove()
                            "
                        >

                            <i class="fa fa-trash"></i>

                        </button>

                    </div>

                @endforelse

            </div>


            <button
                type="button"
                class="membership-add-row"
                id="add-shareholder"
            >

                <i class="fa fa-plus ml-1"></i>

                افزودن سهامدار

            </button>

        </div>

    @else

        <div class="table-responsive">

            <table class="table company-table mb-0">

                <thead>

                <tr>

                    <th class="company-row-number">
                        ردیف
                    </th>

                    <th class="text-right">
                        نام و نام خانوادگی
                    </th>

                    <th>
                        درصد سهام
                    </th>

                </tr>

                </thead>


                <tbody>

                @forelse(
                    $application->shareholders
                    as $key => $shareholder
                )

                    <tr>

                        <td class="company-row-number">
                            {{ $key + 1 }}
                        </td>

                        <td class="text-right">

                            <strong>
                                {{ $shareholder->full_name }}
                            </strong>

                        </td>

                        <td>

                            <strong>

                                {{
                                    rtrim(
                                        rtrim(
                                            number_format(
                                                (float)
                                                $shareholder
                                                    ->ownership_percentage,
                                                2,
                                                '.',
                                                ''
                                            ),
                                            '0'
                                        ),
                                        '.'
                                    )
                                }}%

                            </strong>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="3">

                            <div class="company-empty-state">

                                <p>
                                    سهامداری برای این درخواست
                                    ثبت نشده است.
                                </p>

                            </div>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    @endif

</div>


{{-- =========================================================
    Documents
========================================================= --}}

<div class="company-table-card membership-detail-card">

    <div class="company-table-header">

        <div>

            <h2>
                <i class="fa fa-paperclip ml-1"></i>

                مدارک پرونده
            </h2>

            <p>

                {{
                    $editable
                        ? 'مشاهده و جایگزینی مدارک پرونده'
                        : 'فایل‌های بارگذاری‌شده توسط متقاضی'
                }}

            </p>

        </div>

    </div>


    <div class="membership-detail-body">

        @if($editable)

            <div class="membership-document-edit-grid">

                @foreach(
                    MembershipDocumentType::cases()
                    as $type
                )

                    @php
                        $currentDocument =
                            $documentsByType
                                ->get($type->value);
                    @endphp


                    <div class="membership-document-edit-item">

                        <div>

                            <strong
                                style="
                                    display:block;
                                    margin-bottom:10px;
                                "
                            >
                                {{ $type->label() }}
                            </strong>


                            @if($currentDocument)

                                <div class="membership-current-document">

                                    <div
                                        class="
                                            membership-current-document-info
                                        "
                                    >

                                        <span
                                            class="
                                                membership-current-document-icon
                                            "
                                        >
                                            <i class="fa fa-file-text-o"></i>
                                        </span>


                                        <div>

                                            <strong
                                                style="
                                                    display:block;
                                                    margin-bottom:3px;
                                                    font-size:11px;
                                                "
                                            >
                                                فایل فعلی
                                            </strong>


                                            <span
                                                class="
                                                    membership-current-document-name
                                                "
                                            >
                                                {{
                                                    $currentDocument
                                                        ->original_name
                                                }}
                                            </span>

                                        </div>

                                    </div>


                                    <a
                                        href="{{ asset(
                                            'storage/' .
                                            $currentDocument->path
                                        ) }}"
                                        target="_blank"
                                        rel="noopener"
                                        class="
                                            membership-current-document-btn
                                        "
                                    >

                                        <i class="fa fa-eye"></i>

                                        مشاهده فایل

                                    </a>

                                </div>

                            @else

                                <div
                                    style="
                                        margin-bottom:10px;
                                        padding:9px 11px;
                                        border:1px dashed #d0d5dd;
                                        border-radius:8px;
                                        color:#98a2b3;
                                        font-size:10px;
                                    "
                                >
                                    فایلی ثبت نشده است.
                                </div>

                            @endif


                            <input
                                type="file"
                                name="documents[{{ $type->value }}]"
                                class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png"
                            >

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            @if(
                $application
                    ->documents
                    ->isNotEmpty()
            )

                <div class="membership-document-list">

                    @foreach(
                        $application->documents
                        as $document
                    )

                        @php
                            $type =
                                $document->type
                                instanceof MembershipDocumentType
                                    ? $document->type
                                    : MembershipDocumentType::tryFrom(
                                        $document->type
                                    );
                        @endphp


                        <div class="membership-document-item">

                            <div class="membership-document-info">

                                <strong>
                                    {{
                                        $type?->label()
                                        ?: $document->type
                                    }}
                                </strong>

                                <span>
                                    {{
                                        $document
                                            ->original_name
                                    }}
                                </span>

                            </div>


                            <a
                                href="{{ asset(
                                    'storage/' .
                                    $document->path
                                ) }}"
                                target="_blank"
                                rel="noopener"
                                class="membership-document-btn"
                                title="مشاهده فایل"
                            >

                                <i class="fa fa-eye"></i>

                            </a>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="company-empty-state">

                    <span class="company-empty-icon">
                        <i class="fa fa-folder-open-o"></i>
                    </span>

                    <h3>
                        مدرکی وجود ندارد
                    </h3>

                    <p>
                        هیچ مدرکی برای این پرونده
                        ثبت نشده است.
                    </p>

                </div>

            @endif

        @endif

    </div>

</div>
