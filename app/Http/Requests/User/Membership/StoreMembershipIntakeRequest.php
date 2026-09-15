<?php
namespace App\Http\Requests\User\Membership;
use Illuminate\Foundation\Http\FormRequest;
class StoreMembershipIntakeRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $mobile=(string)$this->input('representative_mobile','');
        $mobile=strtr($mobile,['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9','٠'=>'0','١'=>'1','٢'=>'2','٣'=>'3','٤'=>'4','٥'=>'5','٦'=>'6','٧'=>'7','٨'=>'8','٩'=>'9']);
        $mobile=preg_replace('/\s+/','',$mobile);
        $this->merge(['representative_mobile'=>$mobile]);
    }
    public function authorize(): bool { return $this->user()!==null; }
    public function rules(): array { return ['intake_company_name'=>['required','string','max:255'],'representative_name'=>['required','string','max:255'],'representative_mobile'=>['required','string','regex:/^09\d{9}$/']]; }
    public function messages(): array { return ['intake_company_name.required'=>'نام شرکت را وارد کنید.','representative_name.required'=>'نام نماینده شرکت را وارد کنید.','representative_mobile.required'=>'شماره تماس نماینده را وارد کنید.','representative_mobile.regex'=>'شماره موبایل باید مانند 09121234567 باشد.']; }
}
