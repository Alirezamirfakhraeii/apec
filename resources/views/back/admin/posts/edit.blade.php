@extends('back.admin.layouts.master')
@php use Morilog\Jalali\Jalalian; @endphp


@section('content')
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

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row row-sm">

            <div class="col-xl-8 col-lg-8 col-md-12">
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1"><i class="fa fa-edit ml-2"></i>اصلاح مشخصات و متن خبر</h4>
                    </div>
                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="title" class="font_13 fw-bold">عنوان اصلی خبر / مقاله : <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title', $post->title) }}" required>
                            @error('title') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="summary" class="font_13 fw-bold">خلاصه خبر (Summary) :</label>
                            <textarea name="summary" class="form-control" id="summary" rows="3">{{ old('summary', $post->summary) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="body" class="font_13 fw-bold">متن کامل خبر : <span class="text-danger">*</span></label>
                            <textarea name="body" id="editor" class="form-control @error('body') is-invalid @enderror">{{ old('body', $post->body) }}</textarea>
                            @error('body') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-4 col-md-12">

                <div class="card box-shadow-0">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="blog_category_id" class="font_13 fw-bold">سرویس خبری (دسته‌بندی) : <span class="text-danger">*</span></label>
                            <select name="blog_category_id" id="blog_category_id" class="form-control @error('blog_category_id') is-invalid @enderror" required>
                                @foreach($categories->where('parent_id', null) as $mainCat)
                                    <option value="{{ $mainCat->id }}" class="fw-bold text-dark" {{ old('blog_category_id', $post->blog_category_id) == $mainCat->id ? 'selected' : '' }}>
                                        📁 {{ $mainCat->name }}
                                    </option>
                                    @foreach($mainCat->children as $child)
                                        <option value="{{ $child->id }}" class="text-primary" {{ old('blog_category_id', $post->blog_category_id) == $child->id ? 'selected' : '' }}>
                                            &nbsp;&nbsp;&nbsp;&nbsp; └─ 📄 {{ $child->name }}
                                        </option>
                                    @endforeach
                                @endforeach
                            </select>
                            @error('blog_category_id') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags" class="font_13 fw-bold">برچسب‌ها / هشتگ‌ها :</label>
                            <input type="text" name="tags" class="form-control" id="tags" value="{{ old('tags', method_exists($post, 'tags') ? implode(', ', $post->tags->pluck('name')->toArray()) : '') }}">
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-success mb-0"><i class="fa fa-search ml-1"></i> تنظیمات سئو گوگل</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="form-group">
                            <label for="meta_title" class="font_12 fw-bold">Meta Title (عنوان مرورگر) :</label>
                            <input type="text" name="meta_title" class="form-control" id="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
                        </div>
                        <div class="form-group mb-0">
                            <label for="meta_description" class="font_12 fw-bold">Meta Description (توضیحات در گوگل) :</label>
                            <textarea name="meta_description" class="form-control" id="meta_description" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card box-shadow-0">
                    <div class="card-body">
                        <div class="form-group mb-2">
                            <label for="image" class="font_13 fw-bold">تصویر شاخص خبر :</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image" accept="image/*">
                            @error('image') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
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
                    <div class="card-body">
                        <div class="form-group mb-0">
                            <label for="status" class="font_13 fw-bold">وضعیت انتشار :</label>
                            <select name="status" id="status" class="form-control">
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>🚀 منتشر شده</option>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>📁 پیش‌نویس</option>
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
                           value="{{ old('published_at',
                isset($post) && $post->published_at
                    ? Jalalian::fromCarbon($post->published_at)->format('Y/m/d H:i')
                    : ''
           ) }}">
                </div>

                <button type="submit" class="btn btn-success btn-block btn-lg font_14 fw-bold box-shadow-3">
                    <i class="fa fa-save ml-1"></i> به‌روزرسانی نهایی مطلب
                </button>

            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('editor', {
            contentsLangDirection: 'rtl',
            height: 300
        });
    </script>
@endsection
