@php
    /*
    |--------------------------------------------------------------------------
    | گروه‌بندی حوزه‌های فعالیت
    |--------------------------------------------------------------------------
    */

    $activityGroups = collect($activityFields ?? [])
        ->groupBy('section');

    /*
    |--------------------------------------------------------------------------
    | شناسه گزینه‌های انتخاب‌شده
    |--------------------------------------------------------------------------
    |
    | اولویت با old است تا بعد از خطای اعتبارسنجی،
    | تیک‌های انتخاب‌شده کاربر از بین نروند.
    |
    | در صفحه ویرایش نیز گزینه‌های ذخیره‌شده شرکت
    | از رابطه activityFields دریافت می‌شوند.
    |
    */

    $selectedActivityFieldIds = old('activity_field_ids');

    if ($selectedActivityFieldIds === null) {
        $selectedActivityFieldIds = isset($company) && $company?->exists
            ? $company->activityFields->pluck('id')->all()
            : [];
    }

    $selectedActivityFieldIds = collect($selectedActivityFieldIds)
        ->map(fn ($id) => (int) $id)
        ->all();

    /*
    |--------------------------------------------------------------------------
    | مشخصات سه گروه
    |--------------------------------------------------------------------------
    */

    $sections = [
        'discipline' => [
            'title' => 'انتخاب دیسپلین تخصصی',
            'description' => 'دیسپلین‌ها و تخصص‌های فنی شرکت را انتخاب کنید.',
            'icon' => 'fa-cogs',
        ],

        'work_field' => [
            'title' => 'انتخاب زمینه‌های کاری',
            'description' => 'نوع خدمات و زمینه‌های کاری شرکت را مشخص کنید.',
            'icon' => 'fa-briefcase',
        ],

        'industry' => [
            'title' => 'انتخاب زمینه فعالیت در صنعت',
            'description' => 'صنایعی که شرکت در آن‌ها فعالیت دارد را انتخاب کنید.',
            'icon' => 'fa-industry',
        ],
    ];
@endphp

<div class="card custom-card">

    <div class="card-header border-bottom">
        <div>
            <h6 class="card-title mb-1 fw-bold">
                <i class="fa fa-tasks ml-1 text-primary"></i>
                حوزه‌ها و زمینه‌های فعالیت
            </h6>

            <p class="text-muted font_11 mb-0">
                در هر بخش امکان انتخاب چند گزینه وجود دارد.
            </p>
        </div>
    </div>

    <div class="card-body">

        @error('activity_field_ids')
        <div class="alert alert-danger font_12 py-2">
            <i class="fa fa-exclamation-circle ml-1"></i>
            {{ $message }}
        </div>
        @enderror

        @error('activity_field_ids.*')
        <div class="alert alert-danger font_12 py-2">
            <i class="fa fa-exclamation-circle ml-1"></i>
            {{ $message }}
        </div>
        @enderror

        @foreach($sections as $sectionKey => $section)

            @php
                $fields = $activityGroups
                    ->get($sectionKey, collect())
                    ->sortBy('sort_order');
            @endphp

            <div class="company-activity-group {{ !$loop->last ? 'mb-4 pb-4 border-bottom' : '' }}">

                <div class="d-flex align-items-center mb-3">

                    <span class="company-activity-group-icon ml-2">
                        <i class="fa {{ $section['icon'] }}"></i>
                    </span>

                    <div>
                        <h6 class="font_13 fw-bold mb-1">
                            {{ $section['title'] }}
                        </h6>

                        <p class="text-muted font_10 mb-0">
                            {{ $section['description'] }}
                        </p>
                    </div>

                </div>

                @if($fields->isNotEmpty())

                    <div class="row row-sm">

                        @foreach($fields as $field)

                            <div class="col-12 col-md-6 mb-2">

                                <label class="company-activity-option"
                                       for="activity-field-{{ $field->id }}">

                                    <input type="checkbox"
                                           name="activity_field_ids[]"
                                           id="activity-field-{{ $field->id }}"
                                           value="{{ $field->id }}"
                                           class="company-activity-input"
                                        @checked(
                                            in_array(
                                                (int) $field->id,
                                                $selectedActivityFieldIds,
                                                true
                                            )
                                        )>

                                    <span class="company-activity-checkbox">
                                        <i class="fa fa-check"></i>
                                    </span>

                                    <span class="company-activity-title">
                                        {{ $field->title }}
                                    </span>

                                </label>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="alert alert-light border font_11 mb-0">
                        <i class="fa fa-info-circle ml-1 text-muted"></i>
                        گزینه‌ای برای این بخش تعریف نشده است.
                    </div>

                @endif

            </div>

        @endforeach

    </div>

</div>

@push('styles')
    <style>
        .company-activity-group-icon {
            width: 40px;
            height: 40px;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #3366ff;
            background: rgba(51, 102, 255, 0.10);
            font-size: 15px;
        }

        .company-activity-option {
            position: relative;
            width: 100%;
            min-height: 46px;
            margin: 0;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            border: 1px solid #e2e6ed;
            border-radius: 8px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .company-activity-option:hover {
            border-color: #aebdf4;
            background: #f8faff;
        }

        .company-activity-input {
            position: absolute;
            opacity: 0;
            visibility: hidden;
        }

        .company-activity-checkbox {
            width: 22px;
            height: 22px;
            margin-left: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 2px solid #c5cad4;
            border-radius: 6px;
            background: #ffffff;
            color: #ffffff;
            transition: all 0.2s ease;
        }

        .company-activity-checkbox i {
            opacity: 0;
            font-size: 10px;
            transform: scale(0.6);
            transition: all 0.2s ease;
        }

        .company-activity-title {
            color: #343a40;
            font-size: 12px;
            line-height: 1.8;
            transition: all 0.2s ease;
        }

        .company-activity-input:checked
        + .company-activity-checkbox {
            border-color: #3366ff;
            background: #3366ff;
            box-shadow: 0 3px 8px rgba(51, 102, 255, 0.25);
        }

        .company-activity-input:checked
        + .company-activity-checkbox i {
            opacity: 1;
            transform: scale(1);
        }

        .company-activity-option:has(.company-activity-input:checked) {
            border-color: #9cb0f8;
            background: #f3f6ff;
        }

        .company-activity-option:has(.company-activity-input:checked)
        .company-activity-title {
            color: #2548bd;
            font-weight: 600;
        }
    </style>
@endpush
