<?php

namespace App\Http\Controllers\Front\User\Membership;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\SaveShareholderRequest;
use App\Models\MembershipApplication;
use App\Models\MembershipApplicationShareholder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

final class ShareholderController extends Controller
{
    public function store(
        SaveShareholderRequest $request,
        MembershipApplication $application
    ): JsonResponse {
        $currentTotal = (float) $application->shareholders()->sum('ownership_percentage');
        $newPercentage = (float) $request->validated('ownership_percentage');

        if ($currentTotal + $newPercentage > 100.01) {
            return response()->json([
                'message' => 'مجموع درصد سهامداران نمی‌تواند بیشتر از 100 درصد باشد.',
                'errors' => ['ownership_percentage' => ['مجموع درصد سهام بیشتر از 100 درصد می‌شود.']],
            ], 422);
        }

        $shareholder = $application->shareholders()->create([
            'full_name' => $request->validated('full_name'),
            'ownership_percentage' => $newPercentage,
            'sort_order' => (int) $application->shareholders()->max('sort_order') + 1,
        ]);

        return response()->json([
            'message' => 'سهامدار اضافه شد.',
            'shareholder' => $shareholder,
        ], 201);
    }

    public function destroy(
        Request $request,
        MembershipApplication $application,
        MembershipApplicationShareholder $shareholder
    ): JsonResponse {
        Gate::authorize('update', $application);
        abort_unless($shareholder->membership_application_id === $application->id, 404);

        $shareholder->delete();
        return response()->json(['message' => 'سهامدار حذف شد.']);
    }
}
