@php
    $membershipType = old('membership_type', optional($company)->membership_type);
    $membershipStatus = old('membership_status', optional($company)->membership_status);
@endphp

<div class="card box-shadow-0">
    <div class="card-header border-bottom py-2">
        <h5 class="card-title font_13 text-dark mb-0">
            <i class="fa fa-id-card ml-1"></i>
            اطلاعات عضویت
        </h5>
    </div>

    <div class="card-body">

        <div class="form-group">
            <label for="membership_card" class="font_13 fw-bold">
                کارت عضویت:
            </label>

            <input type="text"
                   name="membership_card"
                   id="membership_card"
                   class="form-control @error('membership_card') is-invalid @enderror"
                   value="{{ old('membership_card', optional($company)->membership_card) }}">

            @error('membership_card')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="membership_number" class="font_13 fw-bold">
                شماره عضویت:
            </label>

            <input type="text"
                   name="membership_number"
                   id="membership_number"
                   class="form-control @error('membership_number') is-invalid @enderror"
                   value="{{ old('membership_number', optional($company)->membership_number) }}">

            @error('membership_number')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="association_join_date" class="font_13 fw-bold">
                تاریخ عضویت در انجمن:
            </label>

            <input type="text"
                   name="association_join_date"
                   id="association_join_date"
                   class="form-control @error('association_join_date') is-invalid @enderror"
                   value="{{ old('association_join_date', optional($company)->association_join_date) }}"
                   placeholder="مثال: 1402/01/15">

            @error('association_join_date')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="membership_type" class="font_13 fw-bold">
                نوع عضویت:
            </label>

            <select name="membership_type"
                    id="membership_type"
                    class="form-control @error('membership_type') is-invalid @enderror">

                <option value="">-- انتخاب نوع عضویت --</option>

                <option value="اصلی"
                    {{ $membershipType === 'اصلی' ? 'selected' : '' }}>
                    اصلی
                </option>

                <option value="وابسته"
                    {{ $membershipType === 'وابسته' ? 'selected' : '' }}>
                    وابسته
                </option>
            </select>

            @error('membership_type')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="membership_status" class="font_13 fw-bold">
                وضعیت عضویت:
            </label>

            <select name="membership_status"
                    id="membership_status"
                    class="form-control @error('membership_status') is-invalid @enderror">

                <option value="">-- انتخاب وضعیت عضویت --</option>

                @foreach(['فعال', 'تعلیق', 'لغو'] as $status)
                    <option value="{{ $status }}"
                        {{ $membershipStatus === $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>

            @error('membership_status')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-0">
            <label for="membership_status_notes_1403" class="font_13 fw-bold">
                توضیحات وضعیت عضویت:
            </label>

            <textarea name="membership_status_notes_1403"
                      id="membership_status_notes_1403"
                      rows="3"
                      class="form-control @error('membership_status_notes_1403') is-invalid @enderror">{{ old('membership_status_notes_1403', optional($company)->membership_status_notes_1403) }}</textarea>

            @error('membership_status_notes_1403')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
