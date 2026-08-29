@extends('back.admin.layouts.master')

@section('content')

    <div class="admin-wrapper">

        {{-- Page Header --}}
        <div class="admin-page-header d-flex align-items-center justify-content-between">

            <div>
                <h4 class="admin-page-title">
                    <i class="fa fa-pencil ml-2"></i>
                    ویرایش پادکست
                </h4>

                <div class="admin-page-subtitle">
                    ویرایش اطلاعات، فایل صوتی، لینک‌ها و تنظیمات انتشار پادکست
                </div>
            </div>

            <a
                href="{{ route('admin.podcasts.index') }}"
                class="btn admin-back-btn"
            >
                <i class="fa fa-arrow-right ml-1"></i>
                بازگشت به لیست
            </a>

        </div>


        <form
            action="{{ route('admin.podcasts.update', $podcast->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            <div class="row row-sm">

                {{-- Main Content --}}
                <div class="col-xl-8 col-lg-8 col-md-12">


                    {{-- Main Information --}}
                    <div class="admin-card">

                        <div class="admin-card-header">
                            <h4 class="admin-card-title">
                                <i class="fa fa-info-circle ml-2"></i>
                                اطلاعات اصلی پادکست
                            </h4>
                        </div>


                        <div class="admin-card-body">

                            {{-- Title --}}
                            <div class="form-group">

                                <label for="title" class="admin-label">
                                    عنوان پادکست
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="title"
                                    id="title"
                                    value="{{ old('title', $podcast->title) }}"
                                    class="form-control admin-form-control @error('title') is-invalid @enderror"
                                    placeholder="مثلاً: گفت‌وگوی ویژه با..."
                                    required
                                >

                                @error('title')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Category --}}
                            <div class="form-group">

                                <label for="category_id" class="admin-label">
                                    سرویس پادکست / دسته‌بندی
                                    <span class="required">*</span>
                                </label>

                                <select
                                    name="category_id"
                                    id="category_id"
                                    class="form-control admin-form-control @error('category_id') is-invalid @enderror"
                                    required
                                >

                                    @foreach($categories->where('parent_id', null) as $mainCat)

                                        <option
                                            value="{{ $mainCat->id }}"
                                            {{ old('category_id', $podcast->category_id) == $mainCat->id ? 'selected' : '' }}
                                        >
                                            {{ $mainCat->title }}
                                        </option>

                                        @foreach($mainCat->children as $child)

                                            <option
                                                value="{{ $child->id }}"
                                                {{ old('category_id', $podcast->category_id) == $child->id ? 'selected' : '' }}
                                            >
                                                — {{ $child->title }}
                                            </option>

                                        @endforeach

                                    @endforeach

                                </select>

                                @error('category_id')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Host --}}
                            <div class="form-group">

                                <label for="host_name" class="admin-label">
                                    میزبان / گوینده
                                </label>

                                <input
                                    type="text"
                                    name="host_name"
                                    id="host_name"
                                    value="{{ old('host_name', $podcast->host_name) }}"
                                    class="form-control admin-form-control @error('host_name') is-invalid @enderror"
                                    placeholder="نام میزبان، گوینده یا مهمان برنامه"
                                >

                                @error('host_name')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Summary --}}
                            <div class="form-group mb-0">

                                <label for="summary" class="admin-label">
                                    توضیحات کوتاه
                                </label>

                                <textarea
                                    name="summary"
                                    id="summary"
                                    rows="5"
                                    class="form-control admin-form-control @error('summary') is-invalid @enderror"
                                    placeholder="خلاصه‌ای کوتاه از موضوع این قسمت بنویسید..."
                                >{{ old('summary', $podcast->summary) }}</textarea>

                                @error('summary')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Links --}}
                    <div class="admin-card">

                        <div class="admin-card-header">
                            <h4 class="admin-card-title">
                                <i class="fa fa-link ml-2"></i>
                                لینک‌ها و کدهای پخش
                            </h4>
                        </div>


                        <div class="admin-card-body">

                            <div class="admin-section-note mb-3">
                                لینک مستقیم فایل صوتی، کد Embed و لینک پلتفرم‌های پخش را می‌توانید از این بخش ویرایش کنید.
                            </div>


                            {{-- Audio URL --}}
                            <div class="form-group">

                                <label for="audio_url" class="admin-label">
                                    لینک مستقیم فایل صوتی
                                </label>

                                <input
                                    type="url"
                                    name="audio_url"
                                    id="audio_url"
                                    value="{{ old('audio_url', $podcast->audio_url) }}"
                                    class="form-control admin-form-control @error('audio_url') is-invalid @enderror"
                                    placeholder="https://example.com/audio.mp3"
                                >

                                @error('audio_url')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Duration --}}
                            <div class="form-group">

                                <label for="duration" class="admin-label">
                                    مدت زمان
                                </label>

                                <input
                                    type="text"
                                    name="duration"
                                    id="duration"
                                    value="{{ old('duration', $podcast->duration) }}"
                                    class="form-control admin-form-control @error('duration') is-invalid @enderror"
                                    placeholder="مثلاً: ۲۴:۳۰ یا 24 min"
                                >

                                @error('duration')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Castbox --}}
                            <div class="form-group">

                                <label for="castbox_url" class="admin-label">
                                    لینک کست باکس
                                </label>

                                <input
                                    type="url"
                                    name="castbox_url"
                                    id="castbox_url"
                                    value="{{ old('castbox_url', $podcast->castbox_url) }}"
                                    class="form-control admin-form-control @error('castbox_url') is-invalid @enderror"
                                    placeholder="لینک کست باکس"
                                >

                                @error('castbox_url')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Shenoto --}}
                            <div class="form-group">

                                <label for="spotify_url" class="admin-label">
                                    لینک شنوتو
                                </label>

                                <input
                                    type="url"
                                    name="spotify_url"
                                    id="spotify_url"
                                    value="{{ old('spotify_url', $podcast->spotify_url) }}"
                                    class="form-control admin-form-control @error('spotify_url') is-invalid @enderror"
                                    placeholder="لینک شنوتو"
                                >

                                @error('spotify_url')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            {{-- Embed --}}
                            <div class="form-group mb-0">

                                <label for="embed_code" class="admin-label">
                                    کد Embed
                                </label>

                                <textarea
                                    name="embed_code"
                                    id="embed_code"
                                    rows="5"
                                    class="form-control admin-form-control @error('embed_code') is-invalid @enderror"
                                    placeholder="<iframe ...></iframe>"
                                >{{ old('embed_code', $podcast->embed_code) }}</textarea>

                                @error('embed_code')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Sidebar --}}
                <div class="col-xl-4 col-lg-4 col-md-12">


                    {{-- Media --}}
                    <div class="admin-card">

                        <div class="admin-card-header">
                            <h4 class="admin-card-title">
                                <i class="fa fa-file-audio-o ml-2"></i>
                                فایل‌های رسانه‌ای
                            </h4>
                        </div>


                        <div class="admin-card-body">

                            {{-- Current Cover --}}
                            @if($podcast->image)

                                <div class="form-group">

                                    <label class="admin-label">
                                        تصویر کاور فعلی
                                    </label>

                                    <div class="text-center p-3"
                                         style="background:#f8f9fa;border:1px solid #eee;border-radius:10px;">

                                        <img
                                            src="{{ asset('storage/' . $podcast->image) }}"
                                            alt="{{ $podcast->title }}"
                                            style="
                                                max-width: 100%;
                                                max-height: 230px;
                                                object-fit: cover;
                                                border-radius: 8px;
                                            "
                                        >

                                    </div>

                                </div>

                                <div class="admin-divider"></div>

                            @endif


                            {{-- Cover --}}
                            <div class="form-group">

                                <label for="image" class="admin-label">
                                    تغییر تصویر کاور
                                </label>

                                <div class="admin-upload-box">

                                    <input
                                        type="file"
                                        name="image"
                                        id="image"
                                        accept="image/jpeg,image/png,image/jpg,image/webp"
                                        class="form-control admin-form-control @error('image') is-invalid @enderror"
                                    >

                                    <div class="admin-help">
                                        در صورتی که نمی‌خواهید تصویر تغییر کند، این قسمت را خالی بگذارید.
                                    </div>

                                    <div class="admin-help mt-1">
                                        فرمت‌های مجاز: jpg, png, webp — حداکثر ۲ مگابایت
                                    </div>

                                </div>

                                @error('image')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            <div class="admin-divider"></div>


                            {{-- Current Audio --}}
                            @if($podcast->audio_url)

                                <div class="form-group">

                                    <label class="admin-label">
                                        فایل صوتی فعلی
                                    </label>

                                    <audio
                                        controls
                                        style="width:100%;"
                                    >
                                        <source src="{{ $podcast->audio_url }}">
                                        مرورگر شما از پخش فایل صوتی پشتیبانی نمی‌کند.
                                    </audio>

                                </div>

                                <div class="admin-divider"></div>

                            @endif


                            {{-- Audio File --}}
                            <div class="form-group mb-0">

                                <label for="audio_file" class="admin-label">
                                    جایگزینی فایل صوتی
                                </label>

                                <div class="admin-upload-box">

                                    <input
                                        type="file"
                                        name="audio_file"
                                        id="audio_file"
                                        accept="audio/mpeg,audio/wav,audio/ogg"
                                        class="form-control admin-form-control @error('audio_file') is-invalid @enderror"
                                    >

                                    <div class="admin-help">
                                        اگر فایل جدید انتخاب نکنید، فایل قبلی حفظ می‌شود.
                                    </div>

                                    <div class="admin-help mt-1">
                                        فرمت‌های مجاز: mp3, wav, ogg — حداکثر ۵۰ مگابایت
                                    </div>

                                </div>

                                @error('audio_file')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Publish Settings --}}
                    <div class="admin-card">

                        <div class="admin-card-header">
                            <h4 class="admin-card-title">
                                <i class="fa fa-cog ml-2"></i>
                                تنظیمات انتشار
                            </h4>
                        </div>


                        <div class="admin-card-body">

                            <div class="form-group">

                                <label for="status" class="admin-label">
                                    وضعیت انتشار
                                    <span class="required">*</span>
                                </label>

                                <div class="admin-status-box">

                                    <select
                                        name="status"
                                        id="status"
                                        class="form-control admin-form-control @error('status') is-invalid @enderror"
                                        required
                                    >

                                        <option
                                            value="published"
                                            {{ old('status', $podcast->status) == 'published' ? 'selected' : '' }}
                                        >
                                            منتشر شده
                                        </option>

                                        <option
                                            value="draft"
                                            {{ old('status', $podcast->status) == 'draft' ? 'selected' : '' }}
                                        >
                                            پیش‌نویس
                                        </option>

                                    </select>

                                </div>

                                @error('status')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror

                            </div>


                            <button
                                type="submit"
                                class="btn admin-submit-btn mt-2"
                            >
                                <i class="fa fa-save ml-1"></i>
                                ذخیره تغییرات
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection
