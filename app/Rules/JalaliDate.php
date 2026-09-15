<?php

namespace App\Rules;

use App\Support\PersianDate;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Throwable;

class JalaliDate implements ValidationRule
{
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        if (blank($value)) {
            return;
        }

        try {
            PersianDate::toGregorian(
                (string) $value
            );
        } catch (Throwable) {
            $fail(
                'تاریخ واردشده معتبر نیست.'
            );
        }
    }
}
