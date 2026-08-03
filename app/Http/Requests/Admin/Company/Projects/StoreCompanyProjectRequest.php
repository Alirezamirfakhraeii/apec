<?php

namespace App\Http\Requests\Admin\Company\Projects;

use Illuminate\Foundation\Http\FormRequest;
use Morilog\Jalali\Jalalian;
use Throwable;

class StoreCompanyProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'company_id' => [
                'required',
                'integer',
                'exists:companies,id',
            ],

            'project_name' => [
                'required',
                'string',
                'max:255',
            ],

            'employer' => [
                'nullable',
                'string',
                'max:255',
            ],

            'start_date' => [
                'nullable',
                'string',
                'regex:/^\d{4}\/\d{2}\/\d{2}$/',
            ],

            'end_date' => [
                'nullable',
                'string',
                'regex:/^\d{4}\/\d{2}\/\d{2}$/',
            ],

            'service_description' => [
                'nullable',
                'string',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id' => 'شرکت عضو',
            'project_name' => 'نام پروژه',
            'employer' => 'کارفرما',
            'start_date' => 'تاریخ شروع',
            'end_date' => 'تاریخ پایان',
            'service_description' => 'شرح خدمات',
        ];
    }

    public function messages(): array
    {
        return [
            'company_id.required' => 'انتخاب شرکت عضو الزامی است.',
            'company_id.exists' => 'شرکت انتخاب‌شده معتبر نیست.',

            'project_name.required' => 'وارد کردن نام پروژه الزامی است.',
            'project_name.max' => 'نام پروژه نباید بیشتر از ۲۵۵ کاراکتر باشد.',

            'start_date.regex' => 'تاریخ شروع باید به‌صورت 1405/05/12 وارد شود.',
            'end_date.regex' => 'تاریخ پایان باید به‌صورت 1405/05/12 وارد شود.',
        ];
    }

    /**
     * بررسی معتبر بودن تاریخ شمسی و ترتیب تاریخ‌ها
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $startDate = $this->parseJalaliDate(
                $this->input('start_date'),
                'start_date',
                $validator
            );

            $endDate = $this->parseJalaliDate(
                $this->input('end_date'),
                'end_date',
                $validator
            );

            if (
                $startDate &&
                $endDate &&
                $endDate->lt($startDate)
            ) {
                $validator->errors()->add(
                    'end_date',
                    'تاریخ پایان نمی‌تواند قبل از تاریخ شروع باشد.'
                );
            }
        });
    }

    private function parseJalaliDate(
        ?string $date,
        string $field,
                $validator
    ) {
        if (blank($date)) {
            return null;
        }

        /*
         * اگر فرمت اولیه اشتباه باشد، خطای regex نمایش داده می‌شود.
         */
        if (! preg_match('/^\d{4}\/\d{2}\/\d{2}$/', $date)) {
            return null;
        }

        try {
            return Jalalian::fromFormat('Y/m/d', $date)->toCarbon();
        } catch (Throwable $exception) {
            $validator->errors()->add(
                $field,
                'تاریخ واردشده معتبر نیست.'
            );

            return null;
        }
    }


}
