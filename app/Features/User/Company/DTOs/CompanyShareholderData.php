<?php

namespace App\Features\User\Company\DTOs;


final readonly class CompanyShareholderData
{
    public function __construct(
        public ?int $id,
        public string $fullName,
        public ?string $ownershipPercentage,
    ) {
    }


    public static function fromArray(
        array $data
    ): ?self {
        $fullName = trim(
            (string) ($data['full_name'] ?? '')
        );

        $ownershipPercentage =
            $data['ownership_percentage']
            ?? null;


        /*
        |--------------------------------------------------------------------------
        | Empty row
        |--------------------------------------------------------------------------
        */

        if (
            $fullName === ''
            &&
            (
                $ownershipPercentage === null
                ||
                $ownershipPercentage === ''
            )
        ) {
            return null;
        }


        return new self(
            id: ! empty($data['id'])
                ? (int) $data['id']
                : null,

            fullName: $fullName,

            ownershipPercentage:
            $ownershipPercentage === ''
                ? null
                : (
            $ownershipPercentage !== null
                ? (string) $ownershipPercentage
                : null
            ),
        );
    }
}
