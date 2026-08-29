<?php

namespace App\Features\Membership\Actions;

use App\Enums\MembershipApplicationState;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class CreateMembershipApplicationAction
{
    public function execute(User $user): MembershipApplication
    {
        return DB::transaction(function () use ($user) {

            $existingApplication = MembershipApplication::query()
                ->where('user_id', $user->id)
                ->whereIn('state', [
                    MembershipApplicationState::Draft->value,
                    MembershipApplicationState::Submitted->value,
                    MembershipApplicationState::InReview->value,
                    MembershipApplicationState::NeedsCorrection->value,
                ])
                ->latest('id')
                ->first();

            if ($existingApplication) {
                return $existingApplication;
            }

            return MembershipApplication::create([
                'user_id' => $user->id,
                'state' => MembershipApplicationState::Draft,
            ]);
        });
    }
}
