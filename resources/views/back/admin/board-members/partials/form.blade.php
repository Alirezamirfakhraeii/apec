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

    {{-- Main Content --}}
    <div class="col-xl-8 col-lg-8 col-md-12">

        {{-- Main Information --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-info-circle ml-2"></i>
                    اطلاعات اصلی عضو
                </h4>

            </div>


            <div class="admin-card-body">

                {{-- Name --}}
                <div class="form-group">

                    <label
                        for="name"
                        class="admin-label"
                    >
                        نام و نام خانوادگی

                        <span class="required">*</span>
                    </label>


                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $member->name ?? '') }}"
                        class="form-control admin-form-control @error('name') is-invalid @enderror"
                        placeholder="مثلاً: محمد حلوایی"
                        required
                    >


                    @error('name')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Roles --}}
                <div class="form-group mb-0">

                    <label
                        for="roles"
                        class="admin-label"
                    >
                        سمت‌ها و مسئولیت‌ها
                    </label>


                    <textarea
                        name="roles"
                        id="roles"
                        rows="5"
                        class="form-control admin-form-control @error('roles') is-invalid @enderror"
                        placeholder="هر سمت را در یک خط جدا وارد کنید"
                    >{{ $rolesValue }}</textarea>


                    <div class="admin-help">

                        مثال:

                        <br>

                        رئیس هیئت مدیره انجمن اپک

                        <br>

                        عضو هیئت مدیره شرکت پارس کیهان

                    </div>


                    @error('roles')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Contact Information --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-address-book ml-2"></i>
                    اطلاعات ارتباطی و آدرس
                </h4>

            </div>


            <div class="admin-card-body">

                <div class="admin-section-note mb-3">
                    اطلاعات تماس در کارت معرفی عضو نمایش داده می‌شود.
                    اگر فیلدی لازم نیست، می‌توانید آن را خالی بگذارید.
                </div>


                {{-- Email --}}
                <div class="form-group">

                    <label
                        for="email"
                        class="admin-label"
                    >
                        آدرس ایمیل
                    </label>


                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $member->email ?? '') }}"
                        class="form-control admin-form-control @error('email') is-invalid @enderror"
                        placeholder="example@irapec.com"
                    >


                    @error('email')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                <div class="row row-sm">

                    {{-- Phone --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label
                                for="phone"
                                class="admin-label"
                            >
                                شماره تماس
                            </label>


                            <input
                                type="text"
                                name="phone"
                                id="phone"
                                value="{{ old('phone', $member->phone ?? '') }}"
                                class="form-control admin-form-control @error('phone') is-invalid @enderror"
                                placeholder="۰۲۱-۸۸۵۰۵۷۱۰"
                            >


                            @error('phone')
                            <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Fax --}}
                    <div class="col-md-6">

                        <div class="form-group">

                            <label
                                for="fax"
                                class="admin-label"
                            >
                                شماره فکس
                            </label>


                            <input
                                type="text"
                                name="fax"
                                id="fax"
                                value="{{ old('fax', $member->fax ?? '') }}"
                                class="form-control admin-form-control @error('fax') is-invalid @enderror"
                                placeholder="۰۲۱-۸۸۵۰۵۷۱۱"
                            >


                            @error('fax')
                            <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- Address --}}
                <div class="form-group">

                    <label
                        for="address"
                        class="admin-label"
                    >
                        آدرس کامل
                    </label>


                    <textarea
                        name="address"
                        id="address"
                        rows="3"
                        class="form-control admin-form-control @error('address') is-invalid @enderror"
                        placeholder="تهران، خیابان شهید احمد قصیر..."
                    >{{ old('address', $member->address ?? '') }}</textarea>


                    @error('address')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Postal Code --}}
                <div class="form-group mb-0">

                    <label
                        for="postal_code"
                        class="admin-label"
                    >
                        کد پستی
                    </label>


                    <input
                        type="text"
                        name="postal_code"
                        id="postal_code"
                        value="{{ old('postal_code', $member->postal_code ?? '') }}"
                        class="form-control admin-form-control @error('postal_code') is-invalid @enderror"
                        placeholder="۱۵۱۴۷۵۵۴۱۱"
                    >


                    @error('postal_code')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Description --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-file-text-o ml-2"></i>
                    توضیحات تکمیلی
                </h4>

            </div>


            <div class="admin-card-body">

                <div class="form-group mb-0">

                    <label
                        for="description"
                        class="admin-label"
                    >
                        رزومه کوتاه / توضیحات
                    </label>


                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        class="form-control admin-form-control @error('description') is-invalid @enderror"
                        placeholder="توضیح کوتاه درباره سوابق یا معرفی عضو"
                    >{{ old('description', $member->description ?? '') }}</textarea>


                    @error('description')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>

    </div>


    {{-- Sidebar --}}
    <div class="col-xl-4 col-lg-4 col-md-12">

        {{-- Image --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-image ml-2"></i>
                    تصویر عضو
                </h4>

            </div>


            <div class="admin-card-body">

                {{-- Current Image --}}
                @if($member && $member->image)

                    <div class="admin-image-preview-wrapper">

                        <img
                            src="{{ asset('storage/' . $member->image) }}"
                            alt="{{ $member->name }}"
                            class="admin-image-preview"
                        >

                    </div>

                @endif


                {{-- Image Upload --}}
                <div class="form-group mb-0">

                    <label
                        for="image"
                        class="admin-label"
                    >
                        آپلود تصویر
                    </label>


                    <div class="admin-upload-box">

                        <input
                            type="file"
                            name="image"
                            id="image"
                            accept="image/jpeg,image/png,image/jpg,image/webp"
                            class="form-control admin-form-control @error('image') is-invalid @enderror"
                        >


                        <div class="admin-help">
                            فرمت‌های مجاز: jpg, png, webp — حداکثر ۲ مگابایت
                        </div>

                    </div>


                    @error('image')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>

            </div>

        </div>


        {{-- Display Settings --}}
        <div class="admin-card">

            <div class="admin-card-header">

                <h4 class="admin-card-title">
                    <i class="fa fa-cog ml-2"></i>
                    تنظیمات نمایش
                </h4>

            </div>


            <div class="admin-card-body">

                {{-- Sort Order --}}
                <div class="form-group">

                    <label
                        for="sort_order"
                        class="admin-label"
                    >
                        ترتیب نمایش
                    </label>


                    <input
                        type="number"
                        name="sort_order"
                        id="sort_order"
                        value="{{ old('sort_order', $member->sort_order ?? 0) }}"
                        class="form-control admin-form-control @error('sort_order') is-invalid @enderror"
                        min="0"
                    >


                    <div class="admin-help">
                        عدد کمتر، عضو را زودتر نمایش می‌دهد.
                    </div>


                    @error('sort_order')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Status --}}
                <div class="form-group">

                    <label
                        for="is_active"
                        class="admin-label"
                    >
                        وضعیت انتشار
                    </label>


                    <div class="admin-status-box">

                        <select
                            name="is_active"
                            id="is_active"
                            class="form-control admin-form-control @error('is_active') is-invalid @enderror"
                        >

                            <option
                                value="1"
                                {{ old('is_active', $member->is_active ?? 1) == 1 ? 'selected' : '' }}
                            >
                                فعال و قابل نمایش
                            </option>


                            <option
                                value="0"
                                {{ old('is_active', $member->is_active ?? 1) == 0 ? 'selected' : '' }}
                            >
                                غیرفعال
                            </option>

                        </select>

                    </div>


                    @error('is_active')
                    <span class="invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- Submit --}}
                <button
                    type="submit"
                    class="btn admin-submit-btn mt-2"
                >
                    <i class="fa fa-check-circle ml-1"></i>

                    {{ $submitText ?? 'ذخیره اطلاعات' }}
                </button>

            </div>

        </div>

    </div>

</div>
