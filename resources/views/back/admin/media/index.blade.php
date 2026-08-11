@extends('back.admin.layouts.master')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('back/css/media/index.css') }}"
    >
@endpush


@section('content')

    @php
        $formatFileSize = function ($bytes) {
            $bytes = (int) $bytes;

            if ($bytes <= 0) {
                return 'نامشخص';
            }

            $units = [
                'بایت',
                'کیلوبایت',
                'مگابایت',
                'گیگابایت',
            ];

            $index = 0;

            while ($bytes >= 1024 && $index < count($units) - 1) {
                $bytes /= 1024;
                $index++;
            }

            return round(
                $bytes,
                $index === 0 ? 0 : 2
            ) . ' ' . $units[$index];
        };
    @endphp


    <div class="admin-wrapper media-admin-wrapper">


        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>

                <h4 class="admin-page-title">
                    <i class="fa fa-picture-o ml-2"></i>
                    کتابخانه رسانه‌ها
                </h4>

                <div class="admin-page-subtitle">
                    تصاویر، اسناد، فایل‌های صوتی و ویدیویی سایت را مدیریت کنید.
                </div>

            </div>


            <a
                href="#media-upload-section"
                class="btn admin-create-btn"
            >
                <i class="fa fa-upload ml-1"></i>
                آپلود فایل جدید
            </a>

        </div>


        {{-- Success Message --}}
        @if(session('success'))

            <div class="alert alert-success mb-4">
                <i class="fa fa-check-circle ml-1"></i>
                {{ session('success') }}
            </div>

        @endif


        {{-- Error Message --}}
        @if(session('error'))

            <div class="alert alert-danger mb-4">
                <i class="fa fa-exclamation-circle ml-1"></i>
                {{ session('error') }}
            </div>

        @endif


        {{-- Validation Errors --}}
        @if($errors->any())

            <div class="alert alert-danger mb-4">

                <strong>
                    عملیات انجام نشد.
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- Upload --}}
        <div
            class="admin-card media-upload-card"
            id="media-upload-section"
        >

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-upload ml-2"></i>
                    آپلود رسانه
                </h4>

            </div>


            <div class="admin-card-body">

                <div class="admin-section-note mb-3">
                    می‌توانید چند فایل را به‌صورت هم‌زمان انتخاب و آپلود کنید.
                </div>


                <form
                    action="{{ route('admin.media.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >

                    @csrf


                    <div class="row row-sm align-items-end">

                        <div class="col-md-9">

                            <div class="form-group mb-md-0">

                                <label
                                    for="media-files"
                                    class="admin-label"
                                >
                                    انتخاب فایل‌ها
                                </label>


                                <div class="admin-upload-box">

                                    <input
                                        type="file"
                                        name="files[]"
                                        id="media-files"
                                        class="form-control admin-form-control"
                                        multiple
                                        required
                                        accept=".jpg,.jpeg,.png,.webp,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.mp3,.wav,.mp4"
                                    >


                                    <div class="admin-help">
                                        تصاویر، PDF، Word، Excel، PowerPoint،
                                        فایل‌های فشرده، صوت و ویدیو قابل آپلود هستند.
                                    </div>


                                    <div class="admin-help">
                                        حداکثر حجم هر فایل ۲۰ مگابایت است.
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-3">

                            <button
                                type="submit"
                                class="btn admin-submit-btn"
                            >
                                <i class="fa fa-upload ml-1"></i>
                                شروع آپلود
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Filters --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-filter ml-2"></i>
                    جستجو و فیلتر رسانه‌ها
                </h4>

            </div>


            <div class="admin-card-body">

                <form
                    action="{{ route('admin.media.index') }}"
                    method="GET"
                >

                    <div class="row row-sm align-items-end">

                        {{-- Search --}}
                        <div class="col-md-6">

                            <div class="form-group mb-md-0">

                                <label
                                    for="q"
                                    class="admin-label"
                                >
                                    جستجو
                                </label>


                                <input
                                    type="text"
                                    name="q"
                                    id="q"
                                    value="{{ request('q') }}"
                                    class="form-control admin-form-control"
                                    placeholder="نام فایل، متن جایگزین یا توضیحات"
                                >

                            </div>

                        </div>


                        {{-- Type --}}
                        <div class="col-md-3">

                            <div class="form-group mb-md-0">

                                <label
                                    for="type"
                                    class="admin-label"
                                >
                                    نوع رسانه
                                </label>


                                <select
                                    name="type"
                                    id="type"
                                    class="form-control admin-form-control"
                                >

                                    <option value="">
                                        همه رسانه‌ها
                                    </option>

                                    <option
                                        value="image"
                                        @selected(request('type') === 'image')
                                    >
                                        تصاویر
                                    </option>

                                    <option
                                        value="pdf"
                                        @selected(request('type') === 'pdf')
                                    >
                                        فایل‌های PDF
                                    </option>

                                    <option
                                        value="audio"
                                        @selected(request('type') === 'audio')
                                    >
                                        فایل‌های صوتی
                                    </option>

                                    <option
                                        value="video"
                                        @selected(request('type') === 'video')
                                    >
                                        فایل‌های ویدیویی
                                    </option>

                                    <option
                                        value="file"
                                        @selected(request('type') === 'file')
                                    >
                                        Word، Excel، PowerPoint و سایر فایل‌ها
                                    </option>

                                </select>

                            </div>

                        </div>


                        {{-- Filter Actions --}}
                        <div class="col-md-3">

                            <button
                                type="submit"
                                class="btn admin-submit-btn"
                            >
                                <i class="fa fa-search ml-1"></i>
                                اعمال فیلتر
                            </button>

                        </div>

                    </div>


                    @if(request()->hasAny(['q', 'type']))

                        <div class="mt-3">

                            <a
                                href="{{ route('admin.media.index') }}"
                                class="btn admin-back-btn"
                            >
                                حذف فیلتر
                            </a>

                        </div>

                    @endif

                </form>

            </div>

        </div>


        {{-- Media Library --}}
        <div class="admin-card media-library-card">

            <div class="admin-card-header media-library-header">

                <div class="d-flex align-items-center justify-content-between">

                    <h4 class="admin-card-title">
                        <i class="fa fa-th ml-2"></i>
                        رسانه‌های آپلودشده
                    </h4>


                    <span class="media-items-count">
                        {{ number_format($mediaItems->total()) }}
                        فایل
                    </span>

                </div>

            </div>


            <div class="admin-card-body">

                @if($mediaItems->count())

                    <div class="media-grid">

                        @foreach($mediaItems as $media)

                            @php
                                $disk = $media->disk ?: 'public';

                                $rawPath = ltrim(
                                    (string) $media->path,
                                    '/'
                                );

                                $candidatePaths = array_filter(
                                    array_unique([
                                        $rawPath,

                                        preg_replace(
                                            '#^public/#',
                                            '',
                                            $rawPath
                                        ),

                                        preg_replace(
                                            '#^storage/#',
                                            '',
                                            $rawPath
                                        ),

                                        preg_replace(
                                            '#^storage/app/public/#',
                                            '',
                                            $rawPath
                                        ),
                                    ])
                                );

                                $resolvedPath = $rawPath;

                                $fileExists = false;


                                foreach ($candidatePaths as $candidatePath) {

                                    try {

                                        if (
                                            \Illuminate\Support\Facades\Storage::disk($disk)
                                                ->exists($candidatePath)
                                        ) {

                                            $resolvedPath = $candidatePath;

                                            $fileExists = true;

                                            break;
                                        }

                                    } catch (\Throwable $exception) {
                                        //
                                    }

                                }


                                $fileName = basename($resolvedPath);


                                $extension = strtolower(
                                    pathinfo(
                                        $resolvedPath,
                                        PATHINFO_EXTENSION
                                    )
                                );


                                $fileTitle = $media->alt ?: $fileName;


                                $imageExtensions = [
                                    'jpg',
                                    'jpeg',
                                    'png',
                                    'webp',
                                    'gif',
                                    'bmp',
                                    'svg',
                                ];


                                $isImage =
                                    $media->type === 'image' ||

                                    str_starts_with(
                                        (string) $media->mime_type,
                                        'image/'
                                    ) ||

                                    in_array(
                                        $extension,
                                        $imageExtensions,
                                        true
                                    );


                                $encodedPath = implode(
                                    '/',
                                    array_map(
                                        'rawurlencode',
                                        explode('/', $resolvedPath)
                                    )
                                );


                                $fileUrl = null;


                                if ($resolvedPath !== '') {

                                    try {

                                        if ($disk === 'public') {

                                            $fileUrl =
                                                '/storage/' .
                                                $encodedPath;

                                        } else {

                                            $fileUrl =
                                                \Illuminate\Support\Facades\Storage::disk(
                                                    $disk
                                                )->url($resolvedPath);
                                        }

                                    } catch (\Throwable $exception) {

                                        $fileUrl = null;

                                    }

                                }


                                $absoluteFileUrl = null;


                                if ($fileUrl) {

                                    if (
                                        str_starts_with(
                                            $fileUrl,
                                            'http://'
                                        ) ||

                                        str_starts_with(
                                            $fileUrl,
                                            'https://'
                                        )
                                    ) {

                                        $absoluteFileUrl = $fileUrl;

                                    } else {

                                        $absoluteFileUrl =
                                            rtrim(
                                                request()->getSchemeAndHttpHost(),
                                                '/'
                                            )
                                            .
                                            '/'
                                            .
                                            ltrim(
                                                $fileUrl,
                                                '/'
                                            );

                                    }

                                }
                            @endphp


                            <article class="media-card">

                                {{-- Preview --}}
                                <div class="media-preview">

                                    @if($isImage && $fileUrl)

                                        <a
                                            href="{{ $fileUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="media-preview-link"
                                        >

                                            <img
                                                src="{{ $fileUrl }}"
                                                alt="{{ $fileTitle }}"
                                                loading="lazy"
                                                class="js-media-image"
                                            >


                                            <div
                                                class="media-file-placeholder js-media-image-fallback"
                                                hidden
                                            >

                                                <span class="media-file-icon">
                                                    IMG
                                                </span>

                                                <strong>
                                                    تصویر قابل نمایش نیست
                                                </strong>

                                            </div>

                                        </a>


                                    @elseif($extension === 'pdf')

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                PDF
                                            </span>

                                            <strong>
                                                سند PDF
                                            </strong>

                                        </div>


                                    @elseif(in_array($extension, ['doc', 'docx'], true))

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                DOC
                                            </span>

                                            <strong>
                                                سند Word
                                            </strong>

                                        </div>


                                    @elseif(in_array($extension, ['xls', 'xlsx'], true))

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                XLS
                                            </span>

                                            <strong>
                                                فایل Excel
                                            </strong>

                                        </div>


                                    @elseif(in_array($extension, ['ppt', 'pptx'], true))

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                PPT
                                            </span>

                                            <strong>
                                                فایل PowerPoint
                                            </strong>

                                        </div>


                                    @elseif(in_array($extension, ['zip', 'rar'], true))

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                ZIP
                                            </span>

                                            <strong>
                                                فایل فشرده
                                            </strong>

                                        </div>


                                    @elseif($media->type === 'video')

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                ▶
                                            </span>

                                            <strong>
                                                فایل ویدیویی
                                            </strong>

                                        </div>


                                    @elseif($media->type === 'audio')

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                ♪
                                            </span>

                                            <strong>
                                                فایل صوتی
                                            </strong>

                                        </div>


                                    @else

                                        <div class="media-file-placeholder">

                                            <span class="media-file-icon">
                                                FILE
                                            </span>

                                            <strong>
                                                فایل
                                            </strong>

                                        </div>

                                    @endif


                                    {{-- File Type --}}
                                    <span class="media-type-badge">

                                        @if($isImage)

                                            تصویر

                                        @elseif($extension === 'pdf')

                                            PDF

                                        @elseif(in_array($extension, ['doc', 'docx'], true))

                                            Word

                                        @elseif(in_array($extension, ['xls', 'xlsx'], true))

                                            Excel

                                        @elseif(in_array($extension, ['ppt', 'pptx'], true))

                                            PowerPoint

                                        @elseif($media->type === 'audio')

                                            صوت

                                        @elseif($media->type === 'video')

                                            ویدیو

                                        @else

                                            فایل

                                        @endif

                                    </span>

                                </div>


                                {{-- Card Body --}}
                                <div class="media-card-body">

                                    <h3
                                        class="media-file-name"
                                        title="{{ $fileTitle }}"
                                    >
                                        {{ \Illuminate\Support\Str::limit(
                                            $fileTitle,
                                            35
                                        ) }}
                                    </h3>


                                    {{-- Meta --}}
                                    <div class="media-meta-list">

                                        <div>

                                            <span>
                                                حجم:
                                            </span>

                                            <strong>
                                                {{ $formatFileSize($media->size) }}
                                            </strong>

                                        </div>


                                        @if($media->width && $media->height)

                                            <div>

                                                <span>
                                                    ابعاد:
                                                </span>

                                                <strong dir="ltr">

                                                    {{ $media->width }}

                                                    ×

                                                    {{ $media->height }}

                                                </strong>

                                            </div>

                                        @endif


                                        <div>

                                            <span>
                                                فرمت:
                                            </span>

                                            <strong dir="ltr">

                                                {{ $extension
                                                    ? strtoupper($extension)
                                                    : '---'
                                                }}

                                            </strong>

                                        </div>


                                        <div>

                                            <span>
                                                تاریخ:
                                            </span>

                                            <strong>
                                                {{ $media->created_at?->format('Y/m/d') }}
                                            </strong>

                                        </div>

                                    </div>


                                    {{-- Missing File --}}
                                    @if(!$fileExists)

                                        <div class="alert alert-warning py-2 px-3 mb-3">
                                            فایل در مسیر ثبت‌شده پیدا نشد.
                                        </div>

                                    @endif


                                    {{-- Direct Link --}}
                                    @if($absoluteFileUrl)

                                        <div class="media-download-section">

                                            <label
                                                for="file-link-{{ $media->id }}"
                                                class="admin-label"
                                            >
                                                لینک فایل برای قرار دادن در مقاله
                                            </label>


                                            <div class="media-download-link-box">

                                                <input
                                                    type="text"
                                                    id="file-link-{{ $media->id }}"
                                                    value="{{ $absoluteFileUrl }}"
                                                    class="form-control admin-form-control"
                                                    readonly
                                                    dir="ltr"
                                                >


                                                <button
                                                    type="button"
                                                    class="admin-action-btn media-copy-btn js-copy-media-link"
                                                    data-media-id="{{ $media->id }}"
                                                style="background: black;!important;">
                                                    کپی لینک
                                                </button>

                                            </div>

                                        </div>

                                    @endif


                                    {{-- Edit --}}
                                    <details class="media-edit-details">

                                        <summary>
                                            ویرایش اطلاعات
                                        </summary>


                                        <form
                                            action="{{ route(
                                                'admin.media.update',
                                                $media
                                            ) }}"
                                            method="POST"
                                            class="media-edit-form"
                                        >

                                            @csrf

                                            @method('PATCH')


                                            <div class="form-group">

                                                <label class="admin-label">
                                                    عنوان یا متن جایگزین
                                                </label>


                                                <input
                                                    type="text"
                                                    name="alt"
                                                    value="{{ $media->alt }}"
                                                    class="form-control admin-form-control"
                                                    maxlength="255"
                                                    placeholder="عنوان قابل نمایش فایل"
                                                >

                                            </div>


                                            <div class="form-group">

                                                <label class="admin-label">
                                                    توضیحات
                                                </label>


                                                <textarea
                                                    name="caption"
                                                    class="form-control admin-form-control"
                                                    rows="3"
                                                    maxlength="2000"
                                                    placeholder="توضیحات تکمیلی رسانه"
                                                >{{ $media->caption }}</textarea>

                                            </div>


                                            <button
                                                type="submit"
                                                class="btn admin-submit-btn media-save-btn"
                                            >
                                                ذخیره تغییرات
                                            </button>

                                        </form>

                                    </details>


                                    {{-- Actions --}}
                                    <div class="media-card-actions">

                                        @if($fileUrl)

                                            <a
                                                href="{{ $fileUrl }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="admin-action-btn media-view-btn"
                                                style="color: #292929;!important;"
                                            >
                                                مشاهده فایل
                                            </a>


                                            <a
                                                href="{{ $fileUrl }}"
                                                download
                                                class="admin-action-btn media-download-btn"
                                                style="color: #292929;!important;"
                                            >
                                                دانلود فایل
                                            </a>

                                        @endif


                                        <form
                                            action="{{ route(
                                                'admin.media.destroy',
                                                $media
                                            ) }}"
                                            method="POST"
                                            onsubmit="return confirm('آیا از حذف این رسانه مطمئن هستید؟')"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="admin-action-btn delete"
                                            >
                                                حذف
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </article>

                        @endforeach

                    </div>


                @else

                    {{-- Empty --}}
                    <div class="media-empty-state">

                        <div class="media-empty-icon">
                            ＋
                        </div>

                        <h3>
                            هنوز رسانه‌ای آپلود نشده است
                        </h3>

                        <p>
                            اولین تصویر یا فایل خود را از بخش بالای صفحه آپلود کنید.
                        </p>

                    </div>

                @endif

            </div>


            {{-- Pagination --}}
            @if($mediaItems->hasPages())

                <div class="card-footer">

                    <div class="d-flex justify-content-center">
                        {{ $mediaItems->links() }}
                    </div>

                </div>

            @endif

        </div>

    </div>

@endsection


@push('scripts')

    <script
        src="{{ asset('back/js/media/index.js') }}"
        defer
    ></script>

@endpush
