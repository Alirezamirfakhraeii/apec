<div class="company-edit-section">
    <div class="company-edit-section__title">رابط شرکت با انجمن</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[association_contact_name]',
            'oldKey' => 'company.association_contact_name',
            'label' => 'نام رابط انجمن',
            'value' => $company?->association_contact_name,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[association_contact_position]',
            'oldKey' => 'company.association_contact_position',
            'label' => 'سمت رابط انجمن',
            'value' => $company?->association_contact_position,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[association_contact_mobile]',
            'oldKey' => 'company.association_contact_mobile',
            'label' => 'موبایل رابط انجمن',
            'dir' => 'ltr',
            'value' => $company?->association_contact_mobile,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[association_contact_email]',
            'oldKey' => 'company.association_contact_email',
            'label' => 'ایمیل رابط انجمن',
            'type' => 'email',
            'dir' => 'ltr',
            'value' => $company?->association_contact_email,
        ])
    </div>
</div>
