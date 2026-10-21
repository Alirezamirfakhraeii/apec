<div class="company-edit-section">
    <div class="company-edit-section__title">اطلاعات تماس شرکت</div>

    <div class="company-edit-grid">
        @include('front.user.company.partials._input', [
            'name' => 'company[phone]',
            'oldKey' => 'company.phone',
            'label' => 'تلفن شرکت',
            'value' => $company?->phone,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[fax]',
            'oldKey' => 'company.fax',
            'label' => 'فکس',
            'value' => $company?->fax,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[email]',
            'oldKey' => 'company.email',
            'label' => 'ایمیل شرکت',
            'type' => 'email',
            'dir' => 'ltr',
            'value' => $company?->email,
        ])

        @include('front.user.company.partials._input', [
            'name' => 'company[website]',
            'oldKey' => 'company.website',
            'label' => 'وب‌سایت',
            'dir' => 'ltr',
            'value' => $company?->website,
        ])

        @include('front.user.company.partials._textarea', [
            'name' => 'company[address]',
            'oldKey' => 'company.address',
            'label' => 'آدرس شرکت',
            'value' => $company?->address,
        ])
    </div>
</div>
