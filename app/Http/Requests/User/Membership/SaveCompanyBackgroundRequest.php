<?php

namespace App\Http\Requests\User\Membership;

use App\Support\PersianNumber;
use Illuminate\Foundation\Http\FormRequest;

class SaveCompanyBackgroundRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('application')) ?? false;
    }

    protected function prepareForValidation(): void
    {
        $years = PersianNumber::digitsOnly($this->input('activity_history_years'));

        $this->merge([
            'activity_history_years' => blank($years) ? null : $years,
            'is_chamber_member' => $this->input('is_chamber_member') === null
                ? null
                : filter_var($this->input('is_chamber_member'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }

    public function rules(): array
    {
        return [
            'activity_history_years' => ['nullable', 'integer', 'min:0', 'max:200'],
            'oil_gas_petro_specialty' => ['nullable', 'string', 'max:5000'],
            'is_chamber_member' => ['nullable', 'boolean'],
        ];
    }
}
