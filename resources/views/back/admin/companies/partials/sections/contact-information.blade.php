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
                    <label for="phone" class="font_13 fw-bold">تلفن:</label>

                    <input type="text"
                           name="phone"
                           id="phone"
                           dir="ltr"
                           class="form-control text-left @error('phone') is-invalid @enderror"
                           value="{{ old('phone', optional($company)->phone) }}"
                           placeholder="02100000000">

                    @error('phone')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="fax" class="font_13 fw-bold">فاکس:</label>

                    <input type="text"
                           name="fax"
                           id="fax"
                           dir="ltr"
                           class="form-control text-left @error('fax') is-invalid @enderror"
                           value="{{ old('fax', optional($company)->fax) }}"
                           placeholder="02100000000">

                    @error('fax')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row row-sm">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" class="font_13 fw-bold">ایمیل شرکت:</label>

                    <input type="email"
                           name="email"
                           id="email"
                           dir="ltr"
                           class="form-control text-left @error('email') is-invalid @enderror"
                           value="{{ old('email', optional($company)->email) }}"
                           placeholder="info@example.com">

                    @error('email')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="website" class="font_13 fw-bold">وب‌سایت:</label>

                    <input type="text"
                           name="website"
                           id="website"
                           dir="ltr"
                           class="form-control text-left @error('website') is-invalid @enderror"
                           value="{{ old('website', optional($company)->website) }}"
                           placeholder="https://example.com">

                    @error('website')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-0">
            <label for="address" class="font_13 fw-bold">آدرس:</label>

            <textarea name="address"
                      id="address"
                      rows="4"
                      class="form-control @error('address') is-invalid @enderror"
                      placeholder="آدرس کامل شرکت">{{ old('address', optional($company)->address) }}</textarea>

            @error('address')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
