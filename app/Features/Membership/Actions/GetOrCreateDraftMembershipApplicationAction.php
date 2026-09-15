<?php

namespace App\Features\Membership\Actions;

use App\Enums\MembershipApplicationState;
use App\Models\MembershipApplication;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class GetOrCreateDraftMembershipApplicationAction
{
    public function execute(User $user): MembershipApplication
    {
        return DB::transaction(function () use ($user) {
            $application = MembershipApplication::query()
                ->where('user_id', $user->id)
                ->whereIn('state', [
                    MembershipApplicationState::Draft->value,
                    MembershipApplicationState::NeedsCorrection->value,
                    MembershipApplicationState::InReview->value,
                ])
                ->latest('id')
                ->lockForUpdate()
                ->first();

            return $application ?? MembershipApplication::create([
                'user_id' => $user->id,
                'state' => MembershipApplicationState::Draft,
            ]);
        });
    }
}
