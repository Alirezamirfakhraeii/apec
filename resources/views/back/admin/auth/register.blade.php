<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ثبت نام در سیستم</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/x-icon"/>

    <!-- Icons css -->
    <link href="{{ asset('assets/plugins/icons/icons.css') }}" rel="stylesheet">

    <!-- Bootstrap css -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet">

    <!-- Styles css -->
    <link href="{{ asset('assets/css-rtl/sidemenu.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css-rtl/skin-modes.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
</head>

<body class="main-body">

<!-- Loader -->
<div id="global-loader">
    <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
</div>

<!-- Page -->
<div class="page">
    <div class="container-fluid">
        <div class="row no-gutter">

            <!-- نیمه تصویر سمت چپ (در دسکتاپ نمایش داده می‌شود) -->
            <div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
                <div class="row wd-100p m-auto text-center">
                    <div class="col-md-12 col-lg-12 col-xl-12 my-auto m-auto wd-100p">
                        <img src="{{ asset('assets/img/media/login.png') }}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p m-auto" alt="logo">
                    </div>
                </div>
            </div>

            <!-- نیمه فرم ثبت نام سمت راست -->
            <div class="col-md-6 col-lg-6 col-xl-5 bg-white">
                <div class="login d-flex align-items-center py-2">
                    <div class="container p-0">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-xl-9 m-auto">
                                <div class="card-sigin">

                                    <!-- هدر لوگو -->
                                    <div class="mb-5 d-flex">
                                        <a href="{{ url('/') }}">
                                            <img src="{{ asset('assets/img/brand/favicon.png') }}" class="sign-favicon-a ht-40" alt="logo">
                                        </a>
                                        <h1 class="main-logo1 ms-1 me-0 my-auto tx-28">Va<span>le</span>x</h1>
                                    </div>

                                    <div class="main-signup-header">
                                        <h2 class="text-primary">شروع کردن</h2>
                                        <h5 class="fw-normal mb-4">ایجاد حساب کاربری رایگان است و فقط یک دقیقه زمان می‌برد.</h5>

                                        <!-- اتصال فرم به روت لاراول و متد POST -->
                                        <form action="{{ route('register') }}" method="POST">
                                            @csrf

                                            <!-- فیلد نام و نام خانوادگی -->
                                            <div class="form-group mb-3">
                                                <label class="form-label">نام و نام خانوادگی</label>
                                                <input name="name" class="form-control @error('name') is-invalid @enderror"
                                                       placeholder="نام و نام خانوادگی خود را وارد کنید"
                                                       type="text" value="{{ old('name') }}">
                                                @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- فیلد ایمیل -->
                                            <div class="form-group mb-3">
                                                <label class="form-label">پست الکترونیک</label>
                                                <input name="email" class="form-control @error('email') is-invalid @enderror"
                                                       placeholder="ایمیل خود را وارد کنید"
                                                       type="email" value="{{ old('email') }}">
                                                @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- فیلد کلمه عبور -->
                                            <div class="form-group mb-4">
                                                <label class="form-label">کلمه عبور</label>
                                                <input name="password" class="form-control @error('password') is-invalid @enderror"
                                                       placeholder="رمز عبور خود را وارد کنید"
                                                       type="password">
                                                @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- فیلد تکرار کلمه عبور (برای تطابق قانون confirmed لاراول) -->
                                            <div class="form-group mb-4">
                                                <label class="form-label">تکرار کلمه عبور</label>
                                                <input name="password_confirmation" class="form-control"
                                                       placeholder="رمز عبور را دوباره وارد کنید"
                                                       type="password">
                                            </div>

                                            <button type="submit" class="btn btn-main-primary btn-block">ایجاد حساب کاربری</button>
                                        </form>

                                        <div class="main-signup-footer mt-5">
                                            <p>در حال حاضر یک حساب کاربری دارید؟ <a href="{{ route('login') }}">ورود</a></p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min-rtl.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

</body>
</html>
