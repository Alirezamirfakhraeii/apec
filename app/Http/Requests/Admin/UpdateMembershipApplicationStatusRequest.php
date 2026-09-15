<?php

namespace App\Http\Requests\Admin;

use App\Enums\MembershipApplicationState;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMembershipApplicationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        return $user
            && (
                $user->hasRole('admin')
                || $user->can('membership.application.manage')
            );
    }

    public function rules(): array
    {
        return [
            'state' => [
                'required',
                Rule::in([
                    MembershipApplicationState::InReview->value,
                    MembershipApplicationState::NeedsCorrection->value,
                    MembershipApplicationState::Rejected->value,
                    MembershipApplicationState::Approved->value,
                ]),
            ],

            'stage_id' => [
                Rule::requiredIf(function () {
                    return in_array(
                        $this->input('state'),
                        [
                            MembershipApplicationState::InReview->value,
                            MembershipApplicationState::NeedsCorrection->value,
                        ],
                        true
                    );
                }),

                'nullable',
                'integer',

                Rule::exists(
                    'workflow_stages',
                    'id'
                )->where(
                    fn ($query) => $query->where(
                        'is_active',
                        true
                    )
                ),
            ],

            'comment' => [
                'required',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'state.required' =>
                'وضعیت جدید را انتخاب کنید.',

            'state.in' =>
                'وضعیت انتخاب‌شده معتبر نیست.',

            'stage_id.required' =>
                'برای این وضعیت، مرحله پرونده را انتخاب کنید.',

            'stage_id.exists' =>
                'مرحله انتخاب‌شده معتبر نیست.',

            'comment.required' =>
                'علت اصلاح وضعیت را وارد کنید.',

            'comment.max' =>
                'توضیحات نمی‌تواند بیشتر از ۲۰۰۰ کاراکتر باشد.',
        ];
    }
}
