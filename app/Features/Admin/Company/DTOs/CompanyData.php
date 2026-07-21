<?php

namespace App\Features\Admin\Company\DTOs;

use App\Http\Requests\Admin\Company\CompanyRequest;
use Illuminate\Http\UploadedFile;

final readonly class
CompanyData
{
    public function __construct(
        private array $attributes,
        public ?UploadedFile $logo,
        public bool $removeLogo,
    ) {
    }

    /**
     * ساخت DTO از اطلاعات اعتبارسنجی‌شده Request
     */
    public static function fromRequest(CompanyRequest $request): self
    {
        $validated = $request->validated();

        /*
         * فایل لوگو را جدا از اطلاعات دیتابیس نگه می‌داریم.
         */
        $logo = $request->file('logo');

        /*
         * مقدار حذف لوگو فقط در ویرایش استفاده می‌شود.
         */
        $removeLogo = $request->boolean('remove_logo');

        /*
         * فیلدهای کنترلی و فایل نباید مستقیم
         * وارد Company::create یا update شوند.
         */
        unset(
            $validated['logo'],
            $validated['remove_logo']
        );

        $validated = self::normalizeBooleanFields($validated);

        return new self(
            attributes: $validated,
            logo: $logo,
            removeLogo: $removeLogo,
        );
    }

    /**
     * اطلاعات قابل ذخیره در جدول companies
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * آیا فایل لوگوی جدید ارسال شده است؟
     */
    public function hasLogo(): bool
    {
        return $this->logo instanceof UploadedFile;
    }

    /**
     * مقداردهی صحیح فیلدهای بله/خیر
     */
    private static function normalizeBooleanFields(array $attributes): array
    {
        $booleanFields = [
            'has_valid_commercial_card',
            'has_valid_chamber_membership_card',

            'activity_design_consulting',
            'activity_construction_installation',
            'activity_epc',
            'activity_mc',
            'activity_manufacturing',
        ];

        foreach ($booleanFields as $field) {
            if (! array_key_exists($field, $attributes)) {
                continue;
            }

            if ($attributes[$field] === null || $attributes[$field] === '') {
                $attributes[$field] = null;
                continue;
            }

            $attributes[$field] = filter_var(
                $attributes[$field],
                FILTER_VALIDATE_BOOLEAN,
                FILTER_NULL_ON_FAILURE
            );
        }

        return $attributes;
    }
}
