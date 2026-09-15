<?php

namespace App\Http\Requests\User\Membership;

use App\Rules\JalaliDate;
use App\Support\PersianNumber;
use Illuminate\Foundation\Http\FormRequest;

class SaveCompanyRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('application')) ?? false;
    }

    protected function prepareForValidation(): void
    {
        $capital = PersianNumber::toEnglish((string) $this->input('registered_capital_irr', ''));
        $capital = str_replace([',', '٬', ' '], '', $capital);

        $this->merge([
            'registration_number' => PersianNumber::toEnglish($this->input('registration_number')),
            'national_id' => PersianNumber::toEnglish($this->input('national_id')),
            'registered_capital_irr' => $capital === '' ? null : $capital,
        ]);
    }

    public function rules(): array
    {
        return [
            'registration_date' => ['nullable', 'string', new JalaliDate],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'registration_place' => ['nullable', 'string', 'max:255'],
            'national_id' => ['nullable', 'string', 'max:20'],
            'registered_capital_irr' => ['nullable', 'integer', 'min:0'],
            'reference_gazette_date' => ['nullable', 'string', new JalaliDate],
        ];
    }
}
