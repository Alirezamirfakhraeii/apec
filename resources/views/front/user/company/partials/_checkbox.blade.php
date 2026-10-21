@php
    $oldKey = $oldKey ?? $name;
    $fieldId = $id ?? preg_replace('/[^A-Za-z0-9_-]+/', '_', $name);
    $checkedValue = old($oldKey, $value ?? false);
@endphp

<div class="company-edit-field">
    <input type="hidden" name="{{ $name }}" value="0">

    <label class="company-edit-checkbox" for="{{ $fieldId }}">
        <input
            type="checkbox"
            id="{{ $fieldId }}"
            name="{{ $name }}"
            value="1"
            @checked((bool) $checkedValue)
        >

        <span>{{ $label }}</span>
    </label>

    @error($oldKey)
        <span class="company-edit-error">{{ $message }}</span>
    @enderror
</div>
