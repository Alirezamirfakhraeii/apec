<?php

namespace App\Http\Controllers\User\Membership;

use App\Enums\MembershipDocumentType;
use App\Features\Membership\Actions\UploadMembershipDocumentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Membership\UploadMembershipDocumentRequest;
use App\Models\MembershipApplication;
use App\Models\MembershipApplicationDocument;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

final class DocumentController extends Controller
{
    public function store(
        UploadMembershipDocumentRequest $request,
        MembershipApplication $application,
        UploadMembershipDocumentAction $action
    ): JsonResponse {
        $type = MembershipDocumentType::from($request->validated('type'));
        $document = $action->execute($application, $type, $request->file('file'));

        return response()->json([
            'message' => 'مدرک بارگذاری شد.',
            'document' => [
                'id' => $document->id,
                'name' => $document->original_name,
                'type' => $document->type->value,
                'url' => Storage::disk($document->disk)->url($document->path),
            ],
        ]);
    }

    public function destroy(
        Request $request,
        MembershipApplication $application,
        MembershipApplicationDocument $document
    ): JsonResponse {
        Gate::authorize('update', $application);
        abort_unless($document->membership_application_id === $application->id, 404);

        Storage::disk($document->disk)->delete($document->path);
        $document->delete();

        return response()->json(['message' => 'مدرک حذف شد.']);
    }
}
