@if($child->children->count() > 0)

    <li class="dropdown-submenu">
        <a class="dropdown-item d-flex align-items-center justify-content-between"
           href="{{ $child->link ?? '#' }}">

            <span>{{ $child->title }}</span>

            <i class="fa fa-chevron-left font_11"></i>
        </a>

        <ul class="dropdown-menu text-right" dir="rtl">
            @foreach($child->children as $subChild)
                @include('front.layouts.partials.nav_child', ['child' => $subChild])
            @endforeach
        </ul>
    </li>

@else

    <li>
        <a class="dropdown-item" href="{{ $child->link ?? '#' }}">
            {{ $child->title }}
        </a>
    </li>

@endif
