@extends('auth.layouts.master')

@section('title', 'ورود به حساب کاربری')

@section('form_content')
    <div class="main-signup-header">
        <h2 class="text-primary">{{ __('Welcome!') }}</h2>
        <h5 class="fw-normal mb-4">{{ __('Please enter your details to sign in.') }}</h5>

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group mb-3">
                <label class="form-label">{{ __('Email Address') }}</label>
                <input name="email" class="form-control" type="email" value="{{ old('email') }}">
            </div>

            <div class="form-group mb-4">
                <label class="form-label">{{ __('Password') }}</label>
                <input name="password" class="form-control" type="password">
            </div>

            <button type="submit" class="btn btn-main-primary btn-block">{{ __('Sign In') }}</button>
        </form>
    </div>
@endsection
