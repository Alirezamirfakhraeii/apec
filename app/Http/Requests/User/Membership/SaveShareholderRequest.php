<?php

namespace App\Http\Requests\User\Membership;

use App\Support\PersianNumber;
use Illuminate\Foundation\Http\FormRequest;

class SaveShareholderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('application')) ?? false;
    }

    protected function prepareForValidation(): void
    {
        $percentage = PersianNumber::toEnglish((string) $this->input('ownership_percentage', ''));
        $percentage = str_replace(',', '.', $percentage);

        $this->merge(['ownership_percentage' => $percentage]);
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'ownership_percentage' => ['required', 'numeric', 'gt:0', 'lte:100'],
        ];
    }
}
