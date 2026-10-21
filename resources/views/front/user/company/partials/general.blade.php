<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات عمومی شرکت</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[company_short_name]',
            'oldKey' => 'company.company_short_name',
            'label' => 'نام کوتاه شرکت',
            'value' => $company?->company_short_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[registered_name]',
            'oldKey' => 'company.registered_name',
            'label' => 'نام ثبتی شرکت',
            'value' => $company?->registered_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[company_name_en]',
            'oldKey' => 'company.company_name_en',
            'label' => 'نام انگلیسی شرکت',
            'value' => $company?->company_name_en,
            'dir' => 'ltr',
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[nationality]',
            'oldKey' => 'company.nationality',
            'label' => 'ملیت شرکت',
            'value' => $company?->nationality,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[parent_company_name]',
            'oldKey' => 'company.parent_company_name',
            'label' => 'نام شرکت مادر',
            'value' => $company?->parent_company_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[company_type]',
            'oldKey' => 'company.company_type',
            'label' => 'نوع شرکت',
            'value' => $company?->company_type instanceof \BackedEnum
                ? $company->company_type->value
                : $company?->company_type,
        ])
    </div>
</div>
