<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات تکمیلی</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._textarea', [
            'name' => 'company[membership_status_notes_1403]',
            'oldKey' => 'company.membership_status_notes_1403',
            'label' => 'توضیحات وضعیت عضویت ۱۴۰۳',
            'value' => $company?->membership_status_notes_1403,
        ])

        @include('front.user.company.partials._textarea', [
            'name' => 'company[association_committees]',
            'oldKey' => 'company.association_committees',
            'label' => 'کمیته‌های انجمن',
            'value' => $company?->association_committees,
        ])
    </div>
</div>
