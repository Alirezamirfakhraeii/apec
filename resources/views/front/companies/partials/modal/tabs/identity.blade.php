{{-- Identity tab --}}
<div class="tab-pane fade show active"
     id="identity-panel-{{ $company->id }}"
     role="tabpanel"
     aria-labelledby="identity-tab-{{ $company->id }}">

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-id-card"></i>
            </div>

            <div>
                <h5>اطلاعات ثبتی و عضویت</h5>
                <p>تمام فیلدها حتی در صورت خالی بودن نمایش داده می‌شوند.</p>
            </div>
        </div>

        <div class="company-information-grid">
            @foreach($identityFields as $field)
                @php
                    $rawValue = $field['value'] ?? null;
                    $isEmpty = ! filled($rawValue);
                    $renderedValue = ($field['already_displayed'] ?? false)
                        ? $rawValue
                        : $displayValue($rawValue);
                @endphp

                <div class="company-info-item {{ $isEmpty ? 'is-empty' : '' }}">
                    <span class="company-info-label">
                        {{ $field['label'] }}
                    </span>

                    <strong class="company-info-value"
                            dir="{{ $field['dir'] ?? 'rtl' }}">
                        {{ $renderedValue }}

                        @if(! $isEmpty && ! empty($field['suffix']))
                            <small>{{ $field['suffix'] }}</small>
                        @endif
                    </strong>
                </div>
            @endforeach
        </div>
    </section>

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-oil-can"></i>
            </div>

            <div>
                <h5>تخصص شرکت</h5>
                <p>سابقه و تخصص در صنایع نفت، گاز و پتروشیمی</p>
            </div>
        </div>

        @php
            $oilGasSpecialty = $getValue(
                'oil_gas_petchem_specialty',
                'oil_gas_specialty',
                'industry_specialty',
                'specialty_description',
                'activity_type'
            );
        @endphp

        <div class="company-long-value {{ filled($oilGasSpecialty) ? '' : 'is-empty' }}">
            <span class="company-info-label">
                نوع تخصص در صنایع نفت، گاز و پتروشیمی
            </span>

            <div class="company-long-value-text">
                {!! nl2br(e($displayValue($oilGasSpecialty))) !!}
            </div>
        </div>
    </section>
</div>
