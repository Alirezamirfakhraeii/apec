<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات رئیس هیئت مدیره</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[chairman_name]',
            'oldKey' => 'company.chairman_name',
            'label' => 'نام رئیس هیئت مدیره',
            'value' => $company?->chairman_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[chairman_mobile]',
            'oldKey' => 'company.chairman_mobile',
            'label' => 'موبایل رئیس هیئت مدیره',
            'dir' => 'ltr',
            'value' => $company?->chairman_mobile,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[chairman_email]',
            'oldKey' => 'company.chairman_email',
            'label' => 'ایمیل رئیس هیئت مدیره',
            'type' => 'email',
            'dir' => 'ltr',
            'value' => $company?->chairman_email,
        ])
    </div>
</div>
