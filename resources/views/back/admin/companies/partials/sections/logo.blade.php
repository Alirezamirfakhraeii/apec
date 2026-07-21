<div class="card box-shadow-0">
    <div class="card-header border-bottom py-2">
        <h5 class="card-title font_13 text-dark mb-0">
            <i class="fa fa-image ml-1"></i>
            لوگوی شرکت
        </h5>
    </div>

    <div class="card-body pt-3">

        @if($isEdit && optional($company)->logo_url)
            <div class="text-center mb-3">
                <img src="{{ $company->logo_url }}"
                     alt="{{ $company->registered_name }}"
                     style="
                        width: 140px;
                        height: 140px;
                        object-fit: contain;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        padding: 10px;
                        background: #fff;
                     ">
            </div>

            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox"
                       name="remove_logo"
                       id="remove_logo"
                       value="1"
                       class="custom-control-input"
                    {{ old('remove_logo') ? 'checked' : '' }}>

                <label class="custom-control-label font_12 text-danger"
                       for="remove_logo">

                    حذف لوگوی فعلی
                </label>
            </div>
        @endif

        <div class="form-group mb-0">
            <label for="logo" class="font_13 fw-bold">
                انتخاب فایل لوگو:
            </label>

            <input type="file"
                   name="logo"
                   id="logo"
                   accept=".jpg,.jpeg,.png,.webp"
                   class="form-control @error('logo') is-invalid @enderror">

            <small class="text-muted font_12 d-block mt-2">
                فرمت‌های مجاز: JPG، PNG و WEBP؛ حداکثر حجم ۲ مگابایت
            </small>

            @if($isEdit && optional($company)->logo_url)
                <small class="text-info font_12 d-block mt-1">
                    با انتخاب فایل جدید، لوگوی فعلی جایگزین می‌شود.
                </small>
            @endif

            @error('logo')
                <span class="invalid-feedback font_12 d-block">
                    {{ $message }}
                </span>
            @enderror
        </div>

    </div>
</div>
