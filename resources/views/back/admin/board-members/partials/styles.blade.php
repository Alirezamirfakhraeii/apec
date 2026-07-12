<style>
    .board-member-wrapper {
        direction: rtl;
    }

    .board-member-page-header {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045);
        margin-bottom: 22px;
    }

    .board-member-page-title {
        color: #111827;
        font-size: 18px;
        font-weight: 900;
        margin-bottom: 5px;
    }

    .board-member-page-subtitle {
        color: #64748b;
        font-size: 13px;
    }

    .board-member-back-btn,
    .board-member-create-btn {
        background: #f8fafc;
        border: 1px solid #dbe1ea;
        color: #334155;
        border-radius: 8px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 800;
    }

    .board-member-create-btn {
        background: #1e293b;
        border-color: #1e293b;
        color: #ffffff;
    }

    .board-member-create-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .board-member-back-btn:hover {
        background: #e2e8f0;
        color: #0f172a;
    }

    .board-member-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045);
        overflow: hidden;
        margin-bottom: 20px;
    }

    .board-member-card-header {
        padding: 16px 18px;
        border-bottom: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .board-member-card-title {
        color: #111827;
        font-size: 14px;
        font-weight: 900;
        margin: 0;
    }

    .board-member-card-title i {
        color: #334155;
    }

    .board-member-card-body {
        padding: 18px;
    }

    .board-member-label {
        color: #334155;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .board-member-label .required {
        color: #dc2626;
    }

    .board-member-form-control {
        border: 1px solid #dbe1ea;
        border-radius: 9px;
        min-height: 43px;
        color: #334155;
        font-size: 13px;
        box-shadow: none;
    }

    .board-member-form-control:focus {
        border-color: #334155;
        box-shadow: 0 0 0 0.12rem rgba(51, 65, 85, 0.12);
    }

    textarea.board-member-form-control {
        min-height: 105px;
        resize: vertical;
    }

    .board-member-help {
        color: #94a3b8;
        font-size: 11px;
        margin-top: 5px;
        line-height: 1.8;
    }

    .board-member-section-note {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        padding: 12px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.9;
    }

    .board-member-upload-box {
        border: 1px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 12px;
        padding: 14px;
    }

    .board-member-status-box {
        border: 1px solid #e2e8f0;
        background: #ffffff;
        border-radius: 10px;
        padding: 12px;
    }

    .board-member-submit-btn {
        width: 100%;
        min-height: 47px;
        border-radius: 9px;
        background: #1e293b;
        border-color: #1e293b;
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
    }

    .board-member-submit-btn:hover {
        background: #0f172a;
        border-color: #0f172a;
        color: #ffffff;
    }

    .board-member-divider {
        height: 1px;
        background: #e5e7eb;
        margin: 18px 0;
    }

    .board-member-thumb {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 13px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
    }

    .board-member-empty-thumb {
        width: 54px;
        height: 54px;
        border-radius: 13px;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
    }

    .board-member-status {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 800;
    }

    .board-member-status.active {
        background: #dcfce7;
        color: #166534;
    }

    .board-member-status.inactive {
        background: #f1f5f9;
        color: #64748b;
    }

    .board-member-action-btn {
        border: 0;
        border-radius: 8px;
        padding: 7px 10px;
        font-size: 12px;
        font-weight: 800;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .board-member-action-btn.edit {
        background: #0ea5e9;
    }

    .board-member-action-btn.delete {
        background: #ef4444;
    }

    .board-member-stat-card {
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.045);
        padding: 16px;
        margin-bottom: 20px;
    }

    .board-member-stat-title {
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .board-member-stat-number {
        color: #111827;
        font-size: 24px;
        font-weight: 900;
        margin: 0;
    }

    .invalid-feedback {
        display: block;
        font-size: 11px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .board-member-page-header {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .board-member-back-btn,
        .board-member-create-btn {
            width: 100%;
            margin-top: 12px;
            text-align: center;
        }
    }
</style>
