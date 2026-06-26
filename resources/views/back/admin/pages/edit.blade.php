@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش محتوا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ویرایش صفحه</span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                بازگشت به لیست صفحات
            </a>

            <a href="{{ route('front.pages.show', $page->slug) }}"
               target="_blank"
               class="btn btn-success mr-2">
                مشاهده صفحه
            </a>
        </div>
    </div>

    <div class="row row-sm">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title mb-1">ویرایش صفحه</h4>
                        <small class="text-muted">
                            ویرایش اطلاعات، محتوا و تنظیمات سئوی صفحه
                        </small>
                    </div>

                    <span class="badge {{ $page->status ? 'badge-success' : 'badge-danger' }}">
                        {{ $page->status ? 'فعال' : 'غیرفعال' }}
                    </span>
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

                    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-lg-8 col-md-12">

                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">اطلاعات اصلی صفحه</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group mb-3">
                                            <label for="title" class="font_12 fw-bold">عنوان صفحه :</label>
                                            <input type="text"
                                                   name="title"
                                                   id="title"
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   value="{{ old('title', $page->title) }}"
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
                                                   value="{{ old('slug', $page->slug) }}"
                                                   placeholder="مثلا: about-us">

                                            <small class="text-muted d-block mt-1">
                                                آدرس صفحه در سایت بر اساس این مقدار ساخته می‌شود.
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
                                                      placeholder="خلاصه کوتاه از محتوای صفحه">{{ old('summary', $page->summary) }}</textarea>

                                            @error('summary')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="body" class="font_12 fw-bold">محتوای صفحه :</label>
                                            <textarea name="body"
                                                      id="body"
                                                      class="form-control js-ckeditor @error('body') is-invalid @enderror"
                                                      rows="16"
                                                      placeholder="متن کامل صفحه را وارد کنید">{{ old('body', $page->body) }}</textarea>

                                            <small class="text-muted d-block mt-1">
                                                می‌توانید محتوای HTML هم وارد کنید.
                                            </small>

                                            @error('body')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                                <div class="card border mt-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">تنظیمات سئو</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group mb-3">
                                            <label for="meta_title" class="font_12 fw-bold">عنوان سئو :</label>
                                            <input type="text"
                                                   name="meta_title"
                                                   id="meta_title"
                                                   class="form-control @error('meta_title') is-invalid @enderror"
                                                   value="{{ old('meta_title', $page->meta_title) }}"
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
                                                      rows="4"
                                                      placeholder="توضیح کوتاه برای موتورهای جستجو">{{ old('meta_description', $page->meta_description) }}</textarea>

                                            @error('meta_description')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4 col-md-12">

                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">تنظیمات انتشار</h5>
                                    </div>

                                    <div class="card-body">

                                        <div class="form-group mb-3">
                                            <label for="status" class="font_12 fw-bold">وضعیت صفحه :</label>
                                            <select name="status"
                                                    id="status"
                                                    class="form-control @error('status') is-invalid @enderror">
                                                <option value="1" {{ old('status', $page->status) == 1 ? 'selected' : '' }}>
                                                    فعال
                                                </option>
                                                <option value="0" {{ old('status', $page->status) == 0 ? 'selected' : '' }}>
                                                    غیرفعال
                                                </option>
                                            </select>

                                            @error('status')
                                            <small class="text-danger d-block mt-1">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        @if(\Illuminate\Support\Facades\Schema::hasColumn('pages', 'template'))
                                            <div class="form-group mb-3">
                                                <label for="template" class="font_12 fw-bold">قالب نمایش صفحه :</label>
                                                <select name="template"
                                                        id="template"
                                                        class="form-control @error('template') is-invalid @enderror">
                                                    <option value="default" {{ old('template', $page->template ?? 'default') == 'default' ? 'selected' : '' }}>
                                                        قالب معمولی
                                                    </option>
                                                    <option value="about" {{ old('template', $page->template ?? '') == 'about' ? 'selected' : '' }}>
                                                        قالب درباره ما
                                                    </option>
                                                    <option value="contact" {{ old('template', $page->template ?? '') == 'contact' ? 'selected' : '' }}>
                                                        قالب تماس با ما
                                                    </option>
                                                </select>

                                                @error('template')
                                                <small class="text-danger d-block mt-1">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        @endif

                                        <hr>

                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">آدرس صفحه:</small>

                                            <a href="{{ route('front.pages.show', $page->slug) }}"
                                               target="_blank"
                                               dir="ltr"
                                               class="d-block text-primary">
                                                {{ route('front.pages.show', $page->slug) }}
                                            </a>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">تاریخ ایجاد:</small>
                                            <strong>
                                                {{ $page->created_at ? $page->created_at->format('Y/m/d H:i') : '-' }}
                                            </strong>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block mb-1">آخرین بروزرسانی:</small>
                                            <strong>
                                                {{ $page->updated_at ? $page->updated_at->format('Y/m/d H:i') : '-' }}
                                            </strong>
                                        </div>

                                        <button type="submit" class="btn btn-primary d-block w-100 mt-4">
                                            ذخیره تغییرات
                                        </button>

                                        <a href="{{ route('admin.pages.index') }}"
                                           class="btn btn-secondary d-block w-100 mt-2">
                                            انصراف
                                        </a>

                                    </div>
                                </div>

                                <div class="card border mt-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">راهنما</h5>
                                    </div>

                                    <div class="card-body">
                                        <p class="text-muted mb-2" style="line-height: 2;">
                                            اگر اسلاگ را تغییر دهید، آدرس صفحه در سایت هم تغییر می‌کند.
                                        </p>

                                        <p class="text-muted mb-0" style="line-height: 2;">
                                            برای نمایش این صفحه در منوی سایت، از بخش مدیریت فهرست‌ها یک آیتم از نوع
                                            «اتصال به صفحه ثابت» بسازید.
                                        </p>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('back.admin.extra.ckeditor')
