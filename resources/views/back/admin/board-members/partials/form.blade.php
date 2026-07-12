@php
    $member = $member ?? null;

    $rolesValue = old('roles');

    if ($rolesValue === null && $member && !empty($member->roles)) {
        $rolesValue = is_array($member->roles)
            ? implode("\n", $member->roles)
            : $member->roles;
    }
@endphp

<div class="row row-sm">

    <div class="col-xl-8 col-lg-8 col-md-12">

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-info-circle ml-2"></i>
                    اطلاعات اصلی عضو
                </h4>
            </div>

            <div class="board-member-card-body">

                <div class="form-group">
                    <label for="name" class="board-member-label">
                        نام و نام خانوادگی
                        <span class="required">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $member->name ?? '') }}"
                           class="form-control board-member-form-control @error('name') is-invalid @enderror"
                           placeholder="مثلاً: محمد حلوایی"
                           required>

                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="roles" class="board-member-label">
                        سمت‌ها و مسئولیت‌ها
                    </label>

                    <textarea name="roles"
                              id="roles"
                              rows="5"
                              class="form-control board-member-form-control @error('roles') is-invalid @enderror"
                              placeholder="هر سمت را در یک خط جدا وارد کنید">{{ $rolesValue }}</textarea>

                    <div class="board-member-help">
                        مثال:
                        <br>
                        رئیس هیئت مدیره انجمن اپک
                        <br>
                        عضو هیئت مدیره شرکت پارس کیهان
                    </div>

                    @error('roles')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-address-book ml-2"></i>
                    اطلاعات ارتباطی و آدرس
                </h4>
            </div>

            <div class="board-member-card-body">

                <div class="board-member-section-note mb-3">
                    اطلاعات تماس در کارت معرفی عضو نمایش داده می‌شود. اگر فیلدی لازم نیست، می‌توانید آن را خالی بگذارید.
                </div>

                <div class="form-group">
                    <label for="email" class="board-member-label">
                        آدرس ایمیل
                    </label>

                    <input type="email"
                           name="email"
                           id="email"
                           value="{{ old('email', $member->email ?? '') }}"
                           class="form-control board-member-form-control @error('email') is-invalid @enderror"
                           placeholder="example@irapec.com">

                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row row-sm">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="board-member-label">
                                شماره تماس
                            </label>

                            <input type="text"
                                   name="phone"
                                   id="phone"
                                   value="{{ old('phone', $member->phone ?? '') }}"
                                   class="form-control board-member-form-control @error('phone') is-invalid @enderror"
                                   placeholder="۰۲۱-۸۸۵۰۵۷۱۰">

                            @error('phone')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="fax" class="board-member-label">
                                شماره فکس
                            </label>

                            <input type="text"
                                   name="fax"
                                   id="fax"
                                   value="{{ old('fax', $member->fax ?? '') }}"
                                   class="form-control board-member-form-control @error('fax') is-invalid @enderror"
                                   placeholder="۰۲۱-۸۸۵۰۵۷۱۱">

                            @error('fax')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address" class="board-member-label">
                        آدرس کامل
                    </label>

                    <textarea name="address"
                              id="address"
                              rows="3"
                              class="form-control board-member-form-control @error('address') is-invalid @enderror"
                              placeholder="تهران، خیابان شهید احمد قصیر...">{{ old('address', $member->address ?? '') }}</textarea>

                    @error('address')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-0">
                    <label for="postal_code" class="board-member-label">
                        کد پستی
                    </label>

                    <input type="text"
                           name="postal_code"
                           id="postal_code"
                           value="{{ old('postal_code', $member->postal_code ?? '') }}"
                           class="form-control board-member-form-control @error('postal_code') is-invalid @enderror"
                           placeholder="۱۵۱۴۷۵۵۴۱۱">

                    @error('postal_code')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-file-text-o ml-2"></i>
                    توضیحات تکمیلی
                </h4>
            </div>

            <div class="board-member-card-body">
                <div class="form-group mb-0">
                    <label for="description" class="board-member-label">
                        رزومه کوتاه / توضیحات
                    </label>

                    <textarea name="description"
                              id="description"
                              rows="5"
                              class="form-control board-member-form-control @error('description') is-invalid @enderror"
                              placeholder="توضیح کوتاه درباره سوابق یا معرفی عضو">{{ old('description', $member->description ?? '') }}</textarea>

                    @error('description')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-4 col-lg-4 col-md-12">

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-image ml-2"></i>
                    تصویر عضو
                </h4>
            </div>

            <div class="board-member-card-body">

                @if($member && $member->image)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $member->image) }}"
                             alt="{{ $member->name }}"
                             style="width: 140px; height: 140px; object-fit: cover; border-radius: 18px; border: 1px solid #e5e7eb;">
                    </div>
                @endif

                <div class="form-group mb-0">
                    <label for="image" class="board-member-label">
                        آپلود تصویر
                    </label>

                    <div class="board-member-upload-box">
                        <input type="file"
                               name="image"
                               id="image"
                               accept="image/jpeg,image/png,image/jpg,image/webp"
                               class="form-control board-member-form-control @error('image') is-invalid @enderror">

                        <div class="board-member-help">
                            فرمت‌های مجاز: jpg, png, webp — حداکثر ۲ مگابایت
                        </div>
                    </div>

                    @error('image')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        <div class="board-member-card">
            <div class="board-member-card-header">
                <h4 class="board-member-card-title">
                    <i class="fa fa-cog ml-2"></i>
                    تنظیمات نمایش
                </h4>
            </div>

            <div class="board-member-card-body">

                <div class="form-group">
                    <label for="sort_order" class="board-member-label">
                        ترتیب نمایش
                    </label>

                    <input type="number"
                           name="sort_order"
                           id="sort_order"
                           value="{{ old('sort_order', $member->sort_order ?? 0) }}"
                           class="form-control board-member-form-control @error('sort_order') is-invalid @enderror"
                           min="0">

                    <div class="board-member-help">
                        عدد کمتر، عضو را زودتر نمایش می‌دهد.
                    </div>

                    @error('sort_order')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_active" class="board-member-label">
                        وضعیت انتشار
                    </label>

                    <div class="board-member-status-box">
                        <select name="is_active"
                                id="is_active"
                                class="form-control board-member-form-control @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', $member->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                فعال و قابل نمایش
                            </option>

                            <option value="0" {{ old('is_active', $member->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                غیرفعال
                            </option>
                        </select>
                    </div>

                    @error('is_active')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn board-member-submit-btn mt-2">
                    <i class="fa fa-check-circle ml-1"></i>
                    {{ $submitText ?? 'ذخیره اطلاعات' }}
                </button>

            </div>
        </div>

    </div>

</div>
