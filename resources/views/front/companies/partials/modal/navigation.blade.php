{{-- Navigation --}}
<div class="company-modal-navigation">
    <ul class="nav nav-pills company-modal-tabs"
        id="companyTabs{{ $company->id }}"
        role="tablist">

        <li class="nav-item" role="presentation">
            <button class="nav-link active"
                    id="identity-tab-{{ $company->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#identity-panel-{{ $company->id }}"
                    type="button"
                    role="tab">
                <i class="fa fa-building"></i>
                <span>شناسنامه شرکت</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="ranks-tab-{{ $company->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#ranks-panel-{{ $company->id }}"
                    type="button"
                    role="tab">
                <i class="fa fa-award"></i>
                <span>رتبه‌ها و صلاحیت‌ها</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="activities-tab-{{ $company->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#activities-panel-{{ $company->id }}"
                    type="button"
                    role="tab">
                <i class="fa fa-sitemap"></i>
                <span>حوزه‌های فعالیت</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="projects-tab-{{ $company->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#projects-panel-{{ $company->id }}"
                    type="button"
                    role="tab">
                <i class="fa fa-project-diagram"></i>
                <span>پروژه‌ها</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link"
                    id="contact-tab-{{ $company->id }}"
                    data-bs-toggle="pill"
                    data-bs-target="#contact-panel-{{ $company->id }}"
                    type="button"
                    role="tab">
                <i class="fa fa-address-card"></i>
                <span>تماس و فایل‌ها</span>
            </button>
        </li>
    </ul>
</div>
