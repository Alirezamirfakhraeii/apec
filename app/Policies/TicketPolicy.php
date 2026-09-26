<?php

namespace App\Policies;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    // فقط صاحب تیکت می‌تواند آن را مشاهده کند.
    public function view(User $user, Ticket $ticket): bool
    {
        return (int) $ticket->user_id === (int) $user->id;
    }

    // فقط صاحب تیکت و تا قبل از بسته شدن می‌تواند پاسخ بدهد.
    public function reply(User $user, Ticket $ticket): bool
    {
        return (int) $ticket->user_id === (int) $user->id
            && $ticket->status !== TicketStatus::Closed;
    }

    // فقط صاحب تیکت می‌تواند آن را حذف کند.
    public function delete(User $user, Ticket $ticket): bool
    {
        return (int) $ticket->user_id === (int) $user->id;
    }
}
