<?php
namespace App\Features\Membership\Data;
use App\Http\Requests\User\Membership\UpdateCompanyQualificationsRequest;
use Illuminate\Http\UploadedFile;
final readonly class CompanyQualificationsData
{
    public function __construct(public int $activityExperienceYears,public string $oilGasPetchemSpecialty,public bool $isChamberMember,public ?UploadedFile $latestGeneralAssemblyMinutes,public ?UploadedFile $latestCapitalGazette,public ?UploadedFile $originalCertificate,public ?UploadedFile $companyResume,public ?UploadedFile $chamberMembershipCard){}
    public static function fromRequest(UpdateCompanyQualificationsRequest $r): self { return new self((int)$r->validated('activity_experience_years'),$r->validated('oil_gas_petchem_specialty'),$r->boolean('is_chamber_member'),$r->file('latest_general_assembly_minutes'),$r->file('latest_capital_gazette'),$r->file('original_certificate'),$r->file('company_resume'),$r->file('chamber_membership_card')); }
}
