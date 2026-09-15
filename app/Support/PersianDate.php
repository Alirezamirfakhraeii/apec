<?php

namespace App\Support;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Morilog\Jalali\Jalalian;

final class PersianDate
{
    public static function toGregorian(?string $date): ?string
    {
        if (blank($date)) {
            return null;
        }

        $date = self::toEnglishDigits($date);

        $date = str_replace('-', '/', $date);

        return Jalalian::fromFormat('Y/m/d', $date)
            ->toCarbon()
            ->format('Y-m-d');
    }

    public static function fromGregorian(
        CarbonInterface|string|null $date
    ): ?string {
        if (blank($date)) {
            return null;
        }

        $carbon = $date instanceof CarbonInterface
            ? $date
            : Carbon::parse($date);

        $jalali = Jalalian::fromCarbon($carbon)
            ->format('Y/m/d');

        return self::toPersianDigits($jalali);
    }

    public static function toEnglishDigits(string $value): string
    {
        return strtr($value, [
            '۰' => '0',
            '۱' => '1',
            '۲' => '2',
            '۳' => '3',
            '۴' => '4',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',

            '٠' => '0',
            '١' => '1',
            '٢' => '2',
            '٣' => '3',
            '٤' => '4',
            '٥' => '5',
            '٦' => '6',
            '٧' => '7',
            '٨' => '8',
            '٩' => '9',
        ]);
    }

    public static function toPersianDigits(string $value): string
    {
        return strtr($value, [
            '0' => '۰',
            '1' => '۱',
            '2' => '۲',
            '3' => '۳',
            '4' => '۴',
            '5' => '۵',
            '6' => '۶',
            '7' => '۷',
            '8' => '۸',
            '9' => '۹',
        ]);
    }
}
