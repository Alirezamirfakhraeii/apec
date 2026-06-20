@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">اتاق پادکست</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ثبت فایل صوتی و پادکست جدید</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.podcasts.index') }}" class="btn btn-secondary fw-bold">
                    <i class="fa fa-arrow-right ml-1"></i> بازگشت به لیست
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.podcasts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row row-sm">

            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1"><i class="fa fa-microphone ml-2"></i>مشخصات و جزئیات پادکست</h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group">
                            <label for="title" class="font_13 fw-bold">عنوان پادکست : <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}" required>
                        </div>

                        <!-- اضافه کردن فیلد دسته‌بندی -->
                        <div class="form-group">
                            <label for="podcast_category_id" class="font_13 fw-bold">سرویس پادکست (دسته‌بندی) : <span class="text-danger">*</span></label>
                            <select name="podcast_category_id" id="podcast_category_id" class="form-control" required>
                                <option value="">-- انتخاب دسته‌بندی --</option>
                                @foreach($categories->where('parent_id', null) as $mainCat)
                                    <option value="{{ $mainCat->id }}" class="fw-bold text-dark" {{ old('podcast_category_id') == $mainCat->id ? 'selected' : '' }}>
                                        📁 {{ $mainCat->title }}
                                    </option>
                                    @foreach($mainCat->children as $child)
                                        <option value="{{ $child->id }}" class="text-primary" {{ old('podcast_category_id') == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;&nbsp; - {{ $child->title }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="host_name" class="font_13 fw-bold">میزبان (Host) :</label>
                            <input type="text" name="host_name" class="form-control" id="host_name" value="{{ old('host_name') }}" placeholder="نام گوینده یا میزبان...">
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font_13 fw-bold">توضیحات کوتاه :</label>
                            <textarea name="summary" class="form-control" id="summary" rows="3">{{ old('summary') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0"><i class="fa fa-file-audio ml-1"></i> فایل‌های رسانه‌ای</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group">
                            <label for="image" class="font_13 fw-bold">تصویر کاور :</label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                        </div>
                        <div class="form-group mb-0">
                            <label for="audio_file" class="font_13 fw-bold">فایل صوتی (MP3) : <span class="text-danger">*</span></label>
                            <input type="file" name="audio_file" class="form-control" id="audio_file" accept="audio/mpeg" required>
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0"><i class="fa fa-info-circle ml-1"></i> تنظیمات انتشار</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group mb-0">
                            <label for="status" class="font_13 fw-bold">وضعیت :</label>
                            <select name="status" id="status" class="form-control">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>🚀 انتشار فوری</option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📁 پیش‌نویس</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-block btn-lg font_14 fw-bold box-shadow-3">
                    <i class="fa fa-check-circle ml-1"></i> ذخیره پادکست
                </button>
            </div>
        </div>
    </form>
@endsection
