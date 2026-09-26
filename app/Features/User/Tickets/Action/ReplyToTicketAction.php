<?php

namespace App\Features\User\Tickets\Action;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ReplyToTicketAction
{
    // پاسخ کاربر را ثبت می‌کند و تیکت را دوباره در صف پشتیبانی قرار می‌دهد.
    public function execute(Ticket $ticket, User $user, string $message): Ticket
    {
        return DB::transaction(function () use ($ticket, $user, $message) {
            $lockedTicket = Ticket::query()->lockForUpdate()->findOrFail($ticket->id);

            abort_if($lockedTicket->status === 'closed', 422, 'این تیکت بسته شده است.');

            $lockedTicket->messages()->create([
                'user_id' => $user->id,
                'sender_type' => 'user',
                'message' => trim($message),
            ]);

            $lockedTicket->update([
                'status' => 'waiting_for_support',
                'last_message_at' => now(),
            ]);

            return $lockedTicket->fresh();
        });
    }
}
