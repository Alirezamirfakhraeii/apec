@extends('back.admin.layouts.master')

@section('content')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">بخش اعضا</h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ مدیریت و ویرایش کاربر «{{ $user->name }}»</span>
            </div>
        </div>
        <div class="d-flex my-xl-auto right-content">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-right ml-1"></i> بازگشت به لیست
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row row-sm">
        <!-- 📄 ستون راست: فرم ویرایش مشخصات کاربری -->
        <div class="col-xl-7 col-lg-7 col-md-12">
            <div class="card box-shadow-0">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-primary"><i class="fa fa-user-edit ml-2"></i>اصلاح مشخصات کاربری
                    </h4>
                    <p class="text-muted font_12 mb-0">اطلاعات هویتی و سطح دسترسی کاربر را از این بخش تغییر دهید.</p>
                </div>
                <div class="card-body pt-3">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="name" class="font_13 fw-bold">نام و نام خانوادگی :</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       id="name" value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="email" class="font_13 fw-bold">آدرس ایمیل (نام کاربری) :</label>
                                <input type="email" name="email"
                                       class="form-control @error('email') is-invalid @enderror" id="email"
                                       value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="avatar" class="font_13 fw-bold">تصویر پروفایل کاربر :</label>

                                @if($user->avatar)
                                    <div class="mb-2">
                                        <img
                                            src="{{ asset('storage/' . $user->avatar) }}"
                                            alt="{{ $user->name }}"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; border: 1px solid #ddd;"
                                        >
                                    </div>
                                @endif

                                <input
                                    type="file"
                                    name="avatar"
                                    class="form-control @error('avatar') is-invalid @enderror"
                                    id="avatar"
                                    accept="image/*"
                                >

                                <small class="text-muted d-block mt-1 font_12">
                                    اگر تصویر جدید انتخاب کنید، تصویر قبلی جایگزین می‌شود.
                                </small>

                                @error('avatar')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="password" class="font_13 fw-bold">رمز عبور جدید :</label>
                                <input type="password" name="password"
                                       class="form-control @error('password') is-invalid @enderror" id="password"
                                       placeholder="اگر مایل به تغییر نیست، خالی بگذارید">
                                <small class="text-warning d-block mt-1"><i class="fa fa-info-circle ml-1"></i> در صورت
                                    ورود رمز جدید، نشست‌های فعال کاربر منقضی خواهد شد.</small>
                                @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="role" class="font_13 fw-bold">نقش و سطح دسترسی سیستم :</label>
                                <select name="role" class="form-control" id="role">
                                    <option value="">-- کاربر عادی (بدون دسترسی به پنل) --</option>
                                    @foreach($roles as $role)
                                        <option
                                            value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 border-top pt-3 text-left">
                            <button type="submit" class="btn btn-success pl-4 pr-4">ذخیره و اعمال تغییرات</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mr-2">انصراف</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- 📊 ستون چپ: اطلاعات رفتاری و مانیتورینگ کاربر -->
        <div class="col-xl-5 col-lg-5 col-md-12">
            <!-- باکس آمار خلاصه سریع -->
            <div class="card bg-primary-transparent text-primary mb-3">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="main-img-user avatar-md ml-3">
                        <div
                            class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                            style="width: 50px; height: 50px; font-size: 20px;">
                            {{ mb_substr($user->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-1 font-weight-semibold text-dark">{{ $user->name }}</h5>
                        <p class="mb-0 font_12 text-muted">عضویت
                            از: {{ $user->created_at ? $user->created_at->format('Y-m-d') : 'نامشخص' }}</p>
                    </div>
                </div>
            </div>

            <!-- باکس جزئیات سیستمی و امنیتی -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-dark"><i class="fa fa-chart-line ml-2"></i>خلاصه وضعیت و رفتار کاربر
                    </h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped mb-0 font_13">
                        <tbody>
                        <tr>
                            <td class="fw-bold text-muted text-right pr-3">شناسه کاربری (ID)</td>
                            <td class="text-left pl-3"><span
                                    class="badge badge-light border text-dark">#{{ $user->id }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted text-right pr-3">وضعیت تایید ایمیل</td>
                            <td class="text-left pl-3">
                                @if($user->email_verified_at)
                                    <span class="text-success fw-bold"><i class="fa fa-check-circle ml-1"></i> تایید شده</span>
                                @else
                                    <span class="text-danger fw-bold"><i class="fa fa-times-circle ml-1"></i> تایید نشده</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted text-right pr-3">آخرین بروزرسانی پروفایل</td>
                            <td class="text-left pl-3 text-muted">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'بدون تغییر' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- باکس تاریخچه فعالیت (Timeline) راهنمای ادمین -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title mb-1 text-dark"><i class="fa fa-history ml-2"></i>توضیحات و راهنمای مدیریتی
                    </h4>
                </div>
                <div class="card-body font_13 text-justify text-muted" style="line-height: 24px;">
                    <p><i class="fa fa-shield-alt text-warning ml-1"></i> <strong>تغییر سطوح دسترسی:</strong> با تخصیص
                        نقش‌های سیستمی، این کاربر می‌تواند به منوها، گزارشات و ابزارهای حساس در بک‌اند دسترسی پیدا کند.
                    </p>
                    <p class="mb-0"><i class="fa fa-exclamation-triangle text-danger ml-1"></i> <strong>امنیت
                            حساب:</strong> به عنوان ادمین کل، در صورتی که گزارش مشکوکی از رفتار کاربر دریافت کردید،
                        توصیه می‌شود ابتدا رمز عبور او را تغییر داده یا دسترسی نقشی او را روی حالت «کاربر عادی» بگذارید.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
