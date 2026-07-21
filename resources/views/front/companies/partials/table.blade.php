<div class="companies-table-card">

    <div class="table-responsive">

        <table class="table companies-table mb-0">

            <thead>
            <tr>
                <th>ردیف</th>
                <th>لوگو</th>
                <th class="text-right">نام شرکت</th>
                <th>شماره عضویت</th>
                <th>نوع عضویت</th>
                <th>وضعیت</th>
                <th>تلفن</th>
                <th>جزئیات</th>
            </tr>
            </thead>

            <tbody>

            @forelse($companies as $key => $company)

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

                <tr>

                    <td class="companies-table-index">
                        {{ $companies->firstItem() + $key }}
                    </td>

                    <td>
                        <div class="companies-table-logo">

                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}"
                                     alt="{{ $company->registered_name }}">
                            @else
                                <div class="companies-logo-placeholder">
                                    <i class="fa fa-building"></i>
                                </div>
                            @endif

                        </div>
                    </td>

                    <td class="text-right">

                        <button type="button"
                                class="companies-table-name"
                                data-bs-toggle="modal"
                                data-bs-target="#companyModal{{ $company->id }}">

                            {{ $company->registered_name ?: 'نام شرکت ثبت نشده' }}
                        </button>

                        @if($company->company_short_name)
                            <div class="companies-table-subtitle">
                                {{ $company->company_short_name }}
                            </div>
                        @endif

                    </td>

                    <td>
                        {{ $company->membership_number ?: '—' }}
                    </td>

                    <td>
                            <span class="companies-type-badge">
                                {{ $company->membership_type ?: 'نامشخص' }}
                            </span>
                    </td>

                    <td>
                            <span class="companies-status {{ $statusClass }}">
                                {{ $company->membership_status ?: 'نامشخص' }}
                            </span>
                    </td>

                    <td dir="ltr">
                        {{ $company->phone ?: '—' }}
                    </td>

                    <td>
                        <button type="button"
                                class="companies-details-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#companyModal{{ $company->id }}">

                            <i class="fa fa-eye"></i>
                            مشاهده
                        </button>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8"
                        class="companies-empty-state">

                        <i class="fa fa-folder-open"></i>

                        <h4>شرکتی پیدا نشد</h4>

                        <p>
                            عبارت جستجو یا فیلترها را تغییر دهید.
                        </p>
                    </td>
                </tr>

            @endforelse

            </tbody>

        </table>

    </div>
</div>
