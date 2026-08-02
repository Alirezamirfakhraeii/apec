@if ($errors->any())
    <div class="alert alert-danger">
        <strong>خطا در ثبت اطلاعات:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf

    @if($method !== 'POST')
        @method($method)
    @endif

    <div class="filter-card mb-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">عنوان صفحه</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $page->title) }}"
                    class="form-control"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">اسلاگ</label>
                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug', $page->slug) }}"
                    class="form-control"
                    required
                    placeholder="contact-us"
                    dir="ltr"
                >
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">خلاصه صفحه</label>
                <textarea
                    name="summary"
                    rows="3"
                    class="form-control"
                >{{ old('summary', $page->summary) }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">تمپلیت صفحه</label>
                <select name="template" class="form-control">
                    @foreach($templates as $key => $template)
                        <option
                            value="{{ $key }}"
                            @selected(old('template', $page->template) === $key)
                        >
                            {{ $template['label'] }}
                        </option>
                    @endforeach
                </select>

                @if($page->exists)
                    <small class="text-muted d-block mt-2">
                        بعد از تغییر تمپلیت و ذخیره، فیلدهای مخصوص همان تمپلیت نمایش داده می‌شود.
                    </small>
                @else
                    <small class="text-muted d-block mt-2">
                        ابتدا صفحه را بسازید؛ سپس در مرحله ویرایش، فیلدهای مخصوص تمپلیت را تکمیل می‌کنید.
                    </small>
                @endif
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">وضعیت</label>
                <select name="status" class="form-control">
                    <option value="1" @selected(old('status', (int) $page->status) == 1)>فعال</option>
                    <option value="0" @selected(old('status', (int) $page->status) == 0)>غیرفعال</option>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">متن اصلی صفحه</label>
                <textarea
                    name="body"
                    rows="8"
                    class="form-control"
                >{{ old('body', $page->body) }}</textarea>
            </div>
        </div>
    </div>

    @if($page->exists && count($templateFields))
        @php
            $currentTemplate = old(
                'template',
                $page->template ?: 'default'
            );

            $currentTemplateConfig = $templates[$currentTemplate] ?? [];

            $templateGroups = $currentTemplateConfig['groups'] ?? [];

            $templateFieldsCollection = collect($templateFields);

            $groupedTemplateFields = $templateFieldsCollection
                ->groupBy(fn ($field) => $field['group'] ?? 'general');
        @endphp

        <div class="template-fields-wrapper">

            <div class="template-fields-heading">
                <div>
                    <h3>تنظیمات اختصاصی صفحه</h3>

                    <p>
                        بخش‌های موردنیاز صفحه کمیته را فعال و تکمیل کنید.
                    </p>
                </div>

                <span>
                {{ $currentTemplateConfig['label'] ?? 'تمپلیت صفحه' }}
            </span>
            </div>

            @foreach($groupedTemplateFields as $groupKey => $fields)
                @php
                    $groupConfig = $templateGroups[$groupKey] ?? [
                        'label' => 'سایر اطلاعات',
                        'description' => null,
                        'icon' => 'fa fa-cog',
                    ];
                @endphp

                <div class="filter-card mb-4 template-field-group">

                    <div class="template-field-group-header">

                        <div class="template-field-group-icon">
                            <i class="{{ $groupConfig['icon'] ?? 'fa fa-cog' }}"></i>
                        </div>

                        <div>
                            <h3>
                                {{ $groupConfig['label'] }}
                            </h3>

                            @if(!empty($groupConfig['description']))
                                <p>
                                    {{ $groupConfig['description'] }}
                                </p>
                            @endif
                        </div>

                    </div>

                    <div class="row">

                        @foreach($fields as $field)
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
                                        $templateFieldsCollection
                                            ->firstWhere(
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

                                $columnClass =
                                    $field['col'] ?? 'col-md-12';
                            @endphp

                            <div class="{{ $columnClass }} mb-3 template-field-item"
                                 @if($condition)
                                     data-condition-field="{{ $condition['field'] }}"
                                 data-condition-value="{{ $condition['value'] }}"
                                 @endif
                                 style="{{ $isVisible ? '' : 'display:none;' }}">

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

                                            <input type="hidden"
                                                   name="template_data[{{ $key }}]"
                                                   value="0">

                                            <input type="checkbox"
                                                   id="template-field-{{ $key }}"
                                                   name="template_data[{{ $key }}]"
                                                   value="1"
                                                   class="form-check-input js-template-controller"
                                                   data-template-key="{{ $key }}"
                                                @checked((string) $value === '1')>

                                        </div>

                                    </div>

                                @else

                                    <label class="form-label"
                                           for="template-field-{{ $key }}">

                                        {{ $field['label'] }}
                                    </label>

                                    @if($field['type'] === 'text')

                                        <input type="text"
                                               id="template-field-{{ $key }}"
                                               name="template_data[{{ $key }}]"
                                               value="{{ $value }}"
                                               class="form-control">

                                    @elseif($field['type'] === 'textarea')

                                        <textarea id="template-field-{{ $key }}"
                                                  name="template_data[{{ $key }}]"
                                                  rows="5"
                                                  class="form-control">{{ $value }}</textarea>

                                    @elseif($field['type'] === 'image')

                                        <input type="file"
                                               id="template-field-{{ $key }}"
                                               name="template_files[{{ $key }}]"
                                               class="form-control"
                                               accept="image/jpeg,image/png,image/webp">

                                        @if($value)
                                            <div class="template-current-image">

                                                <img src="{{ asset('storage/' . ltrim($value, '/')) }}"
                                                     alt="{{ $field['label'] }}">

                                                <div>
                                                    <strong>تصویر فعلی</strong>

                                                    <span>
                                                    با انتخاب فایل جدید، تصویر جایگزین می‌شود.
                                                </span>
                                                </div>

                                            </div>
                                        @endif

                                    @endif

                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>

            @endforeach

        </div>
    @endif
    <div class="filter-card mb-4">
        <h3 class="mb-4">تنظیمات سئو</h3>

        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">عنوان سئو</label>
                <input
                    type="text"
                    name="meta_title"
                    value="{{ old('meta_title', $page->meta_title) }}"
                    class="form-control"
                >
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">توضیحات سئو</label>
                <textarea
                    name="meta_description"
                    rows="3"
                    class="form-control"
                >{{ old('meta_description', $page->meta_description) }}</textarea>
            </div>
        </div>
    </div>

    <button type="submit" class="news-create-btn">
        ذخیره صفحه
    </button>
</form>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const conditionalFields = document.querySelectorAll(
            '[data-condition-field]'
        );

        function getControllerValue(fieldKey) {
            const controller = document.querySelector(
                '[data-template-key="' + fieldKey + '"]'
            );

            if (!controller) {
                return null;
            }

            if (controller.type === 'checkbox') {
                return controller.checked ? '1' : '0';
            }

            return controller.value;
        }

        function updateConditionalFields() {
            conditionalFields.forEach(function (wrapper) {
                const fieldKey = wrapper.dataset.conditionField;
                const requiredValue = wrapper.dataset.conditionValue;
                const currentValue = getControllerValue(fieldKey);

                wrapper.style.display =
                    String(currentValue) === String(requiredValue)
                        ? ''
                        : 'none';
            });
        }

        document.querySelectorAll('.js-template-controller')
            .forEach(function (controller) {
                controller.addEventListener(
                    'change',
                    updateConditionalFields
                );
            });

        updateConditionalFields();
    });
</script>
