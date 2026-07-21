@php
    $hasCommercialCard = old(
        'has_valid_commercial_card',
        optional($company)->has_valid_commercial_card
    );

    $hasChamberMembershipCard = old(
        'has_valid_chamber_membership_card',
        optional($company)->has_valid_chamber_membership_card
    );
@endphp

<div class="card box-shadow-0">
    <div class="card-header border-bottom py-2">
        <h5 class="card-title font_13 text-dark mb-0">
            <i class="fa fa-credit-card ml-1"></i>
            کارت‌های بازرگانی
        </h5>
    </div>

    <div class="card-body pt-3">

        <div class="form-group">
            <label for="has_valid_commercial_card" class="font_13 fw-bold">
                کارت بازرگانی معتبر دارد؟
            </label>

            <select name="has_valid_commercial_card"
                    id="has_valid_commercial_card"
                    class="form-control @error('has_valid_commercial_card') is-invalid @enderror">

                <option value="">-- انتخاب کنید --</option>
                <option value="1" {{ (string) $hasCommercialCard === '1' ? 'selected' : '' }}>
                    بله
                </option>
                <option value="0" {{ (string) $hasCommercialCard === '0' ? 'selected' : '' }}>
                    خیر
                </option>
            </select>

            @error('has_valid_commercial_card')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="commercial_card_valid_until" class="font_13 fw-bold">
                تاریخ اعتبار کارت بازرگانی:
            </label>

            <input type="text"
                   name="commercial_card_valid_until"
                   id="commercial_card_valid_until"
                   class="form-control @error('commercial_card_valid_until') is-invalid @enderror"
                   value="{{ old('commercial_card_valid_until', optional($company)->commercial_card_valid_until) }}">

            @error('commercial_card_valid_until')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="has_valid_chamber_membership_card" class="font_13 fw-bold">
                کارت معتبر اتاق بازرگانی دارد؟
            </label>

            <select name="has_valid_chamber_membership_card"
                    id="has_valid_chamber_membership_card"
                    class="form-control @error('has_valid_chamber_membership_card') is-invalid @enderror">

                <option value="">-- انتخاب کنید --</option>
                <option value="1" {{ (string) $hasChamberMembershipCard === '1' ? 'selected' : '' }}>
                    بله
                </option>
                <option value="0" {{ (string) $hasChamberMembershipCard === '0' ? 'selected' : '' }}>
                    خیر
                </option>
            </select>

            @error('has_valid_chamber_membership_card')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="chamber_membership_valid_until" class="font_13 fw-bold">
                تاریخ اعتبار عضویت اتاق:
            </label>

            <input type="text"
                   name="chamber_membership_valid_until"
                   id="chamber_membership_valid_until"
                   class="form-control @error('chamber_membership_valid_until') is-invalid @enderror"
                   value="{{ old('chamber_membership_valid_until', optional($company)->chamber_membership_valid_until) }}">

            @error('chamber_membership_valid_until')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group mb-0">
            <label for="chamber_province" class="font_13 fw-bold">
                استان اتاق بازرگانی:
            </label>

            <input type="text"
                   name="chamber_province"
                   id="chamber_province"
                   class="form-control @error('chamber_province') is-invalid @enderror"
                   value="{{ old('chamber_province', optional($company)->chamber_province) }}">

            @error('chamber_province')
                <span class="invalid-feedback font_12 d-block">{{ $message }}</span>
            @enderror
        </div>

    </div>
</div>
