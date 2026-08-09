<?php

namespace App\Exports;

use App\Models\Company;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompaniesExport implements FromCollection, WithHeadings
{
    protected array $columns;

    public function __construct()
    {
        $this->columns = Schema::getColumnListing('companies');
    }

    public function collection()
    {
        return Company::query()
            ->select($this->columns)
            ->orderBy('id')
            ->get()
            ->map(function ($company) {

                return collect($this->columns)
                    ->mapWithKeys(function ($column) use ($company) {

                        $value = $company->{$column};

                        /*
                        |--------------------------------------------------------------------------
                        | تبدیل Array / JSON برای Excel
                        |--------------------------------------------------------------------------
                        */

                        if (is_array($value)) {
                            $value = json_encode(
                                $value,
                                JSON_UNESCAPED_UNICODE
                            );
                        }

                        return [
                            $column => $value
                        ];
                    })
                    ->toArray();
            });
    }

    public function headings(): array
    {
        return $this->columns;
    }
}
