<?php

namespace App\Features\Admin\Company\Projects\DTOs;

use Illuminate\Foundation\Http\FormRequest;
use Morilog\Jalali\Jalalian;

class CompanyProjectData
{
    public function __construct(
        public readonly array $attributes
    ) {
    }

    public static function fromRequest(FormRequest $request): self
    {
        $validated = $request->validated();

        return new self(
            attributes: [
                'company_id' => (int) $validated['company_id'],

                'project_name' => trim(
                    $validated['project_name']
                ),

                'employer' => self::nullableString(
                    $validated['employer'] ?? null
                ),

                'start_date' => self::convertJalaliToGregorian(
                    $validated['start_date'] ?? null
                ),

                'end_date' => self::convertJalaliToGregorian(
                    $validated['end_date'] ?? null
                ),

                'service_description' => self::nullableString(
                    $validated['service_description'] ?? null
                ),
            ]
        );
    }

    private static function convertJalaliToGregorian(
        ?string $date
    ): ?string {
        if (blank($date)) {
            return null;
        }

        return Jalalian::fromFormat('Y/m/d', $date)
            ->toCarbon()
            ->format('Y-m-d');
    }

    private static function nullableString(
        mixed $value
    ): ?string {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }
}
