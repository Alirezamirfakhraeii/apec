@php
    $user = auth()->user();

    $displayName = $user?->name ?: 'کاربر عزیز';
    $email = $user?->email ?: 'user@example.com';

    $initials = collect(preg_split('/\s+/', trim($displayName)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp

<aside
    class="user-sidebar"
    data-user-sidebar
>

    <div class="user-sidebar__brand">

        <div class="user-sidebar__brand-mark">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 3 4 7v10l8 4 8-4V7l-8-4Z"/>
                <path d="m4 7 8 4 8-4"/>
                <path d="M12 11v10"/>
            </svg>
        </div>

        <div>
            <strong>پنل کاربری</strong>
            <span>User Dashboard</span>
        </div>
    </div>


    <div class="user-sidebar__profile">

        <div class="user-sidebar__avatar">
            {{ $initials ?: 'U' }}
        </div>

        <div class="user-sidebar__profile-info">
            <strong>{{ $displayName }}</strong>
            <span>{{ $email }}</span>
        </div>

    </div>


    <div class="user-sidebar__section-title">
        منوی کاربری
    </div>


    <nav class="user-sidebar__nav">

        <a
            href="#"
            class="user-sidebar__link {{ request()->routeIs('user.dashboard') ? 'is-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 21a8 8 0 0 1 16 0"/>
            </svg>

            <span>پروفایل</span>
        </a>


        <a
            href="{{ route('user.membership.create') }}"
            class="user-sidebar__link {{ request()->routeIs('user.membership.*') ? 'is-active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                <path d="M14 2v6h6"/>
                <path d="M9 13h6"/>
                <path d="M12 10v6"/>
            </svg>

            <span>درخواست عضویت</span>
        </a>


        <a href="#" class="user-sidebar__link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            </svg>

            <span>تغییر اطلاعات</span>
        </a>


        <a href="#" class="user-sidebar__link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                <path d="m17 8-5-5-5 5"/>
                <path d="M12 3v12"/>
            </svg>

            <span>بارگذاری مدارک</span>
        </a>

    </nav>


    <div class="user-sidebar__spacer"></div>


    <form action="{{ route('logout') }}" method="POST" class="user-sidebar__logout-form">
        @csrf

        <button type="submit" class="user-sidebar__logout-simple">
            خروج از حساب
        </button>
    </form>

</aside>
<style>
    .user-sidebar__logout-form {
        margin: 0;
    }

    .user-sidebar__logout-simple {
        width: 100%;
        padding: 12px 14px;

        border: 0;
        border-radius: 10px;

        background: transparent;

        color: rgba(255, 255, 255, 0.7);

        font-size: 12px;
        font-weight: 500;

        text-align: right;

        cursor: pointer;

        transition: .2s ease;
    }

    .user-sidebar__logout-simple:hover {
        background: rgba(255, 255, 255, 0.06);
        color: #ffffff;
    }
</style>
