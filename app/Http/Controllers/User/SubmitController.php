<?php

namespace App\Http\Controllers\User;

use App\Features\Membership\Actions\SubmitMembershipApplicationAction;
use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

final class SubmitController extends Controller
{
    public function __invoke(
        Request $request,
        MembershipApplication $application,
        SubmitMembershipApplicationAction $action
    ): RedirectResponse {
        Gate::authorize('submit', $application);
        $action->execute($application);

        return redirect()
            ->route('user.membership.step.review', $application)
            ->with('success', 'درخواست عضویت با موفقیت برای بررسی ارسال شد.');
    }
}
