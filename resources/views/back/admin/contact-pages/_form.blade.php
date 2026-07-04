<div class="row row-sm">
    <div class="col-lg-8">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">اطلاعات اصلی</h5>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>عنوان <span class="text-danger">*</span></label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $contactPage->title ?? 'تماس با ما') }}">

                    @error('title')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>زیرعنوان</label>
                    <input type="text"
                           name="subtitle"
                           class="form-control @error('subtitle') is-invalid @enderror"
                           value="{{ old('subtitle', $contactPage->subtitle ?? '') }}">

                    @error('subtitle')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>متن صفحه</label>
                    <textarea name="body"
                              rows="6"
                              class="form-control @error('body') is-invalid @enderror">{{ old('body', $contactPage->body ?? '') }}</textarea>

                    @error('body')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>لینک یا iframe نقشه</label>
                    <textarea name="map_link"
                              rows="4"
                              class="form-control @error('map_link') is-invalid @enderror">{{ old('map_link', $contactPage->map_link ?? '') }}</textarea>

                    @error('map_link')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

    </div>

    <div class="col-lg-4">

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">راه‌های ارتباطی</h5>
            </div>

            <div class="card-body">

                <div class="form-group">
                    <label>تلفن</label>
                    <input type="text"
                           name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone', $contactPage->phone ?? '') }}">

                    @error('phone')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>موبایل</label>
                    <input type="text"
                           name="mobile"
                           class="form-control @error('mobile') is-invalid @enderror"
                           value="{{ old('mobile', $contactPage->mobile ?? '') }}">

                    @error('mobile')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>ایمیل</label>
                    <input type="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $contactPage->email ?? '') }}">

                    @error('email')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>آدرس</label>
                    <textarea name="address"
                              rows="4"
                              class="form-control @error('address') is-invalid @enderror">{{ old('address', $contactPage->address ?? '') }}</textarea>

                    @error('address')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label>
                        <input type="checkbox"
                               name="status"
                               value="1"
                            {{ old('status', $contactPage->status ?? true) ? 'checked' : '' }}>
                        فعال باشد
                    </label>
                </div>

            </div>
        </div>

        <button type="submit" class="btn btn-success btn-block mt-3">
            ذخیره
        </button>

    </div>
</div>
