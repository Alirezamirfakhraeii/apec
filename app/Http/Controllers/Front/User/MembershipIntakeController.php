<?php
namespace App\Http\Controllers\Front\User;
use App\Enums\MembershipApplicationState;
use App\Features\Membership\Actions\StartMembershipApplicationAction;
use App\Features\Membership\Data\MembershipIntakeData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\StoreMembershipIntakeRequest;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipIntakeController extends Controller
{
    public function show(
        Request $request
    ): View|RedirectResponse {
        $application = MembershipApplication::query()
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | No Application
        |--------------------------------------------------------------------------
        */

        if (! $application) {
            return view(
                'front.user.membership.create',
                [
                    'application' => null,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Draft - Intake Not Completed
        |--------------------------------------------------------------------------
        */

        if (
            $application->state ===
            MembershipApplicationState::Draft
            &&
            ! $application->intake_confirmed_at
        ) {
            return view(
                'front.user.membership.create',
                [
                    'application' => $application,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Draft - Continue Wizard
        |--------------------------------------------------------------------------
        */

        if (
            $application->state ===
            MembershipApplicationState::Draft
        ) {
            return redirect()->route(
                'user.membership.basic',
                $application
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Needs Correction
        |--------------------------------------------------------------------------
        |
        | اول وضعیت و دلیل اصلاح را به کاربر نشان می‌دهیم.
        |
        */

        if (
            $application->state ===
            MembershipApplicationState::NeedsCorrection
        ) {
            return redirect()->route(
                'user.membership.status',
                $application
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Submitted / In Review / Approved / Rejected
        |--------------------------------------------------------------------------
        */

        return redirect()->route(
            'user.membership.status',
            $application
        );
    }
    public function store(StoreMembershipIntakeRequest $request,StartMembershipApplicationAction $action): JsonResponse
    {
        $a=$action->execute($request->user(),MembershipIntakeData::fromRequest($request));
        return response()->json(['success'=>true,'message'=>'اطلاعات اولیه درخواست با موفقیت ثبت شد.','redirect'=>route('user.membership.basic',$a)]);
    }
}
