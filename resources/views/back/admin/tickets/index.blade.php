@extends('back.admin.layouts.master')

@section('title', 'تیکت‌های پشتیبانی')

@section('content')

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                <h4 class="mb-1">
                    تیکت‌های پشتیبانی
                </h4>

                <p class="text-muted mb-0">
                    مشاهده و مدیریت درخواست‌های پشتیبانی کاربران
                </p>

            </div>

        </div>


        {{-- Stats --}}
        <div class="row mb-4">

            <div class="col-xl-3 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <small class="text-muted">
                            کل تیکت‌ها
                        </small>

                        <h4 class="mt-2 mb-0">
                            {{ $stats['all'] }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <small class="text-muted">
                            در انتظار پاسخ
                        </small>

                        <h4 class="mt-2 mb-0 text-warning">
                            {{ $stats['waiting'] }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <small class="text-muted">
                            پاسخ داده شده
                        </small>

                        <h4 class="mt-2 mb-0 text-primary">
                            {{ $stats['answered'] }}
                        </h4>

                    </div>

                </div>

            </div>


            <div class="col-xl-3 col-md-6 mb-3">

                <div class="card shadow-sm border-0">

                    <div class="card-body">

                        <small class="text-muted">
                            بسته شده
                        </small>

                        <h4 class="mt-2 mb-0 text-secondary">
                            {{ $stats['closed'] }}
                        </h4>

                    </div>

                </div>

            </div>

        </div>


        {{-- Filter --}}
        <div class="card shadow-sm border-0 mb-4">

            <div class="card-body">

                <form
                    action="{{ route('admin.tickets.index') }}"
                    method="GET"
                >

                    <div class="row align-items-end">

                        {{-- Search --}}
                        <div class="col-lg-5 mb-3">

                            <label class="form-label">
                                جستجو
                            </label>

                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                class="form-control"
                                placeholder="موضوع، نام، ایمیل یا شماره تیکت"
                            >

                        </div>


                        {{-- Status --}}
                        <div class="col-lg-3 mb-3">

                            <label class="form-label">
                                وضعیت
                            </label>

                            <select
                                name="status"
                                class="form-control"
                            >

                                <option value="">
                                    همه وضعیت‌ها
                                </option>

                                @foreach($statuses as $status)

                                    <option
                                        value="{{ $status->value }}"
                                        @selected(
                                            request('status')
                                            === $status->value
                                        )
                                    >
                                        {{ $status->label() }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Priority --}}
                        <div class="col-lg-2 mb-3">

                            <label class="form-label">
                                اولویت
                            </label>

                            <select
                                name="priority"
                                class="form-control"
                            >

                                <option value="">
                                    همه
                                </option>

                                @foreach($priorities as $priority)

                                    <option
                                        value="{{ $priority->value }}"
                                        @selected(
                                            request('priority')
                                            === $priority->value
                                        )
                                    >
                                        {{ $priority->label() }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-lg-2 mb-3">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                جستجو
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>


        {{-- Tickets --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <strong>
                    لیست تیکت‌ها
                </strong>

            </div>


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead>

                    <tr>

                        <th>
                            شماره
                        </th>

                        <th>
                            کاربر
                        </th>

                        <th>
                            موضوع
                        </th>

                        <th>
                            اولویت
                        </th>

                        <th>
                            وضعیت
                        </th>

                        <th>
                            پیام‌ها
                        </th>

                        <th>
                            آخرین فعالیت
                        </th>

                        <th></th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse($tickets as $ticket)

                        <tr>

                            {{-- Number --}}
                            <td>

                                <strong>
                                    {{ $ticket->display_number }}
                                </strong>

                            </td>


                            {{-- User --}}
                            <td>

                                <div>

                                    <strong>
                                        {{ $ticket->user?->name ?: '—' }}
                                    </strong>

                                    <small
                                        class="d-block text-muted"
                                        dir="ltr"
                                    >
                                        {{ $ticket->user?->email }}
                                    </small>

                                </div>

                            </td>


                            {{-- Subject --}}
                            <td>

                                {{ $ticket->subject }}

                            </td>


                            {{-- Priority --}}
                            <td>

                                @php
                                    $priorityClass = match(
                                        $ticket->priority
                                    ) {
                                        \App\Enums\TicketPriority::High
                                            => 'badge-danger',

                                        \App\Enums\TicketPriority::Low
                                            => 'badge-secondary',

                                        default
                                            => 'badge-info',
                                    };
                                @endphp

                                <span
                                    class="badge {{ $priorityClass }}"
                                >
                                    {{ $ticket->priority->label() }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td>

                                @php
                                    $statusClass = match(
                                        $ticket->status
                                    ) {
                                        \App\Enums\TicketStatus::WaitingForSupport
                                            => 'badge-warning',

                                        \App\Enums\TicketStatus::Answered
                                            => 'badge-primary',

                                        \App\Enums\TicketStatus::Closed
                                            => 'badge-secondary',
                                    };
                                @endphp

                                <span
                                    class="badge {{ $statusClass }}"
                                >
                                    {{ $ticket->status->label() }}
                                </span>

                            </td>


                            {{-- Messages --}}
                            <td>

                                {{ $ticket->messages_count }}

                            </td>


                            {{-- Last Message --}}
                            <td>

                                @if($ticket->last_message_at)

                                    {{ $ticket->last_message_at->format(
                                        'Y-m-d H:i'
                                    ) }}

                                @else

                                    —

                                @endif

                            </td>


                            {{-- Action --}}
                            <td>

                                <a
                                    href="{{
                                        route(
                                            'admin.tickets.show',
                                            $ticket
                                        )
                                    }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    مشاهده
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center py-5 text-muted"
                            >
                                تیکتی پیدا نشد.
                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            @if($tickets->hasPages())

                <div class="card-footer bg-white">

                    {{ $tickets->links() }}

                </div>

            @endif

        </div>

    </div>

@endsection
