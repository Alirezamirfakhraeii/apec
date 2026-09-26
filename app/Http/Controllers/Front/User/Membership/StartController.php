<?php

namespace App\Http\Controllers\Front\User\Membership;

use App\Enums\MembershipApplicationState;
use App\Features\Membership\Actions\GetOrCreateDraftMembershipApplicationAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class StartController extends Controller
{
    public function __invoke(
        Request $request,
        GetOrCreateDraftMembershipApplicationAction $action
    ): RedirectResponse {
        $application = $action->execute(
            $request->user()
        );

        /*
        |--------------------------------------------------------------------------
        | Application Already Submitted
        |--------------------------------------------------------------------------
        */

        if (
            in_array(
                $application->state,
                [
                    MembershipApplicationState::Submitted,
                    MembershipApplicationState::InReview,
                    MembershipApplicationState::Approved,
                    MembershipApplicationState::Rejected,
                ],
                true
            )
        ) {
            return redirect()->route(
                'user.dashboard'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Intake Not Completed
        |--------------------------------------------------------------------------
        */

        if (! $application->intake_confirmed_at) {
            return redirect()->route(
                'user.membership.create'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Continue Editable Application
        |--------------------------------------------------------------------------
        |
        | Draft / NeedsCorrection
        |
        */

        return redirect()->route(
            'user.membership.basic',
            $application
        );
    }
}
