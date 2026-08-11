@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('back/css/pages/form.css') }}"
    >
@endpush


@if($errors->any())
    <div class="alert alert-danger">
        <strong>خطا در ثبت اطلاعات:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<form
    action="{{ $action }}"
    method="POST"
    enctype="multipart/form-data"
    class="pages-form-wrapper"
>

    @csrf

    @if($method !== 'POST')
        @method($method)
    @endif


    {{-- اطلاعات پایه صفحه --}}
    <section class="admin-card page-form-section section-general">

        <div class="admin-card-header page-form-section-header">

            <div class="page-form-section-heading">

                <div class="page-form-section-icon">
                    <i class="fa fa-file-text"></i>
                </div>

                <div>
                    <h4 class="admin-card-title">
                        اطلاعات پایه صفحه
                    </h4>

                    <div class="admin-page-subtitle">
                        عنوان، آدرس، تمپلیت و وضعیت انتشار صفحه را مشخص کنید.
                    </div>
                </div>

            </div>


            <span class="page-form-section-badge">
                اطلاعات عمومی
            </span>

        </div>


        <div class="admin-card-body">

            <div class="row row-sm">

                {{-- Title --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="page-title"
                        >
                            عنوان صفحه
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="page-title"
                            name="title"
                            value="{{ old('title', $page->title) }}"
                            class="form-control admin-form-control @error('title') is-invalid @enderror"
                            required
                        >


                        @error('title')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- Slug --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="page-slug"
                        >
                            اسلاگ
                            <span class="required">*</span>
                        </label>


                        <input
                            type="text"
                            id="page-slug"
                            name="slug"
                            value="{{ old('slug', $page->slug) }}"
                            class="form-control admin-form-control @error('slug') is-invalid @enderror"
                            required
                            placeholder="committee-name"
                            dir="ltr"
                        >


                        <div class="admin-help">
                            آدرس انگلیسی صفحه بدون فاصله وارد شود.
                        </div>


                        @error('slug')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- Summary --}}
                <div class="col-md-12">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="page-summary"
                        >
                            خلاصه صفحه
                        </label>


                        <textarea
                            id="page-summary"
                            name="summary"
                            rows="3"
                            class="form-control admin-form-control @error('summary') is-invalid @enderror"
                        >{{ old('summary', $page->summary) }}</textarea>


                        @error('summary')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- Template --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="page-template"
                        >
                            تمپلیت صفحه
                        </label>


                        <select
                            id="page-template"
                            name="template"
                            class="form-control admin-form-control @error('template') is-invalid @enderror"
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


                        <div class="admin-help">
                            فیلدهای اختصاصی بر اساس تمپلیت انتخاب‌شده نمایش داده می‌شوند.
                        </div>


                        @error('template')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- 3D Book PDF --}}
                <div
                    id="3d-book-media-wrapper"
                    @class([
                        'col-md-6',
                        'd-none' => old(
                            'template',
                            $page->template ?: 'default'
                        ) !== '3d-book'
                    ])
                >

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="book-pdf-media"
                        >
                            فایل PDF کتاب
                        </label>


                        <select
                            id="book-pdf-media"
                            name="template_data[book_pdf_media_id]"
                            class="form-control admin-form-control"
                        >

                            <option value="">
                                -- انتخاب PDF از رسانه‌ها --
                            </option>


                            @foreach($pdfMedia as $media)

                                <option
                                    value="{{ $media->id }}"
                                    @selected(
                                        old(
                                            'template_data.book_pdf_media_id',
                                            $page->template_data['book_pdf_media_id'] ?? null
                                        ) == $media->id
                                    )
                                >
                                    {{ $media->caption ?: basename($media->path) }}
                                </option>

                            @endforeach

                        </select>


                        <div class="admin-help">
                            فقط فایل‌های PDF موجود در بخش رسانه‌ها نمایش داده می‌شوند.
                        </div>

                    </div>

                </div>


                {{-- Status --}}
                <div class="col-md-6">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="page-status"
                        >
                            وضعیت صفحه
                        </label>


                        <div class="admin-status-box">

                            <select
                                id="page-status"
                                name="status"
                                class="form-control admin-form-control @error('status') is-invalid @enderror"
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


                        @error('status')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- Body --}}
                <div class="col-md-12">

                    <div class="form-group mb-0">

                        <label
                            class="admin-label"
                            for="page-body"
                        >
                            متن اصلی صفحه
                        </label>


                        <textarea
                            id="page-body"
                            name="body"
                            rows="8"
                            class="form-control admin-form-control @error('body') is-invalid @enderror"
                            data-upload-url="{{ route('admin.ckeditor.upload') }}?_token={{ csrf_token() }}"
                        >{{ old('body', $page->body) }}</textarea>


                        @error('body')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- Template Fields --}}
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

                    <h3>
                        تنظیمات اختصاصی صفحه
                    </h3>

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
                    class="admin-card page-form-section section-{{ $groupKey }}"
                    data-template-group="{{ $groupKey }}"
                >

                    <div class="admin-card-header page-form-section-header">

                        <div class="page-form-section-heading">

                            <div class="page-form-section-icon">

                                <i class="{{ $groupConfig['icon'] ?? 'fa fa-cog' }}"></i>

                            </div>


                            <div>

                                <h4 class="admin-card-title">
                                    {{ $groupConfig['label'] }}
                                </h4>


                                @if(!empty($groupConfig['description']))

                                    <div class="admin-page-subtitle">
                                        {{ $groupConfig['description'] }}
                                    </div>

                                @endif

                            </div>

                        </div>


                        <span class="page-form-section-badge">
                            {{ $groupConfig['label'] }}
                        </span>

                    </div>


                    <div class="admin-card-body">

                        @if($normalFields->isNotEmpty())

                            <div class="row row-sm">

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


                                        <div class="row row-sm">

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

                    </div>

                </section>

            @endforeach

        </div>

    @endif


    {{-- SEO --}}
    <section class="admin-card page-form-section section-seo">

        <div class="admin-card-header page-form-section-header">

            <div class="page-form-section-heading">

                <div class="page-form-section-icon">
                    <i class="fa fa-search"></i>
                </div>


                <div>

                    <h4 class="admin-card-title">
                        تنظیمات سئو
                    </h4>

                    <div class="admin-page-subtitle">
                        عنوان و توضیحات نمایش داده‌شده در موتورهای جست‌وجو.
                    </div>

                </div>

            </div>


            <span class="page-form-section-badge">
                SEO
            </span>

        </div>


        <div class="admin-card-body">

            <div class="row row-sm">

                <div class="col-md-12">

                    <div class="form-group">

                        <label
                            class="admin-label"
                            for="meta-title"
                        >
                            عنوان سئو
                        </label>


                        <input
                            type="text"
                            id="meta-title"
                            name="meta_title"
                            value="{{ old('meta_title', $page->meta_title) }}"
                            class="form-control admin-form-control @error('meta_title') is-invalid @enderror"
                        >


                        @error('meta_title')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                <div class="col-md-12">

                    <div class="form-group mb-0">

                        <label
                            class="admin-label"
                            for="meta-description"
                        >
                            توضیحات سئو
                        </label>


                        <textarea
                            id="meta-description"
                            name="meta_description"
                            rows="4"
                            class="form-control admin-form-control @error('meta_description') is-invalid @enderror"
                        >{{ old('meta_description', $page->meta_description) }}</textarea>


                        @error('meta_description')
                        <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- Submit --}}
    <div class="form-submit-bar">

        <div class="form-submit-text">

            <strong>
                ذخیره اطلاعات صفحه
            </strong>

            <span>
                پس از بررسی اطلاعات، تغییرات را ذخیره کنید.
            </span>

        </div>


        <button
            type="submit"
            class="btn admin-submit-btn page-save-button"
        >
            <i class="fa fa-save ml-1"></i>
            ذخیره صفحه
        </button>

    </div>

</form>


@push('scripts')
    <script
        src="{{ asset('back/js/pages/form.js') }}"
        defer
    ></script>
@endpush
