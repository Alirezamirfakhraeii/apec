@extends('front.layouts.master')

@section('content')
    <main class="dynamic-page" dir="rtl">
        @foreach($page->blocks->where('status', 'active')->sortBy('sort_order') as $block)
            @php
                $type = $block->type;
                $view = $type?->view_path;

                $values = $block->values
                    ->mapWithKeys(fn($value) => [$value->field->field_key => $value->value])
                    ->toArray();
            @endphp

            @if($view && str_starts_with($view, 'front.pages.blocks.') && view()->exists($view))
                @include($view, [
                    'page' => $page,
                    'block' => $block,
                    'type' => $type,
                    'values' => $values,
                    'items' => $block->items,
                ])
            @endif
        @endforeach
    </main>
@endsection
