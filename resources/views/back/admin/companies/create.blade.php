@extends('back.admin.layouts.master')

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدیریت اعضا</h4>

                <span class="text-muted mt-1 tx-13 mr-2 mb-0">
                    / تعریف و ثبت شرکت جدید
                </span>
            </div>
        </div>

        <div class="d-flex my-xl-auto right-content">
            <div class="pe-1 mb-xl-0">
                <a href="{{ route('admin.company.index') }}"
                   class="btn btn-secondary fw-bold">

                    <i class="fa fa-arrow-right ml-1"></i>
                    بازگشت به لیست
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <div class="fw-bold mb-2">
                <i class="fa fa-exclamation-circle ml-1"></i>
                لطفاً خطاهای فرم را بررسی کنید.
            </div>

            <ul class="mb-0 pr-3 font_12">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- فرم مستقل ورود اطلاعات از اکسل --}}
    <form id="company-import-form"
          action="{{ route('admin.company.import-excel') }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
    </form>

    {{-- فرم ثبت دستی شرکت --}}
    <form action="{{ route('admin.company.store') }}"
          method="POST"
          id="company-form">

        @csrf

        <div class="row row-sm">

            {{-- ستون اصلی --}}
            <div class="col-xl-8 col-lg-8 col-md-12">

                {{-- اطلاعات پایه شرکت --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-building ml-2"></i>
                            اطلاعات پایه شرکت
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="registered_name" class="font_13 fw-bold">
                                نام ثبتی شرکت:
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   name="registered_name"
                                   id="registered_name"
                                   class="form-control @error('registered_name') is-invalid @enderror"
                                   value="{{ old('registered_name') }}"
                                   placeholder="نام کامل و ثبتی شرکت"
                                   required>

                            @error('registered_name')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_short_name" class="font_13 fw-bold">
                                        نام اختصاری یا شناخته‌شده:
                                    </label>

                                    <input type="text"
                                           name="company_short_name"
                                           id="company_short_name"
                                           class="form-control @error('company_short_name') is-invalid @enderror"
                                           value="{{ old('company_short_name') }}"
                                           placeholder="نام کوتاه شرکت">

                                    @error('company_short_name')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name_en" class="font_13 fw-bold">
                                        نام انگلیسی شرکت:
                                    </label>

                                    <input type="text"
                                           name="company_name_en"
                                           id="company_name_en"
                                           dir="ltr"
                                           class="form-control text-left @error('company_name_en') is-invalid @enderror"
                                           value="{{ old('company_name_en') }}"
                                           placeholder="Company Name">

                                    @error('company_name_en')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nationality" class="font_13 fw-bold">
                                        تابعیت:
                                    </label>

                                    <input type="text"
                                           name="nationality"
                                           id="nationality"
                                           class="form-control @error('nationality') is-invalid @enderror"
                                           value="{{ old('nationality') }}"
                                           placeholder="مثال: ایرانی">

                                    @error('nationality')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="parent_company_name" class="font_13 fw-bold">
                                        نام شرکت مادر:
                                    </label>

                                    <input type="text"
                                           name="parent_company_name"
                                           id="parent_company_name"
                                           class="form-control @error('parent_company_name') is-invalid @enderror"
                                           value="{{ old('parent_company_name') }}"
                                           placeholder="در صورت وجود">

                                    @error('parent_company_name')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="company_type" class="font_13 fw-bold">
                                نوع شرکت:
                            </label>

                            <select name="company_type"
                                    id="company_type"
                                    class="form-control @error('company_type') is-invalid @enderror">

                                <option value="">-- انتخاب نوع شرکت --</option>

                                <option value="سهامی عام"
                                    {{ old('company_type') === 'سهامی عام' ? 'selected' : '' }}>
                                    سهامی عام
                                </option>

                                <option value="سهامی خاص"
                                    {{ old('company_type') === 'سهامی خاص' ? 'selected' : '' }}>
                                    سهامی خاص
                                </option>

                                <option value="مسئولیت محدود"
                                    {{ old('company_type') === 'مسئولیت محدود' ? 'selected' : '' }}>
                                    مسئولیت محدود
                                </option>

                                <option value="تعاونی"
                                    {{ old('company_type') === 'تعاونی' ? 'selected' : '' }}>
                                    تعاونی
                                </option>

                                <option value="سایر"
                                    {{ old('company_type') === 'سایر' ? 'selected' : '' }}>
                                    سایر
                                </option>
                            </select>

                            @error('company_type')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- اطلاعات ثبتی --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-file-contract ml-2"></i>
                            اطلاعات ثبتی شرکت
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="national_id" class="font_13 fw-bold">
                                        شناسه ملی:
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                           name="national_id"
                                           id="national_id"
                                           dir="ltr"
                                           class="form-control text-left @error('national_id') is-invalid @enderror"
                                           value="{{ old('national_id') }}"
                                           placeholder="شناسه ملی شرکت"
                                           required>

                                    @error('national_id')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_number" class="font_13 fw-bold">
                                        شماره ثبت:
                                    </label>

                                    <input type="text"
                                           name="registration_number"
                                           id="registration_number"
                                           dir="ltr"
                                           class="form-control text-left @error('registration_number') is-invalid @enderror"
                                           value="{{ old('registration_number') }}"
                                           placeholder="شماره ثبت شرکت">

                                    @error('registration_number')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_date" class="font_13 fw-bold">
                                        تاریخ ثبت:
                                    </label>

                                    <input type="text"
                                           name="registration_date"
                                           id="registration_date"
                                           class="form-control @error('registration_date') is-invalid @enderror"
                                           value="{{ old('registration_date') }}"
                                           placeholder="مثال: 1400/05/20">

                                    @error('registration_date')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="registration_place" class="font_13 fw-bold">
                                        محل ثبت:
                                    </label>

                                    <input type="text"
                                           name="registration_place"
                                           id="registration_place"
                                           class="form-control @error('registration_place') is-invalid @enderror"
                                           value="{{ old('registration_place') }}"
                                           placeholder="مثال: تهران">

                                    @error('registration_place')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="registered_capital_irr" class="font_13 fw-bold">
                                سرمایه ثبتی به ریال:
                            </label>

                            <input type="text"
                                   name="registered_capital_irr"
                                   id="registered_capital_irr"
                                   dir="ltr"
                                   class="form-control text-left @error('registered_capital_irr') is-invalid @enderror"
                                   value="{{ old('registered_capital_irr') }}"
                                   placeholder="مثال: 1000000000">

                            @error('registered_capital_irr')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="reference_gazette_date" class="font_13 fw-bold">
                                تاریخ روزنامه مورد استناد:
                            </label>

                            <input type="text"
                                   name="reference_gazette_date"
                                   id="reference_gazette_date"
                                   class="form-control @error('reference_gazette_date') is-invalid @enderror"
                                   value="{{ old('reference_gazette_date') }}"
                                   placeholder="مثال: 1403/02/15">

                            @error('reference_gazette_date')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- اطلاعات تماس --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-address-book ml-2"></i>
                            اطلاعات تماس شرکت
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="font_13 fw-bold">
                                        تلفن:
                                    </label>

                                    <input type="text"
                                           name="phone"
                                           id="phone"
                                           dir="ltr"
                                           class="form-control text-left @error('phone') is-invalid @enderror"
                                           value="{{ old('phone') }}"
                                           placeholder="02100000000">

                                    @error('phone')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fax" class="font_13 fw-bold">
                                        فاکس:
                                    </label>

                                    <input type="text"
                                           name="fax"
                                           id="fax"
                                           dir="ltr"
                                           class="form-control text-left @error('fax') is-invalid @enderror"
                                           value="{{ old('fax') }}"
                                           placeholder="02100000000">

                                    @error('fax')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font_13 fw-bold">
                                        ایمیل شرکت:
                                    </label>

                                    <input type="email"
                                           name="email"
                                           id="email"
                                           dir="ltr"
                                           class="form-control text-left @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="info@example.com">

                                    @error('email')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="website" class="font_13 fw-bold">
                                        وب‌سایت:
                                    </label>

                                    <input type="text"
                                           name="website"
                                           id="website"
                                           dir="ltr"
                                           class="form-control text-left @error('website') is-invalid @enderror"
                                           value="{{ old('website') }}"
                                           placeholder="https://example.com">

                                    @error('website')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="address" class="font_13 fw-bold">
                                آدرس:
                            </label>

                            <textarea name="address"
                                      id="address"
                                      rows="4"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="آدرس کامل شرکت">{{ old('address') }}</textarea>

                            @error('address')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- مدیرعامل و رئیس هیئت‌مدیره --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-user-tie ml-2"></i>
                            اطلاعات مدیران شرکت
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <h6 class="font_13 fw-bold text-primary border-bottom pb-2 mb-3">
                            مدیرعامل
                        </h6>

                        <div class="form-group">
                            <label for="ceo_name" class="font_13 fw-bold">
                                نام مدیرعامل:
                            </label>

                            <input type="text"
                                   name="ceo_name"
                                   id="ceo_name"
                                   class="form-control @error('ceo_name') is-invalid @enderror"
                                   value="{{ old('ceo_name') }}">

                            @error('ceo_name')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ceo_mobile" class="font_13 fw-bold">
                                        موبایل مدیرعامل:
                                    </label>

                                    <input type="text"
                                           name="ceo_mobile"
                                           id="ceo_mobile"
                                           dir="ltr"
                                           class="form-control text-left @error('ceo_mobile') is-invalid @enderror"
                                           value="{{ old('ceo_mobile') }}">

                                    @error('ceo_mobile')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ceo_email" class="font_13 fw-bold">
                                        ایمیل مدیرعامل:
                                    </label>

                                    <input type="email"
                                           name="ceo_email"
                                           id="ceo_email"
                                           dir="ltr"
                                           class="form-control text-left @error('ceo_email') is-invalid @enderror"
                                           value="{{ old('ceo_email') }}">

                                    @error('ceo_email')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <h6 class="font_13 fw-bold text-primary border-bottom pb-2 mb-3 mt-3">
                            رئیس هیئت‌مدیره
                        </h6>

                        <div class="form-group">
                            <label for="chairman_name" class="font_13 fw-bold">
                                نام رئیس هیئت‌مدیره:
                            </label>

                            <input type="text"
                                   name="chairman_name"
                                   id="chairman_name"
                                   class="form-control @error('chairman_name') is-invalid @enderror"
                                   value="{{ old('chairman_name') }}">

                            @error('chairman_name')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chairman_mobile" class="font_13 fw-bold">
                                        موبایل رئیس هیئت‌مدیره:
                                    </label>

                                    <input type="text"
                                           name="chairman_mobile"
                                           id="chairman_mobile"
                                           dir="ltr"
                                           class="form-control text-left @error('chairman_mobile') is-invalid @enderror"
                                           value="{{ old('chairman_mobile') }}">

                                    @error('chairman_mobile')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="chairman_email" class="font_13 fw-bold">
                                        ایمیل رئیس هیئت‌مدیره:
                                    </label>

                                    <input type="email"
                                           name="chairman_email"
                                           id="chairman_email"
                                           dir="ltr"
                                           class="form-control text-left @error('chairman_email') is-invalid @enderror"
                                           value="{{ old('chairman_email') }}">

                                    @error('chairman_email')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- رابط انجمن --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom">
                        <h4 class="card-title text-dark mb-1">
                            <i class="fa fa-user-friends ml-2"></i>
                            اطلاعات رابط انجمن
                        </h4>
                    </div>

                    <div class="card-body pt-3">

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="association_contact_name" class="font_13 fw-bold">
                                        نماینده رابط انجمن:
                                    </label>

                                    <input type="text"
                                           name="association_contact_name"
                                           id="association_contact_name"
                                           class="form-control @error('association_contact_name') is-invalid @enderror"
                                           value="{{ old('association_contact_name') }}">

                                    @error('association_contact_name')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="association_contact_position" class="font_13 fw-bold">
                                        سمت سازمانی:
                                    </label>

                                    <input type="text"
                                           name="association_contact_position"
                                           id="association_contact_position"
                                           class="form-control @error('association_contact_position') is-invalid @enderror"
                                           value="{{ old('association_contact_position') }}">

                                    @error('association_contact_position')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row row-sm">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="association_contact_mobile" class="font_13 fw-bold">
                                        موبایل رابط انجمن:
                                    </label>

                                    <input type="text"
                                           name="association_contact_mobile"
                                           id="association_contact_mobile"
                                           dir="ltr"
                                           class="form-control text-left @error('association_contact_mobile') is-invalid @enderror"
                                           value="{{ old('association_contact_mobile') }}">

                                    @error('association_contact_mobile')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="association_contact_email" class="font_13 fw-bold">
                                        ایمیل رابط انجمن:
                                    </label>

                                    <input type="email"
                                           name="association_contact_email"
                                           id="association_contact_email"
                                           dir="ltr"
                                           class="form-control text-left @error('association_contact_email') is-invalid @enderror"
                                           value="{{ old('association_contact_email') }}">

                                    @error('association_contact_email')
                                    <span class="invalid-feedback font_12 d-block">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label for="association_committees" class="font_13 fw-bold">
                                همکاری با کمیته‌های انجمن:
                            </label>

                            <textarea name="association_committees"
                                      id="association_committees"
                                      rows="3"
                                      class="form-control @error('association_committees') is-invalid @enderror"
                                      placeholder="نام کمیته‌ها را وارد کنید">{{ old('association_committees') }}</textarea>

                            @error('association_committees')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>

            {{-- ستون کناری --}}
            <div class="col-xl-4 col-lg-4 col-md-12">

                {{-- اطلاعات عضویت --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-id-card ml-1"></i>
                            اطلاعات عضویت
                        </h5>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="membership_card" class="font_13 fw-bold">
                                کارت عضویت:
                            </label>

                            <input type="text"
                                   name="membership_card"
                                   id="membership_card"
                                   class="form-control @error('membership_card') is-invalid @enderror"
                                   value="{{ old('membership_card') }}">

                            @error('membership_card')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="membership_number" class="font_13 fw-bold">
                                شماره عضویت:
                            </label>

                            <input type="text"
                                   name="membership_number"
                                   id="membership_number"
                                   class="form-control @error('membership_number') is-invalid @enderror"
                                   value="{{ old('membership_number') }}">

                            @error('membership_number')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="association_join_date" class="font_13 fw-bold">
                                تاریخ عضویت در انجمن:
                            </label>

                            <input type="text"
                                   name="association_join_date"
                                   id="association_join_date"
                                   class="form-control @error('association_join_date') is-invalid @enderror"
                                   value="{{ old('association_join_date') }}"
                                   placeholder="مثال: 1402/01/15">

                            @error('association_join_date')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="membership_type" class="font_13 fw-bold">
                                نوع عضویت:
                            </label>

                            <select name="membership_type"
                                    id="membership_type"
                                    class="form-control @error('membership_type') is-invalid @enderror">

                                <option value="">-- انتخاب نوع عضویت --</option>

                                <option value="اصلی"
                                    {{ old('membership_type') === 'اصلی' ? 'selected' : '' }}>
                                    اصلی
                                </option>

                                <option value="وابسته"
                                    {{ old('membership_type') === 'وابسته' ? 'selected' : '' }}>
                                    وابسته
                                </option>
                            </select>

                            @error('membership_type')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="membership_status" class="font_13 fw-bold">
                                وضعیت عضویت:
                            </label>

                            <select name="membership_status"
                                    id="membership_status"
                                    class="form-control @error('membership_status') is-invalid @enderror">

                                <option value="">-- انتخاب وضعیت عضویت --</option>

                                <option value="فعال"
                                    {{ old('membership_status') === 'فعال' ? 'selected' : '' }}>
                                    فعال
                                </option>

                                <option value="تعلیق"
                                    {{ old('membership_status') === 'تعلیق' ? 'selected' : '' }}>
                                    تعلیق
                                </option>

                                <option value="لغو"
                                    {{ old('membership_status') === 'لغو' ? 'selected' : '' }}>
                                    لغو
                                </option>
                            </select>

                            @error('membership_status')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="membership_status_notes_1403" class="font_13 fw-bold">
                                توضیحات وضعیت عضویت:
                            </label>

                            <textarea name="membership_status_notes_1403"
                                      id="membership_status_notes_1403"
                                      rows="3"
                                      class="form-control @error('membership_status_notes_1403') is-invalid @enderror">{{ old('membership_status_notes_1403') }}</textarea>

                            @error('membership_status_notes_1403')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- کارت بازرگانی --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-credit-card ml-1"></i>
                            کارت‌های بازرگانی
                        </h5>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="has_valid_commercial_card" class="font_13 fw-bold">
                                کارت بازرگانی معتبر دارد؟
                            </label>

                            <select name="has_valid_commercial_card"
                                    id="has_valid_commercial_card"
                                    class="form-control @error('has_valid_commercial_card') is-invalid @enderror">

                                <option value="">-- انتخاب کنید --</option>
                                <option value="1" {{ old('has_valid_commercial_card') === '1' ? 'selected' : '' }}>
                                    بله
                                </option>
                                <option value="0" {{ old('has_valid_commercial_card') === '0' ? 'selected' : '' }}>
                                    خیر
                                </option>
                            </select>

                            @error('has_valid_commercial_card')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="commercial_card_valid_until" class="font_13 fw-bold">
                                تاریخ اعتبار کارت بازرگانی:
                            </label>

                            <input type="text"
                                   name="commercial_card_valid_until"
                                   id="commercial_card_valid_until"
                                   class="form-control @error('commercial_card_valid_until') is-invalid @enderror"
                                   value="{{ old('commercial_card_valid_until') }}">

                            @error('commercial_card_valid_until')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="has_valid_chamber_membership_card" class="font_13 fw-bold">
                                کارت معتبر اتاق بازرگانی دارد؟
                            </label>

                            <select name="has_valid_chamber_membership_card"
                                    id="has_valid_chamber_membership_card"
                                    class="form-control @error('has_valid_chamber_membership_card') is-invalid @enderror">

                                <option value="">-- انتخاب کنید --</option>
                                <option value="1" {{ old('has_valid_chamber_membership_card') === '1' ? 'selected' : '' }}>
                                    بله
                                </option>
                                <option value="0" {{ old('has_valid_chamber_membership_card') === '0' ? 'selected' : '' }}>
                                    خیر
                                </option>
                            </select>

                            @error('has_valid_chamber_membership_card')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="chamber_membership_valid_until" class="font_13 fw-bold">
                                تاریخ اعتبار عضویت اتاق:
                            </label>

                            <input type="text"
                                   name="chamber_membership_valid_until"
                                   id="chamber_membership_valid_until"
                                   class="form-control @error('chamber_membership_valid_until') is-invalid @enderror"
                                   value="{{ old('chamber_membership_valid_until') }}">

                            @error('chamber_membership_valid_until')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="chamber_province" class="font_13 fw-bold">
                                استان اتاق بازرگانی:
                            </label>

                            <input type="text"
                                   name="chamber_province"
                                   id="chamber_province"
                                   class="form-control @error('chamber_province') is-invalid @enderror"
                                   value="{{ old('chamber_province') }}">

                            @error('chamber_province')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                {{-- حوزه فعالیت --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-dark mb-0">
                            <i class="fa fa-industry ml-1"></i>
                            حوزه فعالیت
                        </h5>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="activity_type" class="font_13 fw-bold">
                                نوع فعالیت:
                            </label>

                            <input type="text"
                                   name="activity_type"
                                   id="activity_type"
                                   class="form-control @error('activity_type') is-invalid @enderror"
                                   value="{{ old('activity_type') }}"
                                   placeholder="نوع فعالیت اصلی شرکت">

                            @error('activity_type')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        @php
                            $activityFields = [
                                'activity_design_consulting' => 'طراحی و مشاوره',
                                'activity_construction_installation' => 'ساختمان، نصب و راه‌اندازی',
                                'activity_epc' => 'EPC',
                                'activity_mc' => 'MC',
                                'activity_manufacturing' => 'تولید',
                            ];
                        @endphp

                        @foreach($activityFields as $field => $label)
                            <div class="form-group">
                                <label for="{{ $field }}" class="font_13 fw-bold">
                                    {{ $label }}:
                                </label>

                                <select name="{{ $field }}"
                                        id="{{ $field }}"
                                        class="form-control @error($field) is-invalid @enderror">

                                    <option value="">-- انتخاب کنید --</option>

                                    <option value="1"
                                        {{ old($field) === '1' ? 'selected' : '' }}>
                                        بله
                                    </option>

                                    <option value="0"
                                        {{ old($field) === '0' ? 'selected' : '' }}>
                                        خیر
                                    </option>
                                </select>

                                @error($field)
                                <span class="invalid-feedback font_12 d-block">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        @endforeach

                    </div>
                </div>

                {{-- ورود اطلاعات از اکسل --}}
                <div class="card box-shadow-0">
                    <div class="card-header border-bottom py-2">
                        <h5 class="card-title font_13 text-success mb-0">
                            <i class="fa fa-file-excel ml-1"></i>
                            ورود اطلاعات از اکسل
                        </h5>
                    </div>

                    <div class="card-body pt-3">

                        <div class="form-group">
                            <label for="excel_file" class="font_13 fw-bold">
                                انتخاب فایل اکسل:
                            </label>

                            <input type="file"
                                   name="excel_file"
                                   id="excel_file"
                                   form="company-import-form"
                                   accept=".xlsx,.xls,.csv"
                                   class="form-control @error('excel_file') is-invalid @enderror">

                            <small class="text-muted font_12 d-block mt-2">
                                فرمت‌های مجاز: xlsx، xls و csv
                            </small>

                            @error('excel_file')
                            <span class="invalid-feedback font_12 d-block">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="p-3 bg-light border rounded mb-3">
                            <p class="font_12 text-muted mb-0"
                               style="line-height: 23px;">

                                ردیف اول فایل باید شامل عنوان ستون‌ها باشد.
                                اطلاعات فایل مستقیماً در جدول شرکت‌ها ثبت می‌شود.
                            </p>
                        </div>

                        <button type="submit"
                                form="company-import-form"
                                class="btn btn-success btn-block fw-bold">

                            <i class="fa fa-upload ml-1"></i>
                            آپلود و ثبت فایل اکسل
                        </button>

                    </div>
                </div>

                {{-- ثبت نهایی --}}
                <button type="submit"
                        class="btn btn-primary btn-block btn-lg font_14 fw-bold box-shadow-3">

                    <i class="fa fa-check-circle ml-1"></i>
                    ثبت و ذخیره نهایی شرکت
                </button>

            </div>

        </div>
    </form>

@endsection
