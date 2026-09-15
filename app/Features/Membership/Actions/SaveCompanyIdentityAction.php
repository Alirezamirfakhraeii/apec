<?php

namespace App\Features\Membership\Actions;

use App\Features\Membership\Data\CompanyIdentityData;
use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;

final class SaveCompanyIdentityAction
{
    public function execute(MembershipApplication $application, CompanyIdentityData $data): MembershipCompanyProfile
    {
        return MembershipCompanyProfile::updateOrCreate(
            ['membership_application_id' => $application->id],
            [
                'company_short_name' => $data->companyShortName,
                'registered_name' => $data->registeredName,
                'company_name_en' => $data->companyNameEn,
                'nationality' => $data->nationality,
                'company_type' => $data->companyType,
                'parent_company_name' => $data->parentCompanyName,
            ]
        );
    }
}
