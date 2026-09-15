<?php

namespace App\Features\Membership\Data;

use App\Http\Requests\User\Membership\SaveCompanyIdentityRequest;

final readonly class CompanyIdentityData
{
    public function __construct(
        public ?string $companyShortName,
        public ?string $registeredName,
        public ?string $companyNameEn,
        public ?string $nationality,
        public ?string $companyType,
        public ?string $parentCompanyName,
    ) {}

    public static function fromRequest(SaveCompanyIdentityRequest $request): self
    {
        return new self(
            companyShortName: $request->validated('company_short_name'),
            registeredName: $request->validated('registered_name'),
            companyNameEn: $request->validated('company_name_en'),
            nationality: $request->validated('nationality'),
            companyType: $request->validated('company_type'),
            parentCompanyName: $request->validated('parent_company_name'),
        );
    }
}
