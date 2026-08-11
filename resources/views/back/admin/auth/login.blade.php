<!DOCTYPE html>

<html
    lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}"
>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ __('auth.admin_login') }}</title>


    {{-- Favicon --}}
    <link
        rel="icon"
        href="{{ asset('back/img/brand/favicon.png') }}"
        type="image/x-icon"
    >


    {{-- Auth Style --}}
    <link
        rel="stylesheet"
        href="{{ asset('back/css/auth/auth.css') }}"
    >

    <link href="{{ asset('back/css-rtl/style.css') }}" rel="stylesheet">


</head>

<body>

<main class="login-page">

    <section class="login-wrapper">

        {{-- Hero --}}
        <aside class="login-hero">

            <div class="hero-content">

                <div class="brand-box">

                    <div class="brand-logo">
                        {{ __('auth.panel') }}
                    </div>

                    <div>

                        <h2 class="brand-title">
                            {{ __('auth.admin_panel') }}
                        </h2>

                    </div>

                </div>


                <div class="hero-main">

                    <h1 class="hero-title">
                        {{ __('auth.welcome') }}
                    </h1>

                    <p class="hero-text">
                        {{ __('auth.hero_description') }}
                    </p>

                </div>

            </div>

        </aside>


        {{-- Form Side --}}
        <div class="login-form-side">

            <div class="login-card">

                <div class="mobile-logo">
                    {{ __('auth.panel') }}
                </div>


                <h1 class="login-title">
                    {{ __('auth.sign_in') }}
                </h1>


                <p class="login-subtitle">
                    {{ __('auth.form_description') }}
                </p>


                {{-- General Error --}}
                @if ($errors->any())

                    <div
                        class="error-box"
                        role="alert"
                    >
                        {{ __('auth.invalid_credentials') }}
                    </div>

                @endif


                <form
                    action="{{ route('admin.login') }}"
                    method="POST"
                    data-login-form
                >

                    @csrf


                    {{-- Email --}}
                    <div class="form-group">

                        <label
                            for="email"
                            class="form-label"
                        >
                            {{ __('auth.email') }}
                        </label>


                        <div class="input-wrap">

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                placeholder="{{ __('auth.email_placeholder') }}"
                                autocomplete="email"
                                class="form-control email-input @error('email') is-invalid @enderror"
                            >

                        </div>


                        @error('email')

                        <span
                            class="error-text"
                            role="alert"
                        >
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Password --}}
                    <div class="form-group">

                        <label
                            for="password"
                            class="form-label"
                        >
                            {{ __('auth.password') }}
                        </label>


                        <div class="input-wrap">

                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="{{ __('auth.password_placeholder') }}"
                                autocomplete="current-password"
                                class="form-control @error('password') is-invalid @enderror"
                            >

                        </div>


                        @error('password')

                        <span
                            class="error-text"
                            role="alert"
                        >
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="login-btn"
                        data-login-submit
                        data-loading-text="{{ __('auth.signing_in') }}"
                    >

                        <span data-login-submit-text>
                            {{ __('auth.sign_in') }}
                        </span>

                    </button>

                </form>


                <div class="login-footer">
                    {{ __('auth.restricted_access') }}
                </div>

            </div>

        </div>

    </section>

</main>


<script
    src="{{ asset('back/js/auth/auth.js') }}"
    defer
></script>

</body>

</html>
