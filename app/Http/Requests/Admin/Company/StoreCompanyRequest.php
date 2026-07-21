<?php

namespace App\Http\Requests\Admin\Company;

use Illuminate\Validation\Rule;

class StoreCompanyRequest extends CompanyRequest
{
    public function rules(): array
    {
        $rules = $this->commonRules();

        /*
         * در زمان ثبت، شناسه ملی نباید از قبل وجود داشته باشد.
         */
        $rules['national_id'] = [
            'required',
            'string',
            'max:50',
            Rule::unique('companies', 'national_id'),
        ];

        return $rules;
    }
}
