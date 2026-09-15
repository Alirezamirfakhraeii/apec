<?php

namespace App\Features\Membership\Actions;

use App\Enums\MembershipApplicationState;
use App\Models\Company;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class FinalizeMembershipApplicationAction
{
    public function execute(
        MembershipApplication $application,
        User $actor
    ): MembershipApplication {
        return DB::transaction(function () use (
            $application,
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
                    'activityFields',
                    'currentStage',
                ])
                ->lockForUpdate()
                ->findOrFail($application->id);


            /*
            |--------------------------------------------------------------------------
            | Application State
            |--------------------------------------------------------------------------
            */

            if (
                $application->state !==
                MembershipApplicationState::InReview
            ) {
                throw ValidationException::withMessages([
                    'application' =>
                        'این پرونده در وضعیت قابل تأیید نهایی قرار ندارد.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Current Stage
            |--------------------------------------------------------------------------
            */

            $currentStage = $application->currentStage;

            if (! $currentStage) {
                throw new RuntimeException(
                    'مرحله فعلی پرونده مشخص نشده است.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Final Stage
            |--------------------------------------------------------------------------
            */

            if (! $currentStage->is_final) {
                throw ValidationException::withMessages([
                    'application' =>
                        'این پرونده هنوز به مرحله تأیید نهایی نرسیده است.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Permission
            |--------------------------------------------------------------------------
            */

            if (
                ! $currentStage->required_permission
                ||
                ! $actor->can(
                    $currentStage->required_permission
                )
            ) {
                throw ValidationException::withMessages([
                    'application' =>
                        'شما اجازه تأیید نهایی این پرونده را ندارید.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Company Profile
            |--------------------------------------------------------------------------
            */

            $profile = $application->companyProfile;

            if (! $profile) {
                throw ValidationException::withMessages([
                    'application' =>
                        'اطلاعات شرکت برای این پرونده ثبت نشده است.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Company Data
            |--------------------------------------------------------------------------
            */

            $companyData = [

                /*
                |--------------------------------------------------------------------------
                | General
                |--------------------------------------------------------------------------
                */

                'logo' =>
                    $profile->logo_path,

                'company_short_name' =>
                    $profile->company_short_name,

                'registered_name' =>
                    $profile->registered_name,

                'company_name_en' =>
                    $profile->company_name_en,

                'nationality' =>
                    $profile->nationality,

                'parent_company_name' =>
                    $profile->parent_company_name,

                'company_type' =>
                    $profile->company_type instanceof \BackedEnum
                        ? $profile->company_type->value
                        : $profile->company_type,


                /*
                |--------------------------------------------------------------------------
                | Registration
                |--------------------------------------------------------------------------
                */

                'registration_date' =>
                    $profile->registration_date,

                'registration_number' =>
                    $profile->registration_number,

                'registration_place' =>
                    $profile->registration_place,

                'national_id' =>
                    $profile->national_id,

                'registered_capital_irr' =>
                    $profile->registered_capital_irr,

                'reference_gazette_date' =>
                    $profile->reference_gazette_date,


                /*
                |--------------------------------------------------------------------------
                | Contact
                |--------------------------------------------------------------------------
                */

                'phone' =>
                    $profile->phone,

                'fax' =>
                    $profile->fax,

                'email' =>
                    $profile->email,

                'website' =>
                    $profile->website,

                'address' =>
                    $profile->address,


                /*
                |--------------------------------------------------------------------------
                | CEO
                |--------------------------------------------------------------------------
                */

                'ceo_name' =>
                    $profile->ceo_name,

                'ceo_mobile' =>
                    $profile->ceo_mobile,

                'ceo_email' =>
                    $profile->ceo_email,


                /*
                |--------------------------------------------------------------------------
                | Chairman
                |--------------------------------------------------------------------------
                */

                'chairman_name' =>
                    $profile->chairman_name,

                'chairman_mobile' =>
                    $profile->chairman_mobile,

                'chairman_email' =>
                    $profile->chairman_email,


                /*
                |--------------------------------------------------------------------------
                | Association Contact
                |--------------------------------------------------------------------------
                */

                'association_contact_name' =>
                    $profile->association_contact_name,

                'association_contact_position' =>
                    $profile->association_contact_position,

                'association_contact_mobile' =>
                    $profile->association_contact_mobile,

                'association_contact_email' =>
                    $profile->association_contact_email,


                /*
                |--------------------------------------------------------------------------
                | Membership
                |--------------------------------------------------------------------------
                */

                'membership_type' =>
                    $profile->membership_type,

                'association_committees' =>
                    $profile->association_committees,


                /*
                |--------------------------------------------------------------------------
                | Commercial / Chamber
                |--------------------------------------------------------------------------
                */

                'has_valid_commercial_card' =>
                    $profile->has_valid_commercial_card,

                'commercial_card_valid_until' =>
                    $profile->commercial_card_valid_until,

                'has_valid_chamber_membership_card' =>
                    $profile->has_valid_chamber_membership_card,

                'chamber_membership_valid_until' =>
                    $profile->chamber_membership_valid_until,

                'chamber_province' =>
                    $profile->chamber_province,


                /*
                |--------------------------------------------------------------------------
                | Activities
                |--------------------------------------------------------------------------
                */

                'activity_design_consulting' =>
                    $profile->activity_design_consulting,

                'activity_construction_installation' =>
                    $profile->activity_construction_installation,

                'activity_epc' =>
                    $profile->activity_epc,

                'activity_mc' =>
                    $profile->activity_mc,

                'activity_manufacturing' =>
                    $profile->activity_manufacturing,

                'activity_type' =>
                    $profile->activity_type,
            ];


            /*
            |--------------------------------------------------------------------------
            | Existing Company
            |--------------------------------------------------------------------------
            |
            | اگر Application از قبل به Company متصل باشد،
            | همان Company را بروزرسانی می‌کنیم.
            |
            */

            if ($application->company_id) {

                $company = Company::query()
                    ->lockForUpdate()
                    ->find(
                        $application->company_id
                    );


                if (! $company) {
                    throw ValidationException::withMessages([
                        'application' =>
                            'شرکت متصل به این پرونده در سیستم پیدا نشد.',
                    ]);
                }


                $company->update(
                    $companyData
                );


                /*
                |--------------------------------------------------------------------------
                | Association Join Date
                |--------------------------------------------------------------------------
                |
                | اگر قبلاً مقدار داشته، آن را خراب نمی‌کنیم.
                |
                */

                if (! $company->association_join_date) {
                    $company->update([
                        'association_join_date' =>
                            now()->toDateString(),
                    ]);
                }

            } else {

                /*
                |--------------------------------------------------------------------------
                | Create New Company
                |--------------------------------------------------------------------------
                */

                $companyData['association_join_date'] =
                    now()->toDateString();


                $company = Company::query()
                    ->create(
                        $companyData
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Sync Activity Fields
            |--------------------------------------------------------------------------
            */

            $activityFieldIds = $application
                ->activityFields
                ->pluck('id')
                ->map(
                    fn ($id) => (int) $id
                )
                ->unique()
                ->values()
                ->all();


            $company
                ->activityFields()
                ->sync(
                    $activityFieldIds
                );


            /*
            |--------------------------------------------------------------------------
            | Finalize Application
            |--------------------------------------------------------------------------
            */

            $application->update([
                'company_id' =>
                    $company->id,

                'state' =>
                    MembershipApplicationState::Approved,

                'current_stage_id' =>
                    null,

                'return_stage_id' =>
                    null,

                'approved_at' =>
                    now(),

                'rejected_at' =>
                    null,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Return Fresh Application
            |--------------------------------------------------------------------------
            */

            return $application->fresh([
                'user',
                'company',
                'companyProfile',
                'shareholders',
                'documents',
                'activityFields',
                'currentStage',
                'returnStage',
                'reviews.stage',
                'reviews.reviewer',
            ]);
        });
    }
}
