@extends('auth.layouts.master')

@section('title', __('Sign Up'))

@section('form_content')
    <div class="main-signup-header">
        <h2 class="text-primary">{{ __('Create an Account') }}</h2>
        <h5 class="fw-normal mb-4">{{ __('It is free to register and only takes a minute.') }}</h5>

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <!-- فیلد نام و نام خانوادگی -->
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Full Name') }}</label>
                <input name="name" class="form-control @error('name') is-invalid @enderror"
                       placeholder="{{ __('Enter your full name') }}"
                       type="text" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- فیلد پست الکترونیک -->
            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>
                <input name="email" class="form-control @error('email') is-invalid @enderror"
                       placeholder="{{ __('Enter your email') }}"
                       type="email" value="{{ old('email') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- فیلد کلمه عبور -->
            <div class="form-group mb-4">
                <label class="form-label">{{ __('Password') }}</label>
                <input name="password" class="form-control @error('password') is-invalid @enderror"
                       placeholder="{{ __('Enter your password') }}"
                       type="password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- فیلد تکرار کلمه عبور -->
            <div class="form-group mb-4">
                <label class="form-label">{{ __('Confirm Password') }}</label>
                <input name="password_confirmation" class="form-control"
                       placeholder="{{ __('Repeat your password') }}"
                       type="password">
            </div>

            <button type="submit" class="btn btn-main-primary btn-block">{{ __('Sign Up') }}</button>
        </form>

        <!-- فوتر فرم جهت سوئیچ به صفحه ورود -->
        <div class="main-signup-footer mt-5">
            <p>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
        </div>
    </div>
@endsection
