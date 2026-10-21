<?php

namespace App\Features\User\Company\DTOs;

final readonly class CompanyProjectData
{
    public function __construct(
        public ?int $id,
        public string $projectName,
        public ?string $employer,
        public ?string $startDate,
        public ?string $endDate,
        public ?string $serviceDescription,
    ) {
    }


    public static function fromArray(
        array $data
    ): ?self {
        $projectName = trim(
            (string) ($data['project_name'] ?? '')
        );

        $employer = trim(
            (string) ($data['employer'] ?? '')
        );

        $startDate =
            $data['start_date']
            ?? null;

        $endDate =
            $data['end_date']
            ?? null;

        $serviceDescription = trim(
            (string) (
                $data['service_description']
                ?? ''
            )
        );


        /*
        |--------------------------------------------------------------------------
        | Empty row
        |--------------------------------------------------------------------------
        */

        if (
            $projectName === ''
            &&
            $employer === ''
            &&
            blank($startDate)
            &&
            blank($endDate)
            &&
            $serviceDescription === ''
        ) {
            return null;
        }


        return new self(
            id: ! empty($data['id'])
                ? (int) $data['id']
                : null,

            projectName: $projectName,

            employer:
            $employer !== ''
                ? $employer
                : null,

            startDate:
            filled($startDate)
                ? (string) $startDate
                : null,

            endDate:
            filled($endDate)
                ? (string) $endDate
                : null,

            serviceDescription:
            $serviceDescription !== ''
                ? $serviceDescription
                : null,
        );
    }
}
