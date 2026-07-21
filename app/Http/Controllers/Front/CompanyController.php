<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $viewMode = $request->string('view')->toString();

        if (! in_array($viewMode, ['table', 'grid'], true)) {
            $viewMode = 'grid';
        }

        $query = Company::query();

        /*
        |--------------------------------------------------------------------------
        | جستجوی عمومی
        |--------------------------------------------------------------------------
        */

        if ($request->filled('q')) {
            $search = trim($request->string('q')->toString());

            $query->where(function (Builder $builder) use ($search) {
                $builder
                    ->where('registered_name', 'like', "%{$search}%")
                    ->orWhere('company_short_name', 'like', "%{$search}%")
                    ->orWhere('company_name_en', 'like', "%{$search}%")
                    ->orWhere('membership_number', 'like', "%{$search}%")
                    ->orWhere('national_id', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('activity_type', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | نوع عضویت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('membership_type')) {
            $query->where(
                'membership_type',
                $request->string('membership_type')->toString()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | وضعیت عضویت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('membership_status')) {
            $query->where(
                'membership_status',
                $request->string('membership_status')->toString()
            );
        }

        /*
        |--------------------------------------------------------------------------
        | مرتب‌سازی الفبایی
        |--------------------------------------------------------------------------
        */

        $companies = $query
            ->orderByRaw("
                CASE
                    WHEN registered_name IS NULL OR registered_name = '' THEN 1
                    ELSE 0
                END
            ")
            ->orderBy('registered_name', 'asc')
            ->paginate(20)
            ->withQueryString();

        $totalCompanies = Company::query()->count();

        return view('front.companies.index', compact(
            'companies',
            'totalCompanies',
            'viewMode'
        ));
    }
}
