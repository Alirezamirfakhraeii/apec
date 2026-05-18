<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // تغییر به true برای اجازه دسترسی
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * محلی‌سازی پیام‌های خطا با توجه به چندزبانه بودن سایت
     */
    public function attributes(): array
    {
        return [
            'email'    => __('Email Address'),
            'password' => __('Password'),
        ];
    }
}
