@extends('back.admin.layouts.master')

@section('title', 'مشاهده تیکت')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('back/css/tickets/tickets.css') }}"
    >
@endpush

@section('content')

    @php
        $statusValue = $ticket->status instanceof \BackedEnum
            ? $ticket->status->value
            : $ticket->status;

        $statusLabel = is_object($ticket->status)
            && method_exists($ticket->status, 'label')
                ? $ticket->status->label()
                : match ($statusValue) {
                    'waiting_for_support' => 'در انتظار پاسخ',
                    'answered' => 'پاسخ داده شده',
                    'closed' => 'بسته شده',
                    default => $statusValue,
                };

        $priorityValue = $ticket->priority instanceof \BackedEnum
            ? $ticket->priority->value
            : $ticket->priority;

        $priorityLabel = is_object($ticket->priority)
            && method_exists($ticket->priority, 'label')
                ? $ticket->priority->label()
                : match ($priorityValue) {
                    'low' => 'کم',
                    'normal' => 'عادی',
                    'high' => 'زیاد',
                    default => $priorityValue,
                };
    @endphp


    <div class="admin-ticket-page">

        {{-- =========================================================
            Header
        ========================================================== --}}

        <div class="admin-ticket-header">

            <div class="admin-ticket-header__main">

                <a
                    href="{{ route('admin.tickets.index') }}"
                    class="admin-ticket-back"
                >
                    <i class="fe fe-arrow-right"></i>
                </a>


                <div>

                <span class="admin-ticket-number">
                    {{ $ticket->display_number }}
                </span>

                    <h1>
                        {{ $ticket->subject }}
                    </h1>

                    <p>
                        مشاهده گفتگو و اطلاعات تیکت پشتیبانی
                    </p>

                </div>

            </div>


            <div class="admin-ticket-header__badges">

            <span
                class="
                    admin-ticket-badge
                    admin-ticket-badge--priority-{{ $priorityValue }}
                "
            >
                اولویت:
                {{ $priorityLabel }}
            </span>


                <span
                    class="
                    admin-ticket-badge
                    admin-ticket-badge--{{ $statusValue }}
                "
                >
                {{ $statusLabel }}
            </span>

            </div>

        </div>


        {{-- =========================================================
            Quick Information
        ========================================================== --}}

        <div class="admin-ticket-stats">

            <div class="admin-ticket-stat">

            <span class="admin-ticket-stat__icon">
                <i class="fe fe-user"></i>
            </span>

                <div>

                    <small>
                        ارسال‌کننده
                    </small>

                    <strong>
                        {{ $ticket->user?->name ?: '—' }}
                    </strong>

                </div>

            </div>


            <div class="admin-ticket-stat">

            <span class="admin-ticket-stat__icon">
                <i class="fe fe-message-square"></i>
            </span>

                <div>

                    <small>
                        تعداد پیام‌ها
                    </small>

                    <strong>
                        {{ $ticket->messages->count() }}
                    </strong>

                </div>

            </div>


            <div class="admin-ticket-stat">

            <span class="admin-ticket-stat__icon">
                <i class="fe fe-clock"></i>
            </span>

                <div>

                    <small>
                        آخرین فعالیت
                    </small>

                    <strong>
                        {{
                            $ticket->last_message_at
                                ? $ticket->last_message_at->format('Y-m-d H:i')
                                : '—'
                        }}
                    </strong>

                </div>

            </div>


            <div class="admin-ticket-stat">

            <span class="admin-ticket-stat__icon">
                <i class="fe fe-calendar"></i>
            </span>

                <div>

                    <small>
                        تاریخ ایجاد
                    </small>

                    <strong>
                        {{ $ticket->created_at->format('Y-m-d H:i') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Main Layout
        ========================================================== --}}

        <div class="admin-ticket-layout">


            {{-- =====================================================
                Conversation
            ====================================================== --}}

            <section class="admin-ticket-card admin-ticket-conversation">

                <div class="admin-ticket-card__header">

                    <div>

                        <h2>
                            گفتگوی تیکت
                        </h2>

                        <p>
                            پیام‌های ارسال‌شده بین کاربر و واحد پشتیبانی
                        </p>

                    </div>


                    <span class="admin-ticket-message-count">

                    {{ $ticket->messages->count() }}

                    پیام

                </span>

                </div>


                <div class="admin-ticket-messages">

                    @forelse($ticket->messages as $ticketMessage)

                        @php
                            $isStaff =
                                $ticketMessage->sender_type === 'staff';
                        @endphp


                        <article
                            class="
                            admin-ticket-message
                            {{
                                $isStaff
                                    ? 'admin-ticket-message--staff'
                                    : 'admin-ticket-message--user'
                            }}
                        "
                        >

                            <div class="admin-ticket-message__avatar">

                                @if($isStaff)

                                    <i class="fe fe-headphones"></i>

                                @else

                                    {{
                                        mb_substr(
                                            $ticketMessage->user?->name
                                                ?: 'U',
                                            0,
                                            1
                                        )
                                    }}

                                @endif

                            </div>


                            <div class="admin-ticket-message__body">

                                <div class="admin-ticket-message__head">

                                    <div>

                                        <strong>

                                            @if($isStaff)

                                                پشتیبانی APEC

                                            @else

                                                {{
                                                    $ticketMessage->user?->name
                                                    ?: 'کاربر'
                                                }}

                                            @endif

                                        </strong>


                                        <span
                                            class="
                                            admin-ticket-message__role
                                        "
                                        >

                                        {{
                                            $isStaff
                                                ? 'پشتیبانی'
                                                : 'کاربر'
                                        }}

                                    </span>

                                    </div>


                                    <time>

                                        {{
                                            $ticketMessage
                                                ->created_at
                                                ->format('Y-m-d H:i')
                                        }}

                                    </time>

                                </div>


                                <div class="admin-ticket-message__text">

                                    {!!
                                        nl2br(
                                            e($ticketMessage->message)
                                        )
                                    !!}

                                </div>

                            </div>

                        </article>

                    @empty

                        <div class="admin-ticket-empty">

                            <i class="fe fe-message-circle"></i>

                            <strong>
                                پیامی برای این تیکت ثبت نشده است.
                            </strong>

                        </div>

                    @endforelse

                </div>


                {{-- ================================================
                    Reply
                ================================================= --}}

                @if(
                    $statusValue !== 'closed'
                    && Route::has('admin.tickets.reply')
                )

                    <form
                        action="{{ route('admin.tickets.reply', $ticket) }}"
                        method="POST"
                        class="admin-ticket-reply"
                    >

                        @csrf


                        <div class="admin-ticket-reply__header">

                            <div>

                                <h3>
                                    ارسال پاسخ
                                </h3>

                                <p>
                                    پاسخ برای کاربر در پنل کاربری نمایش داده می‌شود.
                                </p>

                            </div>

                        </div>


                        <textarea
                            name="message"
                            rows="6"
                            maxlength="5000"
                            placeholder="پاسخ خود را برای کاربر بنویسید..."
                            required
                        >{{ old('message') }}</textarea>


                        @error('message')

                        <div class="admin-ticket-error">
                            {{ $message }}
                        </div>

                        @enderror


                        <div class="admin-ticket-reply__footer">

                            <button
                                type="submit"
                                class="admin-ticket-btn admin-ticket-btn--primary"
                            >
                                <i class="fe fe-send"></i>

                                ارسال پاسخ
                            </button>

                        </div>

                    </form>

                @elseif($statusValue === 'closed')

                    <div class="admin-ticket-closed">

                        <i class="fe fe-lock"></i>

                        <div>

                            <strong>
                                این تیکت بسته شده است
                            </strong>

                            <span>
                            امکان ارسال پاسخ جدید وجود ندارد.
                        </span>

                        </div>

                    </div>

                @endif

            </section>


            {{-- =====================================================
                Sidebar
            ====================================================== --}}

            <aside class="admin-ticket-sidebar">


                {{-- User --}}
                <div class="admin-ticket-card">

                    <div class="admin-ticket-card__header">

                        <div>

                            <h2>
                                اطلاعات کاربر
                            </h2>

                            <p>
                                صاحب این تیکت
                            </p>

                        </div>

                    </div>


                    <div class="admin-ticket-user">

                        <div class="admin-ticket-user__avatar">

                            {{
                                mb_substr(
                                    $ticket->user?->name ?: 'U',
                                    0,
                                    1
                                )
                            }}

                        </div>


                        <div class="admin-ticket-user__identity">

                            <strong>
                                {{ $ticket->user?->name ?: 'کاربر' }}
                            </strong>

                            <span dir="ltr">
                            {{ $ticket->user?->email ?: '—' }}
                        </span>

                        </div>

                    </div>


                    <div class="admin-ticket-user__info">

                        <div>

                        <span>
                            شناسه کاربر
                        </span>

                            <strong>
                                #{{ $ticket->user_id }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            ایمیل
                        </span>

                            <strong dir="ltr">
                                {{ $ticket->user?->email ?: '—' }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Ticket Info --}}
                <div class="admin-ticket-card">

                    <div class="admin-ticket-card__header">

                        <div>

                            <h2>
                                اطلاعات تیکت
                            </h2>

                            <p>
                                مشخصات درخواست پشتیبانی
                            </p>

                        </div>

                    </div>


                    <div class="admin-ticket-details">

                        <div>

                        <span>
                            شماره تیکت
                        </span>

                            <strong>
                                {{ $ticket->display_number }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            وضعیت
                        </span>

                            <strong>
                                {{ $statusLabel }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            اولویت
                        </span>

                            <strong>
                                {{ $priorityLabel }}
                            </strong>

                        </div>


                        <div>

                        <span>
                            تعداد پیام
                        </span>

                            <strong>
                                {{ $ticket->messages->count() }}
                            </strong>

                        </div>

                    </div>

                </div>


                {{-- Actions --}}
                @if(
                    $statusValue !== 'closed'
                    && Route::has('admin.tickets.close')
                )

                    <div class="admin-ticket-card">

                        <div class="admin-ticket-card__header">

                            <div>

                                <h2>
                                    عملیات
                                </h2>

                            </div>

                        </div>


                        <div class="admin-ticket-actions">

                            <form
                                action="{{ route(
                                'admin.tickets.close',
                                $ticket
                            ) }}"
                                method="POST"
                                onsubmit="
                                return confirm(
                                    'آیا از بستن این تیکت مطمئن هستید؟'
                                );
                            "
                            >

                                @csrf
                                @method('PATCH')


                                <button
                                    type="submit"
                                    class="
                                    admin-ticket-btn
                                    admin-ticket-btn--danger
                                "
                                >

                                    <i class="fe fe-lock"></i>

                                    بستن تیکت

                                </button>

                            </form>

                        </div>

                    </div>

                @endif

            </aside>

        </div>

    </div>

@endsection
