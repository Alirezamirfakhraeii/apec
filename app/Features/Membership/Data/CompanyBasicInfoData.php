<?php
namespace App\Features\Membership\Data;
use App\Http\Requests\User\Membership\UpdateCompanyBasicInfoRequest;
use Illuminate\Http\UploadedFile;
final readonly class CompanyBasicInfoData
{
    public function __construct(public ?UploadedFile $logo,public ?string $companyShortName,public string $registeredName,public ?string $companyNameEn,public ?string $nationality,public string $companyType,public ?string $parentCompanyName){}
    public static function fromRequest(UpdateCompanyBasicInfoRequest $r): self { return new self($r->file('logo'),$r->validated('company_short_name'),$r->validated('registered_name'),$r->validated('company_name_en'),$r->validated('nationality'),$r->validated('company_type'),$r->validated('parent_company_name')); }
}
