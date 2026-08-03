<?php

namespace App\Features\Admin\Company\Projects\Actions;


use App\Features\Admin\Company\Projects\DTOs\CompanyProjectData;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class UpdateCompanyProjectAction
{
    public function execute(Project $project, CompanyProjectData $data): Project {
        return DB::transaction(function () use ($project, $data) {
            $project->update($data->attributes);
            return $project->refresh();
        });
    }
}
