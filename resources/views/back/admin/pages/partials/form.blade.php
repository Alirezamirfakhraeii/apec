@push('styles')
    <style>
        .page-form-wrapper {
            --primary: #3155a6;
            --primary-light: #eef3ff;
            --border-color: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #64748b;

            position: relative;
            direction: rtl;
        }

        /*
        |--------------------------------------------------------------------------
        | CKEditor
        |--------------------------------------------------------------------------
        */

        .page-form-wrapper .ck-editor {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .page-form-wrapper .ck-editor__top,
        .page-form-wrapper .ck-editor__main {
            position: relative;
            z-index: 1;
        }

        .page-form-wrapper .ck-toolbar {
            direction: rtl;
            background: #f8fafc;
            border-color: #dce3eb !important;
            border-radius: 12px 12px 0 0 !important;
        }

        .page-form-wrapper .ck-editor__editable {
            min-height: 300px;
            padding: 20px !important;
            color: #1e293b;
            line-height: 2;
            direction: rtl;
            text-align: right;
            background: #ffffff;
            border-color: #dce3eb !important;
            border-radius: 0 0 12px 12px !important;
            box-shadow: none !important;
        }

        .page-form-wrapper .ck-editor__editable.ck-focused {
            border-color: #3155a6 !important;
            box-shadow: 0 0 0 3px rgba(49, 85, 166, 0.1) !important;
        }


        .page-form-wrapper .ck-content {
            direction: rtl;
            text-align: right;
        }

        .page-form-wrapper .ck-content img {
            max-width: 100%;
            height: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | سکشن‌های اصلی
        |--------------------------------------------------------------------------
        */

        .page-form-section {
            position: relative;
            overflow: visible;
            margin-bottom: 24px;
            padding: 24px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(15, 23, 42, 0.05);
        }

        .page-form-section::before {
            position: absolute;
            top: 8px;
            right: 0;
            bottom: 8px;
            width: 5px;
            content: "";
            background: var(--section-color, #3155a6);
            border-radius: 5px 0 0 5px;
        }

        .page-form-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid #edf1f5;
        }

        .page-form-section-title {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .page-form-section-icon {
            display: flex;
            flex: 0 0 46px;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 46px;
            color: var(--section-color, #3155a6);
            font-size: 19px;
            background: var(--section-background, #eef3ff);
            border-radius: 14px;
        }

        .page-form-section-title h3 {
            margin: 0 0 5px;
            color: var(--text-main);
            font-size: 17px;
            font-weight: 800;
        }

        .page-form-section-title p {
            margin: 0;
            color: var(--text-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .page-form-section-badge {
            display: inline-flex;
            align-items: center;
            min-height: 32px;
            padding: 5px 13px;
            color: var(--section-color, #3155a6);
            font-size: 12px;
            font-weight: 700;
            background: var(--section-background, #eef3ff);
            border-radius: 30px;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | رنگ‌بندی سکشن‌ها
        |--------------------------------------------------------------------------
        */

        .section-general {
            --section-color: #3155a6;
            --section-background: #eef3ff;
        }

        .section-main {
            --section-color: #0f766e;
            --section-background: #ecfdf5;
        }

        .section-chairman {
            --section-color: #7c3aed;
            --section-background: #f5f3ff;
        }

        .section-secretary {
            --section-color: #0369a1;
            --section-background: #f0f9ff;
        }

        .section-deputies {
            --section-color: #c2410c;
            --section-background: #fff7ed;
        }

        .section-workgroups {
            --section-color: #047857;
            --section-background: #ecfdf5;
        }

        .section-seo {
            --section-color: #a21caf;
            --section-background: #fdf4ff;
        }

        /*
        |--------------------------------------------------------------------------
        | فیلدها
        |--------------------------------------------------------------------------
        */

        .page-form-wrapper .form-label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .page-form-wrapper .form-control {
            min-height: 45px;
            padding: 10px 13px;
            color: #1e293b;
            background-color: #fbfdff;
            border: 1px solid #dce3eb;
            border-radius: 11px;
            box-shadow: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .page-form-wrapper textarea.form-control {
            min-height: unset;
            line-height: 1.9;
            resize: vertical;
        }

        .page-form-wrapper .form-control:hover {
            border-color: #b8c4d4;
        }

        .page-form-wrapper .form-control:focus {
            background: #ffffff;
            border-color: var(--section-color, #3155a6);
            box-shadow: 0 0 0 3px rgba(49, 85, 166, 0.1);
        }

        .field-help {
            display: block;
            margin-top: 7px;
            color: #8491a3;
            font-size: 11px;
            line-height: 1.7;
        }

        /*
        |--------------------------------------------------------------------------
        | گزینه‌های روشن و خاموش
        |--------------------------------------------------------------------------
        */

        .template-toggle-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            min-height: 78px;
            padding: 16px 18px;
            background: var(--section-background, #f8fafc);
            border: 1px dashed var(--section-color, #94a3b8);
            border-radius: 14px;
        }

        .template-toggle-card strong {
            display: block;
            margin-bottom: 4px;
            color: #1e293b;
            font-size: 14px;
        }

        .template-toggle-card small {
            display: block;
            color: #64748b;
            font-size: 11px;
            line-height: 1.8;
        }

        .template-toggle-card .form-check {
            flex-shrink: 0;
            margin: 0;
            padding-left: 49px;
        }

        .template-toggle-card .form-check-input {
            width: 48px;
            height: 25px;
            margin: 0;
            cursor: pointer;
        }

        /*
        |--------------------------------------------------------------------------
        | تصویر فعلی
        |--------------------------------------------------------------------------
        */

        .template-current-image {
            display: flex;
            align-items: center;
            gap: 13px;
            margin-top: 12px;
            padding: 10px;
            background: #f8fafc;
            border: 1px solid #e6ebf1;
            border-radius: 12px;
        }

        .template-current-image img {
            width: 75px;
            height: 75px;
            object-fit: cover;
            border: 3px solid #ffffff;
            border-radius: 11px;
            box-shadow: 0 3px 10px rgba(15, 23, 42, 0.12);
        }

        .template-current-image strong {
            display: block;
            margin-bottom: 5px;
            color: #334155;
            font-size: 12px;
        }

        .template-current-image span {
            color: #7c8a9d;
            font-size: 11px;
            line-height: 1.7;
        }

        /*
        |--------------------------------------------------------------------------
        | کارگروه‌ها
        |--------------------------------------------------------------------------
        */

        .workgroups-container {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
            margin-top: 18px;
        }

        .workgroup-card {
            position: relative;
            padding: 20px;
            background: linear-gradient(
                145deg,
                rgba(236, 253, 245, 0.9),
                rgba(255, 255, 255, 0.95)
            );
            border: 1px solid #cce9dd;
            border-radius: 16px;
        }

        .workgroup-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 13px;
            border-bottom: 1px solid #dcefe7;
        }

        .workgroup-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            color: #065f46;
            font-size: 14px;
            font-weight: 800;
        }

        .workgroup-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            color: #ffffff;
            font-size: 12px;
            background: #047857;
            border-radius: 9px;
        }

        .workgroup-card-badge {
            padding: 4px 10px;
            color: #047857;
            font-size: 10px;
            font-weight: 700;
            background: #d1fae5;
            border-radius: 20px;
        }

        /*
        |--------------------------------------------------------------------------
        | عنوان تنظیمات اختصاصی
        |--------------------------------------------------------------------------
        */

        .template-fields-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin: 30px 0 20px;
            padding: 20px 22px;
            color: #ffffff;
            background: linear-gradient(
                135deg,
                #1e3a8a 0%,
                #3155a6 50%,
                #2563eb 100%
            );
            border-radius: 18px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.18);
        }

        .template-fields-heading h3 {
            margin: 0 0 6px;
            color: #ffffff;
            font-size: 18px;
            font-weight: 800;
        }

        .template-fields-heading p {
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 12px;
        }

        .template-fields-heading span {
            padding: 7px 14px;
            color: #1e3a8a;
            font-size: 12px;
            font-weight: 800;
            background: #ffffff;
            border-radius: 25px;
        }

        /*
        |--------------------------------------------------------------------------
        | نوار ذخیره
        |--------------------------------------------------------------------------
        | عمداً Sticky نیست تا باگ سفیدشدن صفحه رخ ندهد.
        */

        .form-submit-bar {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-top: 25px;
            padding: 15px 18px;
            background: #ffffff;
            border: 1px solid #dfe6ee;
            border-radius: 16px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.14);
        }

        .form-submit-text strong {
            display: block;
            margin-bottom: 3px;
            color: #1e293b;
            font-size: 13px;
        }

        .form-submit-text span {
            color: #64748b;
            font-size: 11px;
        }

        .page-save-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 160px;
            min-height: 46px;
            padding: 10px 22px;
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            background: linear-gradient(135deg, #3155a6, #2563eb);
            border: 0;
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(37, 99, 235, 0.25);
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .page-save-button:hover {
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.32);
        }

        @media (max-width: 991px) {
            .workgroups-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .page-form-section {
                padding: 18px;
                border-radius: 14px;
            }

            .page-form-section-header,
            .template-fields-heading,
            .form-submit-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-form-section-badge {
                margin-right: 60px;
            }

            .page-save-button {
                width: 100%;
            }
        }

        /*
|--------------------------------------------------------------------------
| رفع پرش صفحه هنگام Focus روی CKEditor
|--------------------------------------------------------------------------
*/

        html {
            scroll-behavior: auto !important;
        }

        .page-form-wrapper,
        .page-form-section,
        .page-form-wrapper .ck-editor,
        .page-form-wrapper .ck-editor__top,
        .page-form-wrapper .ck-editor__main,
        .page-form-wrapper .ck-editor__editable {
            overflow-anchor: none !important;
        }

        .page-form-wrapper .ck-editor,
        .page-form-wrapper .ck-editor__top,
        .page-form-wrapper .ck-editor__main {
            transform: none !important;
            perspective: none !important;
            filter: none !important;
            backface-visibility: visible !important;
        }

        .page-form-wrapper .ck-sticky-panel,
        .page-form-wrapper .ck-sticky-panel__content,
        .page-form-wrapper .ck-sticky-panel__content_sticky {
            position: static !important;
            top: auto !important;
            right: auto !important;
            bottom: auto !important;
            left: auto !important;
            width: 100% !important;
            transform: none !important;
            box-shadow: none !important;
        }

        .page-form-wrapper .ck-editor__editable {
            position: relative !important;
            contain: none !important;
            will-change: auto !important;
        }
    </style>
@endpush

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>خطا در ثبت اطلاعات:</strong>

        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form
    action="{{ $action }}"
    method="POST"
    enctype="multipart/form-data"
    class="page-form-wrapper"
>
    @csrf

    @if($method !== 'POST')
        @method($method)
    @endif

    {{-- اطلاعات پایه صفحه --}}
    <section class="page-form-section section-general">

        <div class="page-form-section-header">

            <div class="page-form-section-title">

                <div class="page-form-section-icon">
                    <i class="fa fa-file-text"></i>
                </div>

                <div>
                    <h3>اطلاعات پایه صفحه</h3>

                    <p>
                        عنوان، آدرس، تمپلیت و وضعیت انتشار صفحه را مشخص کنید.
                    </p>
                </div>

            </div>

            <span class="page-form-section-badge">
                اطلاعات عمومی
            </span>

        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label class="form-label" for="page-title">
                    عنوان صفحه
                </label>

                <input
                    type="text"
                    id="page-title"
                    name="title"
                    value="{{ old('title', $page->title) }}"
                    class="form-control"
                    required
                >

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label" for="page-slug">
                    اسلاگ
                </label>

                <input
                    type="text"
                    id="page-slug"
                    name="slug"
                    value="{{ old('slug', $page->slug) }}"
                    class="form-control"
                    required
                    placeholder="committee-name"
                    dir="ltr"
                >

                <small class="field-help">
                    آدرس انگلیسی صفحه بدون فاصله وارد شود.
                </small>

            </div>

            <div class="col-md-12 mb-3">

                <label class="form-label" for="page-summary">
                    خلاصه صفحه
                </label>

                <textarea
                    id="page-summary"
                    name="summary"
                    rows="3"
                    class="form-control"
                >{{ old('summary', $page->summary) }}</textarea>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label" for="page-template">
                    تمپلیت صفحه
                </label>

                <select
                    id="page-template"
                    name="template"
                    class="form-control"
                >
                    @foreach($templates as $key => $template)
                        <option
                            value="{{ $key }}"
                            @selected(
                                old('template', $page->template) === $key
                            )
                        >
                            {{ $template['label'] }}
                        </option>
                    @endforeach
                </select>

                <small class="field-help">
                    فیلدهای اختصاصی بر اساس تمپلیت انتخاب‌شده نمایش داده می‌شوند.
                </small>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label" for="page-status">
                    وضعیت صفحه
                </label>

                <select
                    id="page-status"
                    name="status"
                    class="form-control"
                >
                    <option
                        value="1"
                        @selected(old('status', (int) $page->status) == 1)
                    >
                        فعال و قابل نمایش
                    </option>

                    <option
                        value="0"
                        @selected(old('status', (int) $page->status) == 0)
                    >
                        غیرفعال
                    </option>
                </select>

            </div>

            <div class="col-md-12 mb-0">

                <label class="form-label" for="page-body">
                    متن اصلی صفحه
                </label>

                <textarea
                    id="page-body"
                    name="body"
                    rows="8"
                    class="form-control"
                >{{ old('body', $page->body) }}</textarea>

            </div>

        </div>

    </section>

    @if(count($templateFields))
        @php
            $currentTemplate = old(
                'template',
                $page->template ?: 'default'
            );

            $currentTemplateConfig =
                $templates[$currentTemplate] ?? [];

            $templateGroups =
                $currentTemplateConfig['groups'] ?? [];

            $templateFieldsCollection =
                collect($templateFields);

            $groupedTemplateFields =
                $templateFieldsCollection->groupBy(
                    fn ($field) => $field['group'] ?? 'general'
                );
        @endphp

        <div class="template-fields-wrapper">

            <div class="template-fields-heading">

                <div>
                    <h3>تنظیمات اختصاصی صفحه</h3>

                    <p>
                        اطلاعات هر بخش را به‌صورت جداگانه تکمیل کنید.
                    </p>
                </div>

                <span>
                    {{ $currentTemplateConfig['label'] ?? 'تمپلیت صفحه' }}
                </span>

            </div>

            @foreach($groupedTemplateFields as $groupKey => $fields)
                @php
                    $groupConfig = $templateGroups[$groupKey] ?? [
                        'label' => 'سایر اطلاعات',
                        'description' => null,
                        'icon' => 'fa fa-cog',
                    ];

                    $normalFields = $fields->filter(
                        fn ($field) => empty($field['subgroup'])
                    );

                    $subgroupFields = $fields
                        ->filter(
                            fn ($field) => !empty($field['subgroup'])
                        )
                        ->groupBy('subgroup');
                @endphp

                <section
                    class="page-form-section section-{{ $groupKey }}"
                    data-template-group="{{ $groupKey }}"
                >

                    <div class="page-form-section-header">

                        <div class="page-form-section-title">

                            <div class="page-form-section-icon">
                                <i class="{{ $groupConfig['icon'] ?? 'fa fa-cog' }}"></i>
                            </div>

                            <div>
                                <h3>
                                    {{ $groupConfig['label'] }}
                                </h3>

                                @if(!empty($groupConfig['description']))
                                    <p>
                                        {{ $groupConfig['description'] }}
                                    </p>
                                @endif
                            </div>

                        </div>

                        <span class="page-form-section-badge">
                            {{ $groupConfig['label'] }}
                        </span>

                    </div>

                    @if($normalFields->isNotEmpty())
                        <div class="row">

                            @foreach($normalFields as $field)
                                @include(
                                    'back.admin.pages.partials.template-field',
                                    [
                                        'field' => $field,
                                        'page' => $page,
                                        'templateFieldsCollection' =>
                                            $templateFieldsCollection,
                                    ]
                                )
                            @endforeach

                        </div>
                    @endif

                    @if($subgroupFields->isNotEmpty())
                        <div class="workgroups-container">

                            @foreach($subgroupFields as $subgroupKey => $subFields)
                                @php
                                    preg_match(
                                        '/(\d+)$/',
                                        $subgroupKey,
                                        $matches
                                    );

                                    $workgroupNumber =
                                        $matches[1] ?? $loop->iteration;
                                @endphp

                                <div
                                    class="workgroup-card js-subgroup-card"
                                    data-subgroup="{{ $subgroupKey }}"
                                >

                                    <div class="workgroup-card-header">

                                        <h4 class="workgroup-card-title">

                                            <span class="workgroup-number">
                                                {{ $workgroupNumber }}
                                            </span>

                                            کارگروه شماره
                                            {{ $workgroupNumber }}

                                        </h4>

                                        <span class="workgroup-card-badge">
                                            اطلاعات کارگروه
                                        </span>

                                    </div>

                                    <div class="row">

                                        @foreach($subFields as $field)
                                            @include(
                                                'back.admin.pages.partials.template-field',
                                                [
                                                    'field' => $field,
                                                    'page' => $page,
                                                    'templateFieldsCollection' =>
                                                        $templateFieldsCollection,
                                                ]
                                            )
                                        @endforeach

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    @endif

                </section>
            @endforeach

        </div>
    @endif

    {{-- تنظیمات سئو --}}
    <section class="page-form-section section-seo">

        <div class="page-form-section-header">

            <div class="page-form-section-title">

                <div class="page-form-section-icon">
                    <i class="fa fa-search"></i>
                </div>

                <div>
                    <h3>تنظیمات سئو</h3>

                    <p>
                        عنوان و توضیحات نمایش داده‌شده در موتورهای جست‌وجو.
                    </p>
                </div>

            </div>

            <span class="page-form-section-badge">
                SEO
            </span>

        </div>

        <div class="row">

            <div class="col-md-12 mb-3">

                <label class="form-label" for="meta-title">
                    عنوان سئو
                </label>

                <input
                    type="text"
                    id="meta-title"
                    name="meta_title"
                    value="{{ old('meta_title', $page->meta_title) }}"
                    class="form-control"
                >

            </div>

            <div class="col-md-12 mb-0">

                <label class="form-label" for="meta-description">
                    توضیحات سئو
                </label>

                <textarea
                    id="meta-description"
                    name="meta_description"
                    rows="4"
                    class="form-control"
                >{{ old('meta_description', $page->meta_description) }}</textarea>

            </div>

        </div>

    </section>

    <div class="form-submit-bar">

        <div class="form-submit-text">

            <strong>
                ذخیره اطلاعات صفحه
            </strong>

            <span>
                پس از بررسی اطلاعات، تغییرات را ذخیره کنید.
            </span>

        </div>

        <button type="submit" class="page-save-button">

            <i class="fa fa-save"></i>

            ذخیره صفحه

        </button>

    </div>

</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        /*
        |--------------------------------------------------------------------------
        | فیلدهای شرطی
        |--------------------------------------------------------------------------
        */

        const conditionalFields = document.querySelectorAll(
            '[data-condition-field]'
        );

        function getControllerValue(fieldKey) {
            const controller = document.querySelector(
                '[data-template-key="' + fieldKey + '"]'
            );

            if (!controller) {
                return null;
            }

            if (controller.type === 'checkbox') {
                return controller.checked ? '1' : '0';
            }

            return controller.value;
        }

        function updateSubgroupCards() {
            document
                .querySelectorAll('.js-subgroup-card')
                .forEach(function (card) {
                    const fields = card.querySelectorAll(
                        '.template-field-item'
                    );

                    const hasVisibleField = Array
                        .from(fields)
                        .some(function (field) {
                            return field.style.display !== 'none';
                        });

                    card.style.display = hasVisibleField
                        ? ''
                        : 'none';
                });
        }

        function updateConditionalFields() {
            conditionalFields.forEach(function (wrapper) {
                const fieldKey =
                    wrapper.dataset.conditionField;

                const requiredValue =
                    wrapper.dataset.conditionValue;

                const currentValue =
                    getControllerValue(fieldKey);

                wrapper.style.display =
                    String(currentValue) === String(requiredValue)
                        ? ''
                        : 'none';
            });

            updateSubgroupCards();
        }

        document
            .querySelectorAll('.js-template-controller')
            .forEach(function (controller) {
                controller.addEventListener(
                    'change',
                    updateConditionalFields
                );
            });

        updateConditionalFields();

        /*
        |--------------------------------------------------------------------------
        | CKEditor فقط برای متن اصلی
        |--------------------------------------------------------------------------
        */

        const bodyElement =
            document.getElementById('page-body');

        if (
            !bodyElement ||
            typeof ClassicEditor === 'undefined'
        ) {
            return;
        }

        ClassicEditor
            .create(bodyElement, {
                ckfinder: {
                    uploadUrl:
                        '{{ route('admin.ckeditor.upload') }}' +
                        '?_token={{ csrf_token() }}'
                },

                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        '|',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'blockQuote',
                        'insertTable',
                        'uploadImage',
                        '|',
                        'undo',
                        'redo'
                    ],

                    shouldNotGroupWhenFull: true
                },

                language: 'fa'
            })
            .then(function (editor) {
                /*
                |--------------------------------------------------------------------------
                | غیرفعال‌کردن Sticky Toolbar
                |--------------------------------------------------------------------------
                */

                const stickyPanel =
                    editor.ui.view.stickyPanel;

                if (stickyPanel) {
                    if (
                        typeof stickyPanel.unbind === 'function'
                    ) {
                        stickyPanel.unbind('isActive');
                    }

                    stickyPanel.isActive = false;
                }

                /*
                |--------------------------------------------------------------------------
                | رفع Focus قبل از شروع اسکرول
                |--------------------------------------------------------------------------
                |
                | وقتی موس اسکرول می‌شود، Focus از contenteditable برداشته
                | می‌شود تا مرورگر برای نگه‌داشتن مکان Cursor صفحه را نپراند.
                |
                */

                const editableElement =
                    editor.ui.getEditableElement();

                function editorHasFocus() {
                    if (!editableElement) {
                        return false;
                    }

                    return (
                        document.activeElement === editableElement ||
                        editableElement.contains(
                            document.activeElement
                        )
                    );
                }

                function releaseEditorFocus() {
                    if (
                        !editableElement ||
                        !editorHasFocus()
                    ) {
                        return;
                    }

                    editableElement.blur();

                    requestAnimationFrame(function () {
                        editableElement.blur();
                    });
                }

                /*
                | Capture باعث می‌شود قبل از اجرای Scroll مرورگر،
                | Focus ادیتور آزاد شود.
                */

                window.addEventListener(
                    'wheel',
                    releaseEditorFocus,
                    {
                        capture: true,
                        passive: true
                    }
                );

                window.addEventListener(
                    'touchmove',
                    releaseEditorFocus,
                    {
                        capture: true,
                        passive: true
                    }
                );

                /*
                | پشتیبان برای Scroll با Scrollbar یا کلیدهای صفحه‌کلید
                */

                let previousScrollY = window.scrollY;

                window.addEventListener(
                    'scroll',
                    function () {
                        const currentScrollY = window.scrollY;

                        if (
                            currentScrollY !== previousScrollY &&
                            editorHasFocus()
                        ) {
                            releaseEditorFocus();
                        }

                        previousScrollY = currentScrollY;
                    },
                    {
                        passive: true
                    }
                );

                /*
                |--------------------------------------------------------------------------
                | ارسال مقدار CKEditor هنگام ذخیره
                |--------------------------------------------------------------------------
                */

                const form =
                    bodyElement.closest('form');

                if (form) {
                    form.addEventListener(
                        'submit',
                        function () {
                            bodyElement.value =
                                editor.getData();
                        }
                    );
                }

                window.pageBodyEditor = editor;
            })
            .catch(function (error) {
                console.error(
                    'CKEditor Error:',
                    error
                );
            });
    });
</script>
