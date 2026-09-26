<?php

namespace App\Http\Controllers\Front\User;

use App\Enums\CompanyType;
use App\Enums\MembershipDocumentType;
use App\Features\Membership\Actions\SaveCompanyBasicInfoAction;
use App\Features\Membership\Actions\SaveCompanyQualificationsAction;
use App\Features\Membership\Actions\SaveCompanyRegistrationInfoAction;
use App\Features\Membership\Actions\SubmitMembershipApplicationAction;
use App\Features\Membership\Data\CompanyBasicInfoData;
use App\Features\Membership\Data\CompanyQualificationsData;
use App\Features\Membership\Data\CompanyRegistrationInfoData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\SubmitMembershipApplicationRequest;
use App\Http\Requests\User\Membership\UpdateCompanyBasicInfoRequest;
use App\Http\Requests\User\Membership\UpdateCompanyQualificationsRequest;
use App\Http\Requests\User\Membership\UpdateCompanyRegistrationInfoRequest;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function basic(Request $request, MembershipApplication $application): View
    {
        $this->ensureEditableApplication($request, $application);
        $application->load('companyProfile');
        return view('front.user.membership.steps.basic', ['application' => $application, 'companyTypes' => CompanyType::options()]);
    }

    public function updateBasicCompanyInfo(UpdateCompanyBasicInfoRequest $request, MembershipApplication $application, SaveCompanyBasicInfoAction $action): JsonResponse
    {
        $profile = $action->execute($application, CompanyBasicInfoData::fromRequest($request));
        return response()->json(['success' => true, 'message' => 'اطلاعات پایه شرکت با موفقیت ذخیره شد.', 'data' => ['profile_id' => $profile->id, 'logo_url' => $profile->logo_path ? asset('storage/' . $profile->logo_path) : null], 'redirect' => route('user.membership.registration', $application)]);
    }

    public function registration(Request $request, MembershipApplication $application): View
    {
        $this->ensureEditableApplication($request, $application);
        $application->load(['companyProfile', 'shareholders', 'documents']);
        $official = $application->documents->first(function ($d) {
            $t = $d->type;
            if ($t instanceof MembershipDocumentType) $t = $t->value;
            return $t === MembershipDocumentType::OfficialGazette->value;
        });
        return view('front.user.membership.steps.registration', ['application' => $application, 'officialGazette' => $official]);
    }

    public function updateRegistrationInfo(UpdateCompanyRegistrationInfoRequest $request, MembershipApplication $application, SaveCompanyRegistrationInfoAction $action): JsonResponse
    {
        $action->execute($application, CompanyRegistrationInfoData::fromRequest($request));
        return response()->json(['success' => true, 'message' => 'اطلاعات ثبتی و سهامداران با موفقیت ذخیره شد.', 'redirect' => route('user.membership.qualifications', $application)]);
    }

    public function qualifications(Request $request, MembershipApplication $application): View
    {
        $this->ensureEditableApplication($request, $application);
        $application->load(['companyProfile', 'documents']);
        $documents = $application->documents->keyBy(fn($d) => $d->type instanceof MembershipDocumentType ? $d->type->value : $d->type);
        return view('front.user.membership.steps.qualifications', ['application' => $application, 'documents' => $documents]);
    }

    public function updateQualifications(UpdateCompanyQualificationsRequest $request, MembershipApplication $application, SaveCompanyQualificationsAction $action): JsonResponse
    {
        $action->execute($application, CompanyQualificationsData::fromRequest($request));
        return response()->json(['success' => true, 'message' => 'سوابق و مدارک شرکت با موفقیت ذخیره شد.', 'redirect' => route('user.membership.review', $application)]);
    }

    public function review(Request $request, MembershipApplication $application): View
    {
        $this->ensureEditableApplication($request, $application);
        $application->load(['companyProfile', 'shareholders', 'documents']);
        $documents = $application->documents->keyBy(fn($d) => $d->type instanceof MembershipDocumentType ? $d->type->value : $d->type);
        return view('front.user.membership.steps.review', ['application' => $application, 'documents' => $documents]);
    }

    public function submit(SubmitMembershipApplicationRequest $request, MembershipApplication $application, SubmitMembershipApplicationAction $action): JsonResponse
    {
        $application = $action->execute($application);
        return response()->json(['success' => true, 'message' => 'درخواست عضویت با موفقیت ارسال شد و در صف بررسی قرار گرفت.', 'data' => ['state' => $application->state->value, 'state_label' => $application->state->label(), 'current_stage' => $application->currentStage?->name], 'redirect' => route('user.dashboard')]);
    }

    private function ensureEditableApplication(Request $request, MembershipApplication $application): void
    {
        abort_unless($application->user_id === $request->user()->id, 403);
        abort_unless($application->isEditable(), 403);
    }

    public function status(
        Request $request,
        MembershipApplication $application
    ): View {
        abort_unless(
            $application->user_id === $request->user()->id,
            403
        );

        $application->load([
            'currentStage',
            'returnStage',
            'reviews.stage',
        ]);

        return view(
            'front.user.membership.status',
            [
                'application' => $application,
            ]
        );
    }
}
