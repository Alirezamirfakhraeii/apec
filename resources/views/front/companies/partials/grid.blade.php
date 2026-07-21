<div class="row companies-grid">

    @forelse($companies as $company)

        @php
            $statusClass = 'unknown';

            if ($company->membership_status === 'فعال') {
                $statusClass = 'active';
            } elseif ($company->membership_status === 'تعلیق') {
                $statusClass = 'suspended';
            } elseif ($company->membership_status === 'لغو') {
                $statusClass = 'cancelled';
            }
        @endphp

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">

            <button type="button"
                    class="company-logo-card"
                    data-bs-toggle="modal"
                    data-bs-target="#companyModal{{ $company->id }}">

                <div class="company-logo-card-top">

                    <span class="companies-status {{ $statusClass }}">
                        {{ $company->membership_status ?: 'نامشخص' }}
                    </span>

                    <span class="company-card-arrow">
                        <i class="fa fa-arrow-left"></i>
                    </span>

                </div>

                <div class="company-logo-box">

                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}"
                             alt="{{ $company->registered_name }}"
                             class="company-logo-image">
                    @else
                        <div class="company-logo-empty">
                            <i class="fa fa-building"></i>

                            <span>
                                بدون لوگو
                            </span>
                        </div>
                    @endif

                </div>

                <div class="company-logo-content">

                    <h3 class="company-logo-title">
                        {{ $company->registered_name ?: 'نام شرکت ثبت نشده' }}
                    </h3>

                    @if($company->company_name_en)
                        <div class="company-logo-en-name"
                             dir="ltr">

                            {{ $company->company_name_en }}
                        </div>
                    @endif

                    <div class="company-logo-meta">

                        <div>
                            <span>شماره عضویت</span>

                            <strong>
                                {{ $company->membership_number ?: '—' }}
                            </strong>
                        </div>

                        <div>
                            <span>نوع عضویت</span>

                            <strong>
                                {{ $company->membership_type ?: 'نامشخص' }}
                            </strong>
                        </div>

                    </div>

                </div>

                <div class="company-logo-footer">
                    <span>
                        مشاهده اطلاعات شرکت
                    </span>

                    <i class="fa fa-eye"></i>
                </div>

            </button>

        </div>

    @empty

        <div class="col-12">
            <div class="companies-empty-state">

                <i class="fa fa-folder-open"></i>

                <h4>شرکتی پیدا نشد</h4>

                <p>
                    عبارت جستجو یا فیلترها را تغییر دهید.
                </p>

            </div>
        </div>

    @endforelse

</div>
