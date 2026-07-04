{{-- Sidebar: search --}}
<div class="komyte-widget">
    <div class="komyte-widget-title">
        <span></span>
        <h3>جستجو در سایت</h3>
    </div>

    <form action="{{ url('/') }}" method="GET" class="komyte-search-form">
        <input type="text" name="q" placeholder="کلمه کلیدی را وارد کنید...">
        <button type="submit">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
