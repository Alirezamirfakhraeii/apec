@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش اعضا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تعریف و ثبت عضو جدید در سیستم</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-right ml-1"></i> بازگشت به لیست
            </a>
        </div>
    </div>

    <div class="row row-sm">
        <!-- 📝 ستون راست: فرم ثبت مشخصات کاربر جدید -->
        <div class="col-xl-7 col-lg-7 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-primary"><i class="fa fa-user-plus ml-2"></i>فرم مشخصات کاربر جدید
                    </h4>
                    <p class="text-muted font_12 mb-0">اطلاعات هویتی و اولین سطح دسترسی کاربر را در این بخش تعیین
                        کنید.</p>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="font_13 fw-bold">نام و نام خانوادگی :</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   id="name" placeholder="مثال: رضا احمدی" value="{{ old('name') }}" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="font_13 fw-bold">آدرس ایمیل (نام کاربری ورود) :</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
                            @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="avatar" class="font_13 fw-bold">تصویر پروفایل کاربر :</label>

                            <input
                                type="file"
                                name="avatar"
                                class="form-control @error('avatar') is-invalid @enderror"
                                id="avatar"
                                accept="image/*"
                            >

                            <small class="text-muted font_12">
                                فرمت‌های مجاز: jpg، jpeg، png، webp
                            </small>

                            @error('avatar')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="font_13 fw-bold">رمز عبور اولیه :</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" id="password"
                                   placeholder="حداقل ۸ کاراکتر ترکیبی" required>
                            @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="role" class="font_13 fw-bold">انتخاب نقش و سطح دسترسی :</label>
                            <select name="role" class="form-control" id="role">
                                <option value="">-- کاربر عادی (بدون دسترسی به پنل مدیریت) --</option>
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4 border-top pt-3 text-left">
                            <button type="submit" class="btn btn-primary pl-4 pr-4">
                                <i class="fa fa-check ml-1"></i>ثبت و ذخیره کاربر
                            </button>
                            <a href="{{ route('admin.user.index') }}" class="btn btn-secondary mr-2">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 📊 ستون چپ: چک‌لیست امنیتی و راهنمای رول‌ها -->
        <div class="col-xl-5 col-lg-5 col-md-12">
            <!-- باکس چک‌لیست امنیتی ادمین -->
            <div class="card box-shadow-0">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-dark"><i class="fa fa-shield-alt ml-2"></i>دستورالعمل امنیتی ایجاد
                        حساب</h4>
                </div>
                <div class="card-body p-3 font_13 text-muted">
                    <ul class="list-unstyled pr-0 mb-0" style="line-height: 26px;">
                        <li class="mb-2">
                            <i class="fa fa-check-circle text-success ml-2"></i>
                            <strong>ایمیل معتبر:</strong> مطمئن شوید ایمیل وارد شده فعال است؛ این ایمیل مجرای اصلی
                            بازیابی رمز عبور کاربر خواهد بود.
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-check-circle text-success ml-2"></i>
                            <strong>پیچیدگی کلمه عبور:</strong> برای کاربران پنل مدیریتی، حتماً از ترکیب حروف بزرگ،
                            کوچک، اعداد و نمادها استفاده کنید.
                        </li>
                        <li class="mb-0">
                            <i class="fa fa-check-circle text-success ml-2"></i>
                            <strong>مسئولیت حقوقی:</strong> هرگونه اقدام کاربران در پنل با نقش اختصاص یافته، در بخش
                            لاگ‌های سیستم با شناسه آن‌ها ثبت خواهد شد.
                        </li>
                    </ul>
                </div>
            </div>

            <!-- باکس راهنمای سریع نقش‌های موجود در سیستم -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-dark"><i class="fa fa-user-tag ml-2"></i>نقش‌های فعال دیتابیس شما
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="p-3 bg-light font_12 text-muted border-bottom">
                        لیست نقش‌هایی که در حال حاضر ادمین کل تعریف کرده است. انتخاب هرکدام، دسترسی‌های متصل به آن رول
                        را به این کاربر منتقل می‌کند:
                    </div>
                    <table class="table table-striped mb-0 font_13">
                        <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td class="fw-bold pr-3 text-right"><span class="px-2 py-1">{{ $role->name }}</span>
                                </td>
                                <td class="text-left text-muted pl-3 font_12">
                                    دارای {{ $role->permissions->count() }} مجوز دسترسی فعال
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted py-3 font_12">هنوز هیچ نقشی در سیستم تعریف
                                    نشده است.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
