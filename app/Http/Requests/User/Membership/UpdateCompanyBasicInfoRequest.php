<?php
namespace App\Http\Requests\User\Membership;
use App\Enums\CompanyType;
use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateCompanyBasicInfoRequest extends FormRequest
{
    public function authorize(): bool { $a=$this->route('application'); return $a instanceof MembershipApplication && $this->user()!==null && $a->user_id===$this->user()->id && $a->isEditable(); }
    public function rules(): array { return ['logo'=>['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],'company_short_name'=>['nullable','string','max:255'],'registered_name'=>['required','string','max:255'],'company_name_en'=>['nullable','string','max:255'],'nationality'=>['nullable','string','max:255'],'company_type'=>['required',Rule::enum(CompanyType::class)],'parent_company_name'=>['nullable','string','max:255']]; }
}
