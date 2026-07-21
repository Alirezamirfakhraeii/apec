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
                           value="{{ old('national_id', optional($company)->national_id) }}"
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
                           value="{{ old('registration_number', optional($company)->registration_number) }}"
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
                           value="{{ old('registration_date', optional($company)->registration_date) }}"
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
                           value="{{ old('registration_place', optional($company)->registration_place) }}"
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
                   value="{{ old('registered_capital_irr', optional($company)->registered_capital_irr) }}"
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
                   value="{{ old('reference_gazette_date', optional($company)->reference_gazette_date) }}"
                   placeholder="مثال: 1403/02/15">

            @error('reference_gazette_date')
                <span class="invalid-feedback font_12 d-block">
                    {{ $message }}
                </span>
            @enderror
        </div>

    </div>
</div>
