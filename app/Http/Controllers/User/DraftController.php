<?php

namespace App\Http\Controllers\User\Membership;

use App\Features\Membership\Actions\SaveCompanyBackgroundAction;
use App\Features\Membership\Actions\SaveCompanyIdentityAction;
use App\Features\Membership\Actions\SaveCompanyRegistrationAction;
use App\Features\Membership\Data\CompanyBackgroundData;
use App\Features\Membership\Data\CompanyIdentityData;
use App\Features\Membership\Data\CompanyRegistrationData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\SaveCompanyBackgroundRequest;
use App\Http\Requests\User\Membership\SaveCompanyIdentityRequest;
use App\Http\Requests\User\Membership\SaveCompanyRegistrationRequest;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;

final class DraftController extends Controller
{
    public function company(
        SaveCompanyIdentityRequest $request,
        MembershipApplication $application,
        SaveCompanyIdentityAction $action
    ): JsonResponse {
        $action->execute($application, CompanyIdentityData::fromRequest($request));
        return $this->saved();
    }

    public function registration(
        SaveCompanyRegistrationRequest $request,
        MembershipApplication $application,
        SaveCompanyRegistrationAction $action
    ): JsonResponse {
        $action->execute($application, CompanyRegistrationData::fromRequest($request));
        return $this->saved();
    }

    public function background(
        SaveCompanyBackgroundRequest $request,
        MembershipApplication $application,
        SaveCompanyBackgroundAction $action
    ): JsonResponse {
        $action->execute($application, CompanyBackgroundData::fromRequest($request));
        return $this->saved();
    }

    private function saved(): JsonResponse
    {
        return response()->json([
            'message' => 'پیش‌نویس ذخیره شد.',
            'saved_at' => now()->toIso8601String(),
        ]);
    }
}
