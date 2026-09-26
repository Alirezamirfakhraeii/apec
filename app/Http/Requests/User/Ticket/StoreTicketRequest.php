<?php

namespace App\Http\Requests\User\Ticket;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:200'],
            'priority' => ['required', Rule::in(['low', 'normal', 'high'])],
            'message' => ['required', 'string', 'min:3', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'موضوع تیکت الزامی است.',
            'priority.required' => 'اولویت تیکت را انتخاب کنید.',
            'priority.in' => 'اولویت انتخاب‌شده معتبر نیست.',
            'message.required' => 'متن پیام الزامی است.',
            'message.min' => 'متن پیام خیلی کوتاه است.',
        ];
    }
}
