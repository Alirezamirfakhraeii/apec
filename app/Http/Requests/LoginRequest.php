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
            'remember' => ['nullable'],
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
            'remember' => 'remember me',
        ];
    }


    public function messages(): array
    {
        return [
            'email.required' => __('validation.required', [
                'attribute' => __('auth.email'),
            ]),

            'email.email' => __('validation.email', [
                'attribute' => __('auth.email'),
            ]),

            'password.required' => __('validation.required', [
                'attribute' => __('auth.password'),
            ]),
        ];
    }


}
