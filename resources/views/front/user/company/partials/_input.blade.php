@php
    $type = $type ?? 'text';
    $dir = $dir ?? 'rtl';
    $full = $full ?? false;
    $oldKey = $oldKey ?? $name;
    $fieldId = $id ?? preg_replace('/[^A-Za-z0-9_-]+/', '_', $name);
    $currentValue = old($oldKey, $value ?? null);
@endphp

<div class="company-edit-field {{ $full ? 'company-edit-field--full' : '' }}">
    <label class="company-edit-label" for="{{ $fieldId }}">
        {{ $label }}
    </label>

    <input
        id="{{ $fieldId }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $currentValue }}"
        class="company-edit-input"
        dir="{{ $dir }}"
        @if(isset($min)) min="{{ $min }}" @endif
        @if(isset($max)) max="{{ $max }}" @endif
        @if(isset($step)) step="{{ $step }}" @endif
        @if(!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
    >

    @error($oldKey)
        <span class="company-edit-error">{{ $message }}</span>
    @enderror
</div>
