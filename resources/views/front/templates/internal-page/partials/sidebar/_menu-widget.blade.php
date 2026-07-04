{{-- Sidebar: related menu --}}
<div class="komyte-widget">
    <div class="komyte-widget-title">
        <span></span>
        <h3>{{ $sidebarTitle }}</h3>
    </div>

    <ul class="komyte-side-menu">
        @forelse($sidebarItems as $item)
            <li>
                <a
                    href="{{ $item->href }}"
                    class="{{ trim(request()->path(), '/') === trim($item->url ?? '', '/') ? 'active' : '' }}"
                    @if($item->open_in_new_tab) target="_blank" rel="noopener" @endif
                >
                    <span>{{ $item->title }}</span>
                    <i class="fa fa-angle-left"></i>
                </a>
            </li>
        @empty
            <li class="komyte-empty-side">
                بخش مرتبطی ثبت نشده است.
            </li>
        @endforelse
    </ul>
</div>
