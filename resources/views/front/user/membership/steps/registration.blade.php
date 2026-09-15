@php
    use App\Support\PersianDate;

    $profile = $application->companyProfile;

    $registrationDate = $profile?->registration_date
        ? PersianDate::fromGregorian(
            $profile->registration_date->format('Y-m-d')
        )
        : '';

    $referenceGazetteDate = $profile?->reference_gazette_date
        ? PersianDate::fromGregorian(
            $profile->reference_gazette_date->format('Y-m-d')
        )
        : '';

    $shareholders = $application->shareholders->count()
        ? $application->shareholders
        : collect([
            (object) [
                'full_name' => '',
                'ownership_percentage' => '',
            ],
        ]);
@endphp

@extends('front.user.layouts.app')

@section('title', 'ثبت و مالکیت')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/membership-wizard/style.css') }}"
    >

    <link
        rel="stylesheet"
        href="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css"
    >
@endsection

@section('content')

    <div class="membership-wizard-page">

        @include(
            'front.user.membership.partials.progress',
            ['currentStep' => 2]
        )

        <div class="membership-page-heading">

            <div>
            <span class="membership-eyebrow">
                مرحله ۲ از ۴
            </span>

                <h1>
                    اطلاعات ثبت و مالکیت
                </h1>

                <p>
                    اطلاعات ثبتی شرکت، سهامداران و روزنامه رسمی را وارد کنید.
                </p>
            </div>

        </div>


        <div
            id="registration-general-error"
            class="membership-alert membership-alert--error"
            style="display: none;"
        ></div>


        <div
            id="registration-success"
            class="membership-alert membership-alert--success"
            style="display: none;"
        ></div>


        <form
            id="registration-form"
            class="membership-card"
            action="{{ route(
            'user.membership.registration.update',
            $application
        ) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')


            {{-- =========================================================
                اطلاعات ثبتی شرکت
            ========================================================== --}}

            <div class="membership-section-heading">
                <div>
                    <h2>
                        اطلاعات ثبتی شرکت
                    </h2>

                    <p>
                        مشخصات ثبت رسمی شرکت را تکمیل کنید.
                    </p>
                </div>
            </div>


            <div class="membership-grid">

                {{-- تاریخ ثبت --}}
                <div class="membership-field">

                    <label for="registration_date">
                        تاریخ ثبت شرکت
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="registration_date"
                        name="registration_date"
                        data-jdp
                        autocomplete="off"
                        value="{{ old(
                        'registration_date',
                        $registrationDate
                    ) }}"
                        placeholder="1405/06/15"
                    >

                    <span
                        class="membership-error"
                        data-error-for="registration_date"
                    ></span>

                </div>


                {{-- شماره ثبت --}}
                <div class="membership-field">

                    <label for="registration_number">
                        شماره ثبت شرکت
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="registration_number"
                        name="registration_number"
                        inputmode="numeric"
                        value="{{ old(
                        'registration_number',
                        $profile?->registration_number
                    ) }}"
                    >

                    <span
                        class="membership-error"
                        data-error-for="registration_number"
                    ></span>

                </div>


                {{-- محل ثبت --}}
                <div class="membership-field">

                    <label for="registration_place">
                        محل ثبت شرکت
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="registration_place"
                        name="registration_place"
                        value="{{ old(
                        'registration_place',
                        $profile?->registration_place
                    ) }}"
                    >

                    <span
                        class="membership-error"
                        data-error-for="registration_place"
                    ></span>

                </div>


                {{-- سرمایه ثبت شده --}}
                <div class="membership-field">

                    <label for="registered_capital_irr">
                        سرمایه ثبت‌شده
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="registered_capital_irr"
                        name="registered_capital_irr"
                        inputmode="numeric"
                        value="{{ old(
                        'registered_capital_irr',
                        $profile?->registered_capital_irr
                    ) }}"
                        placeholder="ریال"
                    >

                    <span
                        class="membership-error"
                        data-error-for="registered_capital_irr"
                    ></span>

                </div>


                {{-- تاریخ روزنامه رسمی --}}
                <div class="membership-field">

                    <label for="reference_gazette_date">
                        تاریخ روزنامه رسمی
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="reference_gazette_date"
                        name="reference_gazette_date"
                        data-jdp
                        autocomplete="off"
                        value="{{ old(
                        'reference_gazette_date',
                        $referenceGazetteDate
                    ) }}"
                        placeholder="1405/06/15"
                    >

                    <span
                        class="membership-error"
                        data-error-for="reference_gazette_date"
                    ></span>

                </div>

            </div>


            {{-- =========================================================
                سهامداران
            ========================================================== --}}

            <div class="membership-section-heading">

                <div>
                    <h2>
                        سهامداران شرکت
                    </h2>

                    <p>
                        یک یا چند سهامدار وارد کنید.
                        مجموع درصد سهام باید دقیقاً ۱۰۰٪ باشد.
                    </p>
                </div>

                <button
                    type="button"
                    id="add-shareholder"
                    class="membership-btn membership-btn--secondary"
                >
                    + افزودن سهامدار
                </button>

            </div>


            <div
                id="shareholders-container"
                class="membership-shareholders"
            >

                @foreach($shareholders as $index => $shareholder)

                    <div
                        class="membership-shareholder-row"
                        data-shareholder-row
                    >

                        <div class="membership-field">

                            <label>
                                نام و نام خانوادگی
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                name="shareholders[{{ $index }}][full_name]"
                                value="{{ old(
                                "shareholders.$index.full_name",
                                $shareholder->full_name
                            ) }}"
                                data-shareholder-name
                            >

                            <span
                                class="membership-error"
                                data-shareholder-name-error
                            ></span>

                        </div>


                        <div class="membership-field">

                            <label>
                                درصد سهام
                                <span>*</span>
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                max="100"
                                name="shareholders[{{ $index }}][ownership_percentage]"
                                value="{{ old(
                                "shareholders.$index.ownership_percentage",
                                $shareholder->ownership_percentage
                            ) }}"
                                data-shareholder-percentage
                            >

                            <span
                                class="membership-error"
                                data-shareholder-percentage-error
                            ></span>

                        </div>


                        <div class="membership-field membership-field--button">

                            <button
                                type="button"
                                class="membership-link-danger"
                                data-remove-shareholder
                            >
                                حذف
                            </button>

                        </div>

                    </div>

                @endforeach

            </div>


            <div class="membership-shareholder-total">

                مجموع سهام:

                <strong id="shareholder-total">
                    0
                </strong>

                <span>
                %
            </span>

            </div>


            <span
                class="membership-error"
                data-error-for="shareholders"
            ></span>


            {{-- =========================================================
                روزنامه رسمی
            ========================================================== --}}

            <div class="membership-section-heading">

                <div>
                    <h2>
                        روزنامه رسمی
                    </h2>

                    <p>
                        فرمت مجاز:
                        PDF، JPG، JPEG یا PNG
                    </p>
                </div>

            </div>


            <div class="membership-field">

                <label for="official_gazette">
                    فایل روزنامه رسمی
                    @unless($officialGazette)
                        <span>*</span>
                    @endunless
                </label>

                <input
                    type="file"
                    id="official_gazette"
                    name="official_gazette"
                    accept=".pdf,.jpg,.jpeg,.png"
                >

                <span
                    class="membership-error"
                    data-error-for="official_gazette"
                ></span>


                @if($officialGazette)

                    <div class="membership-existing-file">

                    <span>
                        فایل فعلی:
                    </span>

                        <a
                            href="{{ asset(
                            'storage/' . $officialGazette->path
                        ) }}"
                            target="_blank"
                        >
                            {{ $officialGazette->original_name }}
                        </a>

                        <small>
                            در صورتی که فایل جدید انتخاب نکنید،
                            فایل فعلی حفظ می‌شود.
                        </small>

                    </div>

                @endif

            </div>


            {{-- =========================================================
                Actions
            ========================================================== --}}

            <div class="membership-actions">

                <a
                    href="{{ route(
                    'user.membership.basic',
                    $application
                ) }}"
                    class="membership-btn membership-btn--secondary"
                >
                    مرحله قبل
                </a>


                <button
                    type="submit"
                    id="registration-submit-button"
                    class="membership-btn membership-btn--primary"
                >
                    ذخیره و ادامه
                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script
        src="https://unpkg.com/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"
    ></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Jalali Date Picker
            |--------------------------------------------------------------------------
            */

            jalaliDatepicker.startWatch({
                separatorChar: '/',
                autoHide: true,
                showTodayBtn: true,
                showEmptyBtn: true,
            });


            /*
            |--------------------------------------------------------------------------
            | Elements
            |--------------------------------------------------------------------------
            */

            const form =
                document.getElementById('registration-form');

            const shareholdersContainer =
                document.getElementById('shareholders-container');

            const addShareholderButton =
                document.getElementById('add-shareholder');

            const totalElement =
                document.getElementById('shareholder-total');

            const submitButton =
                document.getElementById('registration-submit-button');

            const successBox =
                document.getElementById('registration-success');

            const generalErrorBox =
                document.getElementById('registration-general-error');


            /*
            |--------------------------------------------------------------------------
            | Helpers
            |--------------------------------------------------------------------------
            */

            function clearErrors() {

                document
                    .querySelectorAll('.membership-error')
                    .forEach(function (element) {
                        element.textContent = '';
                    });

                successBox.style.display = 'none';

                generalErrorBox.style.display = 'none';
                generalErrorBox.textContent = '';
            }


            function updateIndexes() {

                const rows =
                    shareholdersContainer.querySelectorAll(
                        '[data-shareholder-row]'
                    );

                rows.forEach(function (row, index) {

                    const nameInput =
                        row.querySelector('[data-shareholder-name]');

                    const percentageInput =
                        row.querySelector(
                            '[data-shareholder-percentage]'
                        );

                    nameInput.name =
                        `shareholders[${index}][full_name]`;

                    percentageInput.name =
                        `shareholders[${index}][ownership_percentage]`;
                });

            }


            function calculateTotal() {

                let total = 0;

                shareholdersContainer
                    .querySelectorAll(
                        '[data-shareholder-percentage]'
                    )
                    .forEach(function (input) {

                        const value =
                            parseFloat(input.value);

                        if (!Number.isNaN(value)) {
                            total += value;
                        }

                    });

                totalElement.textContent =
                    total.toFixed(2)
                        .replace(/\.00$/, '');

            }


            function createShareholderRow() {

                const row =
                    document.createElement('div');

                row.className =
                    'membership-shareholder-row';

                row.setAttribute(
                    'data-shareholder-row',
                    ''
                );

                row.innerHTML = `
            <div class="membership-field">

                <label>
                    نام و نام خانوادگی
                    <span>*</span>
                </label>

                <input
                    type="text"
                    data-shareholder-name
                >

                <span
                    class="membership-error"
                    data-shareholder-name-error
                ></span>

            </div>

            <div class="membership-field">

                <label>
                    درصد سهام
                    <span>*</span>
                </label>

                <input
                    type="number"
                    step="0.01"
                    min="0.01"
                    max="100"
                    data-shareholder-percentage
                >

                <span
                    class="membership-error"
                    data-shareholder-percentage-error
                ></span>

            </div>

            <div class="membership-field membership-field--button">

                <button
                    type="button"
                    class="membership-link-danger"
                    data-remove-shareholder
                >
                    حذف
                </button>

            </div>
        `;

                shareholdersContainer.appendChild(row);

                updateIndexes();
                calculateTotal();
            }


            function showValidationErrors(errors) {

                Object.entries(errors).forEach(
                    function ([field, messages]) {

                        /*
                        |--------------------------------------------------------------------------
                        | Normal Fields
                        |--------------------------------------------------------------------------
                        */

                        const normalField =
                            document.querySelector(
                                `[data-error-for="${field}"]`
                            );

                        if (normalField) {

                            normalField.textContent =
                                messages[0];

                            return;
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Shareholder Fields
                        |--------------------------------------------------------------------------
                        |
                        | Example:
                        | shareholders.0.full_name
                        |
                        */

                        const nameMatch =
                            field.match(
                                /^shareholders\.(\d+)\.full_name$/
                            );

                        if (nameMatch) {

                            const index =
                                parseInt(
                                    nameMatch[1],
                                    10
                                );

                            const rows =
                                shareholdersContainer.querySelectorAll(
                                    '[data-shareholder-row]'
                                );

                            const errorElement =
                                rows[index]?.querySelector(
                                    '[data-shareholder-name-error]'
                                );

                            if (errorElement) {
                                errorElement.textContent =
                                    messages[0];
                            }

                            return;
                        }


                        const percentageMatch =
                            field.match(
                                /^shareholders\.(\d+)\.ownership_percentage$/
                            );

                        if (percentageMatch) {

                            const index =
                                parseInt(
                                    percentageMatch[1],
                                    10
                                );

                            const rows =
                                shareholdersContainer.querySelectorAll(
                                    '[data-shareholder-row]'
                                );

                            const errorElement =
                                rows[index]?.querySelector(
                                    '[data-shareholder-percentage-error]'
                                );

                            if (errorElement) {
                                errorElement.textContent =
                                    messages[0];
                            }

                        }

                    }
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Add Shareholder
            |--------------------------------------------------------------------------
            */

            addShareholderButton.addEventListener(
                'click',
                function () {
                    createShareholderRow();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Remove Shareholder
            |--------------------------------------------------------------------------
            */

            shareholdersContainer.addEventListener(
                'click',
                function (event) {

                    const button =
                        event.target.closest(
                            '[data-remove-shareholder]'
                        );

                    if (!button) {
                        return;
                    }

                    const rows =
                        shareholdersContainer.querySelectorAll(
                            '[data-shareholder-row]'
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | حداقل یک سهامدار باید باقی بماند
                    |--------------------------------------------------------------------------
                    */

                    if (rows.length === 1) {

                        const row = rows[0];

                        row.querySelector(
                            '[data-shareholder-name]'
                        ).value = '';

                        row.querySelector(
                            '[data-shareholder-percentage]'
                        ).value = '';

                        calculateTotal();

                        return;
                    }

                    button
                        .closest('[data-shareholder-row]')
                        .remove();

                    updateIndexes();
                    calculateTotal();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Live Total
            |--------------------------------------------------------------------------
            */

            shareholdersContainer.addEventListener(
                'input',
                function (event) {

                    if (
                        event.target.matches(
                            '[data-shareholder-percentage]'
                        )
                    ) {
                        calculateTotal();
                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Submit
            |--------------------------------------------------------------------------
            */

            form.addEventListener(
                'submit',
                async function (event) {

                    event.preventDefault();

                    clearErrors();
                    updateIndexes();

                    submitButton.disabled = true;
                    submitButton.textContent =
                        'در حال ذخیره...';

                    try {

                        const formData =
                            new FormData(form);

                        /*
                        |--------------------------------------------------------------------------
                        | Laravel Method Spoofing
                        |--------------------------------------------------------------------------
                        |
                        | فرم به صورت POST ارسال می‌شود و _method=PUT داخل FormData است.
                        |
                        */

                        const response =
                            await fetch(
                                form.action,
                                {
                                    method: 'POST',

                                    headers: {
                                        'Accept':
                                            'application/json',

                                        'X-Requested-With':
                                            'XMLHttpRequest',
                                    },

                                    body: formData,
                                }
                            );


                        const data =
                            await response.json();


                        if (response.status === 422) {

                            showValidationErrors(
                                data.errors ?? {}
                            );

                            return;
                        }


                        if (!response.ok) {
                            throw new Error(
                                'Request failed'
                            );
                        }


                        successBox.textContent =
                            data.message ??
                            'اطلاعات با موفقیت ذخیره شد.';

                        successBox.style.display =
                            'block';


                        if (data.redirect) {

                            setTimeout(
                                function () {
                                    window.location.href =
                                        data.redirect;
                                },
                                400
                            );

                        }

                    } catch (error) {

                        console.error(error);

                        generalErrorBox.textContent =
                            'در ذخیره اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.';

                        generalErrorBox.style.display =
                            'block';

                    } finally {

                        submitButton.disabled = false;

                        submitButton.textContent =
                            'ذخیره و ادامه';

                    }

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Initial Total
            |--------------------------------------------------------------------------
            */

            updateIndexes();
            calculateTotal();

        });
    </script>

@endpush
