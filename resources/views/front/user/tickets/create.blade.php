@extends('front.user.layouts.app')

@section('title', 'ثبت تیکت جدید')
@section('page_title', 'ثبت تیکت جدید')
@section('page_description', 'موضوع و توضیحات درخواست خود را برای واحد پشتیبانی ارسال کنید.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('front/css/user/tickets/tickets.css') }}">
@endpush

@section('content')
<div class="ticket-page ticket-page--form">
    <a href="{{ route('user.tickets.index') }}" class="ticket-back"><i class="fa fa-arrow-right"></i> بازگشت به تیکت‌ها</a>

    <section class="ticket-card">
        <div class="ticket-card__header">
            <h2>درخواست جدید</h2>
            <p>مشکل یا درخواست خود را واضح بنویسید.</p>
        </div>

        <form action="{{ route('user.tickets.store') }}" method="POST" class="ticket-form">
            @csrf

            <div class="ticket-field">
                <label for="subject">موضوع تیکت</label>
                <input id="subject" name="subject" value="{{ old('subject') }}" maxlength="200" required>
                @error('subject')<small class="ticket-error">{{ $message }}</small>@enderror
            </div>

            <div class="ticket-field">
                <label for="priority">اولویت</label>
                <select id="priority" name="priority" required>
                    <option value="low" @selected(old('priority') === 'low')>کم</option>
                    <option value="normal" @selected(old('priority', 'normal') === 'normal')>عادی</option>
                    <option value="high" @selected(old('priority') === 'high')>زیاد</option>
                </select>
                @error('priority')<small class="ticket-error">{{ $message }}</small>@enderror
            </div>

            <div class="ticket-field">
                <label for="message">توضیحات</label>
                <textarea id="message" name="message" rows="8" maxlength="5000" required>{{ old('message') }}</textarea>
                @error('message')<small class="ticket-error">{{ $message }}</small>@enderror
            </div>

            <div class="ticket-form__footer">
                <a href="{{ route('user.tickets.index') }}" class="ticket-btn ticket-btn--secondary">انصراف</a>
                <button type="submit" class="ticket-btn ticket-btn--primary"><i class="fa fa-paper-plane-o"></i> ارسال تیکت</button>
            </div>
        </form>
    </section>
</div>
@endsection
