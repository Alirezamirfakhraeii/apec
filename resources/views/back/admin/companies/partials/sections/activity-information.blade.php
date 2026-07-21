@php
    $activityFields = [
        'activity_design_consulting' => 'طراحی و مشاوره',
        'activity_construction_installation' => 'ساختمان، نصب و راه‌اندازی',
        'activity_epc' => 'EPC',
        'activity_mc' => 'MC',
        'activity_manufacturing' => 'تولید',
    ];
@endphp

<div class="card box-shadow-0">
    <div class="card-header border-bottom py-2">
        <h5 class="card-title font_13 text-dark mb-0">
            <i class="fa fa-industry ml-1"></i>
            حوزه فعالیت
        </h5>
    </div>

    <div class="card-body pt-3">

        <div class="form-group">
            <label for="activity_type" class="font_13 fw-bold">
                نوع فعالیت:
            </label>

            <textarea name="activity_type"
                      id="activity_type"
                      rows="5"
                      class="form-control @error('activity_type') is-invalid @enderror"
                      placeholder="شرح نوع و حوزه فعالیت شرکت">{{ old('activity_type', optional($company)->activity_type) }}</textarea>

            @error('activity_type')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        @foreach($activityFields as $field => $label)
            @php
                $fieldValue = old($field, optional($company)->{$field});
            @endphp

            <div class="form-group">
                <label for="{{ $field }}" class="font_13 fw-bold">
                    {{ $label }}:
                </label>

                <select name="{{ $field }}"
                        id="{{ $field }}"
                        class="form-control @error($field) is-invalid @enderror">

                    <option value="">-- انتخاب کنید --</option>

                    <option value="1"
                        {{ (string) $fieldValue === '1' ? 'selected' : '' }}>
                        بله
                    </option>

                    <option value="0"
                        {{ (string) $fieldValue === '0' ? 'selected' : '' }}>
                        خیر
                    </option>
                </select>

                @error($field)
                    <span class="invalid-feedback font_12 d-block">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        @endforeach

    </div>
</div>
