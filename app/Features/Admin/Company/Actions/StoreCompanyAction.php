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
            return DB::transaction(function () use ($data, &$storedLogoPath) {
                $attributes = $data->attributes();
                if ($data->hasLogo()) {
                    $storedLogoPath = $data->logo->store(
                        'companies/logos',
                        'public'
                    );

                    $attributes['logo'] = $storedLogoPath;
                }
                return Company::query()->create($attributes);
            });
        } catch (Throwable $exception) {
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
