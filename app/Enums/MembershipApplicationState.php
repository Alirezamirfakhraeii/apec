<?php
namespace App\Enums;
enum MembershipApplicationState: string
{
    case Draft='draft';
    case Submitted='submitted';
    case InReview='in_review';
    case NeedsCorrection='needs_correction';
    case Rejected='rejected';
    case Approved='approved';
    public function label(): string
    {
        return match($this){
            self::Draft=>'پیش‌نویس', self::Submitted=>'ارسال شده', self::InReview=>'در حال بررسی',
            self::NeedsCorrection=>'نیازمند اصلاح', self::Rejected=>'رد شده', self::Approved=>'تأیید شده',
        };
    }
}
