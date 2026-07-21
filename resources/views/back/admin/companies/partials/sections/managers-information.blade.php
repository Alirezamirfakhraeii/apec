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
            <label for="ceo_name" class="font_13 fw-bold">نام مدیرعامل:</label>

            <input type="text"
                   name="ceo_name"
                   id="ceo_name"
                   class="form-control @error('ceo_name') is-invalid @enderror"
                   value="{{ old('ceo_name', optional($company)->ceo_name) }}">

            @error('ceo_name')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('ceo_mobile', optional($company)->ceo_mobile) }}">

                    @error('ceo_mobile')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('ceo_email', optional($company)->ceo_email) }}">

                    @error('ceo_email')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                   value="{{ old('chairman_name', optional($company)->chairman_name) }}">

            @error('chairman_name')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('chairman_mobile', optional($company)->chairman_mobile) }}">

                    @error('chairman_mobile')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('chairman_email', optional($company)->chairman_email) }}">

                    @error('chairman_email')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

    </div>
</div>
