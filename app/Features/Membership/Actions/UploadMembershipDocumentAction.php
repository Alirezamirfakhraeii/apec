<?php

namespace App\Features\Membership\Actions;

use App\Enums\MembershipDocumentType;
use App\Models\MembershipApplication;
use App\Models\MembershipApplicationDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadMembershipDocumentAction
{
    public function execute(
        MembershipApplication $application,
        MembershipDocumentType $type,
        UploadedFile $file
    ): MembershipApplicationDocument {
        $existing = MembershipApplicationDocument::query()
            ->where('membership_application_id', $application->id)
            ->where('type', $type->value)
            ->first();

        if ($existing) {
            Storage::disk($existing->disk)->delete($existing->path);
        }

        $path = $file->store(
            "membership-applications/{$application->id}/documents/{$type->value}",
            'public'
        );

        return MembershipApplicationDocument::updateOrCreate(
            [
                'membership_application_id' => $application->id,
                'type' => $type->value,
            ],
            [
                'disk' => 'public',
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]
        );
    }
}
