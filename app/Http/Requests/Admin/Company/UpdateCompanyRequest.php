<?php

namespace App\Http\Requests\Admin\Company;

use App\Models\Company;
use Illuminate\Validation\Rule;

class UpdateCompanyRequest extends CompanyRequest
{
    public function rules(): array
    {
        $rules = $this->commonRules();

        $company = $this->route('company');

        $companyId = $company instanceof Company
            ? $company->getKey()
            : $company;

        $rules['national_id'] = [
            'required',
            'string',
            'max:50',
            Rule::unique('companies', 'national_id')
                ->ignore($companyId),
        ];

        return $rules;
    }
}
