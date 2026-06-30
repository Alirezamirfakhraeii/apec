@extends('back.admin.layouts.master')

@php
    use Morilog\Jalali\Jalalian;

    $contentTypes = $types ?? [
        'news' => 'خبر / مقاله',
        'page' => 'صفحه ثابت',
    ];

    $selectedType = old('type', $post->type ?? 'news');

    $tagsValue = old('tags');

    if ($tagsValue === null) {
        if (method_exists($post, 'tags')) {
            $tagsValue = $post->tags->pluck('name')->implode(', ');
        } else {
            $tagsValue = $post->tags_text ?? '';
        }
    }
@endphp

@section('content')
    <style>
        .ck-editor__editable {
            min-height: 350px;
            direction: rtl;
            text-align: right;
            line-height: 2;
        }

        .ck-content {
            font-size: 14px;
        }

        .ck-content p {
            margin-bottom: 12px;
        }

        .ck-content img {
            max-width: 100%;
            height: auto;
        }
    </style>

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">اتاق خبر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ویرایش مطلب : {{ $post->title }}</span>
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

    <form action="{{ route('admin.posts.update', $post->id) }}"
          method="POST"
          enctype="multipart/form-data"
          id="post-form">

        @csrf
        @method('PUT')

        <div class="row row-sm">

            <div class="col-xl-8 col-lg-8 col-md-12">

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-edit ml-2"></i>
                            اصلاح مشخصات و متن مطلب
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="title" class="font_13 fw-bold">
                                عنوان اصلی :
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="title"
                                   id="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title', $post->title) }}"
                                   required>

                            @error('title')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font_13 fw-bold">
                                خلاصه :
                            </label>

                            <textarea name="summary"
                                      id="summary"
                                      rows="3"
                                      class="form-control @error('summary') is-invalid @enderror">{{ old('summary', $post->summary) }}</textarea>

                            @error('summary')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="editor" class="font_13 fw-bold">
                                متن کامل :
                                <span class="text-danger">*</span>
                            </label>

                            <textarea name="body"
                                      id="editor"
                                      class="form-control js-ckeditor @error('body') is-invalid @enderror">{{ old('body', $post->body) }}</textarea>

                            @error('body')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-success mb-0">
                            <i class="fa fa-search ml-1"></i>
                            تنظیمات سئو گوگل
                        </h5>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="meta_title" class="font_12 fw-bold">
                                Meta Title :
                            </label>

                            <input type="text"
                                   name="meta_title"
                                   id="meta_title"
                                   class="form-control @error('meta_title') is-invalid @enderror"
                                   value="{{ old('meta_title', $post->meta_title) }}">

                            @error('meta_title')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="meta_description" class="font_12 fw-bold">
                                Meta Description :
                            </label>

                            <textarea name="meta_description"
                                      id="meta_description"
                                      rows="3"
                                      class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $post->meta_description) }}</textarea>

                            @error('meta_description')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-cog ml-1"></i>
                            نوع و دسته‌بندی
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="type" class="font_13 fw-bold">
                                نوع محتوا :
                                <span class="text-danger">*</span>
                            </label>

                            <select name="type"
                                    id="type"
                                    class="form-control @error('type') is-invalid @enderror"
                                    required>
                                @foreach($contentTypes as $value => $label)
                                    <option value="{{ $value }}" {{ $selectedType === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            @error('type')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group" id="blog-category-wrapper">
                            <label for="blog_category_id" class="font_13 fw-bold">
                                سرویس خبری / دسته‌بندی :
                                <span class="text-danger category-required-star">*</span>
                            </label>

                            <select name="blog_category_id"
                                    id="blog_category_id"
                                    class="form-control @error('blog_category_id') is-invalid @enderror">

                                <option value="">-- انتخاب سرویس خبری --</option>

                                @foreach($categories->where('parent_id', null) as $mainCat)
                                    <option value="{{ $mainCat->id }}"
                                            class="fw-bold text-dark"
                                        {{ old('blog_category_id', $post->blog_category_id) == $mainCat->id ? 'selected' : '' }}>
                                        📁 {{ $mainCat->name }}
                                    </option>

                                    @foreach($mainCat->children as $child)
                                        <option value="{{ $child->id }}"
                                                class="text-primary"
                                            {{ old('blog_category_id', $post->blog_category_id) == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;&nbsp; └─ 📄 {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>

                            @error('blog_category_id')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <small class="text-muted font_12 d-block mb-3"
                               id="page-category-help"
                               style="display: none;">
                            برای صفحه ثابت، دسته‌بندی خبری لازم نیست و مقدار آن خالی ذخیره می‌شود.
                        </small>

                        <div class="form-group mb-0">
                            <label for="tags" class="font_13 fw-bold">
                                برچسب‌ها / هشتگ‌ها :
                            </label>

                            <input type="text"
                                   name="tags"
                                   id="tags"
                                   class="form-control @error('tags') is-invalid @enderror"
                                   value="{{ $tagsValue }}">

                            @error('tags')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-image ml-1"></i>
                            تصویر شاخص
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="form-group mb-2">
                            <label for="image" class="font_13 fw-bold">
                                انتخاب تصویر جدید :
                            </label>

                            <input type="file"
                                   name="image"
                                   id="image"
                                   accept="image/*"
                                   class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        @if($post->mainImage && $post->mainImage->path)
                            <div class="text-center border p-2 rounded bg-light">
                                <small class="text-muted d-block mb-1">تصویر فعلی :</small>

                                <img src="{{ $post->main_image_url }}"
                                     alt="{{ $post->title }}"
                                     class="img-fluid rounded"
                                     style="max-height: 120px; object-fit: cover;">
                            </div>
                        @endif

                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-info-circle ml-1"></i>
                            تنظیمات انتشار
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="status" class="font_13 fw-bold">
                                وضعیت انتشار :
                                <span class="text-danger">*</span>
                            </label>

                            <select name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror"
                                    required>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>
                                    🚀 منتشر شده
                                </option>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>
                                    📁 پیش‌نویس
                                </option>
                            </select>

                            @error('status')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="published_at" class="font_13 fw-bold">
                                زمان انتشار :
                            </label>

                            <input type="text"
                                   name="published_at"
                                   id="published_at"
                                   class="form-control @error('published_at') is-invalid @enderror"
                                   placeholder="مثال: 1404/03/25 14:30"
                                   value="{{ old('published_at',
                                        $post->published_at
                                            ? Jalalian::fromCarbon($post->published_at)->format('Y/m/d H:i')
                                            : ''
                                   ) }}">

                            @error('published_at')
                            <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-block btn-lg font_14 fw-bold box-shadow-3">
                    <i class="fa fa-save ml-1"></i>
                    به‌روزرسانی نهایی مطلب
                </button>

            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    <script>
        class LaravelUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }

            upload() {
                return this.loader.file.then(file => {
                    const data = new FormData();

                    data.append('upload', file);

                    return fetch("{{ route('admin.ckeditor.upload') }}", {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                : "{{ csrf_token() }}"
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('خطا در آپلود تصویر');
                            }

                            return response.json();
                        })
                        .then(result => {
                            if (result.error) {
                                throw new Error(result.error.message || 'آپلود تصویر ناموفق بود');
                            }

                            if (!result.url) {
                                throw new Error(result.message || 'آدرس تصویر از سرور دریافت نشد');
                            }

                            return {
                                default: result.url
                            };
                        });
                });
            }

            abort() {
                //
            }
        }

        function LaravelUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = function (loader) {
                return new LaravelUploadAdapter(loader);
            };
        }

        document.addEventListener('DOMContentLoaded', function () {
            const editors = [];

            document.querySelectorAll('.js-ckeditor').forEach(function (element) {
                if (element.dataset.ckeditorInitialized === 'true') {
                    return;
                }

                element.dataset.ckeditorInitialized = 'true';

                ClassicEditor
                    .create(element, {
                        language: 'fa',
                        extraPlugins: [
                            LaravelUploadAdapterPlugin
                        ],
                        toolbar: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'link',
                            'bulletedList',
                            'numberedList',
                            'blockQuote',
                            '|',
                            'imageUpload',
                            'insertTable',
                            '|',
                            'undo',
                            'redo'
                        ],
                        image: {
                            toolbar: [
                                'imageTextAlternative',
                                'imageStyle:inline',
                                'imageStyle:block',
                                'imageStyle:side'
                            ]
                        },
                        heading: {
                            options: [
                                {
                                    model: 'paragraph',
                                    title: 'متن معمولی',
                                    class: 'ck-heading_paragraph'
                                },
                                {
                                    model: 'heading2',
                                    view: 'h2',
                                    title: 'تیتر اصلی بخش',
                                    class: 'ck-heading_heading2'
                                },
                                {
                                    model: 'heading3',
                                    view: 'h3',
                                    title: 'زیر تیتر',
                                    class: 'ck-heading_heading3'
                                }
                            ]
                        }
                    })
                    .then(function (editor) {
                        editors.push(editor);

                        editor.editing.view.change(function (writer) {
                            writer.setAttribute(
                                'dir',
                                'rtl',
                                editor.editing.view.document.getRoot()
                            );

                            writer.setStyle(
                                'text-align',
                                'right',
                                editor.editing.view.document.getRoot()
                            );
                        });
                    })
                    .catch(function (error) {
                        console.error('خطای CKEditor:', error);
                    });
            });

            const postForm = document.getElementById('post-form');

            if (postForm) {
                postForm.addEventListener('submit', function () {
                    editors.forEach(function (editor) {
                        editor.updateSourceElement();
                    });
                });
            }

            const typeSelect = document.getElementById('type');
            const categoryWrapper = document.getElementById('blog-category-wrapper');
            const categorySelect = document.getElementById('blog_category_id');
            const requiredStar = document.querySelector('.category-required-star');
            const pageCategoryHelp = document.getElementById('page-category-help');

            function toggleCategoryField() {
                if (!typeSelect || !categoryWrapper || !categorySelect) {
                    return;
                }

                if (typeSelect.value === 'page') {
                    categoryWrapper.style.display = 'none';
                    categorySelect.value = '';
                    categorySelect.removeAttribute('required');
                    categorySelect.setAttribute('disabled', 'disabled');

                    if (requiredStar) {
                        requiredStar.style.display = 'none';
                    }

                    if (pageCategoryHelp) {
                        pageCategoryHelp.style.display = 'block';
                    }
                } else {
                    categoryWrapper.style.display = 'block';
                    categorySelect.removeAttribute('disabled');
                    categorySelect.setAttribute('required', 'required');

                    if (requiredStar) {
                        requiredStar.style.display = 'inline';
                    }

                    if (pageCategoryHelp) {
                        pageCategoryHelp.style.display = 'none';
                    }
                }
            }

            toggleCategoryField();

            if (typeSelect) {
                typeSelect.addEventListener('change', toggleCategoryField);
            }

            const statusSelect = document.getElementById('status');
            const publishedAtInput = document.getElementById('published_at');

            function togglePublishedAt() {
                if (!statusSelect || !publishedAtInput) {
                    return;
                }

                if (statusSelect.value === 'draft') {
                    publishedAtInput.value = '';
                    publishedAtInput.setAttribute('readonly', 'readonly');
                } else {
                    publishedAtInput.removeAttribute('readonly');
                }
            }

            togglePublishedAt();

            if (statusSelect) {
                statusSelect.addEventListener('change', togglePublishedAt);
            }
        });
    </script>
@endsection
