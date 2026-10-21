@php
    $projectRows = old(
        'projects',
        collect($projects ?? [])->map(function ($project) {
            $formatDate = static function ($value) {
                if (! $value) {
                    return '';
                }

                try {
                    return $value instanceof \Carbon\CarbonInterface
                        ? $value->format('Y-m-d')
                        : \Illuminate\Support\Carbon::parse($value)->format('Y-m-d');
                } catch (\Throwable $e) {
                    return (string) $value;
                }
            };

            return [
                'id' => $project->id,
                'project_name' => $project->project_name,
                'employer' => $project->employer,
                'start_date' => $formatDate($project->start_date),
                'end_date' => $formatDate($project->end_date),
                'service_description' => $project->service_description,
            ];
        })->values()->all()
    );

    if (empty($projectRows)) {
        $projectRows = [[
            'id' => null,
            'project_name' => '',
            'employer' => '',
            'start_date' => '',
            'end_date' => '',
            'service_description' => '',
        ]];
    }
@endphp

<div class="company-edit-section">
    <div class="company-edit-section__title">پروژه‌ها و سوابق اجرایی</div>

    <div class="company-edit-section__hint">
        پروژه‌های قبلی را ویرایش کنید یا پروژه جدیدی به سوابق شرکت اضافه کنید.
    </div>

    <div id="company-projects-container" class="company-repeatable-list">
        @foreach($projectRows as $index => $project)
            <div class="company-repeatable-row company-project-row">
                @if(!empty($project['id']))
                    <input
                        type="hidden"
                        name="projects[{{ $index }}][id]"
                        value="{{ $project['id'] }}"
                    >
                @endif

                <div class="company-edit-grid company-repeatable-grid">
                    <div class="company-edit-field">
                        <label class="company-edit-label">نام پروژه</label>
                        <input
                            type="text"
                            name="projects[{{ $index }}][project_name]"
                            value="{{ $project['project_name'] ?? '' }}"
                            class="company-edit-input"
                        >
                        @error("projects.$index.project_name")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="company-edit-field">
                        <label class="company-edit-label">کارفرما</label>
                        <input
                            type="text"
                            name="projects[{{ $index }}][employer]"
                            value="{{ $project['employer'] ?? '' }}"
                            class="company-edit-input"
                        >
                        @error("projects.$index.employer")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="company-edit-field">
                        <label class="company-edit-label">تاریخ شروع</label>
                        <input
                            type="date"
                            name="projects[{{ $index }}][start_date]"
                            value="{{ $project['start_date'] ?? '' }}"
                            class="company-edit-input"
                        >
                        @error("projects.$index.start_date")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="company-edit-field">
                        <label class="company-edit-label">تاریخ پایان</label>
                        <input
                            type="date"
                            name="projects[{{ $index }}][end_date]"
                            value="{{ $project['end_date'] ?? '' }}"
                            class="company-edit-input"
                        >
                        @error("projects.$index.end_date")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="company-edit-field company-edit-field--full">
                        <label class="company-edit-label">شرح خدمات</label>
                        <textarea
                            name="projects[{{ $index }}][service_description]"
                            class="company-edit-textarea"
                        >{{ $project['service_description'] ?? '' }}</textarea>
                        @error("projects.$index.service_description")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button
                    type="button"
                    class="company-repeatable-remove"
                    data-remove-project
                >
                    حذف پروژه
                </button>
            </div>
        @endforeach
    </div>

    <button
        type="button"
        class="company-add-row"
        id="add-company-project"
    >
        + افزودن پروژه
    </button>
</div>

<script>
(function () {
    const container = document.getElementById('company-projects-container');
    const addButton = document.getElementById('add-company-project');

    if (!container || !addButton) return;

    const bindRemoveButtons = () => {
        container.querySelectorAll('[data-remove-project]').forEach((button) => {
            button.onclick = () => {
                const rows = container.querySelectorAll('.company-project-row');

                if (rows.length === 1) {
                    rows[0].querySelectorAll('input, textarea').forEach((field) => {
                        if (field.type !== 'hidden') field.value = '';
                    });
                    return;
                }

                button.closest('.company-project-row')?.remove();
            };
        });
    };

    addButton.addEventListener('click', () => {
        const index = container.querySelectorAll('.company-project-row').length;
        const row = document.createElement('div');
        row.className = 'company-repeatable-row company-project-row';

        row.innerHTML = `
            <div class="company-edit-grid company-repeatable-grid">
                <div class="company-edit-field">
                    <label class="company-edit-label">نام پروژه</label>
                    <input type="text" name="projects[${index}][project_name]" class="company-edit-input">
                </div>
                <div class="company-edit-field">
                    <label class="company-edit-label">کارفرما</label>
                    <input type="text" name="projects[${index}][employer]" class="company-edit-input">
                </div>
                <div class="company-edit-field">
                    <label class="company-edit-label">تاریخ شروع</label>
                    <input type="date" name="projects[${index}][start_date]" class="company-edit-input">
                </div>
                <div class="company-edit-field">
                    <label class="company-edit-label">تاریخ پایان</label>
                    <input type="date" name="projects[${index}][end_date]" class="company-edit-input">
                </div>
                <div class="company-edit-field company-edit-field--full">
                    <label class="company-edit-label">شرح خدمات</label>
                    <textarea name="projects[${index}][service_description]" class="company-edit-textarea"></textarea>
                </div>
            </div>
            <button type="button" class="company-repeatable-remove" data-remove-project>حذف پروژه</button>
        `;

        container.appendChild(row);
        bindRemoveButtons();
    });

    bindRemoveButtons();
})();
</script>
