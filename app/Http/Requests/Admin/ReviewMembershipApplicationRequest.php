<?php

namespace App\Http\Requests\Admin;

use App\Enums\ApplicationReviewDecision;
use App\Enums\MembershipApplicationState;
use App\Models\MembershipApplication;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReviewMembershipApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = $this->user();

        $application =
            $this->route('application');


        /*
        |--------------------------------------------------------------------------
        | Basic Validation
        |--------------------------------------------------------------------------
        */

        if (
            ! $user
            ||
            ! $application instanceof
                \App\Models\MembershipApplication
        ) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Application Must Be In Review
        |--------------------------------------------------------------------------
        */

        $isInReview =
            $application->state instanceof
            \App\Enums\MembershipApplicationState
                ? $application->state ===
                \App\Enums\MembershipApplicationState::InReview
                : $application->state ===
                \App\Enums\MembershipApplicationState::InReview->value;


        if (! $isInReview) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Current Stage
        |--------------------------------------------------------------------------
        */

        $stage =
            $application->currentStage;


        if (
            ! $stage
            ||
            ! $stage->required_permission
        ) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Current Reviewer Permission
        |--------------------------------------------------------------------------
        */

        return $user->can(
            $stage->required_permission
        );
    }


    public function rules(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Decision
            |--------------------------------------------------------------------------
            */

            'decision' => [
                'required',

                Rule::in([
                    ApplicationReviewDecision::Approved->value,

                    ApplicationReviewDecision::NeedsCorrection->value,

                    ApplicationReviewDecision::Rejected->value,
                ]),
            ],


            /*
            |--------------------------------------------------------------------------
            | Comment
            |--------------------------------------------------------------------------
            |
            | برای تأیید توضیح اختیاری است.
            |
            | برای رد یا درخواست اصلاح،
            | کارشناس باید علت را بنویسد.
            |
            */

            'comment' => [
                Rule::requiredIf(
                    fn () => in_array(
                        $this->input('decision'),
                        [
                            ApplicationReviewDecision::NeedsCorrection->value,

                            ApplicationReviewDecision::Rejected->value,
                        ],
                        true
                    )
                ),

                'nullable',
                'string',
                'max:3000',
            ],
        ];
    }


    public function messages(): array
    {
        return [

            'decision.required' =>
                'لطفاً تصمیم خود را مشخص کنید.',

            'decision.in' =>
                'تصمیم انتخاب‌شده معتبر نیست.',

            'comment.required' =>
                'برای رد درخواست یا درخواست اصلاح، توضیحات الزامی است.',

            'comment.max' =>
                'توضیحات نمی‌تواند بیشتر از ۳۰۰۰ کاراکتر باشد.',
        ];
    }
}
