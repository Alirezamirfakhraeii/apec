<?php

namespace App\Enums;

enum ApplicationReviewDecision: string
{
    case Approved = 'approved';

    case Rejected = 'rejected';

    case NeedsCorrection = 'needs_correction';

    case Forwarded = 'forwarded';

    case StatusChanged = 'status_changed';

    case Edited = 'edited';


    public function label(): string
    {
        return match ($this) {

            self::Approved =>
            'تأیید',

            self::Rejected =>
            'رد',

            self::NeedsCorrection =>
            'نیازمند اصلاح',

            self::Forwarded =>
            'ارجاع پرونده',

            self::StatusChanged =>
            'اصلاح وضعیت توسط مدیر',

            self::Edited =>
            'ویرایش اطلاعات پرونده',

        };
    }
}
