<?php

namespace App\Http\Controllers\Front\User\Membership;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

final class WizardController extends Controller
{
    private function ensureIntake(MembershipApplication $application): ?RedirectResponse
    {
        if (! $application->intake_confirmed_at) {
            return redirect()->route('user.membership.intake', $application);
        }

        return null;
    }

    public function company(Request $request, MembershipApplication $application): View|RedirectResponse
    {
        Gate::authorize('update', $application);
        if ($redirect = $this->ensureIntake($application)) return $redirect;

        $application->load('companyProfile');
        return view('front.user.membership.steps.company', compact('application'));
    }

    public function registration(Request $request, MembershipApplication $application): View|RedirectResponse
    {
        Gate::authorize('update', $application);
        if ($redirect = $this->ensureIntake($application)) return $redirect;

        $application->load(['companyProfile', 'shareholders', 'documents']);
        return view('front.user.membership.steps.registration', compact('application'));
    }

    public function background(Request $request, MembershipApplication $application): View|RedirectResponse
    {
        Gate::authorize('update', $application);
        if ($redirect = $this->ensureIntake($application)) return $redirect;

        $application->load(['companyProfile', 'documents']);
        return view('front.user.membership.steps.background', compact('application'));
    }

    public function review(Request $request, MembershipApplication $application): View
    {
        Gate::authorize('view', $application);
        $application->load(['companyProfile', 'shareholders', 'documents', 'currentStage']);

        return view('front.user.membership.steps.review', compact('application'));
    }
}
