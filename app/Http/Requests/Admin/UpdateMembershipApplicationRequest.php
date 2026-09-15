<?php

namespace App\Http\Requests\Admin;

use App\Enums\CompanyType;
use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var MembershipApplication|null $application */
        $application = $this->route('application');

        if (! $application) {
            return false;
        }

        return $this->user()?->can(
            'update',
            $application
        ) ?? false;
    }

    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Intake
            |--------------------------------------------------------------------------
            */

            'intake_company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'representative_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'representative_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],


            /*
            |--------------------------------------------------------------------------
            | Company Profile
            |--------------------------------------------------------------------------
            */

            'profile' => [
                'required',
                'array',
            ],

            'profile.registered_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.company_short_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.company_name_en' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.nationality' => [
                'nullable',
                'string',
                'max:100',
            ],

            'profile.parent_company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.company_type' => [
                'nullable',
                Rule::enum(CompanyType::class),
            ],


            /*
            |--------------------------------------------------------------------------
            | Registration
            |--------------------------------------------------------------------------
            */

            'profile.registration_date' => [
                'nullable',
                'date',
            ],

            'profile.registration_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'profile.registration_place' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.national_id' => [
                'nullable',
                'string',
                'max:50',
            ],

            'profile.registered_capital_irr' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'profile.reference_gazette_date' => [
                'nullable',
                'date',
            ],


            /*
            |--------------------------------------------------------------------------
            | Contact
            |--------------------------------------------------------------------------
            */

            'profile.phone' => [
                'nullable',
                'string',
                'max:50',
            ],

            'profile.fax' => [
                'nullable',
                'string',
                'max:50',
            ],

            'profile.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'profile.website' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.address' => [
                'nullable',
                'string',
                'max:2000',
            ],


            /*
            |--------------------------------------------------------------------------
            | CEO
            |--------------------------------------------------------------------------
            */

            'profile.ceo_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.ceo_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],

            'profile.ceo_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Chairman
            |--------------------------------------------------------------------------
            */

            'profile.chairman_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.chairman_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],

            'profile.chairman_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Association Contact
            |--------------------------------------------------------------------------
            */

            'profile.association_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.association_contact_position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.association_contact_mobile' => [
                'nullable',
                'string',
                'max:20',
            ],

            'profile.association_contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Cards / Chamber
            |--------------------------------------------------------------------------
            */

            'profile.has_valid_commercial_card' => [
                'nullable',
                'boolean',
            ],

            'profile.commercial_card_valid_until' => [
                'nullable',
                'date',
            ],

            'profile.has_valid_chamber_membership_card' => [
                'nullable',
                'boolean',
            ],

            'profile.chamber_membership_valid_until' => [
                'nullable',
                'date',
            ],

            'profile.chamber_province' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.is_chamber_member' => [
                'nullable',
                'boolean',
            ],


            /*
            |--------------------------------------------------------------------------
            | Activity
            |--------------------------------------------------------------------------
            */

            'profile.activity_experience_years' => [
                'nullable',
                'integer',
                'min:0',
                'max:200',
            ],

            'activity_fields' => [
                'nullable',
                'array',
            ],

            'activity_fields.*' => [
                'integer',
                'distinct',
                'exists:activity_fields,id',
            ],

            'profile.oil_gas_petchem_specialty' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'profile.activity_design_consulting' => [
                'required',
                'boolean',
            ],

            'profile.activity_construction_installation' => [
                'required',
                'boolean',
            ],

            'profile.activity_epc' => [
                'required',
                'boolean',
            ],

            'profile.activity_mc' => [
                'required',
                'boolean',
            ],

            'profile.activity_manufacturing' => [
                'required',
                'boolean',
            ],

            'profile.activity_type' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'profile.membership_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'profile.association_committees' => [
                'nullable',
                'string',
                'max:5000',
            ],


            /*
            |--------------------------------------------------------------------------
            | Shareholders
            |--------------------------------------------------------------------------
            */

            'shareholders' => [
                'nullable',
                'array',
            ],



            'shareholders.*.id' => [
                'nullable',
                'integer',
            ],

            'shareholders.*.full_name' => [
                'required_with:shareholders',
                'string',
                'max:255',
            ],

            'shareholders.*.ownership_percentage' => [
                'required_with:shareholders',
                'numeric',
                'min:0',
                'max:100',
            ],


            /*
            |--------------------------------------------------------------------------
            | Documents
            |--------------------------------------------------------------------------
            */

            'documents' => [
                'nullable',
                'array',
            ],

            'documents.*' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [

            'profile.company_type.enum' =>
                'نوع شرکت انتخاب‌شده معتبر نیست.',

            'profile.email.email' =>
                'ایمیل شرکت معتبر نیست.',

            'profile.ceo_email.email' =>
                'ایمیل مدیرعامل معتبر نیست.',

            'profile.chairman_email.email' =>
                'ایمیل رئیس هیئت‌مدیره معتبر نیست.',

            'profile.association_contact_email.email' =>
                'ایمیل رابط انجمن معتبر نیست.',

            'shareholders.*.full_name.required_with' =>
                'نام سهامدار را وارد کنید.',

            'shareholders.*.ownership_percentage.required_with' =>
                'درصد سهام را وارد کنید.',

            'shareholders.*.ownership_percentage.max' =>
                'درصد سهام نمی‌تواند بیشتر از ۱۰۰ باشد.',

            'documents.*.mimes' =>
                'مدرک باید از نوع PDF، JPG، JPEG یا PNG باشد.',

            'documents.*.max' =>
                'حجم هر مدرک نمی‌تواند بیشتر از ۱۰ مگابایت باشد.',
        ];
    }
}
