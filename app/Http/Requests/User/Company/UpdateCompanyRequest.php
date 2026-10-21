<?php

namespace App\Http\Requests\User\Company;

use App\Enums\MembershipDocumentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->companies()->exists() ?? false;
    }


    protected function prepareForValidation(): void
    {
        $company = $this->input('company', []);

        $booleanFields = [
            'has_valid_commercial_card',
            'has_valid_chamber_membership_card',

            'activity_design_consulting',
            'activity_construction_installation',
            'activity_epc',
            'activity_mc',
            'activity_manufacturing',
        ];

        foreach ($booleanFields as $field) {
            $company[$field] = filter_var(
                $company[$field] ?? false,
                FILTER_VALIDATE_BOOLEAN
            );
        }

        $this->merge([
            'company' => $company,
        ]);
    }


    public function rules(): array
    {
        $companyId = $this->user()
            ?->companies()
            ->value('companies.id');


        $rules = [

            /*
            |--------------------------------------------------------------------------
            | Company
            |--------------------------------------------------------------------------
            */

            'company' => [
                'required',
                'array',
            ],

            'company.logo' => [
                'nullable',
                'image',
                'max:5120',
            ],

            'company.membership_card' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp',
                'max:10240',
            ],

            'company.company_short_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.registered_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.company_name_en' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.nationality' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.registration_date' => [
                'nullable',
                'string',
                'max:20',
            ],

            'company.registration_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.registration_place' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.national_id' => [
                'nullable',
                'string',
                'max:255',

                Rule::unique(
                    'companies',
                    'national_id'
                )->ignore($companyId),
            ],

            'company.registered_capital_irr' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'company.parent_company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.company_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.phone' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.fax' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'company.website' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.address' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | CEO
            |--------------------------------------------------------------------------
            */

            'company.ceo_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.ceo_mobile' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.ceo_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Chairman
            |--------------------------------------------------------------------------
            */

            'company.chairman_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.chairman_mobile' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.chairman_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Association Contact
            |--------------------------------------------------------------------------
            */

            'company.association_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.association_contact_position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.association_contact_mobile' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.association_contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Membership
            |--------------------------------------------------------------------------
            */

            'company.association_join_date' => [
                'nullable',
                'string',
                'max:20',
            ],

            'company.membership_number' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.membership_type' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.membership_status' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company.membership_status_notes_1403' => [
                'nullable',
                'string',
            ],

            'company.association_committees' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Commercial
            |--------------------------------------------------------------------------
            */

            'company.has_valid_commercial_card' => [
                'required',
                'boolean',
            ],

            'company.commercial_card_valid_until' => [
                'nullable',
                'string',
                'max:20',
            ],

            'company.has_valid_chamber_membership_card' => [
                'required',
                'boolean',
            ],

            'company.chamber_membership_valid_until' => [
                'nullable',
                'string',
                'max:20',
            ],

            'company.chamber_province' => [
                'nullable',
                'string',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Activity Flags
            |--------------------------------------------------------------------------
            */

            'company.activity_design_consulting' => [
                'required',
                'boolean',
            ],

            'company.activity_construction_installation' => [
                'required',
                'boolean',
            ],

            'company.activity_epc' => [
                'required',
                'boolean',
            ],

            'company.activity_mc' => [
                'required',
                'boolean',
            ],

            'company.activity_manufacturing' => [
                'required',
                'boolean',
            ],

            'company.activity_type' => [
                'nullable',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Activity Fields
            |--------------------------------------------------------------------------
            */

            'activity_fields' => [
                'nullable',
                'array',
            ],

            'activity_fields.*' => [
                'integer',
                'distinct',

                Rule::exists(
                    'activity_fields',
                    'id'
                )->where(
                    'is_active',
                    true
                ),
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
                'nullable',
                'string',
                'max:255',
            ],

            'shareholders.*.ownership_percentage' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
            ],


            /*
            |--------------------------------------------------------------------------
            | Projects
            |--------------------------------------------------------------------------
            */

            'projects' => [
                'nullable',
                'array',
            ],

            'projects.*.id' => [
                'nullable',
                'integer',
            ],

            'projects.*.project_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'projects.*.employer' => [
                'nullable',
                'string',
                'max:255',
            ],

            'projects.*.start_date' => [
                'nullable',
                'date',
            ],

            'projects.*.end_date' => [
                'nullable',
                'date',
            ],

            'projects.*.service_description' => [
                'nullable',
                'string',
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
        ];


        foreach (
            MembershipDocumentType::cases()
            as $type
        ) {
            $rules[
            'documents.' . $type->value
            ] = [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,webp,doc,docx,xls,xlsx',
                'max:10240',
            ];
        }


        return $rules;
    }


    public function after(): array
    {
        return [

            function (Validator $validator) {

                /*
                |--------------------------------------------------------------------------
                | Shareholders
                |--------------------------------------------------------------------------
                */

                foreach (
                    $this->input(
                        'shareholders',
                        []
                    )
                    as $index => $row
                ) {

                    $hasName = filled(
                        $row['full_name'] ?? null
                    );

                    $hasPercentage = filled(
                        $row['ownership_percentage'] ?? null
                    );


                    if (
                        $hasPercentage
                        && ! $hasName
                    ) {
                        $validator
                            ->errors()
                            ->add(
                                "shareholders.$index.full_name",
                                'نام سهامدار را وارد کنید.'
                            );
                    }
                }


                /*
                |--------------------------------------------------------------------------
                | Projects
                |--------------------------------------------------------------------------
                */

                foreach (
                    $this->input(
                        'projects',
                        []
                    )
                    as $index => $row
                ) {

                    $hasAnyData =
                        filled($row['project_name'] ?? null)
                        ||
                        filled($row['employer'] ?? null)
                        ||
                        filled($row['start_date'] ?? null)
                        ||
                        filled($row['end_date'] ?? null)
                        ||
                        filled(
                            $row['service_description']
                            ?? null
                        );


                    if (
                        $hasAnyData
                        &&
                        blank(
                            $row['project_name']
                            ?? null
                        )
                    ) {
                        $validator
                            ->errors()
                            ->add(
                                "projects.$index.project_name",
                                'نام پروژه را وارد کنید.'
                            );
                    }


                    if (
                        filled($row['start_date'] ?? null)
                        &&
                        filled($row['end_date'] ?? null)
                        &&
                        $row['end_date']
                        < $row['start_date']
                    ) {
                        $validator
                            ->errors()
                            ->add(
                                "projects.$index.end_date",
                                'تاریخ پایان نمی‌تواند قبل از تاریخ شروع باشد.'
                            );
                    }
                }

            },

        ];
    }
}
