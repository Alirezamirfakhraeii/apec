<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function rules()
    {
        $user = $this->route('user');
        return [
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],

            'password' => 'nullable|string|min:8',

            'role' => 'nullable|exists:roles,name',
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام کاربر',
            'email' => 'ایمیل',
            'password' => 'رمز عبور',
            'role' => 'نقش',
            'avatar' => 'عکس',
        ];

    }
}
