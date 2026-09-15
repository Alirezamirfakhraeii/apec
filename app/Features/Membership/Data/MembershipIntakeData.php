<?php
namespace App\Features\Membership\Data;
use App\Http\Requests\User\Membership\StoreMembershipIntakeRequest;
final readonly class MembershipIntakeData
{
    public function __construct(public string $companyName,public string $representativeName,public string $representativeMobile){}
    public static function fromRequest(StoreMembershipIntakeRequest $r): self { return new self($r->validated('intake_company_name'),$r->validated('representative_name'),$r->validated('representative_mobile')); }
}
