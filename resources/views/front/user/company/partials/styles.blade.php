@push('styles')
<style>
    .company-edit-page {
        width: 100%;
        max-width: 1120px;
        margin: 0 auto;
    }

    .company-edit-card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e7ebf0;
        border-radius: 18px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .05);
    }

    .company-edit-header {
        padding: 24px 26px;
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 1px solid #edf0f4;
    }

    .company-edit-header__icon {
        width: 48px;
        height: 48px;
        flex: 0 0 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        background: #eef4ff;
        color: #173a70;
    }

    .company-edit-header__icon svg {
        width: 23px;
        height: 23px;
    }

    .company-edit-header h2 {
        margin: 0;
        color: #1d2939;
        font-size: 18px;
        font-weight: 900;
    }

    .company-edit-header p {
        margin: 5px 0 0;
        color: #667085;
        font-size: 12px;
        line-height: 1.9;
    }

    .company-edit-body {
        padding: 26px;
    }

    .company-edit-alert {
        margin-bottom: 22px;
        padding: 13px 15px;
        border-radius: 11px;
        font-size: 12px;
        line-height: 1.9;
    }

    .company-edit-alert strong {
        margin-left: 5px;
    }

    .company-edit-alert--success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #15803d;
    }

    .company-edit-alert--danger {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b42318;
    }

    .company-edit-section {
        margin-bottom: 30px;
        border: 1px solid #e5eaf0;
        border-radius: 14px;
        background: #fff;
        overflow: hidden;
    }

    .company-edit-section__title {
        position: relative;
        margin: 0 0 20px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f3f7fc;
        color: #173a70;
        border-bottom: 1px solid #d9e2ed;
        font-size: 14px;
        font-weight: 900;
    }

    .company-edit-section__title::before {
        content: '';
        width: 4px;
        height: 22px;
        flex: 0 0 4px;
        border-radius: 999px;
        background: #173a70;
    }

    .company-edit-section__hint {
        margin: -7px 18px 18px;
        padding: 10px 12px;
        background: #f8fafc;
        border: 1px dashed #dce3eb;
        border-radius: 9px;
        color: #667085;
        font-size: 11px;
        line-height: 1.9;
    }

    .company-edit-section > .company-edit-grid,
    .company-edit-section > .company-edit-documents-grid,
    .company-edit-section > .company-edit-options-grid,
    .company-edit-section > .company-repeatable-list {
        margin-left: 18px;
        margin-right: 18px;
    }

    .company-edit-section > .company-edit-grid,
    .company-edit-section > .company-edit-documents-grid,
    .company-edit-section > .company-edit-options-grid {
        margin-bottom: 22px;
    }

    .company-edit-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .company-edit-field {
        min-width: 0;
    }

    .company-edit-field--full {
        grid-column: 1 / -1;
    }

    .company-edit-label {
        display: block;
        margin-bottom: 7px;
        color: #344054;
        font-size: 12px;
        font-weight: 800;
    }

    .company-edit-input,
    .company-edit-textarea,
    .company-edit-select,
    .company-edit-file {
        width: 100%;
        border: 1px solid #dfe5ec;
        border-radius: 10px;
        background: #fff;
        color: #344054;
        font-family: inherit;
        font-size: 12px;
        outline: none;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .company-edit-input,
    .company-edit-select {
        min-height: 43px;
        padding: 0 12px;
    }

    .company-edit-file {
        min-height: 43px;
        padding: 8px 10px;
    }

    .company-edit-textarea {
        min-height: 115px;
        padding: 12px;
        resize: vertical;
        line-height: 1.9;
    }

    .company-edit-input:focus,
    .company-edit-textarea:focus,
    .company-edit-select:focus,
    .company-edit-file:focus {
        border-color: #173a70;
        box-shadow: 0 0 0 3px rgba(23, 58, 112, .08);
    }

    .company-edit-error {
        display: block;
        margin-top: 6px;
        color: #b42318;
        font-size: 10px;
        line-height: 1.7;
    }

    .company-edit-error--section {
        margin: 0 18px 15px;
    }

    .company-edit-checkbox,
    .company-edit-option {
        min-height: 45px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 9px;
        border: 1px solid #dfe5ec;
        border-radius: 10px;
        background: #f8fafc;
        color: #344054;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
    }

    .company-edit-checkbox input,
    .company-edit-option input {
        width: 17px;
        height: 17px;
        margin: 0;
        flex: 0 0 17px;
    }

    .company-edit-options-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .company-edit-documents-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .company-document-box {
        padding: 15px;
        border: 1px solid #e5eaf0;
        border-radius: 12px;
        background: #fbfcfe;
    }

    .company-document-box__head {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .company-document-box__head strong {
        color: #344054;
        font-size: 12px;
        font-weight: 900;
    }

    .company-document-status {
        padding: 4px 8px;
        border-radius: 999px;
        background: #f2f4f7;
        color: #667085;
        font-size: 9px;
        font-weight: 800;
    }

    .company-document-status--exists {
        background: #ecfdf3;
        color: #15803d;
    }

    .company-current-file {
        margin-bottom: 12px;
        padding: 9px 10px;
        border: 1px solid #e8edf2;
        border-radius: 9px;
        background: #fff;
        color: #667085;
        font-size: 10px;
        line-height: 1.8;
    }

    .company-current-file--with-preview {
        margin-top: 10px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .company-current-file strong,
    .company-current-file__name {
        display: block;
        margin-bottom: 3px;
        color: #344054;
        font-weight: 800;
        word-break: break-word;
    }

    .company-current-file a {
        color: #173a70;
        font-weight: 800;
        text-decoration: none;
    }

    .company-current-logo {
        width: 54px;
        height: 54px;
        object-fit: contain;
        border-radius: 9px;
        background: #f8fafc;
        border: 1px solid #edf0f4;
    }

    .company-repeatable-list {
        display: grid;
        gap: 14px;
    }

    .company-repeatable-row {
        padding: 16px;
        border: 1px solid #e4e9ef;
        border-radius: 12px;
        background: #fafbfd;
    }

    .company-repeatable-grid {
        margin-bottom: 12px;
    }

    .company-repeatable-remove {
        min-height: 34px;
        padding: 0 12px;
        border: 1px solid #fecaca;
        border-radius: 8px;
        background: #fff;
        color: #b42318;
        font-family: inherit;
        font-size: 10px;
        font-weight: 800;
        cursor: pointer;
    }

    .company-add-row {
        min-height: 39px;
        margin: 14px 18px 20px;
        padding: 0 15px;
        border: 1px solid #cdd8e6;
        border-radius: 9px;
        background: #f4f7fb;
        color: #173a70;
        font-family: inherit;
        font-size: 11px;
        font-weight: 900;
        cursor: pointer;
    }

    .company-edit-empty {
        grid-column: 1 / -1;
        padding: 18px;
        border: 1px dashed #d8e0e9;
        border-radius: 10px;
        background: #fafbfc;
        color: #98a2b3;
        text-align: center;
        font-size: 11px;
    }

    .company-edit-footer {
        margin-top: 28px;
        padding-top: 22px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #edf0f4;
    }

    .company-edit-save,
    .company-edit-cancel {
        min-height: 43px;
        padding: 0 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
    }

    .company-edit-save {
        border: 0;
        background: #173a70;
        color: #fff;
        cursor: pointer;
    }

    .company-edit-cancel {
        border: 1px solid #dfe5ec;
        background: #fff;
        color: #475467;
    }

    @media (max-width: 900px) {
        .company-edit-options-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .company-edit-header,
        .company-edit-body {
            padding: 18px;
        }

        .company-edit-grid,
        .company-edit-documents-grid,
        .company-edit-options-grid {
            grid-template-columns: 1fr;
        }

        .company-edit-field--full {
            grid-column: auto;
        }

        .company-edit-section__title {
            padding: 12px 14px;
            font-size: 13px;
        }

        .company-edit-section > .company-edit-grid,
        .company-edit-section > .company-edit-documents-grid,
        .company-edit-section > .company-edit-options-grid,
        .company-edit-section > .company-repeatable-list {
            margin-left: 14px;
            margin-right: 14px;
        }

        .company-edit-section__hint {
            margin-left: 14px;
            margin-right: 14px;
        }

        .company-add-row {
            margin-left: 14px;
            margin-right: 14px;
        }

        .company-edit-footer {
            flex-direction: column-reverse;
        }

        .company-edit-save,
        .company-edit-cancel {
            width: 100%;
        }
    }
</style>
@endpush
