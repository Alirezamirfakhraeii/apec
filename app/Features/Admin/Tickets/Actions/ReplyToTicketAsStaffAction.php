<?php

namespace App\Features\Admin\Tickets\Actions;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReplyToTicketAsStaffAction
{
    // پاسخ پشتیبانی را ثبت و وضعیت تیکت را پاسخ داده شده می‌کند.
    public function execute(
        Ticket $ticket,
        User $staff,
        string $message
    ): Ticket {
        return DB::transaction(function () use (
            $ticket,
            $staff,
            $message
        ) {
            $lockedTicket = Ticket::query()
                ->lockForUpdate()
                ->findOrFail($ticket->id);

            if ($lockedTicket->status === TicketStatus::Closed) {
                throw ValidationException::withMessages([
                    'message' => 'این تیکت بسته شده و امکان پاسخ وجود ندارد.',
                ]);
            }

            $lockedTicket->messages()->create([
                'user_id' => $staff->id,
                'sender_type' => 'staff',
                'message' => trim($message),
            ]);

            $lockedTicket->update([
                'status' => TicketStatus::Answered,
                'last_message_at' => now(),
            ]);

            return $lockedTicket->fresh();
        });
    }
}
