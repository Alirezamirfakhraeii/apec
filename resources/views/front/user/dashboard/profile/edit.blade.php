@extends('front.user.layouts.app')

@section('title', 'ویرایش اطلاعات حساب')

@section('page_title', 'ویرایش اطلاعات حساب')

@section(
    'page_description',
    'اطلاعات شخصی، نام کاربری، رمز عبور و راه‌های ارتباطی حساب کاربری خود را مدیریت کنید.'
)


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
            preg_split(
                '/\s+/',
                trim($displayName)
            )
        )
            ->filter()
            ->take(2)
            ->map(
                fn ($part) =>
                    mb_substr($part, 0, 1)
            )
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

                    <span
                        class="user-profile-edit__summary-note-icon"
                    >
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

                    <div
                        class="user-profile-edit__card-header-content"
                    >

                        <span
                            class="user-profile-edit__card-icon"
                        >
                            <i class="fa fa-user-o"></i>
                        </span>


                        <div>

                            <h2>
                                اطلاعات حساب کاربری
                            </h2>

                            <p>
                                اطلاعات اصلی حساب کاربری خود را
                                بروزرسانی کنید.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Success Message --}}

                @if(session('success'))

                    <div class="alert alert-success">

                        <i class="fa fa-check-circle"></i>

                        {{ session('success') }}

                    </div>

                @endif


                {{-- Form --}}

                <form
                    action="{{ route('user.profile.update') }}"
                    method="POST"
                    class="user-profile-edit__form"
                >

                    @csrf

                    @method('PUT')


                    {{-- =====================================================
                        Basic Information
                    ====================================================== --}}

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


                            <div
                                class="user-profile-edit__input-wrapper"
                            >

                                <span
                                    class="user-profile-edit__input-icon"
                                >
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

                            <span
                                class="user-profile-edit__error"
                            >
                                    <i
                                        class="fa fa-exclamation-circle"
                                    ></i>

                                    {{ $message }}
                                </span>

                            @enderror

                        </div>


                        {{-- Username --}}

                        <div class="user-profile-edit__field">

                            <label for="username">

                                <span>
                                    نام کاربری
                                </span>

                                <small>
                                    الزامی
                                </small>

                            </label>


                            <div
                                class="user-profile-edit__input-wrapper"
                            >

                                <span
                                    class="user-profile-edit__input-icon"
                                >
                                    <i class="fa fa-at"></i>
                                </span>


                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    dir="ltr"
                                    value="{{ old('username', $user->username) }}"
                                    class="
                                        user-profile-edit__input
                                        user-font-en
                                        @error('username') is-invalid @enderror
                                    "
                                    placeholder="username"
                                    autocomplete="username"
                                    maxlength="100"
                                    required
                                >

                            </div>


                            @error('username')

                            <span
                                class="user-profile-edit__error"
                            >
                                    <i
                                        class="fa fa-exclamation-circle"
                                    ></i>

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


                            <div
                                class="user-profile-edit__input-wrapper"
                            >

                                <span
                                    class="user-profile-edit__input-icon"
                                >
                                    <i
                                        class="fa fa-envelope-o"
                                    ></i>
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

                            <span
                                class="user-profile-edit__error"
                            >
                                    <i
                                        class="fa fa-exclamation-circle"
                                    ></i>

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


                            <div
                                class="user-profile-edit__input-wrapper"
                            >

                                <span
                                    class="user-profile-edit__input-icon"
                                >
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

                            <span
                                class="user-profile-edit__error"
                            >
                                    <i
                                        class="fa fa-exclamation-circle"
                                    ></i>

                                    {{ $message }}
                                </span>

                            @enderror

                        </div>

                    </div>


                    {{-- =====================================================
                        Password Section
                    ====================================================== --}}

                    <div
                        style="
                            margin-top: 32px;
                            padding-top: 28px;
                            border-top: 1px solid #eef1f5;
                        "
                    >

                        <div
                            class="user-profile-edit__card-header-content"
                            style="margin-bottom: 24px;"
                        >

                            <span
                                class="user-profile-edit__card-icon"
                            >
                                <i class="fa fa-lock"></i>
                            </span>


                            <div>

                                <h5>
                                    تغییر رمز عبور
                                </h5>

                                <p>
                                    در صورتی که قصد تغییر رمز عبور
                                    را ندارید، فیلدهای این بخش را
                                    خالی بگذارید.
                                </p>

                            </div>

                        </div>


                        <div
                            class="user-profile-edit__form-grid"
                        >


                            {{-- Current Password --}}

                            <div class="user-profile-edit__field">

                                <label for="current_password">

                                    <span>
                                        رمز عبور فعلی
                                    </span>

                                    <small>
                                        جهت تأیید تغییر رمز
                                    </small>

                                </label>


                                <div
                                    class="user-profile-edit__input-wrapper"
                                >

                                    <span
                                        class="user-profile-edit__input-icon"
                                    >
                                        <i class="fa fa-key"></i>
                                    </span>


                                    <input
                                        type="password"
                                        id="current_password"
                                        name="current_password"
                                        dir="ltr"
                                        class="
                                            user-profile-edit__input
                                            user-font-en
                                            @error('current_password') is-invalid @enderror
                                        "
                                        placeholder="••••••••"
                                        autocomplete="current-password"
                                    >

                                </div>


                                @error('current_password')

                                <span
                                    class="user-profile-edit__error"
                                >
                                        <i
                                            class="fa fa-exclamation-circle"
                                        ></i>

                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- New Password --}}

                            <div class="user-profile-edit__field">

                                <label for="password">

                                    <span>
                                        رمز عبور جدید
                                    </span>

                                    <small>
                                        حداقل ۸ کاراکتر
                                    </small>

                                </label>


                                <div
                                    class="user-profile-edit__input-wrapper"
                                >

                                    <span
                                        class="user-profile-edit__input-icon"
                                    >
                                        <i class="fa fa-lock"></i>
                                    </span>


                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        dir="ltr"
                                        class="
                                            user-profile-edit__input
                                            user-font-en
                                            @error('password') is-invalid @enderror
                                        "
                                        placeholder="••••••••"
                                        autocomplete="new-password"
                                    >

                                </div>


                                @error('password')

                                <span
                                    class="user-profile-edit__error"
                                >
                                        <i
                                            class="fa fa-exclamation-circle"
                                        ></i>

                                        {{ $message }}
                                    </span>

                                @enderror

                            </div>


                            {{-- Password Confirmation --}}

                            <div class="user-profile-edit__field">

                                <label for="password_confirmation">

                                    <span>
                                        تکرار رمز عبور جدید
                                    </span>

                                    <small>
                                        تأیید رمز
                                    </small>

                                </label>


                                <div
                                    class="user-profile-edit__input-wrapper"
                                >

                                    <span
                                        class="user-profile-edit__input-icon"
                                    >
                                        <i class="fa fa-lock"></i>
                                    </span>


                                    <input
                                        type="password"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        dir="ltr"
                                        class="
                                            user-profile-edit__input
                                            user-font-en
                                        "
                                        placeholder="••••••••"
                                        autocomplete="new-password"
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =====================================================
                        Footer
                    ====================================================== --}}

                    <div class="user-profile-edit__footer">

                        <div
                            class="user-profile-edit__footer-note"
                        >

                            <i class="fa fa-shield"></i>

                            <span>
                                تغییرات فقط روی اطلاعات حساب
                                کاربری شما اعمال می‌شود.
                            </span>

                        </div>


                        <div
                            class="user-profile-edit__actions"
                        >

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
