<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات ثبتی و حقوقی</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[registration_date]',
            'oldKey' => 'company.registration_date',
            'label' => 'تاریخ ثبت',
            'value' => $company?->registration_date,
            'placeholder' => 'مثال: ۱۴۰۳/۰۶/۱۵',
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[registration_number]',
            'oldKey' => 'company.registration_number',
            'label' => 'شماره ثبت',
            'value' => $company?->registration_number,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[registration_place]',
            'oldKey' => 'company.registration_place',
            'label' => 'محل ثبت',
            'value' => $company?->registration_place,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[national_id]',
            'oldKey' => 'company.national_id',
            'label' => 'شناسه ملی',
            'value' => $company?->national_id,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[registered_capital_irr]',
            'oldKey' => 'company.registered_capital_irr',
            'label' => 'سرمایه ثبت‌شده (ریال)',
            'type' => 'number',
            'min' => 0,
            'step' => 1,
            'value' => $company?->registered_capital_irr,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[reference_gazette_date]',
            'oldKey' => 'company.reference_gazette_date',
            'label' => 'تاریخ آخرین روزنامه رسمی',
            'value' => $company?->reference_gazette_date,
            'placeholder' => 'مثال: ۱۴۰۳/۰۶/۱۵',
        ])
    </div>
</div>
