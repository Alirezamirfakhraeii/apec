@php use Illuminate\Support\Str; @endphp
@extends('front.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/internal-page-page.css') }}">
@endpush

@section('content')
    @php
        $segments = $segments ?? request()->segments();
        $pageTitle = $page->title ?? $menuItem->title ?? 'صفحه داخلی';
        $pageSummary = $page->summary ?? null;
        $pageBody = $page->body ?? null;

        $pageImage = $page->image_url ?? null;

        if (!$pageImage && !empty($page->image)) {
            $pageImage = Str::startsWith($page->image, ['http://', 'https://', '/'])
                ? $page->image
                : asset('storage/' . $page->image);
        }

        $sidebarItems = $sidebarItems ?? $sideMenuItems ?? collect();
        $sidebarTitle = $sidebarTitle ?? $rootMenuItem?->title ?? 'بخش‌های مرتبط';

        $latestPosts = $latestPosts ?? collect();
    @endphp

    @include('front.templates.internal-page.partials._reading-progress')

    <main class="komyte-page-wrapper" dir="rtl">
        @include('front.templates.internal-page.partials._hero')
        @include('front.templates.internal-page.partials._layout')
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('front/js/internal-page-page.js') }}"></script>
@endpush
