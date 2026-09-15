<?php

namespace App\Http\Requests\User\Membership;

use App\Enums\CompanyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveCompanyIdentityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('application')) ?? false;
    }

    public function rules(): array
    {
        return [
            'company_short_name' => ['nullable', 'string', 'max:255'],
            'registered_name' => ['nullable', 'string', 'max:255'],
            'company_name_en' => ['nullable', 'string', 'max:255'],
            'nationality' => ['nullable', Rule::in(['ایرانی', 'غیرایرانی'])],
            'company_type' => ['nullable', Rule::enum(CompanyType::class)],
            'parent_company_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
