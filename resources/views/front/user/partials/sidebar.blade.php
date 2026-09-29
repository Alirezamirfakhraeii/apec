@php
    $user = auth()->user();

    $displayName = $user?->name ?: 'کاربر عزیز';
    $email = $user?->email ?: 'ایمیل ثبت نشده';

    /*
     * Check whether the logged-in user is already
     * connected to an existing company.
     */
    $hasCompany = $user
        ? $user->companies()->exists()
        : false;

    $initials = collect(preg_split('/\s+/', trim($displayName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');

    $dashboardUrl = Route::has('user.dashboard')
        ? route('user.dashboard')
        : url('/');

    $profileUrl = Route::has('user.profile.edit')
        ? route('user.profile.edit')
        : null;

    $companyEditUrl = Route::has('user.company.edit')
        ? route('user.company.edit')
        : null;

    $membershipCreateUrl = Route::has('user.membership.create')
        ? route('user.membership.create')
        : null;
@endphp

<div class="user-sidebar">

    <div class="user-sidebar__brand">
        <a href="{{ $dashboardUrl }}" class="user-sidebar__brand-link">

            <span class="user-sidebar__brand-mark">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path d="M12 3 4 7v10l8 4 8-4V7l-8-4Z"/>
                    <path d="m4 7 8 4 8-4"/>
                    <path d="M12 11v10"/>
                </svg>
            </span>

            <span class="user-sidebar__brand-content">
                <strong>پنل کاربری</strong>
                <small>APEC Member Panel</small>
            </span>

        </a>

        <button
            type="button"
            class="user-sidebar__mobile-close"
            data-user-sidebar-close
            aria-label="بستن منو"
        >
            <i class="fa fa-times"></i>
        </button>
    </div>


    {{-- User Profile --}}
    <div class="user-sidebar__profile">

        <div class="user-sidebar__avatar">
            {{ $initials ?: 'U' }}
        </div>

        <div class="user-sidebar__profile-info">
            <strong>{{ $displayName }}</strong>
            <span dir="ltr">{{ $email }}</span>
        </div>

    </div>


    <div class="user-sidebar__navigation">

        <span class="user-sidebar__section-title">
            منوی اصلی
        </span>

        <nav class="user-sidebar__nav">

            {{-- Dashboard --}}
            <a
                href="{{ $dashboardUrl }}"
                class="user-sidebar__link {{ request()->routeIs('user.dashboard') ? 'is-active' : '' }}"
            >
                <span class="user-sidebar__link-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <path d="M3 11 12 3l9 8"/>
                        <path d="M5 10v10h14V10"/>
                        <path d="M9 20v-6h6v6"/>
                    </svg>
                </span>

                <span class="user-sidebar__link-text">
                    داشبورد
                </span>
            </a>


            {{-- Support Tickets --}}
            @if(Route::has('user.tickets.index'))

                <a
                    href="{{ route('user.tickets.index') }}"
                    class="user-sidebar__link {{ request()->routeIs('user.tickets.*') ? 'is-active' : '' }}"
                >
                    <span class="user-sidebar__link-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"/>
                            <path d="M8 9h8"/>
                            <path d="M8 13h5"/>
                        </svg>
                    </span>

                    <span class="user-sidebar__link-text">
                        تیکت‌های پشتیبانی
                    </span>
                </a>

            @endif


            {{-- User Account --}}
            @if($profileUrl)

                <a
                    href="{{ $profileUrl }}"
                    class="user-sidebar__link {{ request()->routeIs('user.profile.*') ? 'is-active' : '' }}"
                >
                    <span class="user-sidebar__link-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 21a8 8 0 0 1 16 0"/>
                        </svg>
                    </span>

                    <span class="user-sidebar__link-text">
                        اطلاعات حساب
                    </span>
                </a>

            @endif


            {{--
                Existing member:
                Show company information instead of membership request.
            --}}
            @if($hasCompany)

                @if($companyEditUrl)

                    <a
                        href="{{ $companyEditUrl }}"
                        class="user-sidebar__link {{ request()->routeIs('user.company.*') ? 'is-active' : '' }}"
                    >
                        <span class="user-sidebar__link-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path d="M3 21h18"/>
                                <path d="M6 21V7l6-4 6 4v14"/>
                                <path d="M9 9h2"/>
                                <path d="M13 9h2"/>
                                <path d="M9 13h2"/>
                                <path d="M13 13h2"/>
                                <path d="M10 21v-4h4v4"/>
                            </svg>
                        </span>

                        <span class="user-sidebar__link-text">
                            ویرایش اطلاعات شرکت
                        </span>
                    </a>

                @endif

            @else

                {{-- New Membership Request --}}
                @if($membershipCreateUrl)

                    <a
                        href="{{ $membershipCreateUrl }}"
                        class="user-sidebar__link {{ request()->routeIs('user.membership.*') && !request()->routeIs('user.membership.tracking') ? 'is-active' : '' }}"
                    >
                        <span class="user-sidebar__link-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M9 13h6"/>
                                <path d="M12 10v6"/>
                            </svg>
                        </span>

                        <span class="user-sidebar__link-text">
                            درخواست عضویت
                        </span>
                    </a>

                @endif


                {{-- Membership Tracking --}}
                @if(Route::has('user.membership.tracking'))

                    <a
                        href="{{ route('user.membership.tracking') }}"
                        class="user-sidebar__link {{ request()->routeIs('user.membership.tracking') ? 'is-active' : '' }}"
                    >
                        <span class="user-sidebar__link-icon">
                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 2"/>
                                <path d="M8 3.5l1.5 2"/>
                                <path d="M16 3.5l-1.5 2"/>
                            </svg>
                        </span>

                        <span class="user-sidebar__link-text">
                            پیگیری عضویت
                        </span>
                    </a>

                @endif

            @endif

        </nav>


        <div class="user-sidebar__divider"></div>

        <span class="user-sidebar__section-title">
            دسترسی‌ها
        </span>

        <nav class="user-sidebar__nav">

            <a
                href="{{ url('/') }}"
                class="user-sidebar__link"
            >
                <span class="user-sidebar__link-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M3 12h18"/>
                        <path d="M12 3a15 15 0 0 1 0 18"/>
                        <path d="M12 3a15 15 0 0 0 0 18"/>
                    </svg>
                </span>

                <span class="user-sidebar__link-text">
                    بازگشت به وب‌سایت
                </span>
            </a>

        </nav>

    </div>


    {{-- Footer / Logout --}}
    <div class="user-sidebar__footer">

        @if(Route::has('logout'))

            <form
                action="{{ route('logout') }}"
                method="POST"
                class="user-sidebar__logout-form"
            >
                @csrf

                <button
                    type="submit"
                    class="user-sidebar__logout"
                >
                    <span class="user-sidebar__logout-icon">
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path d="M10 17l5-5-5-5"/>
                            <path d="M15 12H3"/>
                            <path d="M14 3h5a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-5"/>
                        </svg>
                    </span>

                    <span>
                        خروج از حساب
                    </span>
                </button>

            </form>

        @endif

    </div>

</div>
