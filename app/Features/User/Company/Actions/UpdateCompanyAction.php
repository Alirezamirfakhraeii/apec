<?php

namespace App\Features\User\Company\Actions;


use App\Features\User\Company\DTOs\CompanyProjectData;
use App\Features\User\Company\DTOs\CompanyShareholderData;
use App\Features\User\Company\DTOs\UpdateCompanyData;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

final class UpdateCompanyAction
{
    public function execute(
        Company $company,
        UpdateCompanyData $data
    ): Company {
        $newFiles = [];
        $oldFiles = [];


        try {

            DB::transaction(
                function () use (
                    $company,
                    $data,
                    &$newFiles,
                    &$oldFiles
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Company
                    |--------------------------------------------------------------------------
                    */

                    $attributes =
                        $data->companyAttributes;


                    $this->storeCompanyFiles(
                        company: $company,
                        data: $data,
                        attributes: $attributes,
                        newFiles: $newFiles,
                        oldFiles: $oldFiles,
                    );


                    $company->fill(
                        $attributes
                    );

                    $company->save();


                    /*
                    |--------------------------------------------------------------------------
                    | Activity Fields
                    |--------------------------------------------------------------------------
                    */

                    $company
                        ->activityFields()
                        ->sync(
                            $data->activityFieldIds
                        );


                    /*
                    |--------------------------------------------------------------------------
                    | Shareholders
                    |--------------------------------------------------------------------------
                    */

                    $this->syncShareholders(
                        $company,
                        $data->shareholders
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Projects
                    |--------------------------------------------------------------------------
                    */

                    $this->syncProjects(
                        $company,
                        $data->projects
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Documents
                    |--------------------------------------------------------------------------
                    */

                    $this->syncDocuments(
                        company: $company,
                        documents: $data->documents,
                        newFiles: $newFiles,
                        oldFiles: $oldFiles,
                    );

                },
                3
            );

        } catch (Throwable $exception) {

            /*
            |--------------------------------------------------------------------------
            | Delete newly stored files if DB transaction failed
            |--------------------------------------------------------------------------
            */

            if (! empty($newFiles)) {
                Storage::disk('public')
                    ->delete(
                        array_values(
                            array_unique(
                                $newFiles
                            )
                        )
                    );
            }

            throw $exception;
        }


        /*
        |--------------------------------------------------------------------------
        | Transaction succeeded
        |--------------------------------------------------------------------------
        |
        | حالا می‌توانیم فایل‌های قبلی را حذف کنیم.
        |
        */

        if (! empty($oldFiles)) {

            Storage::disk('public')
                ->delete(
                    array_values(
                        array_unique(
                            array_filter(
                                $oldFiles
                            )
                        )
                    )
                );
        }


        return $company->fresh([
            'activityFields',
            'projects',
            'shareholders',
            'documents',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Company Files
    |--------------------------------------------------------------------------
    */

    private function storeCompanyFiles(
        Company $company,
        UpdateCompanyData $data,
        array &$attributes,
        array &$newFiles,
        array &$oldFiles,
    ): void {

        /*
        |--------------------------------------------------------------------------
        | Logo
        |--------------------------------------------------------------------------
        */

        if (
            $data->logo instanceof UploadedFile
        ) {

            $path = $data->logo->store(
                "companies/{$company->id}/logo",
                'public'
            );


            $newFiles[] = $path;


            if ($company->logo) {
                $oldFiles[] = $company->logo;
            }


            $attributes['logo'] = $path;
        }


        /*
        |--------------------------------------------------------------------------
        | Membership Card
        |--------------------------------------------------------------------------
        */

        if (
            $data->membershipCard
            instanceof UploadedFile
        ) {

            $path =
                $data->membershipCard->store(
                    "companies/{$company->id}/membership",
                    'public'
                );


            $newFiles[] = $path;


            if ($company->membership_card) {
                $oldFiles[] =
                    $company->membership_card;
            }


            $attributes[
            'membership_card'
            ] = $path;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Shareholders
    |--------------------------------------------------------------------------
    */

    private function syncShareholders(
        Company $company,
        array $rows
    ): void {
        $submittedIds = collect($rows)
            ->map(
                fn (
                    CompanyShareholderData $row
                ) => $row->id
            )
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();


        $existing = $company
            ->shareholders()
            ->get()
            ->keyBy('id');


        $this->ensureIdsBelongToCompany(
            existing: $existing,
            submittedIds: $submittedIds,
            field: 'shareholders'
        );


        /*
        |--------------------------------------------------------------------------
        | Delete removed shareholders
        |--------------------------------------------------------------------------
        */

        $deleteQuery =
            $company->shareholders();


        if (! empty($submittedIds)) {

            $deleteQuery
                ->whereNotIn(
                    'id',
                    $submittedIds
                )
                ->delete();

        } else {

            $deleteQuery->delete();
        }


        /*
        |--------------------------------------------------------------------------
        | Update / Create
        |--------------------------------------------------------------------------
        */

        foreach (
            $rows
            as $sortOrder => $row
        ) {

            /** @var CompanyShareholderData $row */

            $attributes = [

                'full_name' =>
                    $row->fullName,

                'ownership_percentage' =>
                    $row->ownershipPercentage,

                'sort_order' =>
                    $sortOrder,
            ];


            if ($row->id) {

                $existing
                    ->get($row->id)
                    ->update($attributes);

                continue;
            }


            $company
                ->shareholders()
                ->create($attributes);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */

    private function syncProjects(
        Company $company,
        array $rows
    ): void {
        $submittedIds = collect($rows)
            ->map(
                fn (
                    CompanyProjectData $row
                ) => $row->id
            )
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();


        $existing = $company
            ->projects()
            ->get()
            ->keyBy('id');


        $this->ensureIdsBelongToCompany(
            existing: $existing,
            submittedIds: $submittedIds,
            field: 'projects'
        );


        /*
        |--------------------------------------------------------------------------
        | Delete removed projects
        |--------------------------------------------------------------------------
        */

        $deleteQuery =
            $company->projects();


        if (! empty($submittedIds)) {

            $deleteQuery
                ->whereNotIn(
                    'id',
                    $submittedIds
                )
                ->delete();

        } else {

            $deleteQuery->delete();
        }


        /*
        |--------------------------------------------------------------------------
        | Update / Create
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $row) {

            /** @var CompanyProjectData $row */

            $attributes = [

                'project_name' =>
                    $row->projectName,

                'employer' =>
                    $row->employer,

                'start_date' =>
                    $row->startDate,

                'end_date' =>
                    $row->endDate,

                'service_description' =>
                    $row->serviceDescription,
            ];


            if ($row->id) {

                $existing
                    ->get($row->id)
                    ->update($attributes);

                continue;
            }


            $company
                ->projects()
                ->create($attributes);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Documents
    |--------------------------------------------------------------------------
    */

    private function syncDocuments(
        Company $company,
        array $documents,
        array &$newFiles,
        array &$oldFiles,
    ): void {

        foreach (
            $documents
            as $type => $file
        ) {

            /** @var UploadedFile $file */

            $currentDocument =
                $company
                    ->documents()
                    ->where(
                        'type',
                        $type
                    )
                    ->first();


            $path = $file->store(
                "companies/{$company->id}/documents",
                'public'
            );


            $newFiles[] = $path;


            if ($currentDocument?->path) {

                $oldFiles[] =
                    $currentDocument->path;
            }


            $company
                ->documents()
                ->updateOrCreate(
                    [
                        'type' => $type,
                    ],
                    [
                        'path' => $path,

                        'original_name' =>
                            $file
                                ->getClientOriginalName(),

                        'mime_type' =>
                            $file
                                ->getClientMimeType(),

                        'size' =>
                            $file->getSize(),
                    ]
                );
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Security
    |--------------------------------------------------------------------------
    |
    | کاربر نباید بتواند با دستکاری hidden id،
    | Project یا Shareholder متعلق به شرکت دیگری را Update کند.
    |
    */

    private function ensureIdsBelongToCompany(
        Collection $existing,
        array $submittedIds,
        string $field
    ): void {
        if (empty($submittedIds)) {
            return;
        }


        $existingIds = $existing
            ->keys()
            ->map(fn ($id) => (int) $id)
            ->all();


        $invalidIds = array_diff(
            $submittedIds,
            $existingIds
        );


        if (! empty($invalidIds)) {

            throw ValidationException::withMessages([
                $field =>
                    'اطلاعات ارسال‌شده معتبر نیست.',
            ]);
        }
    }
}
