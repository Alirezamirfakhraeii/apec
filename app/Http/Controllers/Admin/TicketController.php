<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Features\Admin\Tickets\Actions\ReplyToTicketAsStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Tickets\ReplyTicketRequest;
use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // لیست تیکت‌های کاربران را نمایش می‌دهد.
    public function index(Request $request): View
    {
        $query = Ticket::query()
            ->with('user')
            ->withCount('messages');

        if ($request->filled('q')) {
            $search = trim($request->string('q')->toString());

            $query->where(function ($query) use ($search) {
                $query
                    ->where('subject', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('priority')) {
            $query->where(
                'priority',
                $request->string('priority')->toString()
            );
        }

        $tickets = $query
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $statuses = TicketStatus::cases();
        $priorities = TicketPriority::cases();

        $stats = [
            'all' => Ticket::query()->count(),

            'waiting' => Ticket::query()
                ->where(
                    'status',
                    TicketStatus::WaitingForSupport
                )
                ->count(),

            'answered' => Ticket::query()
                ->where(
                    'status',
                    TicketStatus::Answered
                )
                ->count(),

            'closed' => Ticket::query()
                ->where(
                    'status',
                    TicketStatus::Closed
                )
                ->count(),
        ];

        return view(
            'back.admin.tickets.index',
            compact(
                'tickets',
                'statuses',
                'priorities',
                'stats'
            )
        );
    }


    // جزئیات یک تیکت را نمایش می‌دهد.
    public function show(Ticket $ticket): View
    {
        $ticket->load([
            'user',
            'messages.user',
        ]);

        return view(
            'back.admin.tickets.show',
            compact('ticket')
        );
    }

    // پاسخ ادمین را روی تیکت ثبت می‌کند.
    public function reply(
        ReplyTicketRequest $request,
        Ticket $ticket,
        ReplyToTicketAsStaffAction $action
    ): RedirectResponse {
        $action->execute(
            $ticket,
            $request->user(),
            $request->validated('message')
        );

        return redirect()
            ->route('admin.tickets.show', $ticket)
            ->with(
                'success',
                'پاسخ با موفقیت برای کاربر ارسال شد.'
            );
    }
}
