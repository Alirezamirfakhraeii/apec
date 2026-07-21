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
