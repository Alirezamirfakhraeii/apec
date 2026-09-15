<?php

namespace App\Features\Membership\Services;

use App\Enums\MembershipDocumentType;
use App\Models\MembershipApplication;
use Illuminate\Validation\ValidationException;

final class MembershipSubmissionValidator
{
    public function validate(MembershipApplication $application): void
    {
        $application->loadMissing(['companyProfile', 'shareholders', 'documents']);
        $profile = $application->companyProfile;
        $errors = [];

        $requiredProfile = [
            'logo_path' => 'لوگوی شرکت',
            'registered_name' => 'نام فارسی شرکت',
            'company_name_en' => 'نام انگلیسی شرکت',
            'company_type' => 'نوع ثبت شرکت',
            'registration_date' => 'تاریخ ثبت شرکت',
            'registration_number' => 'شماره ثبت شرکت',
            'registration_place' => 'محل ثبت شرکت',
            'registered_capital_irr' => 'سرمایه ثبت‌شده',
            'activity_history_years' => 'سابقه فعالیت شرکت',
            'oil_gas_petro_specialty' => 'نوع تخصص در صنایع نفت، گاز و پتروشیمی',
            'is_chamber_member' => 'وضعیت عضویت در اتاق بازرگانی',
        ];

        if (! $application->intake_confirmed_at) {
            $errors['intake'][] = 'اطلاعات اولیه درخواست تأیید نشده است.';
        }

        foreach ($requiredProfile as $field => $label) {
            if (! $profile || $profile->{$field} === null || $profile->{$field} === '') {
                $errors[$field][] = "{$label} تکمیل نشده است.";
            }
        }

        if ($application->shareholders->isEmpty()) {
            $errors['shareholders'][] = 'حداقل یک سهامدار وارد کنید.';
        } else {
            $total = (float) $application->shareholders->sum('ownership_percentage');
            if (abs($total - 100.0) > 0.01) {
                $errors['shareholders'][] = 'مجموع درصد سهامداران باید دقیقاً 100 درصد باشد.';
            }
        }

        $requiredDocuments = [
            MembershipDocumentType::OfficialGazette,
            MembershipDocumentType::LatestGeneralAssemblyMinutes,
            MembershipDocumentType::LatestCapitalGazette,
            MembershipDocumentType::OriginalCertificate,
            MembershipDocumentType::Resume,
        ];

        if ($profile?->is_chamber_member === true) {
            $requiredDocuments[] = MembershipDocumentType::ChamberMembershipCard;
        }

        $uploaded = $application->documents
            ->map(fn ($document) => $document->type->value)
            ->all();

        foreach ($requiredDocuments as $type) {
            if (! in_array($type->value, $uploaded, true)) {
                $errors['documents'][] = "مدرک «{$type->label()}» بارگذاری نشده است.";
            }
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }
    }
}
