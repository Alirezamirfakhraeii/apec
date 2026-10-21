@php
    $selectedIds = collect(
        old('activity_fields', $selectedActivityFieldIds ?? [])
    )
        ->map(fn ($id) => (string) $id)
        ->all();
@endphp

<div class="company-edit-section">
    <div class="company-edit-section__title">حوزه‌ها و رتبه‌های فعالیت شرکت</div>

    <div class="company-edit-section__hint">
        هر حوزه یا رتبه‌ای که شرکت در آن فعالیت یا صلاحیت دارد انتخاب کنید.
    </div>

    <div class="company-edit-options-grid">
        @forelse($activityFields as $field)
            <label class="company-edit-option" for="activity_field_{{ $field->id }}">
                <input
                    type="checkbox"
                    id="activity_field_{{ $field->id }}"
                    name="activity_fields[]"
                    value="{{ $field->id }}"
                    @checked(in_array((string) $field->id, $selectedIds, true))
                >

                <span>{{ $field->title }}</span>
            </label>
        @empty
            <div class="company-edit-empty">
                حوزه فعالیتی در سیستم تعریف نشده است.
            </div>
        @endforelse
    </div>

    @error('activity_fields')
        <span class="company-edit-error company-edit-error--section">{{ $message }}</span>
    @enderror

    @error('activity_fields.*')
        <span class="company-edit-error company-edit-error--section">{{ $message }}</span>
    @enderror
</div>
