<?php

namespace App\Http\Controllers\User\Membership;

use App\Features\Membership\Actions\UploadCompanyLogoAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\UploadCompanyLogoRequest;
use App\Models\MembershipApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

final class LogoController extends Controller
{
    public function store(
        UploadCompanyLogoRequest $request,
        MembershipApplication $application,
        UploadCompanyLogoAction $action
    ): JsonResponse {
        $path = $action->execute($application, $request->file('logo'));

        return response()->json([
            'message' => 'لوگو بارگذاری شد.',
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
