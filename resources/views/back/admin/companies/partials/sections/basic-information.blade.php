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
                   value="{{ old('registered_name', optional($company)->registered_name) }}"
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
                           value="{{ old('company_short_name', optional($company)->company_short_name) }}"
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
                           value="{{ old('company_name_en', optional($company)->company_name_en) }}"
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
                           value="{{ old('nationality', optional($company)->nationality) }}"
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
                           value="{{ old('parent_company_name', optional($company)->parent_company_name) }}"
                           placeholder="در صورت وجود">

                    @error('parent_company_name')
                        <span class="invalid-feedback font_12 d-block">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        @php
            $companyType = old('company_type', optional($company)->company_type);
        @endphp

        <div class="form-group mb-0">
            <label for="company_type" class="font_13 fw-bold">
                نوع شرکت:
            </label>

            <select name="company_type"
                    id="company_type"
                    class="form-control @error('company_type') is-invalid @enderror">

                <option value="">-- انتخاب نوع شرکت --</option>

                @foreach(['سهامی عام', 'سهامی خاص', 'مسئولیت محدود', 'تعاونی', 'سایر'] as $type)
                    <option value="{{ $type }}"
                        {{ $companyType === $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            @error('company_type')
                <span class="invalid-feedback font_12 d-block">
                    {{ $message }}
                </span>
            @enderror
        </div>

    </div>
</div>
