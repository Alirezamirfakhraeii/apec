<?php
namespace App\Http\Requests\User\Membership;
use App\Enums\MembershipDocumentType;
use App\Models\MembershipApplication;
use App\Rules\JalaliDate;
use App\Support\PersianDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
class UpdateCompanyRegistrationInfoRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $capital=$this->input('registered_capital_irr');
        if(is_string($capital)){ $capital=PersianDate::toEnglishDigits($capital); $capital=str_replace([',','٬','،',' '],'',$capital); }
        $shareholders=collect($this->input('shareholders',[]))->map(function($s){ if(isset($s['ownership_percentage'])) $s['ownership_percentage']=PersianDate::toEnglishDigits((string)$s['ownership_percentage']); return $s; })->values()->all();
        $this->merge(['registered_capital_irr'=>$capital,'shareholders'=>$shareholders]);
    }
    public function authorize(): bool { $a=$this->route('application'); return $a instanceof MembershipApplication && $this->user()!==null && $a->user_id===$this->user()->id && $a->isEditable(); }
    public function rules(): array
    {
        $a=$this->route('application');
        $has=$a->documents()->where('type',MembershipDocumentType::OfficialGazette->value)->exists();
        return ['registration_date'=>['required','string',new JalaliDate()],'registration_number'=>['required','string','max:100'],'registration_place'=>['required','string','max:255'],'registered_capital_irr'=>['required','integer','min:0'],'reference_gazette_date'=>['required','string',new JalaliDate()],'official_gazette'=>[$has?'nullable':'required','file','mimes:jpg,jpeg,png,pdf','max:10240'],'shareholders'=>['required','array','min:1'],'shareholders.*.full_name'=>['required','string','max:255'],'shareholders.*.ownership_percentage'=>['required','numeric','gt:0','lte:100']];
    }
    public function after(): array
    {
        return [function(Validator $v): void { $s=$this->input('shareholders',[]); if(empty($s)) return; $total=collect($s)->sum(fn(array $x)=>(float)($x['ownership_percentage']??0)); if(abs($total-100)>0.01) $v->errors()->add('shareholders','مجموع درصد سهامداران باید دقیقاً ۱۰۰ درصد باشد.'); }];
    }
}
