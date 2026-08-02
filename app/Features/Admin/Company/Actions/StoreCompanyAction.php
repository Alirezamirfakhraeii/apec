<?php

namespace App\Features\Admin\Company\Actions;

use App\Features\Admin\Company\DTOs\CompanyData;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class StoreCompanyAction
{
    public function execute(CompanyData $data): Company
    {
        $storedLogoPath = null;

        try {
            return DB::transaction(function () use (
                $data,
                &$storedLogoPath
            ) {
                $attributes = $data->attributes();

                /*
                 * ذخیره لوگوی شرکت
                 */
                if ($data->hasLogo()) {
                    $storedLogoPath = $data->logo->store(
                        'companies/logos',
                        'public'
                    );

                    $attributes['logo'] = $storedLogoPath;
                }

                /*
                 * ایجاد رکورد اصلی شرکت
                 */
                $company = Company::query()->create($attributes);

                /*
                 * ذخیره حوزه‌های فعالیت در جدول واسط
                 */
                $company->activityFields()->sync(
                    $data->activityFieldIds
                );

                /*
                 * برگرداندن شرکت همراه با فعالیت‌های ثبت‌شده
                 */
                return $company->load('activityFields');
            });
        } catch (Throwable $exception) {
            /*
             * اگر ذخیره شرکت یا فعالیت‌ها خطا داد،
             * فایل لوگوی آپلودشده نیز حذف می‌شود.
             */
            if (
                $storedLogoPath &&
                Storage::disk('public')->exists($storedLogoPath)
            ) {
                Storage::disk('public')->delete($storedLogoPath);
            }

            throw $exception;
        }
    }
}
