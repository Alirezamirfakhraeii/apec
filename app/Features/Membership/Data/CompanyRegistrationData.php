<?php

namespace App\Features\Membership\Data;

use App\Http\Requests\User\Membership\SaveCompanyRegistrationRequest;
use App\Support\PersianDate;

final readonly class CompanyRegistrationData
{
    public function __construct(
        public ?string $registrationDate,
        public ?string $registrationNumber,
        public ?string $registrationPlace,
        public ?string $nationalId,
        public int|string|null $registeredCapitalIrr,
        public ?string $referenceGazetteDate,
    ) {}

    public static function fromRequest(SaveCompanyRegistrationRequest $request): self
    {
        return new self(
            registrationDate: PersianDate::toGregorian($request->validated('registration_date')),
            registrationNumber: $request->validated('registration_number'),
            registrationPlace: $request->validated('registration_place'),
            nationalId: $request->validated('national_id'),
            registeredCapitalIrr: $request->validated('registered_capital_irr'),
            referenceGazetteDate: PersianDate::toGregorian($request->validated('reference_gazette_date')),
        );
    }
}
