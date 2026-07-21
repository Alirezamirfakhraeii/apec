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
                           value="{{ old('association_contact_name', optional($company)->association_contact_name) }}">

                    @error('association_contact_name')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('association_contact_position', optional($company)->association_contact_position) }}">

                    @error('association_contact_position')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('association_contact_mobile', optional($company)->association_contact_mobile) }}">

                    @error('association_contact_mobile')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                           value="{{ old('association_contact_email', optional($company)->association_contact_email) }}">

                    @error('association_contact_email')
                        <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
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
                      placeholder="نام کمیته‌ها را وارد کنید">{{ old('association_committees', optional($company)->association_committees) }}</textarea>

            @error('association_committees')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
