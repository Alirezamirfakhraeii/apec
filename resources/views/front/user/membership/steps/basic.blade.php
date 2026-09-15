@extends('front.user.layouts.app')

@section('title', 'اطلاعات پایه شرکت')

@section('styles')
    <link
        rel="stylesheet"
        href="{{ asset('front/css/membership/style.css') }}"
    >
@endsection


@section('content')

    <div class="membership-form-page">

        {{-- Header --}}
        <div class="membership-form-header">

            <div>
                <h1>
                    درخواست عضویت
                </h1>

                <p>
                    اطلاعات اصلی شرکت را وارد کنید.
                </p>
            </div>

            <div class="membership-form-status">
                مرحله ۱
            </div>

        </div>


        <div
            id="basic-general-error"
            class="membership-alert membership-alert--error"
            style="display:none;"
        ></div>


        <div class="membership-form-card">

            <div class="membership-form-card__header">

            <span class="membership-step-badge">
                ۱
            </span>

                <div>
                    <h2>
                        اطلاعات پایه شرکت
                    </h2>

                    <p>
                        مشخصات عمومی و اصلی شرکت را تکمیل کنید.
                    </p>
                </div>

            </div>


            <form
                id="company-basic-form"
                action="{{ route(
                'user.membership.basic.update',
                $application
            ) }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf
                @method('PUT')


                <div class="membership-form-grid">


                    {{-- Logo --}}
                    <div class="membership-form-group">

                        <label for="logo">
                            لوگوی شرکت
                        </label>

                        @if ($application->companyProfile?->logo_path)

                            <div style="margin-bottom: 10px;">
                                <img
                                    src="{{ asset(
                                    'storage/' .
                                    $application->companyProfile->logo_path
                                ) }}"
                                    alt="لوگوی شرکت"
                                    style="
                                    width:80px;
                                    height:80px;
                                    object-fit:contain;
                                    border:1px solid #e5e7eb;
                                    border-radius:10px;
                                    padding:5px;
                                "
                                >
                            </div>

                        @endif

                        <input
                            type="file"
                            id="logo"
                            name="logo"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                        <span
                            class="membership-field-error"
                            data-error="logo"
                        ></span>

                    </div>


                    {{-- Persian Company Name --}}
                    <div class="membership-form-group">

                        <label for="registered_name">
                            نام شرکت
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="registered_name"
                            name="registered_name"
                            value="{{
                            $application->companyProfile?->registered_name
                            ??
                            $application->intake_company_name
                        }}"
                            placeholder="نام فارسی شرکت"
                        >

                        <span
                            class="membership-field-error"
                            data-error="registered_name"
                        ></span>

                    </div>


                    {{-- Short Name --}}
                    <div class="membership-form-group">

                        <label for="company_short_name">
                            نام کوتاه شرکت
                        </label>

                        <input
                            type="text"
                            id="company_short_name"
                            name="company_short_name"
                            value="{{
                            $application->companyProfile?->company_short_name
                        }}"
                            placeholder="مثلاً رستاک"
                        >

                        <span
                            class="membership-field-error"
                            data-error="company_short_name"
                        ></span>

                    </div>


                    {{-- English Name --}}
                    <div class="membership-form-group">

                        <label for="company_name_en">
                            نام انگلیسی شرکت
                        </label>

                        <input
                            type="text"
                            id="company_name_en"
                            name="company_name_en"
                            dir="ltr"
                            value="{{
                            $application->companyProfile?->company_name_en
                        }}"
                            placeholder="Company English Name"
                        >

                        <span
                            class="membership-field-error"
                            data-error="company_name_en"
                        ></span>

                    </div>


                    {{-- Nationality --}}
                    <div class="membership-form-group">

                        <label for="nationality">
                            تابعیت شرکت
                        </label>

                        <select
                            id="nationality"
                            name="nationality"
                        >

                            <option value="">
                                انتخاب کنید
                            </option>

                            <option
                                value="ایرانی"
                                @selected(
                                    $application->companyProfile?->nationality
                                    === 'ایرانی'
                                )
                            >
                                ایرانی
                            </option>

                            <option
                                value="غیرایرانی"
                                @selected(
                                    $application->companyProfile?->nationality
                                    === 'غیرایرانی'
                                )
                            >
                                غیرایرانی
                            </option>

                        </select>

                        <span
                            class="membership-field-error"
                            data-error="nationality"
                        ></span>

                    </div>


                    {{-- Company Type --}}
                    <div class="membership-form-group">

                        <label for="company_type">
                            نوع ثبت شرکت
                            <span>*</span>
                        </label>

                        <select
                            id="company_type"
                            name="company_type"
                        >

                            <option value="">
                                انتخاب نوع شرکت
                            </option>

                            @foreach ($companyTypes as $type)

                                <option
                                    value="{{ $type['value'] }}"
                                    @selected(
                                        $application->companyProfile?->company_type
                                        === $type['value']
                                    )
                                >
                                    {{ $type['label'] }}
                                </option>

                            @endforeach

                        </select>

                        <span
                            class="membership-field-error"
                            data-error="company_type"
                        ></span>

                    </div>


                    {{-- Parent Company --}}
                    <div class="membership-form-group">

                        <label for="parent_company_name">
                            نام شرکت مادر
                        </label>

                        <input
                            type="text"
                            id="parent_company_name"
                            name="parent_company_name"
                            value="{{
                            $application->companyProfile?->parent_company_name
                        }}"
                            placeholder="در صورت وجود"
                        >

                        <span
                            class="membership-field-error"
                            data-error="parent_company_name"
                        ></span>

                    </div>

                </div>


                <div class="membership-form-actions">

                    <a
                        href="{{ route('user.membership.create') }}"
                        class="membership-secondary-button"
                    >
                        مرحله قبل
                    </a>


                    <button
                        type="submit"
                        id="basic-submit-button"
                        class="membership-primary-button"
                    >
                        ذخیره و ادامه
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection



@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form =
                document.getElementById('company-basic-form');

            const button =
                document.getElementById('basic-submit-button');

            const generalError =
                document.getElementById('basic-general-error');

            if (!form) {
                return;
            }


            function clearErrors() {

                document
                    .querySelectorAll('[data-error]')
                    .forEach(function (element) {
                        element.textContent = '';
                    });

                generalError.style.display = 'none';
                generalError.textContent = '';
            }


            function showErrors(errors) {

                Object.entries(errors).forEach(
                    function ([field, messages]) {

                        const element = document.querySelector(
                            `[data-error="${field}"]`
                        );

                        if (element) {
                            element.textContent = messages[0];
                        }

                    }
                );
            }


            form.addEventListener('submit', async function (event) {

                event.preventDefault();

                clearErrors();

                button.disabled = true;
                button.textContent = 'در حال ذخیره...';


                try {

                    const response = await fetch(
                        form.action,
                        {
                            method: 'POST',

                            headers: {
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                            },

                            body: new FormData(form),
                        }
                    );


                    const data = await response.json();


                    if (response.status === 422) {

                        showErrors(
                            data.errors ?? {}
                        );

                        return;
                    }


                    if (!response.ok) {
                        throw new Error();
                    }


                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }


                } catch (error) {

                    console.error(error);

                    generalError.textContent =
                        'در ذخیره اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.';

                    generalError.style.display = 'block';

                } finally {

                    button.disabled = false;
                    button.textContent = 'ذخیره و ادامه';

                }

            });

        });
    </script>

@endpush
