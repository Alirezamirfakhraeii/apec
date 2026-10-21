<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات مدیرعامل</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[ceo_name]',
            'oldKey' => 'company.ceo_name',
            'label' => 'نام مدیرعامل',
            'value' => $company?->ceo_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[ceo_mobile]',
            'oldKey' => 'company.ceo_mobile',
            'label' => 'موبایل مدیرعامل',
            'dir' => 'ltr',
            'value' => $company?->ceo_mobile,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[ceo_email]',
            'oldKey' => 'company.ceo_email',
            'label' => 'ایمیل مدیرعامل',
            'type' => 'email',
            'dir' => 'ltr',
            'value' => $company?->ceo_email,
        ])
    </div>
</div>
