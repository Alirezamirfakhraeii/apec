{{-- Projects tab --}}
<div class="tab-pane fade"
     id="projects-panel-{{ $company->id }}"
     role="tabpanel"
     aria-labelledby="projects-tab-{{ $company->id }}">

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-project-diagram"></i>
            </div>

            <div>
                <h5>پروژه‌های شرکت</h5>
                <p>پروژه‌ها و سوابق اجرایی ثبت‌شده برای این شرکت</p>
            </div>
        </div>

        @if($companyProjects->isNotEmpty())
            <div class="company-projects-grid">
                @foreach($companyProjects as $project)
                    @php
                        $projectTitle = data_get($project, 'title')
                            ?? data_get($project, 'name');

                        $projectEmployer = data_get($project, 'employer')
                            ?? data_get($project, 'client')
                            ?? data_get($project, 'customer');

                        $projectLocation = data_get($project, 'location')
                            ?? data_get($project, 'project_location');

                        $projectStartDate = data_get($project, 'start_date')
                            ?? data_get($project, 'started_at');

                        $projectEndDate = data_get($project, 'end_date')
                            ?? data_get($project, 'finished_at');

                        $projectStatus = data_get($project, 'status');

                        $projectDescription = data_get($project, 'description')
                            ?? data_get($project, 'summary')
                            ?? data_get($project, 'details');
                    @endphp

                    <article class="company-project-card">
                        <div class="company-project-card-header">
                            <div class="company-project-card-icon">
                                <i class="fa fa-briefcase"></i>
                            </div>

                            <div class="company-project-card-title-wrap">
                                <h6>
                                    {{ $displayValue($projectTitle) }}
                                </h6>

                                @if(filled($projectStatus))
                                    <span class="company-project-status">
                                        {{ $projectStatus }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if(
                            filled($projectEmployer) ||
                            filled($projectLocation) ||
                            filled($projectStartDate) ||
                            filled($projectEndDate)
                        )
                            <div class="company-project-meta">
                                @if(filled($projectEmployer))
                                    <div class="company-project-meta-item">
                                        <span>کارفرما</span>
                                        <strong>{{ $projectEmployer }}</strong>
                                    </div>
                                @endif

                                @if(filled($projectLocation))
                                    <div class="company-project-meta-item">
                                        <span>محل اجرا</span>
                                        <strong>{{ $projectLocation }}</strong>
                                    </div>
                                @endif

                                @if(filled($projectStartDate))
                                    <div class="company-project-meta-item">
                                        <span>تاریخ شروع</span>
                                        <strong>{{ $projectStartDate }}</strong>
                                    </div>
                                @endif

                                @if(filled($projectEndDate))
                                    <div class="company-project-meta-item">
                                        <span>تاریخ پایان</span>
                                        <strong>{{ $projectEndDate }}</strong>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if(filled($projectDescription))
                            <div class="company-project-description">
                                {!! nl2br(e($projectDescription)) !!}
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="company-section-empty company-projects-empty">
                <i class="fa fa-project-diagram"></i>
                <span>پروژه‌ای برای این شرکت ثبت نشده است.</span>
            </div>
        @endif
    </section>
</div>
