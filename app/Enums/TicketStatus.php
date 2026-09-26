<?php

namespace App\Enums;

enum TicketStatus: string
{
    case WaitingForSupport = 'waiting_for_support';
    case Answered = 'answered';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::WaitingForSupport => 'در انتظار پاسخ',
            self::Answered => 'پاسخ داده شده',
            self::Closed => 'بسته شده',
        };
    }
}
