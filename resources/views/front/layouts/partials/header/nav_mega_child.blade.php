@php
    use Illuminate\Support\Str;

    $level = $level ?? 1;
    $hasChildren = $child->children && $child->children->count() > 0;

    $href = '#';

    if (!empty($child->link)) {
        $link = trim($child->link);

        if (
            Str::startsWith($link, ['http://', 'https://', 'mailto:', 'tel:', '#'])
        ) {
            $href = $link;
        } elseif (Str::startsWith($link, '/')) {
            $href = url($link);
        } else {
            $href = url('/' . $link);
        }
    } elseif (!empty($child->url)) {
        $url = trim($child->url);

        if (
            Str::startsWith($url, ['http://', 'https://', 'mailto:', 'tel:', '#'])
        ) {
            $href = $url;
        } elseif (Str::startsWith($url, '/')) {
            $href = url($url);
        } else {
            $href = url('/' . $url);
        }
    } elseif (!empty($child->slug)) {
        $href = url('/' . ltrim($child->slug, '/'));
    }
@endphp

<div class="mega-tree-node mega-tree-level-{{ $level }}">

    <a href="{{ $child->href }}"
       class="{{ $level == 1 ? 'mega-tree-title' : 'mega-tree-link' }}"
       title="{{ $child->title }}">

        <span>
            {{ \Illuminate\Support\Str::limit($child->title, $level == 1 ? 30 : 38) }}
        </span>

        @if($hasChildren)
            <i class="fa fa-angle-left"></i>
        @endif
    </a>

    @if($hasChildren)
        <ul class="mega-tree-list mega-tree-list-level-{{ $level }}">
            @foreach($child->children as $nextChild)
                <li>
                    @include('front.layouts.partials.header.nav_mega_child', [
                        'child' => $nextChild,
                        'level' => $level + 1
                    ])
                </li>
            @endforeach
        </ul>
    @endif

</div>
