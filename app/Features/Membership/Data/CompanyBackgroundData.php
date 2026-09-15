<?php

namespace App\Features\Membership\Data;

use App\Http\Requests\User\Membership\SaveCompanyBackgroundRequest;

final readonly class CompanyBackgroundData
{
    public function __construct(
        public ?int $activityHistoryYears,
        public ?string $oilGasPetroSpecialty,
        public ?bool $isChamberMember,
    ) {}

    public static function fromRequest(SaveCompanyBackgroundRequest $request): self
    {
        $isMember = $request->validated('is_chamber_member');

        return new self(
            activityHistoryYears: $request->filled('activity_history_years')
                ? (int) $request->validated('activity_history_years')
                : null,
            oilGasPetroSpecialty: $request->validated('oil_gas_petro_specialty'),
            isChamberMember: $isMember === null ? null : (bool) $isMember,
        );
    }
}
