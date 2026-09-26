<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'status',
        'priority',
        'last_message_at',
        'closed_at',
    ];

    // تبدیل مقادیر دیتابیس به Enum و DateTime.
    protected function casts(): array
    {
        return [
            'status' => TicketStatus::class,
            'priority' => TicketPriority::class,
            'last_message_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    // کاربر صاحب تیکت.
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // پیام‌های تیکت.
    public function messages(): HasMany
    {
        return $this->hasMany(TicketMessage::class);
    }

    // شماره نمایشی تیکت.
    public function getDisplayNumberAttribute(): string
    {
        return 'TKT-' . str_pad(
                (string) $this->id,
                6,
                '0',
                STR_PAD_LEFT
            );
    }
}
