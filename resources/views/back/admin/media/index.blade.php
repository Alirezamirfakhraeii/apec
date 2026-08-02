@extends('back.admin.layouts.master')

<head>
    <link rel="stylesheet" href="{{ asset('back/css/pages/index.css') }}">
    <link rel="stylesheet" href="{{ asset('back/css/media/index.css') }}">
</head>

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

    <div class="news-admin-wrapper media-admin-wrapper" dir="rtl">

        {{-- هدر صفحه --}}
        <div class="news-page-header">
            <div>
                <h1>کتابخانه رسانه‌ها</h1>

                <p>
                    تصاویر، اسناد، فایل‌های صوتی و ویدیویی سایت را مدیریت کنید.
                </p>
            </div>

            <a href="#media-upload-section" class="news-create-btn">
                آپلود فایل جدید
            </a>
        </div>

        {{-- پیام موفقیت --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- پیام خطا --}}
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- خطاهای اعتبارسنجی --}}
        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <strong>عملیات انجام نشد.</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- بخش آپلود --}}
        <div
            class="filter-card media-upload-card mb-4"
            id="media-upload-section"
        >
            <div class="media-section-header">
                <div>
                    <h2>آپلود رسانه</h2>

                    <p>
                        می‌توانید چند فایل را به‌صورت هم‌زمان انتخاب و آپلود کنید.
                    </p>
                </div>
            </div>

            <form
                action="{{ route('admin.media.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf

                <div class="row align-items-end">

                    <div class="col-md-9 mb-3">
                        <label
                            for="media-files"
                            class="form-label"
                        >
                            انتخاب فایل‌ها
                        </label>

                        <input
                            type="file"
                            name="files[]"
                            id="media-files"
                            class="form-control"
                            multiple
                            required
                            accept=".jpg,.jpeg,.png,.webp,.gif,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar,.txt,.mp3,.wav,.mp4"
                        >

                        <small class="text-muted d-block mt-2">
                            تصاویر، PDF، Word، Excel، PowerPoint، فایل‌های فشرده،
                            صوت و ویدیو قابل آپلود هستند.
                        </small>

                        <small class="text-muted d-block mt-1">
                            حداکثر حجم هر فایل ۲۰ مگابایت است.
                        </small>
                    </div>

                    <div class="col-md-3 mb-3">
                        <button
                            type="submit"
                            class="news-create-btn w-100"
                        >
                            شروع آپلود
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- فیلترها --}}
        <div class="filter-card mb-4">
            <form
                action="{{ route('admin.media.index') }}"
                method="GET"
            >
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            جستجو
                        </label>

                        <input
                            type="text"
                            name="q"
                            value="{{ request('q') }}"
                            class="form-control"
                            placeholder="نام فایل، متن جایگزین یا توضیحات"
                        >
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">
                            نوع رسانه
                        </label>

                        <select
                            name="type"
                            class="form-control"
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

                    <div class="col-md-3 mb-3 d-flex align-items-end">
                        <div class="media-filter-actions w-100">

                            <button
                                type="submit"
                                class="news-create-btn"
                            >
                                اعمال فیلتر
                            </button>

                            @if(request()->hasAny(['q', 'type']))
                                <a
                                    href="{{ route('admin.media.index') }}"
                                    class="media-reset-btn"
                                >
                                    حذف فیلتر
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            </form>
        </div>

        {{-- کتابخانه رسانه --}}
        <div class="editorial-table-card media-library-card">

            <div class="editorial-table-header media-library-header">
                <div>
                    <h2>رسانه‌های آپلودشده</h2>

                    <span class="media-items-count">
                        {{ number_format($mediaItems->total()) }} فایل
                    </span>
                </div>
            </div>

            @if($mediaItems->count())
                <div class="media-grid">

                    @foreach($mediaItems as $media)
                        @php
                            /*
                             * آماده‌سازی اطلاعات فایل
                             */
                            $disk = $media->disk ?: 'public';

                            $rawPath = ltrim(
                                (string) $media->path,
                                '/'
                            );

                            /*
                             * بعضی رکوردهای قدیمی ممکن است مسیرهایی مثل:
                             *
                             * public/media/file.jpg
                             * storage/media/file.jpg
                             * storage/app/public/media/file.jpg
                             *
                             * داشته باشند. این قسمت آن‌ها را اصلاح می‌کند.
                             */
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
                                    // در صورت خطای دیسک، مسیر اولیه حفظ می‌شود.
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

                            /*
                             * تشخیص نوع تصویر
                             */
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

                            /*
                             * ساخت آدرس واقعی فایل
                             */
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
                                        /*
                                         * آدرس نسبی استفاده می‌کنیم تا وابسته به
                                         * APP_URL اشتباه نباشد.
                                         */
                                        $fileUrl = '/storage/' . $encodedPath;
                                    } else {
                                        $fileUrl = \Illuminate\Support\Facades\Storage::disk(
                                            $disk
                                        )->url($resolvedPath);
                                    }
                                } catch (\Throwable $exception) {
                                    $fileUrl = null;
                                }
                            }

                            /*
                             * لینک کامل برای کپی داخل مقاله
                             */
                            $absoluteFileUrl = null;

                            if ($fileUrl) {
                                if (
                                    str_starts_with($fileUrl, 'http://') ||
                                    str_starts_with($fileUrl, 'https://')
                                ) {
                                    $absoluteFileUrl = $fileUrl;
                                } else {
                                    $absoluteFileUrl =
                                        rtrim(
                                            request()->getSchemeAndHttpHost(),
                                            '/'
                                        ) .
                                        '/' .
                                        ltrim($fileUrl, '/');
                                }
                            }
                        @endphp

                        <article class="media-card">

                            {{-- پیش‌نمایش --}}
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
                                            onerror="
                                                this.style.display='none';
                                                this.nextElementSibling.style.display='flex';
                                            "
                                        >

                                        <div
                                            class="media-file-placeholder"
                                            style="display: none;"
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

                                {{-- برچسب نوع فایل --}}
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

                            {{-- اطلاعات کارت --}}
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

                                {{-- مشخصات فایل --}}
                                <div class="media-meta-list">

                                    <div>
                                        <span>حجم:</span>

                                        <strong>
                                            {{ $formatFileSize($media->size) }}
                                        </strong>
                                    </div>

                                    @if($media->width && $media->height)
                                        <div>
                                            <span>ابعاد:</span>

                                            <strong dir="ltr">
                                                {{ $media->width }}
                                                ×
                                                {{ $media->height }}
                                            </strong>
                                        </div>
                                    @endif

                                    <div>
                                        <span>فرمت:</span>

                                        <strong dir="ltr">
                                            {{ $extension
                                                ? strtoupper($extension)
                                                : '---'
                                            }}
                                        </strong>
                                    </div>

                                    <div>
                                        <span>تاریخ:</span>

                                        <strong>
                                            {{ $media->created_at?->format('Y/m/d') }}
                                        </strong>
                                    </div>

                                </div>

                                {{-- هشدار فایل ناموجود --}}
                                @if(!$fileExists)
                                    <div class="alert alert-warning py-2 px-3 mb-3">
                                        فایل در مسیر ثبت‌شده پیدا نشد.
                                    </div>
                                @endif

                                {{-- لینک مستقیم برای مقاله --}}
                                @if($absoluteFileUrl)
                                    <div class="media-download-section">

                                        <label
                                            for="file-link-{{ $media->id }}"
                                            class="form-label"
                                        >
                                            لینک فایل برای قرار دادن در مقاله
                                        </label>

                                        <div class="media-download-link-box">

                                            <input
                                                type="text"
                                                id="file-link-{{ $media->id }}"
                                                value="{{ $absoluteFileUrl }}"
                                                class="form-control"
                                                readonly
                                                dir="ltr"
                                                onclick="this.select()"
                                            >

                                            <button
                                                type="button"
                                                class="editorial-action-btn media-copy-btn"
                                                onclick="copyFileLink(
                                                    {{ $media->id }},
                                                    this
                                                )"
                                            >
                                                کپی لینک
                                            </button>

                                        </div>
                                    </div>
                                @endif

                                {{-- ویرایش اطلاعات --}}
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

                                        <div class="mb-3">
                                            <label class="form-label">
                                                عنوان یا متن جایگزین
                                            </label>

                                            <input
                                                type="text"
                                                name="alt"
                                                value="{{ $media->alt }}"
                                                class="form-control"
                                                maxlength="255"
                                                placeholder="عنوان قابل نمایش فایل"
                                            >
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                توضیحات
                                            </label>

                                            <textarea
                                                name="caption"
                                                class="form-control"
                                                rows="3"
                                                maxlength="2000"
                                                placeholder="توضیحات تکمیلی رسانه"
                                            >{{ $media->caption }}</textarea>
                                        </div>

                                        <button
                                            type="submit"
                                            class="editorial-action-btn media-save-btn"
                                        >
                                            ذخیره تغییرات
                                        </button>
                                    </form>
                                </details>

                                {{-- عملیات --}}
                                <div class="media-card-actions">

                                    @if($fileUrl)
                                        <a
                                            href="{{ $fileUrl }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="editorial-action-btn"
                                        >
                                            مشاهده فایل
                                        </a>

                                        <a
                                            href="{{ $fileUrl }}"
                                            download
                                            class="editorial-action-btn"
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
                                        onsubmit="return confirm(
                                            'آیا از حذف این رسانه مطمئن هستید؟'
                                        )"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="editorial-action-btn media-delete-btn"
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

            @if($mediaItems->hasPages())
                <div class="editorial-footer">
                    {{ $mediaItems->links() }}
                </div>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        async function copyFileLink(mediaId, button) {
            const input = document.getElementById(
                `file-link-${mediaId}`
            );

            if (!input) {
                return;
            }

            const oldText = button.innerText;

            try {
                if (
                    navigator.clipboard &&
                    window.isSecureContext
                ) {
                    await navigator.clipboard.writeText(
                        input.value
                    );
                } else {
                    input.focus();
                    input.select();
                    input.setSelectionRange(
                        0,
                        input.value.length
                    );

                    document.execCommand('copy');
                }

                button.innerText = 'کپی شد';
                button.disabled = true;

                setTimeout(() => {
                    button.innerText = oldText;
                    button.disabled = false;
                }, 1500);

            } catch (error) {
                input.focus();
                input.select();

                alert(
                    'کپی خودکار انجام نشد. لینک انتخاب شده است؛ آن را دستی کپی کنید.'
                );
            }
        }
    </script>
@endpush
