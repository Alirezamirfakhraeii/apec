@extends('front.auth.layouts.master')

@section('title', 'ثبت‌نام')

@section('form_content')

    <div class="login-wrapper">

        <div class="login-card">

            {{-- Brand --}}
            <div class="login-brand">

                <div class="login-brand-icon">
                    <i class="fa fa-user-plus"></i>
                </div>

                <h2>ایجاد حساب کاربری</h2>

                <p>
                    برای عضویت در سامانه، اطلاعات خود را وارد کنید.
                </p>

            </div>


            {{-- General Validation Errors --}}
            @if ($errors->any())
                <div class="login-alert">

                    <i class="fa fa-exclamation-circle"></i>

                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>

                </div>
            @endif


            <form action="{{ route('register') }}" method="POST" novalidate>

                @csrf



                {{-- Full Name --}}
                <div class="login-form-group">

                    <label for="name">
                        نام و نام خانوادگی
                    </label>

                    <div class="login-input-wrapper">

                        <i class="fa fa-user input-icon"></i>

                        <input
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name') }}"
                            class="login-input @error('name') is-invalid @enderror"
                            placeholder="نام و نام خانوادگی خود را وارد کنید"
                            autocomplete="name"
                            autofocus
                        >

                    </div>

                    @error('name')
                    <div class="login-error">
                        <i class="fa fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="login-form-group">

                    <label for="email">
                        ایمیل
                    </label>

                    <div class="login-input-wrapper">

                        <i class="fa fa-envelope input-icon"></i>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="login-input @error('email') is-invalid @enderror"
                            placeholder="example@email.com"
                            autocomplete="email"
                            autofocus
                        >

                    </div>

                    @error('email')
                    <div class="login-error">

                        <i class="fa fa-exclamation-circle"></i>

                        {{ $message }}

                    </div>
                    @enderror

                </div>


                {{-- Mobile --}}
                <div class="login-form-group">

                    <label for="mobile">
                        شماره همراه
                    </label>

                    <div class="login-input-wrapper">

                        <i class="fa fa-mobile input-icon"></i>

                        <input
                            type="tel"
                            name="mobile"
                            id="mobile"
                            value="{{ old('mobile') }}"
                            class="login-input @error('mobile') is-invalid @enderror"
                            placeholder="09123456789"
                            autocomplete="tel"
                            inputmode="numeric"
                            dir="ltr"
                        >

                    </div>

                    @error('mobile')
                    <div class="login-error">

                        <i class="fa fa-exclamation-circle"></i>

                        {{ $message }}

                    </div>
                    @enderror

                </div>


                {{-- Password --}}
                <div class="login-form-group">

                    <label for="password">
                        رمز عبور
                    </label>

                    <div class="login-input-wrapper">

                        <i class="fa fa-lock input-icon"></i>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="login-input @error('password') is-invalid @enderror"
                            placeholder="رمز عبور خود را وارد کنید"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', 'passwordIcon')"
                            tabindex="-1"
                        >

                            <i
                                class="fa fa-eye"
                                id="passwordIcon"
                            ></i>

                        </button>

                    </div>

                    @error('password')
                    <div class="login-error">

                        <i class="fa fa-exclamation-circle"></i>

                        {{ $message }}

                    </div>
                    @enderror

                </div>


                {{-- Password Confirmation --}}
                <div class="login-form-group">

                    <label for="password_confirmation">
                        تکرار رمز عبور
                    </label>

                    <div class="login-input-wrapper">

                        <i class="fa fa-lock input-icon"></i>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="login-input"
                            placeholder="رمز عبور را مجدداً وارد کنید"
                            autocomplete="new-password"
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password_confirmation', 'passwordConfirmationIcon')"
                            tabindex="-1"
                        >

                            <i
                                class="fa fa-eye"
                                id="passwordConfirmationIcon"
                            ></i>

                        </button>

                    </div>

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="login-submit"
                >

                    ثبت‌نام

                    <i class="fa fa-arrow-left"></i>

                </button>


                {{-- Login Link --}}
                <div class="register-link">

                    قبلاً ثبت‌نام کرده‌اید؟

                    <a href="{{ route('login') }}">
                        وارد شوید
                    </a>

                </div>


                <div class="register-link">
                    بازگشت به
                    <a href="{{ route('home') }}">
                        صفحه اصلی سایت
                    </a>
                </div>



            </form>

        </div>

    </div>


    <style>

        .login-wrapper {
            width: 100%;
            min-height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 20px;

            direction: rtl;

            box-sizing: border-box;
        }


        .login-card {

            width: 100%;
            max-width: 430px;

            background: #ffffff;

            border: 1px solid #e9edf3;

            border-radius: 20px;

            padding: 38px 35px;

            box-shadow:
                0 4px 8px rgba(15, 23, 42, 0.02),
                0 15px 45px rgba(15, 23, 42, 0.06);
        }


        /* Brand */

        .login-brand {

            text-align: center;

            margin-bottom: 32px;
        }


        .login-brand-icon {

            width: 58px;
            height: 58px;

            margin: 0 auto 18px;

            border-radius: 16px;

            background: linear-gradient(
                135deg,
                #0f2d52,
                #2B286D
            );

            display: flex;
            justify-content: center;
            align-items: center;

            color: #ffffff;

            font-size: 22px;

            box-shadow:
                0 8px 20px rgba(15, 45, 82, 0.18);
        }


        .login-brand h2 {

            margin: 0;

            color: #172033;

            font-size: 22px;
            font-weight: 700;

            line-height: 1.7;
        }


        .login-brand p {

            margin: 7px 0 0;

            color: #8992a3;

            font-size: 13px;

            line-height: 1.8;
        }


        /* Form */

        .login-form-group {

            margin-bottom: 22px;
        }


        .login-form-group label {

            display: block;

            color: #303846;

            font-size: 13px;
            font-weight: 600;

            margin-bottom: 9px;
        }


        .login-input-wrapper {

            position: relative;
        }


        .login-input {

            width: 100%;
            height: 52px;

            border: 1px solid #dfe4ea;

            border-radius: 12px;

            padding: 0 44px;

            background: #ffffff;

            color: #2B286D;

            font-size: 13px;

            outline: none;

            box-sizing: border-box;

            transition: all .2s ease;
        }


        .login-input::placeholder {

            color: #adb5c2;
        }


        .login-input:hover {

            border-color: #c8d0da;
        }


        .login-input:focus {

            border-color: #2B286D;

            box-shadow:
                0 0 0 3px rgba(23, 77, 130, 0.08);
        }


        .login-input.is-invalid {

            border-color: #e74c3c;
        }


        .login-input.is-invalid:focus {

            box-shadow:
                0 0 0 3px rgba(231, 76, 60, 0.07);
        }


        .input-icon {

            position: absolute;

            right: 16px;

            top: 50%;

            transform: translateY(-50%);

            color: #9ba5b4;

            font-size: 15px;

            pointer-events: none;
        }


        /* Password Toggle */

        .password-toggle {

            border: 0;

            outline: 0;

            background: transparent;

            position: absolute;

            left: 14px;

            top: 50%;

            transform: translateY(-50%);

            color: #98a2b1;

            cursor: pointer;

            padding: 5px;

            font-size: 15px;
        }


        .password-toggle:hover {

            color: #2B286D;
        }


        /* Validation */

        .login-error {

            display: flex;

            align-items: center;

            gap: 5px;

            margin-top: 7px;

            color: #e5484d;

            font-size: 11px;
        }


        .login-alert {

            display: flex;

            align-items: flex-start;

            gap: 10px;

            background: #fff5f5;

            border: 1px solid #ffe0e0;

            color: #d93843;

            border-radius: 11px;

            padding: 11px 13px;

            font-size: 12px;

            line-height: 1.8;

            margin-bottom: 22px;
        }


        .login-alert > i {

            margin-top: 4px;
        }


        /* Submit */

        .login-submit {

            width: 100%;

            height: 52px;

            border: none;

            border-radius: 12px;

            background: #123b67;

            color: #ffffff;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            transition: all .2s ease;

            box-shadow:
                0 6px 18px rgba(18, 59, 103, 0.16);
        }


        .login-submit:hover {

            background: #2B286D;

            transform: translateY(-1px);

            box-shadow:
                0 8px 22px rgba(18, 59, 103, 0.22);
        }


        .login-submit:active {

            transform: translateY(0);
        }


        /* Login Link */

        .register-link {

            margin-top: 18px;

            text-align: center;

            font-size: 13px;

            color: #6b7280;
        }


        .register-link a {

            color: #2B286D;

            font-weight: 600;

            text-decoration: none;

            margin-right: 4px;
        }


        .register-link a:hover {

            text-decoration: underline;
        }


        /* Chrome Autofill */

        .login-input:-webkit-autofill,
        .login-input:-webkit-autofill:hover,
        .login-input:-webkit-autofill:focus {

            -webkit-box-shadow:
                0 0 0 1000px #ffffff inset !important;

            -webkit-text-fill-color:
                #202938 !important;
        }


        /* Responsive */

        @media (max-width: 576px) {

            .login-wrapper {

                padding: 15px;
            }


            .login-card {

                padding: 30px 22px;

                border-radius: 17px;
            }


            .login-brand h2 {

                font-size: 20px;
            }

        }

    </style>


    <script>

        function togglePassword(inputId, iconId) {

            const input = document.getElementById(inputId);

            const icon = document.getElementById(iconId);


            if (input.type === 'password') {

                input.type = 'text';

                icon.classList.remove('fa-eye');

                icon.classList.add('fa-eye-slash');

            } else {

                input.type = 'password';

                icon.classList.remove('fa-eye-slash');

                icon.classList.add('fa-eye');

            }

        }

    </script>

@endsection
