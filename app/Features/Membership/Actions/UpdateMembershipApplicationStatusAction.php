<?php

namespace App\Features\Membership\Actions;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipApplicationState;
use App\Models\ApplicationReview;
use App\Models\MembershipApplication;
use App\Models\User;
use App\Models\WorkflowStage;
use Illuminate\Support\Facades\DB;

final class UpdateMembershipApplicationStatusAction
{
    public function execute(
        MembershipApplication $application,
        MembershipApplicationState $newState,
        User $actor,
        ?WorkflowStage $stage,
        string $comment
    ): MembershipApplication {
        return DB::transaction(
            function () use (
                $application,
                $newState,
                $actor,
                $stage,
                $comment
            ) {
                $application = MembershipApplication::query()
                    ->whereKey($application->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $oldState = $application->state;

                /*
                |--------------------------------------------------------------------------
                | Resolve Audit Stage
                |--------------------------------------------------------------------------
                */

                $auditStageId =
                    $application->current_stage_id
                        ?: $application
                        ->reviews()
                        ->latest('id')
                        ->value('stage_id')
                        ?: WorkflowStage::query()
                            ->active()
                            ->ordered()
                            ->value('id');


                /*
                |--------------------------------------------------------------------------
                | Update State
                |--------------------------------------------------------------------------
                */

                match ($newState) {

                    MembershipApplicationState::InReview =>
                    $application->update([
                        'state' =>
                            MembershipApplicationState::InReview,

                        'current_stage_id' =>
                            $stage?->id,

                        'return_stage_id' =>
                            null,

                        'approved_at' =>
                            null,

                        'rejected_at' =>
                            null,
                    ]),


                    MembershipApplicationState::NeedsCorrection =>
                    $application->update([
                        'state' =>
                            MembershipApplicationState::NeedsCorrection,

                        'current_stage_id' =>
                            $stage?->id,

                        'return_stage_id' =>
                            $stage?->id,

                        'approved_at' =>
                            null,

                        'rejected_at' =>
                            null,
                    ]),


                    MembershipApplicationState::Rejected =>
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
                    ]),


                    MembershipApplicationState::Approved =>
                    $application->update([
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
                    ]),

                    default => null,
                };


                /*
                |--------------------------------------------------------------------------
                | Audit
                |--------------------------------------------------------------------------
                */

                if ($auditStageId) {

                    ApplicationReview::create([
                        'membership_application_id' =>
                            $application->id,

                        'reviewer_id' =>
                            $actor->id,

                        'stage_id' =>
                            $auditStageId,

                        'decision' =>
                            ApplicationReviewDecision::StatusChanged,

                        'comment' =>
                            'تغییر وضعیت توسط مدیر از «' .
                            $oldState->label() .
                            '» به «' .
                            $newState->label() .
                            '»' .
                            PHP_EOL .
                            PHP_EOL .
                            'علت: ' .
                            trim($comment),
                    ]);
                }


                return $application->fresh();
            }
        );
    }
}
