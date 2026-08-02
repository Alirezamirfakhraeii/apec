<?php

namespace App\Features\Admin\Company\Actions;

use App\Features\Admin\Company\DTOs\CompanyData;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

final class UpdateCompanyAction
{
    /**
     * ویرایش اطلاعات شرکت، حوزه‌های فعالیت و مدیریت لوگو
     *
     * @throws Throwable
     */
    public function execute(Company $company, CompanyData $data): Company
    {
        $oldLogoPath = $company->logo;
        $newLogoPath = null;
        $shouldDeleteOldLogo = false;

        try {
            $updatedCompany = DB::transaction(function () use (
                $company,
                $data,
                $oldLogoPath,
                &$newLogoPath,
                &$shouldDeleteOldLogo
            ) {
                $attributes = $data->attributes();

                /*
                |--------------------------------------------------------------------------
                | جایگزینی لوگو
                |--------------------------------------------------------------------------
                */

                if ($data->hasLogo()) {
                    $newLogoPath = $data->logo->store(
                        'companies/logos',
                        'public'
                    );

                    $attributes['logo'] = $newLogoPath;

                    $shouldDeleteOldLogo = filled($oldLogoPath);
                }

                /*
                |--------------------------------------------------------------------------
                | حذف لوگوی فعلی
                |--------------------------------------------------------------------------
                */

                elseif ($data->removeLogo) {
                    $attributes['logo'] = null;

                    $shouldDeleteOldLogo = filled($oldLogoPath);
                }

                /*
                |--------------------------------------------------------------------------
                | ویرایش اطلاعات اصلی شرکت
                |--------------------------------------------------------------------------
                */

                $company->fill($attributes);
                $company->save();

                /*
                |--------------------------------------------------------------------------
                | هماهنگ‌سازی حوزه‌های فعالیت
                |--------------------------------------------------------------------------
                |
                | گزینه‌های جدید اضافه می‌شوند.
                | گزینه‌های حذف‌شده از جدول واسط پاک می‌شوند.
                | گزینه‌های باقی‌مانده بدون تغییر می‌مانند.
                |
                */

                $company->activityFields()->sync(
                    $data->activityFieldIds
                );

                /*
                |--------------------------------------------------------------------------
                | بازگرداندن اطلاعات تازه شرکت
                |--------------------------------------------------------------------------
                */

                return $company->fresh([
                    'activityFields',
                ]);
            });

            /*
            |--------------------------------------------------------------------------
            | حذف لوگوی قبلی بعد از موفقیت دیتابیس
            |--------------------------------------------------------------------------
            */

            if (
                $shouldDeleteOldLogo &&
                $oldLogoPath &&
                $oldLogoPath !== $newLogoPath &&
                Storage::disk('public')->exists($oldLogoPath)
            ) {
                Storage::disk('public')->delete($oldLogoPath);
            }

            return $updatedCompany;
        } catch (Throwable $exception) {
            /*
            |--------------------------------------------------------------------------
            | حذف لوگوی جدید در صورت شکست عملیات
            |--------------------------------------------------------------------------
            */

            if (
                $newLogoPath &&
                Storage::disk('public')->exists($newLogoPath)
            ) {
                Storage::disk('public')->delete($newLogoPath);
            }

            throw $exception;
        }
    }
}
