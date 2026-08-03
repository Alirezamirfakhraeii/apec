<?php

namespace App\Http\Controllers\Admin;

use App\Features\Admin\Company\Projects\Actions\StoreCompanyProjectAction;
use App\Features\Admin\Company\Projects\Actions\UpdateCompanyProjectAction;
use App\Features\Admin\Company\Projects\DTOs\CompanyProjectData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Company\Projects\StoreCompanyProjectRequest;
use App\Http\Requests\Admin\Company\Projects\UpdateCompanyProjectRequest;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Morilog\Jalali\Jalalian;

class CompanyProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query()
            ->with('company');


        if ($request->filled('q')) {
            $search = trim($request->q);

            $query->where(function ($query) use ($search) {
                $query->where('project_name', 'like', "%{$search}%")
                    ->orWhere('employer', 'like', "%{$search}%")
                    ->orWhere('service_description', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر شرکت
        |--------------------------------------------------------------------------
        */

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        /*
        |--------------------------------------------------------------------------
        | فیلتر تاریخ شروع پروژه
        |--------------------------------------------------------------------------
        |
        | فعلاً این بخش با تاریخ میلادی کار می‌کند.
        | تبدیل ورودی شمسی را در مرحله بعد اضافه می‌کنیم.
        |
        */

        if ($request->filled('date_from')) {
            $query->whereDate('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('start_date', '<=', $request->date_to);
        }

        /*
        |--------------------------------------------------------------------------
        | مرتب‌سازی
        |--------------------------------------------------------------------------
        */

        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;

            case 'start_date_desc':
                $query->orderByRaw('start_date IS NULL')
                    ->orderByDesc('start_date');
                break;

            case 'start_date_asc':
                $query->orderByRaw('start_date IS NULL')
                    ->orderBy('start_date');
                break;

            case 'project_name':
                $query->orderBy('project_name');
                break;

            default:
                $query->latest();
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | دریافت اطلاعات
        |--------------------------------------------------------------------------
        */

        $projects = $query->paginate(20);

        $companies = Company::query()
            ->orderBy('registered_name')
            ->get();

        return view(
            'back.admin.companies.projects.index',
            compact('projects', 'companies')
        );
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::query()
            ->get()
            ->sortBy(function ($company) {
                return $company->short_name
                    ?? $company->registered_name
                    ?? $company->company_name
                    ?? $company->name
                    ?? '';
            })
            ->values();

        return view(
            'back.admin.companies.projects.create',
            compact('companies')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyProjectRequest $request, StoreCompanyProjectAction $action): RedirectResponse
    {
        $projectData = CompanyProjectData::fromRequest($request);
        $project = $action->execute($projectData);
        return redirect()->route('admin.company-projects.index')->with('success', "پروژه «{$project->project_name}» با موفقیت ثبت شد.");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $companyProject): View
    {
        $companies = Company::query()->get()->sortBy(function ($company) {
                return $company->short_name
                    ?? $company->registered_name
                    ?? $company->company_name
                    ?? $company->name
                    ?? '';
        })->values();

        $startDate = $companyProject->start_date
            ? Jalalian::fromDateTime($companyProject->start_date)
                ->format('Y/m/d')
            : null;

        $endDate = $companyProject->end_date
            ? Jalalian::fromDateTime($companyProject->end_date)
                ->format('Y/m/d')
            : null;

        return view('back.admin.companies.projects.edit', [
                'project' => $companyProject,
                'companies' => $companies,
                'startDate' => $startDate,
                'endDate' => $endDate,
            ]
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyProjectRequest $request, Project $companyProject, UpdateCompanyProjectAction $action): RedirectResponse
    {
        $projectData = CompanyProjectData::fromRequest($request);
        $project = $action->execute($companyProject, $projectData);
        return redirect()->route('admin.company-projects.index')->with('success', "پروژه «{$project->project_name}» با موفقیت ویرایش شد.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $companyProject): RedirectResponse {
        $projectName = $companyProject->project_name;
        $companyProject->delete();
        return redirect()->route('admin.company-projects.index')->with('success', "پروژه «{$projectName}» با موفقیت حذف شد.");
    }
}
