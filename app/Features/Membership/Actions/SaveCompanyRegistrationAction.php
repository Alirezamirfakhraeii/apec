<?php

namespace App\Features\Membership\Actions;

use App\Features\Membership\Data\CompanyRegistrationData;
use App\Models\MembershipApplication;
use App\Models\MembershipCompanyProfile;

final class SaveCompanyRegistrationAction
{
    public function execute(MembershipApplication $application, CompanyRegistrationData $data): MembershipCompanyProfile
    {
        return MembershipCompanyProfile::updateOrCreate(
            ['membership_application_id' => $application->id],
            [
                'registration_date' => $data->registrationDate,
                'registration_number' => $data->registrationNumber,
                'registration_place' => $data->registrationPlace,
                'national_id' => $data->nationalId,
                'registered_capital_irr' => $data->registeredCapitalIrr,
                'reference_gazette_date' => $data->referenceGazetteDate,
            ]
        );
    }
}
