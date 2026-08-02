<?php

namespace App\Http\Requests\Admin\Media;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'caption' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'alt' => $this->filled('alt')
                ? trim((string) $this->input('alt'))
                : null,

            'caption' => $this->filled('caption')
                ? trim((string) $this->input('caption'))
                : null,
        ]);
    }
}
