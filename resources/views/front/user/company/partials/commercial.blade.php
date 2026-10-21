<div class="company-edit-section">
    <div class="company-edit-section__title">کارت بازرگانی و عضویت اتاق</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._checkbox', [
            'name' => 'company[has_valid_commercial_card]',
            'oldKey' => 'company.has_valid_commercial_card',
            'label' => 'دارای کارت بازرگانی معتبر',
            'value' => $company?->has_valid_commercial_card,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[commercial_card_valid_until]',
            'oldKey' => 'company.commercial_card_valid_until',
            'label' => 'اعتبار کارت بازرگانی تا',
            'value' => $company?->commercial_card_valid_until,
            'placeholder' => 'مثال: ۱۴۰۳/۰۶/۱۵',
        ])

        @include('front.user.company.partials._checkbox', [
            'name' => 'company[has_valid_chamber_membership_card]',
            'oldKey' => 'company.has_valid_chamber_membership_card',
            'label' => 'دارای کارت عضویت معتبر اتاق بازرگانی',
            'value' => $company?->has_valid_chamber_membership_card,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[chamber_membership_valid_until]',
            'oldKey' => 'company.chamber_membership_valid_until',
            'label' => 'اعتبار کارت عضویت اتاق تا',
            'value' => $company?->chamber_membership_valid_until,
            'placeholder' => 'مثال: ۱۴۰۳/۰۶/۱۵',
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[chamber_province]',
            'oldKey' => 'company.chamber_province',
            'label' => 'استان اتاق بازرگانی',
            'value' => $company?->chamber_province,
        ])
    </div>
</div>
