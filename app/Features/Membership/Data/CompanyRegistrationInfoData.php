<?php
namespace App\Features\Membership\Data;
use App\Http\Requests\User\Membership\UpdateCompanyRegistrationInfoRequest;
use App\Support\PersianDate;
use Illuminate\Http\UploadedFile;
final readonly class CompanyRegistrationInfoData
{
    public function __construct(public string $registrationDate,public string $registrationNumber,public string $registrationPlace,public int $registeredCapitalIrr,public string $referenceGazetteDate,public array $shareholders,public ?UploadedFile $officialGazette){}
    public static function fromRequest(UpdateCompanyRegistrationInfoRequest $r): self { return new self(PersianDate::toGregorian($r->validated('registration_date')),$r->validated('registration_number'),$r->validated('registration_place'),(int)$r->validated('registered_capital_irr'),PersianDate::toGregorian($r->validated('reference_gazette_date')),$r->validated('shareholders'),$r->file('official_gazette')); }
}
