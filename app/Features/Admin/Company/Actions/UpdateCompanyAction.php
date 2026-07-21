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
     * ویرایش اطلاعات شرکت و مدیریت لوگو
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
                |
                | اگر لوگوی جدید ارسال شده باشد، ابتدا آن را ذخیره می‌کنیم.
                | حذف لوگوی قبلی بعد از موفقیت کامل تراکنش انجام می‌شود.
                |
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
                |
                | فقط زمانی اجرا می‌شود که لوگوی جدید ارسال نشده باشد.
                | اگر هم‌زمان فایل جدید و remove_logo ارسال شود،
                | لوگوی جدید اولویت دارد.
                |
                */

                elseif ($data->removeLogo) {
                    $attributes['logo'] = null;

                    $shouldDeleteOldLogo = filled($oldLogoPath);
                }

                /*
                |--------------------------------------------------------------------------
                | ویرایش اطلاعات شرکت
                |--------------------------------------------------------------------------
                */

                $company->fill($attributes);
                $company->save();

                return $company->refresh();
            });

            /*
            |--------------------------------------------------------------------------
            | حذف لوگوی قبلی بعد از موفقیت دیتابیس
            |--------------------------------------------------------------------------
            |
            | لوگوی قبلی را قبل از Commit حذف نمی‌کنیم؛ چون اگر ذخیره
            | اطلاعات شکست بخورد، شرکت باید همچنان لوگوی قبلی خود را داشته باشد.
            |
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
            | پاک‌سازی لوگوی جدید در صورت خطا
            |--------------------------------------------------------------------------
            |
            | اگر فایل جدید ذخیره شده ولی عملیات دیتابیس شکست خورده باشد،
            | فایل جدید را حذف می‌کنیم و لوگوی قبلی دست‌نخورده باقی می‌ماند.
            |
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
