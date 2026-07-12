@php
    $textSide = $values['text_side'] ?? 'right';

    $contentClass = $textSide === 'left'
        ? 'commite-content-left'
        : 'commite-content-right';
@endphp

<head>
    <link rel="stylesheet" href="{{ asset('front/css/page-blocks.css') }}">
</head>

<section class="page-block commite-block {{ $contentClass }}">
    <div class="container">
        <div class="commite-card">

            <div class="commite-text">
                @if(!empty($values['title']))
                    <h2>
                        {{ $values['title'] }}
                    </h2>
                @endif

                @if(!empty($values['body']))
                    <div class="commite-body">
                        {!! $values['body'] !!}
                    </div>
                @endif
            </div>

            @if(!empty($values['image']))
                <div class="commite-image">
                    <img src="{{ asset('storage/' . $values['image']) }}"
                         alt="{{ $values['title'] ?? $page->title }}">
                </div>
            @endif

        </div>
    </div>
</section>
