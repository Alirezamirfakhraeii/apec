<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات عضویت در انجمن</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[association_join_date]',
            'oldKey' => 'company.association_join_date',
            'label' => 'تاریخ عضویت در انجمن',
            'value' => $company?->association_join_date,
            'placeholder' => 'مثال: ۱۴۰۳/۰۶/۱۵',
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[membership_number]',
            'oldKey' => 'company.membership_number',
            'label' => 'شماره عضویت',
            'value' => $company?->membership_number,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[membership_type]',
            'oldKey' => 'company.membership_type',
            'label' => 'نوع عضویت',
            'value' => $company?->membership_type,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[membership_status]',
            'oldKey' => 'company.membership_status',
            'label' => 'وضعیت عضویت',
            'value' => $company?->membership_status,
        ])
    </div>
</div>
