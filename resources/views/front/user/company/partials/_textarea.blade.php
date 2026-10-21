@php
    $full = $full ?? true;
    $oldKey = $oldKey ?? $name;
    $fieldId = $id ?? preg_replace('/[^A-Za-z0-9_-]+/', '_', $name);
    $currentValue = old($oldKey, $value ?? null);
@endphp

<div class="company-edit-field {{ $full ? 'company-edit-field--full' : '' }}">
    <label class="company-edit-label" for="{{ $fieldId }}">
        {{ $label }}
    </label>

    <textarea
        id="{{ $fieldId }}"
        name="{{ $name }}"
        class="company-edit-textarea"
        @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
    >{{ $currentValue }}</textarea>

    @error($oldKey)
        <span class="company-edit-error">{{ $message }}</span>
    @enderror
</div>
