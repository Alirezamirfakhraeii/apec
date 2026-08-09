{{-- Contact tab --}}
<div class="tab-pane fade"
     id="contact-panel-{{ $company->id }}"
     role="tabpanel"
     aria-labelledby="contact-tab-{{ $company->id }}">

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-phone"></i>
            </div>

            <div>
                <h5>راه‌های ارتباطی</h5>
                <p>تلفن، ایمیل، وب‌سایت و کد پستی شرکت</p>
            </div>
        </div>

        <div class="company-information-grid">
            @foreach($contactFields as $field)
                @php
                    $fieldValue = $field['value'] ?? null;
                    $isEmpty = ! filled($fieldValue);
                    $fieldType = $field['type'] ?? 'text';
                @endphp

                <div class="company-info-item {{ $isEmpty ? 'is-empty' : '' }}">
                    <span class="company-info-label">
                        {{ $field['label'] }}
                    </span>

                    <strong class="company-info-value"
                            dir="{{ $field['dir'] ?? 'rtl' }}">
                        @if($fieldType === 'phone' && ! $isEmpty)
                            <a href="tel:{{ $fieldValue }}">
                                {{ $fieldValue }}
                            </a>
                        @elseif($fieldType === 'email' && ! $isEmpty)
                            <a href="mailto:{{ $fieldValue }}">
                                {{ $fieldValue }}
                            </a>
                        @elseif($fieldType === 'website' && $websiteUrl)
                            <a href="{{ $websiteUrl }}"
                               target="_blank"
                               rel="noopener noreferrer">
                                {{ $fieldValue }}
                            </a>
                        @else
                            {{ $displayValue($fieldValue) }}
                        @endif
                    </strong>
                </div>
            @endforeach
        </div>
    </section>

    @php
        $addressFa = $getValue('address', 'address_fa');
        $addressEn = $getValue('address_en', 'english_address');
        $additionalDescription = $getValue(
            'additional_description',
            'description',
            'notes'
        );
    @endphp

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-map-marker-alt"></i>
            </div>

            <div>
                <h5>نشانی شرکت</h5>
                <p>نشانی فارسی و انگلیسی به‌صورت جداگانه</p>
            </div>
        </div>

        <div class="company-address-grid">
            <div class="company-long-value {{ filled($addressFa) ? '' : 'is-empty' }}">
                <span class="company-info-label">نشانی فارسی</span>
                <div class="company-long-value-text">
                    {!! nl2br(e($displayValue($addressFa))) !!}
                </div>
            </div>

            <div class="company-long-value {{ filled($addressEn) ? '' : 'is-empty' }}"
                 dir="ltr">
                <span class="company-info-label">English Address</span>
                <div class="company-long-value-text">
                    {!! nl2br(e($displayValue($addressEn))) !!}
                </div>
            </div>
        </div>
    </section>

    <section class="company-modal-section">
        <div class="company-modal-section-header">
            <div class="company-modal-section-icon">
                <i class="fa fa-file-alt"></i>
            </div>

            <div>
                <h5>کاتالوگ و توضیحات تکمیلی</h5>
                <p>فایل معرفی شرکت و اطلاعات تکمیلی</p>
            </div>
        </div>

        <div class="company-file-card {{ $catalogUrl ? 'has-file' : 'is-empty' }}">
            <div class="company-file-icon">
                <i class="fa fa-file-pdf"></i>
            </div>

            <div class="company-file-content">
                <strong>کاتالوگ شرکت</strong>
                <span>
                    {{ $catalogUrl ? 'فایل PDF کاتالوگ در دسترس است.' : 'فایل کاتالوگ بارگذاری نشده است.' }}
                </span>
            </div>

            @if($catalogUrl)
                <a href="{{ $catalogUrl }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="company-file-button">
                    مشاهده کاتالوگ
                </a>
            @else
                <span class="company-file-button disabled">
                    ثبت نشده
                </span>
            @endif
        </div>

        <div class="company-long-value mt-3 {{ filled($additionalDescription) ? '' : 'is-empty' }}">
            <span class="company-info-label">توضیحات تکمیلی</span>
            <div class="company-long-value-text">
                {!! nl2br(e($displayValue($additionalDescription))) !!}
            </div>
        </div>
    </section>
</div>
