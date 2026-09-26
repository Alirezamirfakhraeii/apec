@extends('front.user.layouts.app')

@section('title', 'ویرایش اطلاعات حساب')
@section('page_title', 'ویرایش اطلاعات حساب')
@section('page_description', 'اطلاعات شخصی و راه‌های ارتباطی حساب کاربری خود را مدیریت کنید.')

@section('page_actions')
    <a
        href="{{ route('user.dashboard') }}"
        class="user-page-back"
    >
        <i class="fa fa-arrow-right"></i>
        بازگشت به داشبورد
    </a>
@endsection

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/user/dashboard/profile-card.css') }}"
    >
@endpush

@section('content')

    @php
        $displayName = $user->name ?: 'کاربر عزیز';

        $email = $user->email ?: '';

        $mobile = $user->mobile
            ?? $user->phone_number
            ?? '';

        $initials = collect(
            preg_split('/\s+/', trim($displayName))
        )
            ->filter()
            ->take(2)
            ->map(fn ($part) => mb_substr($part, 0, 1))
            ->implode('');
    @endphp


    <div class="user-profile-edit">

        {{-- =========================================================
            Profile Summary
        ========================================================== --}}
        <aside class="user-profile-edit__summary">

            <div class="user-profile-edit__summary-card">

                <div class="user-profile-edit__avatar">
                    {{ $initials ?: 'U' }}
                </div>


                <div class="user-profile-edit__summary-content">

                    <h2>
                        {{ $displayName }}
                    </h2>

                    <p
                        dir="ltr"
                        class="user-font-en"
                    >
                        {{ $email ?: 'ایمیل ثبت نشده' }}
                    </p>

                    @if($mobile)

                        <p
                            dir="ltr"
                            class="user-font-en"
                        >
                            {{ $mobile }}
                        </p>

                    @endif

                </div>


                <div class="user-profile-edit__status">

                    <i class="fa fa-check-circle"></i>

                    <span>
                    حساب کاربری فعال
                </span>

                </div>


                <div class="user-profile-edit__summary-note">

                <span class="user-profile-edit__summary-note-icon">

                    <i class="fa fa-info-circle"></i>

                </span>

                    <p>
                        اطلاعات این بخش مربوط به حساب کاربری شماست
                        و با اطلاعات شرکت در درخواست عضویت متفاوت است.
                    </p>

                </div>

            </div>

        </aside>


        {{-- =========================================================
            Profile Form
        ========================================================== --}}
        <section class="user-profile-edit__main">

            <div class="user-profile-edit__card">


                {{-- Header --}}
                <div class="user-profile-edit__card-header">

                    <div class="user-profile-edit__card-header-content">

                    <span class="user-profile-edit__card-icon">

                        <i class="fa fa-user-o"></i>

                    </span>


                        <div>

                            <h2>
                                اطلاعات شخصی
                            </h2>

                            <p>
                                اطلاعات اصلی حساب کاربری خود را بروزرسانی کنید.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form --}}
                <form
                    action="{{ route('user.profile.update') }}"
                    method="POST"
                    class="user-profile-edit__form"
                >

                    @csrf
                    @method('PUT')


                    <div class="user-profile-edit__form-grid">


                        {{-- Name --}}
                        <div class="user-profile-edit__field">

                            <label for="name">

                            <span>
                                نام و نام خانوادگی
                            </span>

                                <small>
                                    الزامی
                                </small>

                            </label>


                            <div class="user-profile-edit__input-wrapper">

                            <span class="user-profile-edit__input-icon">

                                <i class="fa fa-user-o"></i>

                            </span>


                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    class="
                                    user-profile-edit__input
                                    @error('name') is-invalid @enderror
                                "
                                    placeholder="نام و نام خانوادگی"
                                    autocomplete="name"
                                    maxlength="150"
                                    required
                                >

                            </div>


                            @error('name')

                            <span class="user-profile-edit__error">

                                <i class="fa fa-exclamation-circle"></i>

                                {{ $message }}

                            </span>

                            @enderror

                        </div>


                        {{-- Email --}}
                        <div class="user-profile-edit__field">

                            <label for="email">

                            <span>
                                آدرس ایمیل
                            </span>

                                <small>
                                    الزامی
                                </small>

                            </label>


                            <div class="user-profile-edit__input-wrapper">

                            <span class="user-profile-edit__input-icon">

                                <i class="fa fa-envelope-o"></i>

                            </span>


                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    dir="ltr"
                                    value="{{ old('email', $user->email) }}"
                                    class="
                                    user-profile-edit__input
                                    user-font-en
                                    @error('email') is-invalid @enderror
                                "
                                    placeholder="example@email.com"
                                    autocomplete="email"
                                    maxlength="255"
                                    required
                                >

                            </div>


                            @error('email')

                            <span class="user-profile-edit__error">

                                <i class="fa fa-exclamation-circle"></i>

                                {{ $message }}

                            </span>

                            @enderror

                        </div>


                        {{-- Mobile --}}
                        <div class="user-profile-edit__field">

                            <label for="mobile">

                            <span>
                                شماره همراه
                            </span>

                                <small>
                                    راه ارتباطی
                                </small>

                            </label>


                            <div class="user-profile-edit__input-wrapper">

                            <span class="user-profile-edit__input-icon">

                                <i class="fa fa-mobile"></i>

                            </span>


                                <input
                                    type="text"
                                    id="mobile"
                                    name="mobile"
                                    dir="ltr"
                                    inputmode="numeric"
                                    value="{{ old('mobile', $mobile) }}"
                                    class="
                                    user-profile-edit__input
                                    user-font-en
                                    @error('mobile') is-invalid @enderror
                                "
                                    placeholder="09xxxxxxxxx"
                                    autocomplete="tel"
                                    maxlength="20"
                                >

                            </div>


                            @error('mobile')

                            <span class="user-profile-edit__error">

                                <i class="fa fa-exclamation-circle"></i>

                                {{ $message }}

                            </span>

                            @enderror

                        </div>

                    </div>


                    {{-- Footer --}}
                    <div class="user-profile-edit__footer">

                        <div class="user-profile-edit__footer-note">

                            <i class="fa fa-shield"></i>

                            <span>
                            تغییرات فقط روی اطلاعات حساب کاربری شما اعمال می‌شود.
                        </span>

                        </div>


                        <div class="user-profile-edit__actions">

                            <a
                                href="{{ route('user.dashboard') }}"
                                class="user-profile-edit__cancel"
                            >
                                انصراف
                            </a>


                            <button
                                type="submit"
                                class="user-profile-edit__submit"
                            >

                                <i class="fa fa-check"></i>

                                ذخیره تغییرات

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </section>

    </div>

@endsection
