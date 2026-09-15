<?php
namespace App\Http\Requests\User\Membership;
use App\Enums\MembershipDocumentType;
use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCompanyQualificationsRequest extends FormRequest
{
    public function authorize(): bool { $a=$this->route('application'); return $a instanceof MembershipApplication && $this->user()!==null && $a->user_id===$this->user()->id && $a->isEditable(); }
    public function rules(): array
    {
        $a=$this->route('application');
        $has=fn(MembershipDocumentType $t): bool=>$a->documents()->where('type',$t->value)->exists();
        $ch=$this->boolean('is_chamber_member');
        return ['activity_experience_years'=>['required','integer','min:0','max:200'],'oil_gas_petchem_specialty'=>['required','string','max:5000'],'latest_general_assembly_minutes'=>[Rule::requiredIf(!$has(MembershipDocumentType::LatestGeneralAssemblyMinutes)),'nullable','file','mimes:jpg,jpeg,png,pdf','max:10240'],'latest_capital_gazette'=>[Rule::requiredIf(!$has(MembershipDocumentType::LatestCapitalGazette)),'nullable','file','mimes:jpg,jpeg,png,pdf','max:10240'],'original_certificate'=>[Rule::requiredIf(!$has(MembershipDocumentType::OriginalCertificate)),'nullable','file','mimes:jpg,jpeg,png,pdf','max:10240'],'company_resume'=>[Rule::requiredIf(!$has(MembershipDocumentType::CompanyResume)),'nullable','file','mimes:pdf,doc,docx','max:15360'],'is_chamber_member'=>['required','boolean'],'chamber_membership_card'=>[Rule::requiredIf($ch && !$has(MembershipDocumentType::ChamberMembershipCard)),'nullable','file','mimes:jpg,jpeg,png,pdf','max:10240']];
    }
}
