<?php

namespace App\Features\Membership\Actions;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipApplicationState;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Models\WorkflowStage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class ReviewMembershipApplicationAction
{
    public function __construct(
        private readonly FinalizeMembershipApplicationAction $finalizer
    ) {
    }


    public function execute(
        MembershipApplication $application,
        ApplicationReviewDecision $decision,
        User $actor,
        ?string $comment = null
    ): MembershipApplication {
        return DB::transaction(function () use (
            $application,
            $decision,
            $actor,
            $comment
        ) {
            /*
            |--------------------------------------------------------------------------
            | Lock Application
            |--------------------------------------------------------------------------
            */

            $application = MembershipApplication::query()
                ->with([
                    'currentStage',
                    'returnStage',
                    'companyProfile',
                    'activityFields',
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
                        'این پرونده در حال حاضر در وضعیت بررسی قرار ندارد.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Current Stage
            |--------------------------------------------------------------------------
            */

            $currentStage =
                $application->currentStage;


            if (! $currentStage) {
                throw new RuntimeException(
                    'مرحله فعلی پرونده مشخص نشده است.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Reviewer Permission
            |--------------------------------------------------------------------------
            */

            if (
                ! $currentStage->required_permission
                ||
                ! $actor->can(
                    $currentStage->required_permission
                )
            ) {
                throw new AuthorizationException(
                    'شما اجازه بررسی این پرونده را ندارید.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Validate Decision
            |--------------------------------------------------------------------------
            */

            if (
                ! in_array(
                    $decision,
                    [
                        ApplicationReviewDecision::Approved,
                        ApplicationReviewDecision::NeedsCorrection,
                        ApplicationReviewDecision::Rejected,
                    ],
                    true
                )
            ) {
                throw ValidationException::withMessages([
                    'decision' =>
                        'تصمیم انتخاب‌شده معتبر نیست.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Comment Validation
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $decision,
                    [
                        ApplicationReviewDecision::NeedsCorrection,
                        ApplicationReviewDecision::Rejected,
                    ],
                    true
                )
                &&
                blank($comment)
            ) {
                throw ValidationException::withMessages([
                    'comment' =>
                        'برای رد درخواست یا درخواست اصلاح، توضیحات الزامی است.',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Store Review History
            |--------------------------------------------------------------------------
            */

            $application
                ->reviews()
                ->create([
                    'reviewer_id' =>
                        $actor->id,

                    'stage_id' =>
                        $currentStage->id,

                    'decision' =>
                        $decision->value,

                    'comment' =>
                        filled($comment)
                            ? trim($comment)
                            : null,
                ]);


            /*
            |--------------------------------------------------------------------------
            | Needs Correction
            |--------------------------------------------------------------------------
            |
            | پرونده برای اصلاح به متقاضی برمی‌گردد.
            |
            | return_stage_id مشخص می‌کند بعد از اصلاح،
            | پرونده باید دوباره به کدام مرحله برگردد.
            |
            */

            if (
                $decision ===
                ApplicationReviewDecision::NeedsCorrection
            ) {
                $application->update([
                    'state' =>
                        MembershipApplicationState::NeedsCorrection,

                    'current_stage_id' =>
                        $currentStage->id,

                    'return_stage_id' =>
                        $currentStage->id,

                    'approved_at' =>
                        null,

                    'rejected_at' =>
                        null,
                ]);


                return $this->freshApplication(
                    $application
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Rejected
            |--------------------------------------------------------------------------
            */

            if (
                $decision ===
                ApplicationReviewDecision::Rejected
            ) {
                $application->update([
                    'state' =>
                        MembershipApplicationState::Rejected,

                    'current_stage_id' =>
                        null,

                    'return_stage_id' =>
                        null,

                    'approved_at' =>
                        null,

                    'rejected_at' =>
                        now(),
                ]);


                return $this->freshApplication(
                    $application
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Approved
            |--------------------------------------------------------------------------
            */

            if (
                $decision ===
                ApplicationReviewDecision::Approved
            ) {
                /*
                |--------------------------------------------------------------------------
                | Final Stage
                |--------------------------------------------------------------------------
                |
                | اگر مرحله فعلی Final باشد، مثل Board Chairman،
                | دیگر Stage بعدی نداریم.
                |
                | Finalizer:
                |
                | - Company می‌سازد
                | - اطلاعات شرکت را منتقل می‌کند
                | - Activity Fields را Sync می‌کند
                | - company_id را ثبت می‌کند
                | - Application را Approved می‌کند
                |
                */

                if ($currentStage->is_final) {
                    return $this->finalizer->execute(
                        $application,
                        $actor
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Find Next Workflow Stage
                |--------------------------------------------------------------------------
                */

                $nextStage = WorkflowStage::query()
                    ->active()
                    ->where(
                        'position',
                        '>',
                        $currentStage->position
                    )
                    ->ordered()
                    ->first();


                if (! $nextStage) {
                    throw ValidationException::withMessages([
                        'application' =>
                            'مرحله بعدی برای این پرونده تعریف نشده است.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Move To Next Stage
                |--------------------------------------------------------------------------
                */

                $application->update([
                    'state' =>
                        MembershipApplicationState::InReview,

                    'current_stage_id' =>
                        $nextStage->id,

                    'return_stage_id' =>
                        null,

                    'approved_at' =>
                        null,

                    'rejected_at' =>
                        null,
                ]);


                return $this->freshApplication(
                    $application
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Safety
            |--------------------------------------------------------------------------
            */

            throw new RuntimeException(
                'عملیات بررسی پرونده قابل انجام نیست.'
            );
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Fresh Application
    |--------------------------------------------------------------------------
    */

    private function freshApplication(
        MembershipApplication $application
    ): MembershipApplication {
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
    }
}
