<?php

namespace App\Http\Requests\Admin\Company;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        /*
         * دسترسی ادمین توسط middleware کنترل می‌شود.
         */
        return true;
    }

    protected function commonRules(): array
    {
        return [
            /*
            |--------------------------------------------------------------------------
            | اطلاعات پایه شرکت
            |--------------------------------------------------------------------------
            */

            'company_short_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'registered_name' => [
                'required',
                'string',
                'max:255',
            ],

            'membership_card' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company_name_en' => [
                'nullable',
                'string',
                'max:255',
            ],

            'nationality' => [
                'nullable',
                'string',
                'max:100',
            ],

            'parent_company_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'company_type' => [
                'nullable',
                'string',
                Rule::in([
                    'سهامی عام',
                    'سهامی خاص',
                    'مسئولیت محدود',
                    'تعاونی',
                    'سایر',
                ]),
            ],

            /*
            |--------------------------------------------------------------------------
            | اطلاعات ثبتی
            |--------------------------------------------------------------------------
            */

            'registration_date' => [
                'nullable',
                'string',
                'max:20',
            ],

            'registration_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'registration_place' => [
                'nullable',
                'string',
                'max:255',
            ],

            'national_id' => [
                'required',
                'string',
                'max:50',
            ],

            'registered_capital_irr' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'reference_gazette_date' => [
                'nullable',
                'string',
                'max:20',
            ],

            /*
            |--------------------------------------------------------------------------
            | اطلاعات تماس
            |--------------------------------------------------------------------------
            */

            'phone' => [
                'nullable',
                'string',
                'max:100',
            ],

            'fax' => [
                'nullable',
                'string',
                'max:100',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'website' => [
                'nullable',
                'string',
                'max:255',
            ],

            'address' => [
                'nullable',
                'string',
                'max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | اطلاعات مدیرعامل
            |--------------------------------------------------------------------------
            */

            'ceo_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'ceo_mobile' => [
                'nullable',
                'string',
                'max:100',
            ],

            'ceo_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | رئیس هیئت‌مدیره
            |--------------------------------------------------------------------------
            */

            'chairman_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'chairman_mobile' => [
                'nullable',
                'string',
                'max:100',
            ],

            'chairman_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | رابط انجمن
            |--------------------------------------------------------------------------
            */

            'association_contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'association_contact_position' => [
                'nullable',
                'string',
                'max:255',
            ],

            'association_contact_mobile' => [
                'nullable',
                'string',
                'max:100',
            ],

            'association_contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | اطلاعات عضویت
            |--------------------------------------------------------------------------
            */

            'association_join_date' => [
                'nullable',
                'string',
                'max:20',
            ],

            'membership_number' => [
                'nullable',
                'string',
                'max:100',
            ],

            'membership_type' => [
                'nullable',
                Rule::in([
                    'اصلی',
                    'وابسته',
                ]),
            ],

            'membership_status' => [
                'nullable',
                Rule::in([
                    'فعال',
                    'تعلیق',
                    'لغو',
                ]),
            ],

            'membership_status_notes_1403' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'association_committees' => [
                'nullable',
                'string',
                'max:5000',
            ],

            /*
            |--------------------------------------------------------------------------
            | کارت‌های بازرگانی
            |--------------------------------------------------------------------------
            */

            'has_valid_commercial_card' => [
                'nullable',
                'boolean',
            ],

            'commercial_card_valid_until' => [
                'nullable',
                'string',
                'max:20',
            ],

            'has_valid_chamber_membership_card' => [
                'nullable',
                'boolean',
            ],

            'chamber_membership_valid_until' => [
                'nullable',
                'string',
                'max:20',
            ],

            'chamber_province' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | حوزه فعالیت
            |--------------------------------------------------------------------------
            */

            'activity_design_consulting' => [
                'nullable',
                'boolean',
            ],

            'activity_construction_installation' => [
                'nullable',
                'boolean',
            ],

            'activity_epc' => [
                'nullable',
                'boolean',
            ],

            'activity_mc' => [
                'nullable',
                'boolean',
            ],

            'activity_manufacturing' => [
                'nullable',
                'boolean',
            ],

            'activity_type' => [
                'nullable',
                'string',
                'max:10000',
            ],

            /*
            |--------------------------------------------------------------------------
            | لوگوی شرکت
            |--------------------------------------------------------------------------
            */

            'logo' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
             * در فرم ویرایش برای حذف لوگوی قبلی استفاده می‌شود.
             */
            'remove_logo' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $digitFields = [
            'national_id',
            'registration_number',
            'membership_number',
            'registered_capital_irr',
            'phone',
            'fax',
            'ceo_mobile',
            'chairman_mobile',
            'association_contact_mobile',
        ];

        $normalizedData = [];

        foreach ($digitFields as $field) {
            if ($this->filled($field)) {
                $normalizedData[$field] = $this->normalizeDigits(
                    $this->input($field)
                );
            }
        }

        /*
         * رشته‌های خالی را به null تبدیل می‌کنیم.
         */
        foreach ($this->all() as $field => $value) {
            if (is_string($value) && trim($value) === '') {
                $normalizedData[$field] = null;
            }
        }

        $this->merge($normalizedData);
    }

    private function normalizeDigits(mixed $value): mixed
    {
        if (! is_string($value) && ! is_numeric($value)) {
            return $value;
        }

        $value = (string) $value;

        $persianDigits = [
            '۰', '۱', '۲', '۳', '۴',
            '۵', '۶', '۷', '۸', '۹',
        ];

        $arabicDigits = [
            '٠', '١', '٢', '٣', '٤',
            '٥', '٦', '٧', '٨', '٩',
        ];

        $englishDigits = [
            '0', '1', '2', '3', '4',
            '5', '6', '7', '8', '9',
        ];

        $value = str_replace(
            $persianDigits,
            $englishDigits,
            $value
        );

        $value = str_replace(
            $arabicDigits,
            $englishDigits,
            $value
        );

        /*
         * جداکننده عدد مثل 1,000,000 را حذف می‌کنیم.
         */
        return str_replace([',', '٬'], '', trim($value));
    }

    public function messages(): array
    {
        return [
            'registered_name.required' =>
                'وارد کردن نام ثبتی شرکت الزامی است.',

            'registered_name.max' =>
                'نام ثبتی شرکت نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'national_id.required' =>
                'وارد کردن شناسه ملی شرکت الزامی است.',

            'national_id.unique' =>
                'شرکتی با این شناسه ملی قبلاً ثبت شده است.',

            'email.email' =>
                'فرمت ایمیل شرکت صحیح نیست.',

            'ceo_email.email' =>
                'فرمت ایمیل مدیرعامل صحیح نیست.',

            'chairman_email.email' =>
                'فرمت ایمیل رئیس هیئت‌مدیره صحیح نیست.',

            'association_contact_email.email' =>
                'فرمت ایمیل رابط انجمن صحیح نیست.',

            'registered_capital_irr.integer' =>
                'سرمایه ثبتی باید یک عدد صحیح باشد.',

            'registered_capital_irr.min' =>
                'سرمایه ثبتی نمی‌تواند منفی باشد.',

            'company_type.in' =>
                'نوع شرکت انتخاب‌شده معتبر نیست.',

            'membership_type.in' =>
                'نوع عضویت انتخاب‌شده معتبر نیست.',

            'membership_status.in' =>
                'وضعیت عضویت انتخاب‌شده معتبر نیست.',

            'logo.image' =>
                'فایل لوگو باید یک تصویر معتبر باشد.',

            'logo.mimes' =>
                'فرمت لوگو باید jpg، jpeg، png یا webp باشد.',

            'logo.max' =>
                'حجم لوگو نباید بیشتر از ۲ مگابایت باشد.',

            '*.boolean' =>
                'مقدار انتخاب‌شده باید بله یا خیر باشد.',
        ];
    }

    public function attributes(): array
    {
        return [
            'registered_name' => 'نام ثبتی شرکت',
            'company_short_name' => 'نام اختصاری شرکت',
            'company_name_en' => 'نام انگلیسی شرکت',
            'national_id' => 'شناسه ملی',
            'registration_number' => 'شماره ثبت',
            'registered_capital_irr' => 'سرمایه ثبتی',
            'membership_number' => 'شماره عضویت',
            'membership_type' => 'نوع عضویت',
            'membership_status' => 'وضعیت عضویت',
            'activity_type' => 'نوع فعالیت',
            'logo' => 'لوگوی شرکت',
        ];
    }
}
