@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">اتاق خبر</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ دسته‌بندی موضوعی اخبار و مقالات</span>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success font_13" role="alert">
            <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ session()->get('success') }}
        </div>
    @endif

    <div class="row row-sm">

        <div class="col-xl-5 col-lg-5 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header border-bottom">
                    <h4 class="card-title text-primary mb-1"><i class="fa fa-plus-circle ml-2"></i>ایجاد دسته‌بندی جدید</h4>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.blog-categories.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="font_13 fw-bold">نام سرویس / دسته‌بندی : <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" placeholder="مثال: اخبار نفت و توسعه، بیوگرافی اعضا" required>
                            @error('name') <span class="invalid-feedback font_12">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="font_13 fw-bold">توضیحات کوتاه (اختیاری) :</label>
                            <textarea name="description" class="form-control" id="description" rows="4" placeholder="توضیحاتی درباره ماهیت این دسته‌بندی بنویسید...">{{ old('description') }}</textarea>
                        </div>

                        <div class="mt-4 border-top pt-3">
                            <button type="submit" class="btn btn-primary btn-block fw-bold">
                                <i class="fa fa-check ml-1"></i> ذخیره و ایجاد سرویس خبری
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-7 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header border-bottom">
                    <h4 class="card-title text-dark mb-1"><i class="fa fa-list ml-2"></i>لیست سرویس‌های خبری فعال</h4>
                    <p class="text-muted font_12 mb-0">تعداد کل دسته‌بندی‌ها: {{ $categories->count() }} مورد</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 font_13 text-center">
                            <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th class="text-right">نام دسته‌بندی</th>پس ی
                                <th class="text-right">نامک سئو (Slug)</th>
                                <th>تعداد مطالب</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($categories as $key => $cat)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td class="text-right fw-bold text-primary">{{ $cat->name }}</td>
                                    <td class="text-right text-muted font_12" dir="ltr">{{ $cat->slug }}</td>
                                    <td>
                                        <span class="font_12">{{ $cat->posts_count ?? $cat->posts()->count() }} مطلب</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.blog-categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟ مطالب بدون دسته‌بندی خواهند شد.');" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-light" title="حذف">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4 font_13">هنوز هیچ دسته‌بندی موضوعی تعریف نشده است.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
