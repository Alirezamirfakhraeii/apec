@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش محتوا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ایجاد صفحه جدید</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                بازگشت به لیست صفحات
            </a>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header">
                    <h4 class="card-title mb-1">ایجاد صفحه جدید</h4>
                    <small class="text-muted">برای ساخت صفحات ثابت مثل درباره ما، تماس با ما، قوانین و...</small>
                </div>

                <div class="card-body pt-0" dir="rtl" style="text-align: right;">
                    @if($errors->any())
                        <div class="alert alert-danger mt-2">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.pages.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="title" class="font_12 fw-bold">عنوان صفحه :</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="مثلا: درباره ما"
                                   required>

                            @error('title')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="slug" class="font_12 fw-bold">اسلاگ صفحه :</label>
                            <input type="text"
                                   name="slug"
                                   id="slug"
                                   class="form-control text-start @error('slug') is-invalid @enderror"
                                   dir="ltr"
                                   value="{{ old('slug') }}"
                                   placeholder="مثلا: about-us">

                            <small class="text-muted d-block mt-1">
                                اگر خالی بماند، از روی عنوان ساخته می‌شود.
                            </small>

                            @error('slug')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="summary" class="font_12 fw-bold">خلاصه صفحه :</label>
                            <textarea name="summary"
                                      id="summary"
                                      class="form-control @error('summary') is-invalid @enderror"
                                      rows="3"
                                      placeholder="خلاصه کوتاه از محتوای صفحه">{{ old('summary') }}</textarea>

                            @error('summary')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        @include('back.admin.extra.ckeditor')
                        <div class="form-group mb-3">
                            <label for="body" class="font_12 fw-bold">محتوای صفحه :</label>
                            <textarea name="body"
                                      id="body"
                                      class="form-control js-ckeditor @error('body') is-invalid @enderror"
                                      rows="16"
                                      placeholder="متن کامل صفحه را وارد کنید">{{ old('body', $page->body ?? '') }}</textarea>

                            @error('body')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3">تنظیمات سئو</h6>

                        <div class="form-group mb-3">
                            <label for="meta_title" class="font_12 fw-bold">عنوان سئو :</label>
                            <input type="text"
                                   name="meta_title"
                                   id="meta_title"
                                   class="form-control @error('meta_title') is-invalid @enderror"
                                   value="{{ old('meta_title') }}"
                                   placeholder="عنوان مناسب برای گوگل">

                            @error('meta_title')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="meta_description" class="font_12 fw-bold">توضیحات سئو :</label>
                            <textarea name="meta_description"
                                      id="meta_description"
                                      class="form-control @error('meta_description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="توضیح کوتاه برای نمایش در موتورهای جستجو">{{ old('meta_description') }}</textarea>

                            @error('meta_description')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status" class="font_12 fw-bold">وضعیت صفحه :</label>
                            <select name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                    فعال
                                </option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>
                                    غیرفعال
                                </option>
                            </select>

                            @error('status')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mt-4">
                            ثبت صفحه
                        </button>

                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary mt-4">
                            انصراف
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
