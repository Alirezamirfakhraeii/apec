<?php

namespace App\Http\Controllers\Front\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MembershipApplication;
use App\Models\WorkflowStage;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipTrackingController extends Controller
{
    // وضعیت آخرین درخواست عضویت کاربر را نمایش می‌دهد.
    public function index(Request $request): View
    {
        $application = MembershipApplication::query()
            ->with([
                'companyProfile',
                'currentStage',
                'returnStage',
                'reviews' => fn ($query) => $query
                    ->with([
                        'stage',
                        'reviewer',
                    ])
                    ->latest(),
            ])
            ->where(
                'user_id',
                $request->user()->id
            )
            ->latest('id')
            ->first();

        $workflowStages = WorkflowStage::query()
            ->where('is_active', true)
            ->orderBy('position')
            ->get();

        return view(
            'front.user.membership.tracking',
            compact(
                'application',
                'workflowStages'
            )
        );
    }
}
