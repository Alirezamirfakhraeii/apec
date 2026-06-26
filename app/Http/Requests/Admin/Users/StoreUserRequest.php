<?php

namespace App\Http\Requests\Admin\Users;

use Illuminate\Foundation\Http\FormRequest;


class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'nullable|exists:roles,name',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام کاربر',
            'email' => 'ایمیل',
            'password' => 'رمز عبور',
            'role' => 'نقش',
        ];
    }
}
