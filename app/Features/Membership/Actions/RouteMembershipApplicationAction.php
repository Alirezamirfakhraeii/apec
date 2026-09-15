<?php

namespace App\Features\Membership\Actions;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipApplicationState;
use App\Models\ApplicationReview;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Models\WorkflowStage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class RouteMembershipApplicationAction
{
    public function execute(
        MembershipApplication $application,
        WorkflowStage $targetStage,
        User $actor,
        ?string $comment = null
    ): MembershipApplication {
        return DB::transaction(
            function () use (
                $application,
                $targetStage,
                $actor,
                $comment
            ) {
                /*
                |--------------------------------------------------------------------------
                | Lock Application
                |--------------------------------------------------------------------------
                */

                $application = MembershipApplication::query()
                    ->whereKey($application->id)
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Final States Cannot Be Routed
                |--------------------------------------------------------------------------
                */

                if (
                    in_array(
                        $application->state,
                        [
                            MembershipApplicationState::Approved,
                            MembershipApplicationState::Rejected,
                        ],
                        true
                    )
                ) {
                    throw ValidationException::withMessages([
                        'application' =>
                            'پرونده بسته‌شده قابل ارجاع نیست.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Draft Cannot Be Routed
                |--------------------------------------------------------------------------
                */

                if (
                    $application->state ===
                    MembershipApplicationState::Draft
                ) {
                    throw ValidationException::withMessages([
                        'application' =>
                            'درخواست پیش‌نویس هنوز قابل ارجاع نیست.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Target Stage
                |--------------------------------------------------------------------------
                */

                $targetStage = WorkflowStage::query()
                    ->whereKey($targetStage->id)
                    ->where('is_active', true)
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | Same Stage
                |--------------------------------------------------------------------------
                */

                if (
                    $application->current_stage_id ===
                    $targetStage->id
                ) {
                    throw ValidationException::withMessages([
                        'stage_id' =>
                            'پرونده در حال حاضر در همین مرحله قرار دارد.',
                    ]);
                }


                /*
                |--------------------------------------------------------------------------
                | Previous Stage
                |--------------------------------------------------------------------------
                */

                $previousStageId =
                    $application->current_stage_id;


                /*
                |--------------------------------------------------------------------------
                | Audit Review
                |--------------------------------------------------------------------------
                |
                | stage_id نشان می‌دهد ارجاع از چه مرحله‌ای انجام شده.
                | اگر مرحله فعلی نداشته باشیم، مقصد را ثبت می‌کنیم.
                |
                */

                $reviewComment =
                    'ارجاع پرونده به «' .
                    $targetStage->name .
                    '»';

                if (filled($comment)) {
                    $reviewComment .=
                        PHP_EOL .
                        'توضیحات: ' .
                        trim($comment);
                }


                ApplicationReview::create([
                    'membership_application_id' =>
                        $application->id,

                    'reviewer_id' =>
                        $actor->id,

                    'stage_id' =>
                        $previousStageId
                            ?: $targetStage->id,

                    'decision' =>
                        ApplicationReviewDecision::Forwarded,

                    'comment' =>
                        $reviewComment,
                ]);


                /*
                |--------------------------------------------------------------------------
                | Move Application
                |--------------------------------------------------------------------------
                */

                $application->update([
                    'state' =>
                        MembershipApplicationState::InReview,

                    'current_stage_id' =>
                        $targetStage->id,

                    'return_stage_id' =>
                        null,

                    'rejected_at' =>
                        null,

                    'approved_at' =>
                        null,
                ]);


                return $application
                    ->fresh()
                    ->load([
                        'currentStage',
                        'reviews.stage',
                        'reviews.reviewer',
                    ]);
            }
        );
    }
}
