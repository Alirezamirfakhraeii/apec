@php
    $shareholderRows = old(
        'shareholders',
        collect($shareholders ?? [])->map(function ($shareholder) {
            return [
                'id' => $shareholder->id,
                'full_name' => $shareholder->full_name,
                'ownership_percentage' => $shareholder->ownership_percentage,
            ];
        })->values()->all()
    );

    if (empty($shareholderRows)) {
        $shareholderRows = [[
            'id' => null,
            'full_name' => '',
            'ownership_percentage' => '',
        ]];
    }
@endphp

<div class="company-edit-section">
    <div class="company-edit-section__title">سهامداران شرکت</div>

    <div class="company-edit-section__hint">
        سهامداران فعلی را ویرایش کنید یا سهامدار جدید اضافه کنید.
    </div>

    <div id="company-shareholders-container" class="company-repeatable-list">
        @foreach($shareholderRows as $index => $shareholder)
            <div class="company-repeatable-row company-shareholder-row">
                @if(!empty($shareholder['id']))
                    <input
                        type="hidden"
                        name="shareholders[{{ $index }}][id]"
                        value="{{ $shareholder['id'] }}"
                    >
                @endif

                <div class="company-edit-grid company-repeatable-grid">
                    <div class="company-edit-field">
                        <label class="company-edit-label">نام و نام خانوادگی / نام سهامدار</label>
                        <input
                            type="text"
                            name="shareholders[{{ $index }}][full_name]"
                            value="{{ $shareholder['full_name'] ?? '' }}"
                            class="company-edit-input"
                        >

                        @error("shareholders.$index.full_name")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="company-edit-field">
                        <label class="company-edit-label">درصد سهام</label>
                        <input
                            type="number"
                            min="0"
                            max="100"
                            step="0.01"
                            name="shareholders[{{ $index }}][ownership_percentage]"
                            value="{{ $shareholder['ownership_percentage'] ?? '' }}"
                            class="company-edit-input"
                        >

                        @error("shareholders.$index.ownership_percentage")
                            <span class="company-edit-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button
                    type="button"
                    class="company-repeatable-remove"
                    data-remove-shareholder
                >
                    حذف سهامدار
                </button>
            </div>
        @endforeach
    </div>

    <button
        type="button"
        class="company-add-row"
        id="add-company-shareholder"
    >
        + افزودن سهامدار
    </button>
</div>

<script>
(function () {
    const container = document.getElementById('company-shareholders-container');
    const addButton = document.getElementById('add-company-shareholder');

    if (!container || !addButton) return;

    const bindRemoveButtons = () => {
        container.querySelectorAll('[data-remove-shareholder]').forEach((button) => {
            button.onclick = () => {
                const rows = container.querySelectorAll('.company-shareholder-row');

                if (rows.length === 1) {
                    rows[0].querySelectorAll('input').forEach((input) => {
                        if (input.type !== 'hidden') input.value = '';
                    });
                    return;
                }

                button.closest('.company-shareholder-row')?.remove();
            };
        });
    };

    addButton.addEventListener('click', () => {
        const index = container.querySelectorAll('.company-shareholder-row').length;
        const row = document.createElement('div');
        row.className = 'company-repeatable-row company-shareholder-row';

        row.innerHTML = `
            <div class="company-edit-grid company-repeatable-grid">
                <div class="company-edit-field">
                    <label class="company-edit-label">نام و نام خانوادگی / نام سهامدار</label>
                    <input type="text" name="shareholders[${index}][full_name]" class="company-edit-input">
                </div>
                <div class="company-edit-field">
                    <label class="company-edit-label">درصد سهام</label>
                    <input type="number" min="0" max="100" step="0.01" name="shareholders[${index}][ownership_percentage]" class="company-edit-input">
                </div>
            </div>
            <button type="button" class="company-repeatable-remove" data-remove-shareholder>حذف سهامدار</button>
        `;

        container.appendChild(row);
        bindRemoveButtons();
    });

    bindRemoveButtons();
})();
</script>
