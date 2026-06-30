@extends('back.admin.layouts.master')

@section('content')

    <style>
        .podcast-create-wrapper {
            direction: rtl;
        }

        .podcast-page-header {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045);
            margin-bottom: 22px;
        }

        .podcast-page-title {
            color: #111827;
            font-size: 18px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .podcast-page-subtitle {
            color: #64748b;
            font-size: 13px;
        }

        .podcast-back-btn {
            background: #f8fafc;
            border: 1px solid #dbe1ea;
            color: #334155;
            border-radius: 8px;
            padding: 9px 16px;
            font-size: 13px;
            font-weight: 800;
        }

        .podcast-back-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }

        .podcast-card {
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .podcast-card-header {
            padding: 16px 18px;
            border-bottom: 1px solid #e5e7eb;
            background: #f8fafc;
        }

        .podcast-card-title {
            color: #111827;
            font-size: 14px;
            font-weight: 900;
            margin: 0;
        }

        .podcast-card-title i {
            color: #334155;
        }

        .podcast-card-body {
            padding: 18px;
        }

        .podcast-label {
            color: #334155;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .podcast-label .required {
            color: #dc2626;
        }

        .podcast-form-control {
            border: 1px solid #dbe1ea;
            border-radius: 9px;
            min-height: 43px;
            color: #334155;
            font-size: 13px;
            box-shadow: none;
        }

        .podcast-form-control:focus {
            border-color: #334155;
            box-shadow: 0 0 0 0.12rem rgba(51, 65, 85, 0.12);
        }

        textarea.podcast-form-control {
            min-height: 105px;
            resize: vertical;
        }

        .podcast-help {
            color: #94a3b8;
            font-size: 11px;
            margin-top: 5px;
        }

        .podcast-section-note {
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            padding: 12px;
            color: #64748b;
            font-size: 12px;
            line-height: 1.9;
        }

        .podcast-upload-box {
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            border-radius: 12px;
            padding: 14px;
        }

        .podcast-status-box {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            border-radius: 10px;
            padding: 12px;
        }

        .podcast-submit-btn {
            width: 100%;
            min-height: 47px;
            border-radius: 9px;
            background: #1e293b;
            border-color: #1e293b;
            color: #ffffff;
            font-size: 14px;
            font-weight: 900;
        }

        .podcast-submit-btn:hover {
            background: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
        }

        .podcast-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 18px 0;
        }

        .invalid-feedback {
            display: block;
            font-size: 11px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .podcast-page-header {
                flex-direction: column;
                align-items: flex-start !important;
            }

            .podcast-back-btn {
                width: 100%;
                margin-top: 12px;
                text-align: center;
            }
        }
    </style>

    <div class="podcast-create-wrapper">

        <div class="podcast-page-header d-flex align-items-center justify-content-between">
            <div>
                <h4 class="podcast-page-title">
                    <i class="fa fa-microphone ml-2"></i>
                    اتاق پادکست
                </h4>
                <div class="podcast-page-subtitle">
                    ثبت، مدیریت و انتشار فایل صوتی، لینک پادکست و پلتفرم‌های پخش
                </div>
            </div>

            <a href="{{ route('admin.podcasts.index') }}" class="btn podcast-back-btn">
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست
            </a>
        </div>

        <form action="{{ route('admin.podcasts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row row-sm">

                <div class="col-xl-8 col-lg-8 col-md-12">

                    <div class="podcast-card">
                        <div class="podcast-card-header">
                            <h4 class="podcast-card-title">
                                <i class="fa fa-info-circle ml-2"></i>
                                اطلاعات اصلی پادکست
                            </h4>
                        </div>

                        <div class="podcast-card-body">

                            <div class="form-group">
                                <label for="title" class="podcast-label">
                                    عنوان پادکست
                                    <span class="required">*</span>
                                </label>
                                <input type="text"
                                       name="title"
                                       id="title"
                                       value="{{ old('title') }}"
                                       class="form-control podcast-form-control @error('title') is-invalid @enderror"
                                       placeholder="مثلاً: گفت‌وگوی ویژه با..."
                                       required>

                                @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="podcast_category_id" class="podcast-label">
                                    سرویس پادکست / دسته‌بندی
                                    <span class="required">*</span>
                                </label>

                                <select name="category_id"
                                        id="category_id"
                                        class="form-control podcast-form-control @error('category_id') is-invalid @enderror"
                                        required>


                                    @foreach($categories->where('parent_id', null) as $mainCat)
                                        <option value="{{ $mainCat->id }}"
                                            {{ old('podcast_category_id') == $mainCat->id ? 'selected' : '' }}>
                                            {{ $mainCat->title }}
                                        </option>

                                        @foreach($mainCat->children as $child)
                                            <option value="{{ $child->id }}"
                                                {{ old('podcast_category_id') == $child->id ? 'selected' : '' }}>
                                                — {{ $child->title }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>

                                @error('podcast_category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="host_name" class="podcast-label">
                                    میزبان / گوینده
                                </label>
                                <input type="text"
                                       name="host_name"
                                       id="host_name"
                                       value="{{ old('host_name') }}"
                                       class="form-control podcast-form-control @error('host_name') is-invalid @enderror"
                                       placeholder="نام میزبان، گوینده یا مهمان برنامه">

                                @error('host_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label for="summary" class="podcast-label">
                                    توضیحات کوتاه
                                </label>
                                <textarea name="summary"
                                          id="summary"
                                          class="form-control podcast-form-control @error('summary') is-invalid @enderror"
                                          placeholder="خلاصه‌ای کوتاه از موضوع این قسمت بنویسید...">{{ old('summary') }}</textarea>

                                @error('summary')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="podcast-card">
                        <div class="podcast-card-header">
                            <h4 class="podcast-card-title">
                                <i class="fa fa-link ml-2"></i>
                                لینک‌ها و کدهای پخش
                            </h4>
                        </div>

                        <div class="podcast-card-body">

                            <div class="podcast-section-note mb-3">
                                در این بخش می‌توانید لینک مستقیم فایل صوتی، کد Embed یا لینک پلتفرم‌های کست باکس و شنوتو را وارد کنید.
                            </div>

                            <div class="form-group">
                                <label for="audio_url" class="podcast-label">
                                    لینک مستقیم فایل صوتی
                                </label>
                                <input type="url"
                                       name="audio_url"
                                       id="audio_url"
                                       value="{{ old('audio_url') }}"
                                       class="form-control podcast-form-control @error('audio_url') is-invalid @enderror"
                                       placeholder="https://example.com/audio.mp3">

                                @error('audio_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="duration" class="podcast-label">
                                    مدت زمان
                                </label>
                                <input type="text"
                                       name="duration"
                                       id="duration"
                                       value="{{ old('duration') }}"
                                       class="form-control podcast-form-control @error('duration') is-invalid @enderror"
                                       placeholder="مثلاً: ۲۴:۳۰ یا 24 min">

                                @error('duration')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="castbox_url" class="podcast-label">
                                    لینک کست باکس
                                </label>
                                <input type="url"
                                       name="castbox_url"
                                       id="castbox_url"
                                       value="{{ old('castbox_url') }}"
                                       class="form-control podcast-form-control @error('castbox_url') is-invalid @enderror"
                                       placeholder="لینک کست باکس">

                                @error('castbox_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="spotify_url" class="podcast-label">
                                    لینک شنوتو
                                </label>
                                <input type="url"
                                       name="spotify_url"
                                       id="spotify_url"
                                       value="{{ old('spotify_url') }}"
                                       class="form-control podcast-form-control @error('spotify_url') is-invalid @enderror"
                                       placeholder="لینک شنوتو">

                                @error('spotify_url')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label for="embed_code" class="podcast-label">
                                    کد Embed
                                </label>
                                <textarea name="embed_code"
                                          id="embed_code"
                                          rows="4"
                                          class="form-control podcast-form-control @error('embed_code') is-invalid @enderror"
                                          placeholder="<iframe ...></iframe>">{{ old('embed_code') }}</textarea>

                                @error('embed_code')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-xl-4 col-lg-4 col-md-12">

                    <div class="podcast-card">
                        <div class="podcast-card-header">
                            <h4 class="podcast-card-title">
                                <i class="fa fa-file-audio-o ml-2"></i>
                                فایل‌های رسانه‌ای
                            </h4>
                        </div>

                        <div class="podcast-card-body">

                            <div class="form-group">
                                <label for="image" class="podcast-label">
                                    تصویر کاور
                                </label>

                                <div class="podcast-upload-box">
                                    <input type="file"
                                           name="image"
                                           id="image"
                                           accept="image/jpeg,image/png,image/jpg,image/webp"
                                           class="form-control podcast-form-control @error('image') is-invalid @enderror">

                                    <div class="podcast-help">
                                        فرمت‌های مجاز: jpg, png, webp — حداکثر ۲ مگابایت
                                    </div>
                                </div>

                                @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="podcast-divider"></div>

                            <div class="form-group mb-0">
                                <label for="audio_file" class="podcast-label">
                                    آپلود فایل صوتی
                                </label>

                                <div class="podcast-upload-box">
                                    <input type="file"
                                           name="audio_file"
                                           id="audio_file"
                                           accept="audio/mpeg,audio/wav,audio/ogg"
                                           class="form-control podcast-form-control @error('audio_file') is-invalid @enderror">

                                    <div class="podcast-help">
                                        فرمت‌های مجاز: mp3, wav, ogg — حداکثر ۵۰ مگابایت
                                    </div>
                                </div>

                                @error('audio_file')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="podcast-card">
                        <div class="podcast-card-header">
                            <h4 class="podcast-card-title">
                                <i class="fa fa-cog ml-2"></i>
                                تنظیمات انتشار
                            </h4>
                        </div>

                        <div class="podcast-card-body">

                            <div class="form-group">
                                <label for="status" class="podcast-label">
                                    وضعیت انتشار
                                    <span class="required">*</span>
                                </label>

                                <div class="podcast-status-box">
                                    <select name="status"
                                            id="status"
                                            class="form-control podcast-form-control @error('status') is-invalid @enderror">
                                        <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>
                                            انتشار فوری
                                        </option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>
                                            پیش‌نویس
                                        </option>
                                    </select>
                                </div>

                                @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn podcast-submit-btn mt-2">
                                <i class="fa fa-check-circle ml-1"></i>
                                ذخیره پادکست
                            </button>

                        </div>
                    </div>

                </div>

            </div>
        </form>

    </div>
@endsection
