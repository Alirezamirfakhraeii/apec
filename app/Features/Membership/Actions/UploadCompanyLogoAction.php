<?php

namespace App\Features\Membership\Actions;

use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class UploadCompanyLogoAction
{
    public function execute(MembershipApplication $application, UploadedFile $file): string
    {
        $profile = MembershipCompanyProfile::firstOrCreate([
            'membership_application_id' => $application->id,
        ]);

        if ($profile->logo_path) {
            Storage::disk('public')->delete($profile->logo_path);
        }

        $path = $file->store("membership-applications/{$application->id}/logo", 'public');
        $profile->update(['logo_path' => $path]);

        return $path;
    }
}
