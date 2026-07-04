<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به پنل مدیریت</title>

    <style>
        @font-face {
            font-family: 'IRANSans';
            src: url('{{ asset('IRANSansWeb.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'IRANSans', Tahoma, Arial, sans-serif;
            direction: rtl;
            color: #0f172a;
            background: #eef5ff;
        }

        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow: hidden;
            position: relative;
            background:
                radial-gradient(circle at 15% 15%, rgba(37, 99, 235, 0.22), transparent 30%),
                radial-gradient(circle at 85% 85%, rgba(14, 165, 233, 0.20), transparent 32%),
                linear-gradient(135deg, #f8fbff 0%, #eaf3ff 45%, #f7fbff 100%);
        }

        .login-page::before,
        .login-page::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            filter: blur(3px);
            opacity: 0.8;
        }

        .login-page::before {
            width: 340px;
            height: 340px;
            background: rgba(59, 130, 246, 0.16);
            top: -120px;
            right: -90px;
        }

        .login-page::after {
            width: 280px;
            height: 280px;
            background: rgba(14, 165, 233, 0.16);
            bottom: -100px;
            left: -80px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 940px;
            min-height: 570px;
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: 1fr 1.05fr;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 30px;
            overflow: hidden;
            box-shadow:
                0 30px 80px rgba(15, 23, 42, 0.14),
                inset 0 1px 0 rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(18px);
        }

        .login-hero {
            position: relative;
            padding: 42px;
            color: #fff;
            background:
                linear-gradient(145deg, rgba(15, 23, 42, 0.96), rgba(30, 64, 175, 0.95)),
                radial-gradient(circle at top right, rgba(96, 165, 250, 0.65), transparent 35%);
            overflow: hidden;
        }

        .login-hero::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(96, 165, 250, 0.22);
            top: -70px;
            left: -70px;
        }

        .login-hero::after {
            content: "";
            position: absolute;
            width: 170px;
            height: 170px;
            border-radius: 45px;
            background: rgba(255, 255, 255, 0.09);
            bottom: 55px;
            right: -50px;
            transform: rotate(18deg);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 54px;
            height: 54px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.22);
            font-size: 18px;
            font-weight: 900;
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.18);
        }

        .brand-title {
            font-size: 21px;
            font-weight: 900;
            margin: 0;
        }

        .brand-subtitle {
            margin: 5px 0 0;
            color: rgba(255, 255, 255, 0.68);
            font-size: 12px;
        }

        .hero-main {
            margin-top: 70px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 13px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 12px;
            color: rgba(255, 255, 255, 0.88);
            margin-bottom: 22px;
        }

        .hero-badge span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #38bdf8;
            box-shadow: 0 0 0 6px rgba(56, 189, 248, 0.15);
        }

        .hero-title {
            margin: 0;
            font-size: 34px;
            line-height: 1.55;
            font-weight: 900;
            letter-spacing: -1px;
        }

        .hero-text {
            margin: 18px 0 0;
            max-width: 330px;
            color: rgba(255, 255, 255, 0.68);
            font-size: 14px;
            line-height: 2;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 42px;
        }

        .hero-stat {
            padding: 15px 12px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .hero-stat strong {
            display: block;
            font-size: 17px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .hero-stat small {
            color: rgba(255, 255, 255, 0.62);
            font-size: 11px;
        }

        .login-form-side {
            padding: 52px 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.86), rgba(255, 255, 255, 0.95));
        }

        .login-card {
            width: 100%;
            max-width: 390px;
        }

        .mobile-logo {
            display: none;
            width: 58px;
            height: 58px;
            border-radius: 18px;
            margin: 0 auto 22px;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1d4ed8, #38bdf8);
            color: #fff;
            font-weight: 900;
            box-shadow: 0 16px 30px rgba(37, 99, 235, 0.25);
        }

        .login-title {
            margin: 0 0 10px;
            font-size: 27px;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.8px;
        }

        .login-subtitle {
            margin: 0 0 30px;
            font-size: 14px;
            color: #64748b;
            line-height: 1.9;
        }

        .error-box {
            margin-bottom: 20px;
            padding: 13px 15px;
            border-radius: 16px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            font-size: 13px;
            line-height: 1.8;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 9px;
            font-size: 13px;
            font-weight: 800;
            color: #334155;
        }

        .input-wrap {
            position: relative;
        }

        .form-control {
            width: 100%;
            height: 52px;
            border: 1px solid #dbe3ef;
            border-radius: 16px;
            padding: 0 16px;
            font-size: 14px;
            background: #f8fbff;
            color: #0f172a;
            outline: none;
            transition: all 0.22s ease;
        }

        .form-control:hover {
            border-color: #bfdbfe;
            background: #fff;
        }

        .form-control:focus {
            background: #fff;
            border-color: #2563eb;
            box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.11);
        }

        .email-input {
            direction: ltr;
            text-align: left;
        }

        .form-control.is-invalid {
            border-color: #2563eb;
            background: #eff6ff;
        }

        .error-text {
            display: block;
            margin-top: 7px;
            font-size: 12px;
            color: #1d4ed8;
        }

        .login-btn {
            width: 100%;
            height: 52px;
            margin-top: 8px;
            border: 0;
            border-radius: 16px;
            cursor: pointer;
            color: #fff;
            font-size: 15px;
            font-weight: 900;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            box-shadow: 0 18px 32px rgba(37, 99, 235, 0.24);
            transition: all 0.22s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 38px rgba(37, 99, 235, 0.30);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            line-height: 1.8;
        }

        @media (max-width: 850px) {
            .login-wrapper {
                max-width: 460px;
                grid-template-columns: 1fr;
                min-height: auto;
            }

            .login-hero {
                display: none;
            }

            .login-form-side {
                padding: 36px 28px;
            }

            .mobile-logo {
                display: flex;
            }

            .login-title,
            .login-subtitle {
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 16px;
            }

            .login-wrapper {
                border-radius: 24px;
            }

            .login-form-side {
                padding: 32px 22px;
            }

            .login-title {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>
<main class="login-page">
    <section class="login-wrapper">

        <aside class="login-hero">
            <div class="hero-content">

                <div class="brand-box">
                    <div class="brand-logo">پنل</div>
                    <div>
                        <h2 class="brand-title">پنل مدیریت</h2>
                    </div>
                </div>

                <div class="hero-main">
                    <h1 class="hero-title">
                        خوش آمدید
                    </h1>

                    <p class="hero-text">
                        برای ورود به پنل، اطلاعات حساب خود را وارد کنید.
                    </p>
                </div>

            </div>
        </aside>

        <div class="login-form-side">
            <div class="login-card">

                <div class="mobile-logo">پنل</div>

                <h1 class="login-title">ورود به حساب کاربری</h1>

                <p class="login-subtitle">
                    ایمیل و رمز عبور خود را وارد کنید تا وارد پنل مدیریت شوید.
                </p>

                @if ($errors->any())
                    <div class="error-box">
                        اطلاعات وارد شده صحیح نیست. لطفاً دوباره بررسی کنید.
                    </div>
                @endif

                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">ایمیل</label>

                        <div class="input-wrap">
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="example@email.com"
                                autocomplete="email"
                                class="form-control email-input @error('email') is-invalid @enderror"
                            >
                        </div>

                        @error('email')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">رمز عبور</label>

                        <div class="input-wrap">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="رمز عبور خود را وارد کنید"
                                autocomplete="current-password"
                                class="form-control @error('password') is-invalid @enderror"
                            >
                        </div>

                        @error('password')
                        <span class="error-text">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="login-btn">
                        ورود به پنل مدیریت
                    </button>
                </form>

                <div class="login-footer">
                    دسترسی به این بخش فقط برای مدیران مجاز امکان‌پذیر است.
                </div>

            </div>
        </div>

    </section>
</main>
</body>
</html>
