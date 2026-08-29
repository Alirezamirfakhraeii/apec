<header class="user-topbar">

    <div class="user-topbar__start">

        <button
            type="button"
            class="user-topbar__menu-button"
            data-user-sidebar-toggle
            aria-label="باز کردن منو"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M4 6h16"/>
                <path d="M4 12h16"/>
                <path d="M4 18h16"/>
            </svg>
        </button>


        <div class="user-topbar__title">
            <h1>@yield('page_title', 'حساب کاربری من')</h1>

            <p>
                @yield(
                    'page_description',
                    'اطلاعات حساب و درخواست‌های خود را از این بخش مدیریت کنید.'
                )
            </p>
        </div>

    </div>


    <div class="user-topbar__actions">

        <button
            type="button"
            class="user-topbar__icon-button"
            title="اعلان‌ها"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </button>

    </div>

</header>
