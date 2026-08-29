<?php

namespace App\Http\Controllers\User;

use App\Enums\MembershipApplicationState;
use App\Features\Membership\Actions\CreateMembershipApplicationAction;
use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class MembershipApplicationController extends Controller
{
    public function create(Request $request): View
    {
        $application = MembershipApplication::query()
            ->where('user_id', $request->user()->id)
            ->whereIn('state', [
                MembershipApplicationState::Draft->value,
                MembershipApplicationState::Submitted->value,
                MembershipApplicationState::InReview->value,
                MembershipApplicationState::NeedsCorrection->value,
            ])
            ->with('currentStage')
            ->latest('id')
            ->first();

        return view('front.user.membership.create', [
            'application' => $application,
        ]);
    }


    public function store(
        Request $request,
        CreateMembershipApplicationAction $action
    ): RedirectResponse {
        $action->execute($request->user());

        return redirect()
            ->route('user.membership.create')
            ->with(
                'success',
                'درخواست عضویت شما ایجاد شد. می‌توانید اطلاعات آن را تکمیل کنید.'
            );
    }

    public function edit(
        Request $request,
        MembershipApplication $application
    ): View {
        abort_unless(
            $application->user_id === $request->user()->id,
            403
        );

        abort_unless(
            $application->state === MembershipApplicationState::Draft,
            403
        );

        return view('front.user.membership.edit', [
            'application' => $application,
        ]);
    }



}
