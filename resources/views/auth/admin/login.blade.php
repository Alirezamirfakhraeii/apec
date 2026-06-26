@extends('auth.layouts.master')

@section('title', 'ورود به حساب کاربری')

@section('form_content')
    <div class="main-signup-header">
        <h2 class="text-primary">{{ __('Welcome!') }}</h2>
        <h5 class="fw-normal mb-4">{{ __('Please enter your details to sign in.') }}</h5>

        {{-- نمایش خطاهای کلی --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>

                <input
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="ایمیل خود را وارد کنید"
                >

                @error('email')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label class="form-label">{{ __('Password') }}</label>

                <input
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    type="password"
                    placeholder="رمز عبور خود را وارد کنید"
                >

                @error('password')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-main-primary btn-block">
                {{ __('Sign In') }}
            </button>
        </form>
    </div>
@endsection
