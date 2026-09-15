<?php

namespace App\Features\Membership\Actions;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipDocumentType;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Models\WorkflowStage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class UpdateMembershipApplicationAction
{
    /**
     * فایل‌های جدیدی که طی عملیات ساخته می‌شوند.
     *
     * اگر Transaction شکست بخورد،
     * این فایل‌ها باید پاک شوند.
     */
    private array $newDocumentPaths = [];

    /**
     * فایل‌های قبلی که بعد از Commit موفق
     * باید پاک شوند.
     */
    private array $oldDocumentPaths = [];


    /**
     * Update membership application.
     */
    public function execute(
        MembershipApplication $application,
        array $data,
        User $actor
    ): MembershipApplication {
        $this->newDocumentPaths = [];
        $this->oldDocumentPaths = [];

        try {
            $result = DB::transaction(function () use (
                $application,
                $data,
                $actor
            ) {
                /*
                |--------------------------------------------------------------------------
                | Lock Application
                |--------------------------------------------------------------------------
                */

                $application = MembershipApplication::query()
                    ->with([
                        'companyProfile',
                        'shareholders',
                        'documents',
                        'currentStage',
                        'returnStage',
                    ])
                    ->lockForUpdate()
                    ->findOrFail($application->id);


                /*
                |--------------------------------------------------------------------------
                | Changed Sections
                |--------------------------------------------------------------------------
                */

                $changedSections = [];


                /*
                |--------------------------------------------------------------------------
                | Update Application Intake Information
                |--------------------------------------------------------------------------
                */

                $applicationData = Arr::only(
                    $data,
                    [
                        'intake_company_name',
                        'representative_name',
                        'representative_mobile',
                    ]
                );

                $application->fill($applicationData);

                if ($application->isDirty()) {
                    $application->save();

                    $changedSections[] =
                        'اطلاعات اولیه درخواست';
                }


                /*
                |--------------------------------------------------------------------------
                | Update Company Profile
                |--------------------------------------------------------------------------
                */

                $profileData = Arr::only(
                    $data['profile'] ?? [],
                    [
                        /*
                        |--------------------------------------------------------------------------
                        | Identity
                        |--------------------------------------------------------------------------
                        */

                        'registered_name',
                        'company_short_name',
                        'company_name_en',
                        'nationality',
                        'parent_company_name',
                        'company_type',

                        /*
                        |--------------------------------------------------------------------------
                        | Registration
                        |--------------------------------------------------------------------------
                        */

                        'registration_date',
                        'registration_number',
                        'registration_place',
                        'national_id',
                        'registered_capital_irr',
                        'reference_gazette_date',

                        /*
                        |--------------------------------------------------------------------------
                        | Contact Information
                        |--------------------------------------------------------------------------
                        */

                        'phone',
                        'fax',
                        'email',
                        'website',
                        'address',

                        /*
                        |--------------------------------------------------------------------------
                        | CEO
                        |--------------------------------------------------------------------------
                        */

                        'ceo_name',
                        'ceo_mobile',
                        'ceo_email',

                        /*
                        |--------------------------------------------------------------------------
                        | Chairman
                        |--------------------------------------------------------------------------
                        */

                        'chairman_name',
                        'chairman_mobile',
                        'chairman_email',

                        /*
                        |--------------------------------------------------------------------------
                        | Association Contact
                        |--------------------------------------------------------------------------
                        */

                        'association_contact_name',
                        'association_contact_position',
                        'association_contact_mobile',
                        'association_contact_email',

                        /*
                        |--------------------------------------------------------------------------
                        | Commercial Card
                        |--------------------------------------------------------------------------
                        */

                        'has_valid_commercial_card',
                        'commercial_card_valid_until',

                        /*
                        |--------------------------------------------------------------------------
                        | Chamber Membership
                        |--------------------------------------------------------------------------
                        */

                        'has_valid_chamber_membership_card',
                        'chamber_membership_valid_until',
                        'chamber_province',
                        'is_chamber_member',

                        /*
                        |--------------------------------------------------------------------------
                        | Activity
                        |--------------------------------------------------------------------------
                        */

                        'activity_experience_years',
                        'oil_gas_petchem_specialty',

                        'activity_design_consulting',
                        'activity_construction_installation',
                        'activity_epc',
                        'activity_mc',
                        'activity_manufacturing',

                        'activity_type',
                        'membership_type',
                        'association_committees',
                    ]
                );

                $profile = $application->companyProfile;

                if (! $profile) {
                    $application
                        ->companyProfile()
                        ->create($profileData);

                    $changedSections[] =
                        'مشخصات شرکت';
                } else {
                    $profile->fill($profileData);

                    if ($profile->isDirty()) {
                        $profile->save();

                        $changedSections[] =
                            'مشخصات شرکت';
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Sync Shareholders
                |--------------------------------------------------------------------------
                */

                if (
                    array_key_exists(
                        'shareholders',
                        $data
                    )
                ) {
                    $shareholdersChanged =
                        $this->syncShareholders(
                            $application,
                            $data['shareholders'] ?? []
                        );

                    if ($shareholdersChanged) {
                        $changedSections[] =
                            'اطلاعات سهامداران';
                    }
                }


                /*
|--------------------------------------------------------------------------
| Sync Activity Fields
|--------------------------------------------------------------------------
*/

                $activityFieldsChanged =
                    $this->syncActivityFields(
                        $application,
                        $data['activity_fields'] ?? []
                    );

                if ($activityFieldsChanged) {
                    $changedSections[] =
                        'حوزه‌ها و صنایع فعالیت';
                }



                /*
                |--------------------------------------------------------------------------
                | Sync Documents
                |--------------------------------------------------------------------------
                */

                if (
                    array_key_exists(
                        'documents',
                        $data
                    )
                    &&
                    ! empty($data['documents'])
                ) {
                    $documentsChanged =
                        $this->syncDocuments(
                            $application,
                            $data['documents']
                        );

                    if ($documentsChanged) {
                        $changedSections[] =
                            'مدارک پرونده';
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Store Audit
                |--------------------------------------------------------------------------
                */

                if (! empty($changedSections)) {
                    $this->storeAudit(
                        $application,
                        $actor,
                        $changedSections
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Return Fresh Model
                |--------------------------------------------------------------------------
                */

                return $application->fresh([
                    'user',
                    'companyProfile',
                    'shareholders',
                    'documents',
                    'currentStage',
                    'returnStage',
                    'reviews.stage',
                    'reviews.reviewer',
                ]);
            });

        } catch (Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | Transaction Failed
            |--------------------------------------------------------------------------
            |
            | Database Rollback شده است.
            | بنابراین فایل‌های جدید ایجادشده نیز باید حذف شوند.
            |
            */

            $this->deleteNewFilesAfterFailure();

            throw $e;
        }


        /*
        |--------------------------------------------------------------------------
        | Transaction Successfully Committed
        |--------------------------------------------------------------------------
        |
        | حالا که DB با موفقیت Commit شده،
        | فایل‌های قبلی جایگزین‌شده را حذف می‌کنیم.
        |
        */

        $this->deleteOldFilesAfterSuccess();

        return $result;
    }


    /**
     * Sync application shareholders.
     */
    private function syncShareholders(
        MembershipApplication $application,
        array $shareholders
    ): bool {
        $existingShareholders = $application
            ->shareholders()
            ->get()
            ->keyBy('id');

        $keptIds = [];

        $changed = false;


        foreach (
            $shareholders
            as $index => $shareholderData
        ) {
            /*
            |--------------------------------------------------------------------------
            | Normalize Data
            |--------------------------------------------------------------------------
            */

            $fullName = trim(
                (string) (
                    $shareholderData['full_name']
                    ?? ''
                )
            );

            $percentage =
                $shareholderData['ownership_percentage']
                ?? null;


            /*
            |--------------------------------------------------------------------------
            | Ignore Empty Rows
            |--------------------------------------------------------------------------
            */

            if (
                $fullName === ''
                &&
                (
                    $percentage === null
                    ||
                    $percentage === ''
                )
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Existing Shareholder
            |--------------------------------------------------------------------------
            */

            $shareholderId =
                $shareholderData['id']
                ?? null;

            if ($shareholderId) {
                $shareholder =
                    $existingShareholders->get(
                        (int) $shareholderId
                    );

                /*
                |--------------------------------------------------------------------------
                | Security Check
                |--------------------------------------------------------------------------
                |
                | نباید بتوان ID سهامدار متعلق به پرونده دیگری را ارسال کرد.
                |
                */

                if (! $shareholder) {
                    throw ValidationException::withMessages([
                        "shareholders.$index.id" =>
                            'سهامدار انتخاب‌شده متعلق به این پرونده نیست.',
                    ]);
                }


                $shareholder->fill([
                    'full_name' =>
                        $fullName,

                    'ownership_percentage' =>
                        $percentage,

                    'sort_order' =>
                        $index + 1,
                ]);


                if ($shareholder->isDirty()) {
                    $shareholder->save();

                    $changed = true;
                }


                $keptIds[] =
                    $shareholder->id;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Create New Shareholder
            |--------------------------------------------------------------------------
            */

            $shareholder = $application
                ->shareholders()
                ->create([
                    'full_name' =>
                        $fullName,

                    'ownership_percentage' =>
                        $percentage,

                    'sort_order' =>
                        $index + 1,
                ]);


            $keptIds[] =
                $shareholder->id;

            $changed = true;
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Removed Shareholders
        |--------------------------------------------------------------------------
        */

        $deleteQuery = $application
            ->shareholders();

        if (! empty($keptIds)) {
            $deleteQuery->whereNotIn(
                'id',
                $keptIds
            );
        }


        $deletedCount =
            $deleteQuery->delete();


        if ($deletedCount > 0) {
            $changed = true;
        }


        return $changed;
    }


    /**
     * Sync uploaded documents.
     */
    private function syncDocuments(
        MembershipApplication $application,
        array $documents
    ): bool {
        $changed = false;


        foreach (
            MembershipDocumentType::cases()
            as $documentType
        ) {
            /*
            |--------------------------------------------------------------------------
            | Check Uploaded File
            |--------------------------------------------------------------------------
            */

            $uploadedFile =
                $documents[$documentType->value]
                ?? null;


            if (! $uploadedFile) {
                continue;
            }


            if (! $uploadedFile instanceof UploadedFile) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Find Existing Document
            |--------------------------------------------------------------------------
            */

            $existingDocument = $application
                ->documents()
                ->where(
                    'type',
                    $documentType->value
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Store New File
            |--------------------------------------------------------------------------
            */

            $newPath = $uploadedFile->store(
                'membership-applications/'
                . $application->id
                . '/documents',
                'public'
            );


            if (! $newPath) {
                throw new RuntimeException(
                    'ذخیره فایل مدرک با خطا مواجه شد.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Track New File
            |--------------------------------------------------------------------------
            */

            $this->newDocumentPaths[] =
                $newPath;


            /*
            |--------------------------------------------------------------------------
            | Remember Old Path
            |--------------------------------------------------------------------------
            */

            $oldPath =
                $existingDocument?->path;


            /*
            |--------------------------------------------------------------------------
            | Save Document Record
            |--------------------------------------------------------------------------
            */

            $application
                ->documents()
                ->updateOrCreate(
                    [
                        'type' =>
                            $documentType->value,
                    ],
                    [
                        'path' =>
                            $newPath,

                        'original_name' =>
                            $uploadedFile
                                ->getClientOriginalName(),

                        'mime_type' =>
                            $uploadedFile->getMimeType()
                                ?: $uploadedFile
                                ->getClientMimeType()
                                ?: 'application/octet-stream',

                        'size' =>
                            $uploadedFile->getSize(),
                    ]
                );


            /*
            |--------------------------------------------------------------------------
            | Queue Old File For Deletion
            |--------------------------------------------------------------------------
            |
            | فایل قبلی را اینجا حذف نمی‌کنیم.
            | فقط بعد از Commit موفق DB حذف خواهد شد.
            |
            */

            if (
                $oldPath
                &&
                $oldPath !== $newPath
            ) {
                $this->oldDocumentPaths[] =
                    $oldPath;
            }


            $changed = true;
        }


        return $changed;
    }


    /**
     * Store edit history.
     */
    private function storeAudit(
        MembershipApplication $application,
        User $actor,
        array $changedSections
    ): void {
        /*
        |--------------------------------------------------------------------------
        | Find Audit Stage
        |--------------------------------------------------------------------------
        |
        | معمولاً current_stage_id موجود است.
        |
        | ولی Admin ممکن است یک پرونده Approved یا Rejected را ویرایش کند
        | و current_stage_id در آن حالت null باشد.
        |
        */

        $stageId =
            $application->current_stage_id
                ?: $application->return_stage_id
                ?: $application
                    ->reviews()
                    ->latest('id')
                    ->value('stage_id')
                    ?: WorkflowStage::query()
                        ->active()
                        ->ordered()
                        ->value('id');


        if (! $stageId) {
            throw new RuntimeException(
                'هیچ مرحله‌ای برای ثبت تاریخچه ویرایش پرونده وجود ندارد.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Human Readable Change List
        |--------------------------------------------------------------------------
        */

        $changedSections = array_values(
            array_unique(
                $changedSections
            )
        );


        $lines = collect(
            $changedSections
        )
            ->map(
                fn (string $section) =>
                    '• ' . $section
            )
            ->implode("\n");


        $comment =
            "اطلاعات پرونده ویرایش شد."
            . "\n\n"
            . "بخش‌های تغییر یافته:"
            . "\n"
            . $lines;


        /*
        |--------------------------------------------------------------------------
        | Create History
        |--------------------------------------------------------------------------
        */

        $application
            ->reviews()
            ->create([
                'reviewer_id' =>
                    $actor->id,

                'stage_id' =>
                    $stageId,

                'decision' =>
                    ApplicationReviewDecision::Edited->value,

                'comment' =>
                    $comment,
            ]);
    }


    /**
     * Delete newly-created files if transaction failed.
     */
    private function deleteNewFilesAfterFailure(): void
    {
        foreach (
            array_unique(
                $this->newDocumentPaths
            )
            as $path
        ) {
            try {
                if (
                    Storage::disk('public')
                        ->exists($path)
                ) {
                    Storage::disk('public')
                        ->delete($path);
                }
            } catch (Throwable $e) {
                report($e);
            }
        }
    }


    /**
     * Delete replaced files after successful DB commit.
     */
    private function deleteOldFilesAfterSuccess(): void
    {
        foreach (
            array_unique(
                $this->oldDocumentPaths
            )
            as $path
        ) {
            try {
                if (
                    Storage::disk('public')
                        ->exists($path)
                ) {
                    Storage::disk('public')
                        ->delete($path);
                }
            } catch (Throwable $e) {
                /*
                |--------------------------------------------------------------------------
                | Important
                |--------------------------------------------------------------------------
                |
                | DB قبلاً Commit شده.
                | بنابراین خطای حذف فایل قدیمی نباید باعث خراب شدن
                | عملیات موفق کاربر شود.
                |
                */

                report($e);
            }
        }
    }

    private function syncActivityFields(
        MembershipApplication $application,
        array $activityFieldIds
    ): bool {
        $newIds = collect($activityFieldIds)
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->sort()
            ->values();

        $currentIds = $application
            ->activityFields()
            ->pluck('activity_fields.id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->sort()
            ->values();

        if ($currentIds->all() === $newIds->all()) {
            return false;
        }

        $application
            ->activityFields()
            ->sync(
                $newIds->all()
            );

        return true;
    }
}
