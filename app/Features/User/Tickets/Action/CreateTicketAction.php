<?php

namespace App\Features\User\Tickets\Action;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{
    // تیکت و اولین پیام را در یک تراکنش ایجاد می‌کند.
    public function execute(User $user, array $data): Ticket
    {
        return DB::transaction(function () use ($user, $data) {
            $ticket = Ticket::create([
                'user_id' => $user->id,
                'subject' => trim($data['subject']),
                'priority' => $data['priority'],
                'status' => 'waiting_for_support',
                'last_message_at' => now(),
            ]);

            $ticket->messages()->create([
                'user_id' => $user->id,
                'sender_type' => 'user',
                'message' => trim($data['message']),
            ]);

            return $ticket->fresh();
        });
    }
}
