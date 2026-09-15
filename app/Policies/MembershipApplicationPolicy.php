<?php

namespace App\Policies;

use App\Enums\MembershipApplicationState;
use App\Models\MembershipApplication;
use App\Models\User;

class MembershipApplicationPolicy
{
    /**
     * آیا کاربر می‌تواند این پرونده را ببیند؟
     */
    public function view(
        User $user,
        MembershipApplication $application
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Admin / Manager
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('admin')
            ||
            $user->can('membership.application.manage')
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Reviewers
        |--------------------------------------------------------------------------
        |
        | تمام Reviewerهای رسمی می‌توانند تمام پرونده‌های ارسال‌شده را ببینند.
        |
        | توجه:
        | این فقط View است.
        | اجازه Approve / Reject / NeedsCorrection همچنان بر اساس
        | currentStage.required_permission کنترل می‌شود.
        |
        */

        $reviewPermissions = [
            'membership.application.review.it',
            'membership.application.review.secretary',
            'membership.application.review.chair',
            'membership.application.review.board',
        ];

        if ($user->hasAnyPermission($reviewPermissions)) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Applicant
        |--------------------------------------------------------------------------
        |
        | خود متقاضی نیز می‌تواند پرونده خودش را مشاهده کند.
        |
        */

        return (int) $application->user_id === (int) $user->id;
    }


    /**
     * آیا کاربر می‌تواند اطلاعات پرونده را ویرایش کند؟
     */
    public function update(
        User $user,
        MembershipApplication $application
    ): bool {
        /*
        |--------------------------------------------------------------------------
        | Admin / Manager
        |--------------------------------------------------------------------------
        */

        if (
            $user->hasRole('admin')
            ||
            $user->can('membership.application.manage')
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Current Reviewer
        |--------------------------------------------------------------------------
        |
        | Reviewer فعلی می‌تواند در زمان بررسی پرونده را ویرایش کند.
        |
        | مثلاً:
        |
        | current_stage = board
        | permission = membership.application.review.board
        |
        | پس board_chairman اجازه ویرایش دارد.
        |
        */

        $isInReview =
            $application->state instanceof
            \App\Enums\MembershipApplicationState
                ? $application->state ===
                \App\Enums\MembershipApplicationState::InReview
                : $application->state ===
                \App\Enums\MembershipApplicationState::InReview->value;


        if (
            $isInReview
            &&
            $application->currentStage
            &&
            $application->currentStage->required_permission
            &&
            $user->can(
                $application->currentStage->required_permission
            )
        ) {
            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Applicant
        |--------------------------------------------------------------------------
        |
        | متقاضی فقط در Draft یا NeedsCorrection می‌تواند
        | پرونده خودش را ویرایش کند.
        |
        */

        $isOwner =
            (int) $application->user_id
            ===
            (int) $user->id;


        $canApplicantEdit =
            in_array(
                $application->state instanceof
                \App\Enums\MembershipApplicationState
                    ? $application->state
                    : \App\Enums\MembershipApplicationState::tryFrom(
                    $application->state
                ),
                [
                    \App\Enums\MembershipApplicationState::Draft,
                    \App\Enums\MembershipApplicationState::NeedsCorrection,
                ],
                true
            );


        return $isOwner && $canApplicantEdit;
    }
}
