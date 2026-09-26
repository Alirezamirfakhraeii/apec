@php
    $user = auth()->user();

    $displayName = $user?->name ?: 'کاربر عزیز';

    $email = $user?->email ?: 'ثبت نشده';

    $mobile = $user?->phone_number
        ?? $user?->mobile
        ?? 'ثبت نشده';

    $initials = collect(
        preg_split('/\s+/', trim($displayName))
    )
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp


<section class="user-dashboard-profile">


    {{-- =====================================================
        Decorative Header
    ====================================================== --}}

    <div class="user-dashboard-profile__cover">

        <div class="user-dashboard-profile__cover-content">

            <span class="user-dashboard-profile__cover-label">
                پروفایل کاربری
            </span>

            <strong>
                اطلاعات حساب شما
            </strong>

        </div>


        <div class="user-dashboard-profile__cover-shape"></div>

    </div>


    {{-- =====================================================
        Profile Body
    ====================================================== --}}

    <div class="user-dashboard-profile__body">


        {{-- =================================================
            Identity
        ================================================== --}}

        <div class="user-dashboard-profile__header">

            <div class="user-dashboard-profile__identity">


                {{-- Avatar --}}

                <div class="user-dashboard-profile__avatar-wrapper">

                    <div class="user-dashboard-profile__avatar">
                        {{ $initials ?: 'U' }}
                    </div>


                    <span
                        class="user-dashboard-profile__active-indicator"
                        title="حساب فعال"
                    ></span>

                </div>


                {{-- User Name --}}

                <div class="user-dashboard-profile__identity-content">

                    <div class="user-dashboard-profile__name-row">

                        <h2>
                            {{ $displayName }}
                        </h2>


                        <span class="user-dashboard-profile__status">

                            <i class="fa fa-check-circle"></i>

                            حساب فعال

                        </span>

                    </div>


                    <p>

                        <i class="fa fa-envelope-o"></i>

                        <span dir="ltr">
                            {{ $email }}
                        </span>

                    </p>

                </div>

            </div>


            {{-- =================================================
                Edit Action
            ================================================== --}}

            @if(Route::has('user.profile.edit'))

                <a
                    href="{{ route('user.profile.edit') }}"
                    class="user-dashboard-profile__edit"
                >

                    <span class="user-dashboard-profile__edit-icon">

                        <i class="fa fa-pencil"></i>

                    </span>


                    <span class="user-dashboard-profile__edit-content">

                        <strong>
                            ویرایش اطلاعات
                        </strong>

                        <small>
                            بروزرسانی اطلاعات حساب کاربری
                        </small>

                    </span>


                    <span class="user-dashboard-profile__edit-arrow">

                        <i class="fa fa-angle-left"></i>

                    </span>

                </a>

            @endif

        </div>


        {{-- =================================================
            Divider
        ================================================== --}}

        <div class="user-dashboard-profile__divider"></div>


        {{-- =================================================
            Information
        ================================================== --}}

        <div class="user-dashboard-profile__info-grid">


            {{-- Name --}}

            <div class="user-dashboard-profile__info-card">

                <span class="user-dashboard-profile__info-icon">

                    <i class="fa fa-user-o"></i>

                </span>


                <div class="user-dashboard-profile__info-content">

                    <span>
                        نام و نام خانوادگی
                    </span>

                    <strong>
                        {{ $displayName }}
                    </strong>

                </div>

            </div>


            {{-- Email --}}

            <div class="user-dashboard-profile__info-card">

                <span class="user-dashboard-profile__info-icon">

                    <i class="fa fa-envelope-o"></i>

                </span>


                <div class="user-dashboard-profile__info-content">

                    <span>
                        آدرس ایمیل
                    </span>

                    <strong dir="ltr">
                        {{ $email }}
                    </strong>

                </div>

            </div>


            {{-- Mobile --}}

            <div class="user-dashboard-profile__info-card">

                <span class="user-dashboard-profile__info-icon">

                    <i class="fa fa-mobile"></i>

                </span>


                <div class="user-dashboard-profile__info-content">

                    <span>
                        شماره همراه
                    </span>

                    <strong dir="ltr">
                        {{ $mobile }}
                    </strong>

                </div>

            </div>

        </div>

    </div>

</section>
