<?php

namespace App\Features\Membership\Actions;

use App\Features\Membership\Data\CompanyBackgroundData;
use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;

final class SaveCompanyBackgroundAction
{
    public function execute(MembershipApplication $application, CompanyBackgroundData $data): MembershipCompanyProfile
    {
        return MembershipCompanyProfile::updateOrCreate(
            ['membership_application_id' => $application->id],
            [
                'activity_history_years' => $data->activityHistoryYears,
                'oil_gas_petro_specialty' => $data->oilGasPetroSpecialty,
                'is_chamber_member' => $data->isChamberMember,
            ]
        );
    }
}
