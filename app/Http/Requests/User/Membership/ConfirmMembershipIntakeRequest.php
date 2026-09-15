<?php

namespace App\Http\Requests\User\Membership;

use App\Support\PersianNumber;
use Illuminate\Foundation\Http\FormRequest;

class ConfirmMembershipIntakeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'representative_mobile' => PersianNumber::digitsOnly($this->input('representative_mobile')),
        ]);
    }

    public function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'representative_name' => ['required', 'string', 'max:255'],
            'representative_mobile' => ['required', 'regex:/^09\d{9}$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'representative_mobile.regex' => 'شماره موبایل نماینده باید با 09 شروع شود و 11 رقم باشد.',
        ];
    }
}
