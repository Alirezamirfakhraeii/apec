<?php

namespace App\Http\Controllers\Front\User;

use App\Features\User\Company\Actions\UpdateCompanyAction;
use App\Features\User\Company\DTOs\UpdateCompanyData;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Company\UpdateCompanyRequest;
use App\Models\ActivityField;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $viewMode = in_array(
            $request->input('view'),
            ['table', 'grid'],
            true
        )
            ? $request->input('view')
            : 'table';

        /*
        |--------------------------------------------------------------------------
        | گزینه‌های فیلتر فعالیت
        |--------------------------------------------------------------------------
        */

        $activityFields = ActivityField::query()
            ->where('is_active', true)
            ->orderByRaw("
            CASE section
                WHEN 'discipline' THEN 1
                WHEN 'work_field' THEN 2
                WHEN 'industry' THEN 3
                ELSE 4
            END
        ")
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section');


        /*
        |--------------------------------------------------------------------------
        | پاک‌سازی شناسه‌های انتخاب‌شده
        |--------------------------------------------------------------------------
        */

        $allowedSections = [
            'discipline',
            'work_field',
            'industry',
        ];

        $activityFilters = collect(
            $request->input('activity_fields', [])
        )
            ->only($allowedSections)
            ->map(function ($ids, $section) use ($activityFields) {
                $allowedIds = $activityFields
                    ->get($section, collect())
                    ->pluck('id')
                    ->map(fn ($id) => (int) $id);

                return collect($ids)
                    ->map(fn ($id) => (int) $id)
                    ->intersect($allowedIds)
                    ->unique()
                    ->values()
                    ->all();
            })
            ->filter(fn ($ids) => count($ids) > 0);

        /*
        |--------------------------------------------------------------------------
        | کوئری شرکت‌ها
        |--------------------------------------------------------------------------
        */

        $companiesQuery = Company::query()
            ->with([
                'activityFields' => function ($query) {
                    $query
                        ->select([
                            'activity_fields.id',
                            'activity_fields.section',
                            'activity_fields.title',
                            'activity_fields.sort_order',
                        ])
                        ->orderBy('activity_fields.sort_order');
                },

                'projects' => function ($query) {
                    $query->orderByDesc('id');
                },
            ]);

        /*
        |--------------------------------------------------------------------------
        | جستجوی متنی
        |--------------------------------------------------------------------------
        */

        $companiesQuery->when(
            $request->filled('q'),
            function ($query) use ($request) {
                $search = trim($request->input('q'));

                $query->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'company_short_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'registered_name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'company_name_en',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'national_id',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'membership_number',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'activityFields',
                            function ($activityQuery) use ($search) {
                                $activityQuery->where(
                                    'activity_fields.title',
                                    'like',
                                    "%{$search}%"
                                );
                            }
                        );
                });
            }
        );

        /*
        |--------------------------------------------------------------------------
        | فیلتر نوع عضویت
        |--------------------------------------------------------------------------
        */

        $companiesQuery->when(
            $request->filled('membership_type'),
            fn ($query) => $query->where(
                'membership_type',
                $request->input('membership_type')
            )
        );

        /*
        |--------------------------------------------------------------------------
        | فیلتر وضعیت عضویت
        |--------------------------------------------------------------------------
        */

        $companiesQuery->when(
            $request->filled('membership_status'),
            fn ($query) => $query->where(
                'membership_status',
                $request->input('membership_status')
            )
        );

        /*
        |--------------------------------------------------------------------------
        | فیلتر فعالیت‌ها
        |--------------------------------------------------------------------------
        |
        | داخل هر گروه OR است.
        | بین گروه‌ها AND است.
        |
        */

        foreach ($activityFilters as $section => $ids) {
            $companiesQuery->whereHas(
                'activityFields',
                function ($activityQuery) use ($section, $ids) {
                    $activityQuery
                        ->where(
                            'activity_fields.section',
                            $section
                        )
                        ->whereIn(
                            'activity_fields.id',
                            $ids
                        );
                }
            );
        }

        $totalCompanies = Company::query()->count();

        $companies = $companiesQuery
            ->orderBy('registered_name')
            ->paginate(20)
            ->withQueryString();

        return view('front.companies.index', compact(
            'companies',
            'totalCompanies',
            'viewMode',
            'activityFields'
        ));
    }

    public function edit(Request $request): View
    {
        $company = $request->user()
            ->companies()
            ->with([
                'projects',
                'activityFields',
                'shareholders',
                'documents',
            ])
            ->firstOrFail();


        $activityFields = ActivityField::query()
            ->where('is_active', true)
            ->orderByRaw("
            CASE section
                WHEN 'discipline' THEN 1
                WHEN 'work_field' THEN 2
                WHEN 'industry' THEN 3
                ELSE 4
            END
        ")
            ->orderBy('sort_order')
            ->get();


        $selectedActivityFieldIds = $company
            ->activityFields
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();


        $projects = $company
            ->projects
            ->sortByDesc('id')
            ->values();


        $shareholders = $company
            ->shareholders
            ->values();


        $documents = $company->documents;


        $documentsByType = $documents
            ->keyBy('type');


        return view(
            'front.user.company.edit',
            compact(
                'company',
                'activityFields',
                'selectedActivityFieldIds',
                'projects',
                'shareholders',
                'documents',
                'documentsByType'
            )
        );
    }
    public function update(
        UpdateCompanyRequest $request,
        UpdateCompanyAction $action
    ): RedirectResponse {
        $company = $request
            ->user()
            ->companies()
            ->firstOrFail();


        $data = UpdateCompanyData::fromRequest(
            $request
        );


        $action->execute(
            $company,
            $data
        );


        return redirect()
            ->route('user.company.edit')
            ->with(
                'success',
                'اطلاعات شرکت با موفقیت به‌روزرسانی شد.'
            );
    }
}
