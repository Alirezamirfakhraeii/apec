@php use Morilog\Jalali\Jalalian; @endphp
@extends('back.admin.layouts.master')

@section('content')
    <style>
        .ck-editor__editable_inline {
            min-height: 250px;
        }
    </style>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">اتاق خبر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ارسال مطلب و خبر جدید</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary fw-bold">
                    <i class="fa fa-arrow-right ml-1"></i> بازگشت به لیست
                </a>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row row-sm">

            <div class="col-xl-8 col-lg-8 col-md-12">

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1"><i class="fa fa-pen ml-2"></i>مشخصات و متن خبر</h4>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group">
                            <label for="title" class="font_13 fw-bold">عنوان اصلی خبر / مقاله : <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                   id="title" value="{{ old('title') }}" placeholder="عنوان جذاب و سئو شده بنویسید..."
                                   required>
                            @error('title') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font_13 fw-bold">خلاصه خبر (Summary) :</label>
                            <textarea name="summary" class="form-control" id="summary" rows="3"
                                      placeholder="خلاصه‌ای کوتاه برای بخش کارت‌های بلاگ...">{{ old('summary') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="body" class="font_13 fw-bold">متن کامل خبر : <span class="text-danger">*</span></label>
                            <textarea name="body" id="editor" class="form-control">{{ old('body') }}</textarea>
                            @error('body') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-primary mb-0"><i class="fa fa-folder ml-1"></i> دسته‌بندی و
                            برچسب‌ها</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="blog_category_id" class="font_13 fw-bold">سرویس خبری (دسته‌بندی) : <span
                                            class="text-danger">*</span></label>
                                    <select name="blog_category_id" id="blog_category_id"
                                            class="form-control @error('blog_category_id') is-invalid @enderror"
                                            required>
                                        <option value="">-- انتخاب سرویس خبری --</option>
                                        @foreach($categories->where('parent_id', null) as $mainCat)
                                            <option value="{{ $mainCat->id }}"
                                                    class="fw-bold text-dark" {{ old('blog_category_id') == $mainCat->id ? 'selected' : '' }}>
                                                📁 {{ $mainCat->name }}
                                            </option>
                                            @foreach($mainCat->children as $child)
                                                <option value="{{ $child->id }}"
                                                        class="text-primary" {{ old('blog_category_id') == $child->id ? 'selected' : '' }}>
                                                    &nbsp;&nbsp;&nbsp;&nbsp; └─ 📄 {{ $child->name }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('blog_category_id') <span
                                        class="invalid-feedback font_12">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tags" class="font_13 fw-bold">برچسب‌ها / هشتگ‌ها :</label>
                                    <input type="text" name="tags" class="form-control" id="tags"
                                           value="{{ old('tags') }}" placeholder="مثال: انرژی, نفت_خام, توسعه">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-success mb-0"><i class="fa fa-search ml-1"></i> تنظیمات سئو
                            گوگل</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group">
                            <label for="meta_title" class="font_12 fw-bold">Meta Title (عنوان مرورگر) :</label>
                            <input type="text" name="meta_title" class="form-control" id="meta_title"
                                   value="{{ old('meta_title') }}"
                                   placeholder="اگر خالی بماند، عنوان اصلی قرار می‌گیرد">
                        </div>
                        <div class="form-group mb-0">
                            <label for="meta_description" class="font_12 fw-bold">Meta Description (توضیحات در گوگل)
                                :</label>
                            <textarea name="meta_description" class="form-control" id="meta_description" rows="3"
                                      placeholder="توضیحات جذاب بین ۱۵۰ تا ۱۶۰ کاراکتر برای گوگل...">{{ old('meta_description') }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0"><i class="fa fa-image ml-1"></i> تصویر شاخص</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group mb-0">
                            <label for="image" class="font_13 fw-bold">انتخاب فایل تصویر :</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                   id="image" accept="image/*">
                            @error('image') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0"><i class="fa fa-info-circle ml-1"></i> تنظیمات
                            انتشار</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group mb-0">
                            <label for="status" class="font_13 fw-bold">وضعیت انتشار :</label>
                            <select name="status" id="status" class="form-control">
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>🚀 انتشار
                                    فوری
                                </option>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>📁 ذخیره به عنوان
                                    پیش‌نویس
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="published_at" class="font_13 fw-bold">
                        زمان انتشار مقاله :
                    </label>

                    <input type="text"
                           name="published_at"
                           id="published_at"
                           class="form-control"
                           placeholder="مثال: 1404/03/25 14:30"
                           value="{{ old('published_at') }}">
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg font_14 fw-bold box-shadow-3">
                    <i class="fa fa-check-circle ml-1"></i> انتشار و ذخیره نهایی مطلب
                </button>

            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@ckeditor/ckeditor5-build-classic@41.0.0/build/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                language: 'fa',
                direction: 'rtl'
            })
            .catch(error => {
                console.error(error);
            });
    </script>


    <script>
        document.getElementById('status').addEventListener('change', function () {
            const dateInput = document.getElementById('published_at');

            if (this.value === 'draft') {
                dateInput.disabled = true;
                dateInput.value = '';
            } else {
                dateInput.disabled = false;
            }
        });
    </script>
@endsection
