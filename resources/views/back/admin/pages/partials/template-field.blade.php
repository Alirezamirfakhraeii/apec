@php
    $key = $field['key'];

    $defaultValue = $field['default'] ?? null;

    $value = old(
        "template_data.$key",
        data_get(
            $page->template_data ?? [],
            $key,
            $defaultValue
        )
    );

    $condition = $field['condition'] ?? null;

    $isVisible = true;

    if ($condition) {
        $conditionFieldConfig =
            $templateFieldsCollection->firstWhere(
                'key',
                $condition['field']
            );

        $conditionDefault =
            $conditionFieldConfig['default'] ?? 0;

        $conditionCurrentValue = old(
            "template_data.{$condition['field']}",
            data_get(
                $page->template_data ?? [],
                $condition['field'],
                $conditionDefault
            )
        );

        $isVisible =
            (string) $conditionCurrentValue ===
            (string) $condition['value'];
    }

    $columnClass = $field['col'] ?? 'col-md-12';
@endphp

<div
    class="{{ $columnClass }} mb-3 template-field-item"
    @if($condition)
        data-condition-field="{{ $condition['field'] }}"
    data-condition-value="{{ $condition['value'] }}"
    @endif
    style="{{ $isVisible ? '' : 'display:none;' }}"
>
    @if($field['type'] === 'checkbox')

        <div class="template-toggle-card">

            <div>
                <strong>
                    {{ $field['label'] }}
                </strong>

                @if(!empty($field['help']))
                    <small>
                        {{ $field['help'] }}
                    </small>
                @endif
            </div>

            <div class="form-check form-switch">

                <input
                    type="hidden"
                    name="template_data[{{ $key }}]"
                    value="0"
                >

                <input
                    type="checkbox"
                    id="template-field-{{ $key }}"
                    name="template_data[{{ $key }}]"
                    value="1"
                    class="form-check-input js-template-controller"
                    data-template-key="{{ $key }}"
                    @checked((string) $value === '1')
                >

            </div>

        </div>

    @else

        <label
            class="form-label"
            for="template-field-{{ $key }}"
        >
            {{ $field['label'] }}
        </label>

        @if($field['type'] === 'text')

            <input
                type="text"
                id="template-field-{{ $key }}"
                name="template_data[{{ $key }}]"
                value="{{ $value }}"
                class="form-control"
            >

        @elseif($field['type'] === 'textarea')

            <textarea
                id="template-field-{{ $key }}"
                name="template_data[{{ $key }}]"
                rows="5"
                class="form-control"
            >{{ $value }}</textarea>

        @elseif($field['type'] === 'image')

            <input
                type="file"
                id="template-field-{{ $key }}"
                name="template_files[{{ $key }}]"
                class="form-control"
                accept="image/jpeg,image/png,image/webp"
            >

            @if($value)
                <div class="template-current-image">

                    <img
                        src="{{ asset('storage/' . ltrim($value, '/')) }}"
                        alt="{{ $field['label'] }}"
                    >

                    <div>
                        <strong>تصویر فعلی</strong>

                        <span>
                            با انتخاب فایل جدید، تصویر فعلی جایگزین می‌شود.
                        </span>
                    </div>

                </div>
            @endif

        @endif

    @endif
</div>
