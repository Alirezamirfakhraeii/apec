<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RouteMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        if (! $user) {
            return false;
        }

        return $user->hasRole('admin')
            || $user->can('membership.application.manage');
    }

    public function rules(): array
    {
        return [
            'stage_id' => [
                'required',
                'integer',

                Rule::exists(
                    'workflow_stages',
                    'id'
                )->where(function ($query) {
                    $query->where(
                        'is_active',
                        true
                    );
                }),
            ],

            'comment' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'stage_id.required' =>
                'مرحله مقصد را انتخاب کنید.',

            'stage_id.exists' =>
                'مرحله انتخاب‌شده معتبر نیست.',

            'comment.max' =>
                'توضیحات نمی‌تواند بیشتر از ۲۰۰۰ کاراکتر باشد.',
        ];
    }
}
