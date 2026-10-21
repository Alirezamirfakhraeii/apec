<div class="company-edit-section">
    <div class="company-edit-section__title">نوع فعالیت شرکت</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._checkbox', [
            'name' => 'company[activity_design_consulting]',
            'oldKey' => 'company.activity_design_consulting',
            'label' => 'طراحی و مشاوره',
            'value' => $company?->activity_design_consulting,
        ])

        @include('front.user.company.partials._checkbox', [
            'name' => 'company[activity_construction_installation]',
            'oldKey' => 'company.activity_construction_installation',
            'label' => 'ساخت و نصب',
            'value' => $company?->activity_construction_installation,
        ])

        @include('front.user.company.partials._checkbox', [
            'name' => 'company[activity_epc]',
            'oldKey' => 'company.activity_epc',
            'label' => 'EPC',
            'value' => $company?->activity_epc,
        ])

        @include('front.user.company.partials._checkbox', [
            'name' => 'company[activity_mc]',
            'oldKey' => 'company.activity_mc',
            'label' => 'MC',
            'value' => $company?->activity_mc,
        ])

        @include('front.user.company.partials._checkbox', [
            'name' => 'company[activity_manufacturing]',
            'oldKey' => 'company.activity_manufacturing',
            'label' => 'تولید / ساخت',
            'value' => $company?->activity_manufacturing,
        ])

        @include('front.user.company.partials._textarea', [
            'name' => 'company[activity_type]',
            'oldKey' => 'company.activity_type',
            'label' => 'شرح نوع فعالیت',
            'value' => $company?->activity_type,
        ])
    </div>
</div>
