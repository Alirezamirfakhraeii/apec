@extends('front.user.layouts.app')

@section('title', 'مشاهده تیکت')
@section('page_title', 'گفتگوی پشتیبانی')
@section('page_description', 'پیام‌های این درخواست را مشاهده و پیگیری کنید.')

@push('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/user/tickets/tickets.css') }}"
    >
@endpush

@section('content')

    <div class="ticket-page">

        <a
            href="{{ route('user.tickets.index') }}"
            class="ticket-back"
        >
            <i class="fa fa-arrow-right"></i>
            بازگشت به تیکت‌ها
        </a>


        <section class="ticket-card">

            {{-- Header --}}
            <div class="ticket-thread__header">

                <div>

                    <small>
                        {{ $ticket->display_number }}
                    </small>

                    <h2>
                        {{ $ticket->subject }}
                    </h2>

                </div>


                <span
                    class="
                    ticket-status
                    ticket-status--{{ $ticket->status->value }}
                "
                >
                {{ $ticket->status->label() }}
            </span>

            </div>


            {{-- Messages --}}
            <div class="ticket-messages">

                @foreach($ticket->messages as $ticketMessage)

                    <article
                        class="
                        ticket-message
                        {{
                            $ticketMessage->sender_type === 'staff'
                                ? 'ticket-message--staff'
                                : ''
                        }}
                    "
                    >

                        <div class="ticket-message__avatar">

                            @if($ticketMessage->sender_type === 'staff')

                                پ

                            @else

                                {{
                                    mb_substr(
                                        $ticketMessage->user?->name ?: 'U',
                                        0,
                                        1
                                    )
                                }}

                            @endif

                        </div>


                        <div class="ticket-message__bubble">

                            <div class="ticket-message__head">

                                <strong>

                                    {{
                                        $ticketMessage->sender_type === 'staff'
                                            ? 'پشتیبانی APEC'
                                            : ($ticketMessage->user?->name ?: 'شما')
                                    }}

                                </strong>


                                <span>
                                {{ $ticketMessage->created_at->format('Y-m-d H:i') }}
                            </span>

                            </div>


                            <div class="ticket-message__text">

                                {!! nl2br(e($ticketMessage->message)) !!}

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- Delete Ticket --}}
            <div class="ticket-thread__actions">

                <form
                    action="{{ route('user.tickets.destroy', $ticket) }}"
                    method="POST"
                    onsubmit="return confirm('آیا از حذف این تیکت مطمئن هستید؟');"
                >

                    @csrf
                    @method('DELETE')


                    <button
                        type="submit"
                        class="ticket-btn ticket-btn--danger"
                    >

                        <i class="fa fa-trash-o"></i>

                        حذف تیکت

                    </button>

                </form>

            </div>


            {{-- Reply --}}
            @if(
                $ticket->status
                !== \App\Enums\TicketStatus::Closed
            )

                <form
                    action="{{ route('user.tickets.reply', $ticket) }}"
                    method="POST"
                    class="ticket-reply"
                >

                    @csrf


                    <label for="message">
                        پاسخ شما
                    </label>


                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        maxlength="5000"
                        required
                    >{{ old('message') }}</textarea>


                    @error('message')

                    <small class="ticket-error">
                        {{ $message }}
                    </small>

                    @enderror


                    <div class="ticket-form__footer">

                        <button
                            type="submit"
                            class="ticket-btn ticket-btn--primary"
                        >

                            <i class="fa fa-paper-plane-o"></i>

                            ارسال پاسخ

                        </button>

                    </div>

                </form>

            @else

                <div class="ticket-closed">

                    <i class="fa fa-lock"></i>

                    این تیکت بسته شده است.

                </div>

            @endif

        </section>

    </div>

@endsection
