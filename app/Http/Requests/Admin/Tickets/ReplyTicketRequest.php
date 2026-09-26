<?php

namespace App\Http\Requests\Admin\Tickets;

use Illuminate\Foundation\Http\FormRequest;

class ReplyTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'message' => [
                'required',
                'string',
                'min:2',
                'max:5000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'متن پاسخ الزامی است.',
            'message.min' => 'متن پاسخ خیلی کوتاه است.',
            'message.max' => 'متن پاسخ نباید بیشتر از ۵۰۰۰ کاراکتر باشد.',
        ];
    }
}
