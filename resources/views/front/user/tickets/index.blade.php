@extends('front.user.layouts.app')

@section('title', 'تیکت‌های پشتیبانی')
@section('page_title', 'تیکت‌های پشتیبانی')
@section('page_description', 'درخواست‌های پشتیبانی خود را ثبت و پیگیری کنید.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/user/tickets/tickets.css') }}">
@endpush

@section('content')
<div class="ticket-page">
    <div class="ticket-toolbar">
        <div>
            <h2>تیکت‌های من</h2>
            <p>تمام درخواست‌های پشتیبانی شما در این بخش نمایش داده می‌شوند.</p>
        </div>
        <a href="{{ route('user.tickets.create') }}" class="ticket-btn ticket-btn--primary">
            <i class="fa fa-plus"></i> ثبت تیکت جدید
        </a>
    </div>

    <section class="ticket-card">
        @forelse($tickets as $ticket)
            @php
                $statusLabel = match($ticket->status) {
                    'waiting_for_support' => 'در انتظار پاسخ',
                    'answered' => 'پاسخ داده شده',
                    'closed' => 'بسته شده',
                    default => $ticket->status,
                };
                $priorityLabel = match($ticket->priority) {
                    'low' => 'کم',
                    'high' => 'زیاد',
                    default => 'عادی',
                };
            @endphp

            <a href="{{ route('user.tickets.show', $ticket) }}" class="ticket-row">
                <span class="ticket-row__icon"><i class="fa fa-comment-o"></i></span>
                <span class="ticket-row__content">
                    <span class="ticket-row__title">
                        <strong>{{ $ticket->subject }}</strong>
                        <span class="ticket-status ticket-status--{{ $ticket->status }}">{{ $statusLabel }}</span>
                    </span>
                    <span class="ticket-row__meta">
                        <span>{{ $ticket->display_number }}</span>
                        <span>اولویت: {{ $priorityLabel }}</span>
                        <span>{{ $ticket->messages_count }} پیام</span>
                    </span>
                </span>
                <i class="fa fa-angle-left"></i>
            </a>
        @empty
            <div class="ticket-empty">
                <i class="fa fa-comments-o"></i>
                <h3>هنوز تیکتی ثبت نکرده‌اید</h3>
                <p>اگر سؤال یا مشکلی دارید، برای پشتیبانی تیکت ارسال کنید.</p>
                <a href="{{ route('user.tickets.create') }}" class="ticket-btn ticket-btn--primary">ثبت اولین تیکت</a>
            </div>
        @endforelse

        @if($tickets->hasPages())
            <div class="ticket-pagination">{{ $tickets->links() }}</div>
        @endif
    </section>
</div>
@endsection
