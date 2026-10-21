<?php

namespace App\Features\User\Company\DTOs;

use App\Enums\MembershipDocumentType;
use App\Http\Requests\User\Company\UpdateCompanyRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

final readonly class UpdateCompanyData
{
    public function __construct(

        public array $companyAttributes,

        public ?UploadedFile $logo,

        public ?UploadedFile $membershipCard,

        public array $activityFieldIds,

        /** @var CompanyShareholderData[] */
        public array $shareholders,

        /** @var CompanyProjectData[] */
        public array $projects,

        /** @var array<string, UploadedFile> */
        public array $documents,
    ) {
    }


    public static function fromRequest(
        UpdateCompanyRequest $request
    ): self {
        $validated = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | Company
        |--------------------------------------------------------------------------
        */

        $companyAttributes = Arr::except(
            $validated['company'] ?? [],
            [
                'logo',
                'membership_card',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | Activity Fields
        |--------------------------------------------------------------------------
        */

        $activityFieldIds = collect(
            $validated['activity_fields']
            ?? []
        )
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Shareholders
        |--------------------------------------------------------------------------
        */

        $shareholders = collect(
            $validated['shareholders']
            ?? []
        )
            ->map(
                fn (array $row) =>
                CompanyShareholderData::fromArray(
                    $row
                )
            )
            ->filter()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Projects
        |--------------------------------------------------------------------------
        */

        $projects = collect(
            $validated['projects']
            ?? []
        )
            ->map(
                fn (array $row) =>
                CompanyProjectData::fromArray(
                    $row
                )
            )
            ->filter()
            ->values()
            ->all();


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        $documents = [];

        foreach (
            MembershipDocumentType::cases()
            as $type
        ) {

            $file = $request->file(
                'documents.' . $type->value
            );

            if (
                $file instanceof UploadedFile
            ) {
                $documents[
                $type->value
                ] = $file;
            }
        }


        return new self(

            companyAttributes:
            $companyAttributes,

            logo:
            $request->file(
                'company.logo'
            ),

            membershipCard:
            $request->file(
                'company.membership_card'
            ),

            activityFieldIds:
            $activityFieldIds,

            shareholders:
            $shareholders,

            projects:
            $projects,

            documents:
            $documents,
        );
    }
}
