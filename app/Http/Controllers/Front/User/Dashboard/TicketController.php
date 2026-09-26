<?php

namespace App\Http\Controllers\Front\User\Dashboard;

use App\Features\User\Tickets\Action\CreateTicketAction;
use App\Features\User\Tickets\Action\ReplyToTicketAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Ticket\ReplyTicketRequest;
use App\Http\Requests\User\Ticket\StoreTicketRequest;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    // تیکت‌های کاربر جاری.
    public function index(Request $request): View
    {
        $tickets = Ticket::query()
            ->where('user_id', $request->user()->id)
            ->withCount('messages')
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('front.user.tickets.index', compact('tickets'));
    }

    // فرم ثبت تیکت.
    public function create(): View
    {
        return view('front.user.tickets.create');
    }

    // ذخیره تیکت جدید.
    public function store(StoreTicketRequest $request, CreateTicketAction $action): RedirectResponse
    {
        $ticket = $action->execute($request->user(), $request->validated());

        return redirect()
            ->route('user.tickets.show', $ticket)
            ->with('success', 'تیکت شما با موفقیت ثبت شد.');
    }

    // نمایش تیکت متعلق به کاربر جاری.
    public function show(Request $request, Ticket $ticket): View
    {
        abort_unless((int) $ticket->user_id === (int) $request->user()->id, 403);

        $ticket->load([
            'messages' => fn ($query) => $query->with('user')->oldest('id'),
        ]);

        return view('front.user.tickets.show', compact('ticket'));
    }

    // پاسخ کاربر روی تیکت خودش.
    public function reply(
        ReplyTicketRequest $request,
        Ticket $ticket,
        ReplyToTicketAction $action
    ): RedirectResponse {
        abort_unless((int) $ticket->user_id === (int) $request->user()->id, 403);
        abort_if($ticket->status === 'closed', 403);

        $action->execute($ticket, $request->user(), $request->validated('message'));

        return redirect()
            ->route('user.tickets.show', $ticket)
            ->with('success', 'پاسخ شما ثبت شد.');
    }

    // تیکت متعلق به کاربر را حذف می‌کند.
    public function destroy(Ticket $ticket): RedirectResponse
    {
        Gate::authorize('delete', $ticket);

        $ticket->delete();

        return redirect()
            ->route('user.tickets.index')
            ->with(
                'success',
                'تیکت با موفقیت حذف شد.'
            );
    }
}
