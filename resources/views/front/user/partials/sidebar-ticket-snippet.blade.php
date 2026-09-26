@if(Route::has('user.tickets.index'))
    <a href="{{ route('user.tickets.index') }}" class="user-sidebar__link {{ request()->routeIs('user.tickets.*') ? 'is-active' : '' }}">
        <span class="user-sidebar__link-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4Z"/>
                <path d="M8 9h8"/><path d="M8 13h5"/>
            </svg>
        </span>
        <span class="user-sidebar__link-text">تیکت‌های پشتیبانی</span>
    </a>
@endif
