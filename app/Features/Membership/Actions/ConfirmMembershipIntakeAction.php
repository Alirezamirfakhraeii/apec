<?php

namespace App\Features\Membership\Actions;

use App\Features\Membership\Data\MembershipIntakeData;
use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;
use Illuminate\Support\Facades\DB;

final class ConfirmMembershipIntakeAction
{
    public function execute(MembershipApplication $application, MembershipIntakeData $data): void
    {
        DB::transaction(function () use ($application, $data) {
            $application->update([
                'intake_company_name' => $data->companyName,
                'representative_name' => $data->representativeName,
                'representative_mobile' => $data->representativeMobile,
                'intake_confirmed_at' => now(),
            ]);

            $profile = MembershipCompanyProfile::firstOrCreate(
                ['membership_application_id' => $application->id]
            );

            if (blank($profile->registered_name)) {
                $profile->update(['registered_name' => $data->companyName]);
            }
        });
    }
}
