<?php

namespace App\Http\Controllers\User\Membership;

use App\Features\Membership\Actions\ConfirmMembershipIntakeAction;
use App\Features\Membership\Data\MembershipIntakeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\ConfirmMembershipIntakeRequest;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

final class IntakeController extends Controller
{
    public function show(Request $request, MembershipApplication $application): View
    {
        Gate::authorize('update', $application);

        return view('front.user.membership.intake', compact('application'));
    }

    public function confirm(
        ConfirmMembershipIntakeRequest $request,
        MembershipApplication $application,
        ConfirmMembershipIntakeAction $action
    ): JsonResponse {
        Gate::authorize('update', $application);
        $action->execute($application, MembershipIntakeData::fromRequest($request));

        return response()->json([
            'message' => 'اطلاعات اولیه ثبت شد.',
            'redirect' => route('user.membership.basic', $application),
        ]);
    }
}
