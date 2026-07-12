@extends('back.admin.layouts.master')


<head>
    <link rel="stylesheet" href="{{ asset('back/css/pages/index.css') }}">
</head>


@section('content')
    <div class="news-admin-wrapper" dir="rtl">
        <div class="news-page-header">
            <div>
                <h1>ویرایش صفحه: {{ $page->title }}</h1>
                <p>اطلاعات اصلی صفحه و فیلدهای مخصوص تمپلیت را مدیریت کنید.</p>
            </div>

            <a href="{{ route('admin.pages.index') }}" class="news-create-btn">
                بازگشت به لیست صفحات
            </a>
        </div>

        @include('back.admin.pages.partials.form', [
            'page' => $page,
            'templates' => $templates,
            'templateFields' => $templateFields,
            'action' => route('admin.pages.update', $page),
            'method' => 'PUT',
        ])
    </div>
@endsection
@push('styles')
    <style>
        .news-admin-wrapper {
            direction: rtl;
            padding: 28px;
            background: #f4f6f9;
            min-height: 100vh;
            font-family: inherit;
        }

        .news-page-header {
            background: #ffffff;
            border-radius: 22px;
            padding: 28px 32px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.06);
            border: 1px solid #e5e7eb;
        }

        .news-page-header h1 {
            margin: 0 0 8px;
            font-size: 26px;
            font-weight: 800;
            color: #0f172a;
        }

        .news-page-header p {
            margin: 0;
            color: #64748b;
            font-size: 14px;
            line-height: 1.9;
        }

        .news-create-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 10px 20px;
            border-radius: 14px;
            background: #0f172a;
            color: #ffffff !important;
            border: none;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.2s ease;
            white-space: nowrap;
            cursor: pointer;
        }

        .news-create-btn:hover {
            background: #1e293b;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.18);
        }

        .filter-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.05);
        }

        .filter-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 13px;
            border: 1px solid #dbe3ef;
            min-height: 44px;
            padding: 10px 14px;
            font-size: 14px;
            color: #0f172a;
            background-color: #ffffff;
            box-shadow: none;
        }

        textarea.form-control {
            min-height: auto;
            line-height: 1.9;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #0f172a;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
        }

        .alert {
            border-radius: 16px;
            padding: 14px 18px;
            font-size: 14px;
            border: none;
        }

        .alert-success {
            background: #ecfdf5;
            color: #047857;
        }

        .alert-danger {
            background: #fef2f2;
            color: #b91c1c;
        }

        .editorial-table-card {
            background: #ffffff;
            border-radius: 22px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.06);
            overflow: hidden;
        }

        .editorial-table-header {
            padding: 22px 26px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .editorial-table-header h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            color: #0f172a;
        }

        .editorial-table {
            margin: 0;
            width: 100%;
            vertical-align: middle;
        }

        .editorial-table thead th {
            background: #f8fafc;
            color: #475569;
            font-size: 13px;
            font-weight: 800;
            padding: 16px 18px;
            border-bottom: 1px solid #e5e7eb;
            white-space: nowrap;
        }

        .editorial-table tbody td {
            padding: 18px;
            color: #334155;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .editorial-table tbody tr:hover {
            background: #f8fafc;
        }

        .editorial-post-title {
            display: block;
            color: #0f172a;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.8;
        }

        .editorial-category {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #334155;
            font-size: 12px;
            font-weight: 700;
        }

        .editorial-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
        }

        .editorial-status.published {
            background: #dcfce7;
            color: #15803d;
        }

        .editorial-status.draft {
            background: #fee2e2;
            color: #b91c1c;
        }

        .editorial-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .editorial-action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            padding: 7px 12px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #0f172a !important;
            text-decoration: none;
            border: none;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .editorial-action-btn:hover {
            background: #0f172a;
            color: #ffffff !important;
        }

        .editorial-footer {
            padding: 18px 24px;
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
        }

        .editorial-footer nav {
            margin: 0;
        }

        .pagination {
            margin: 0;
            gap: 6px;
            justify-content: center;
        }

        .page-link {
            border-radius: 10px !important;
            border: 1px solid #e5e7eb;
            color: #0f172a;
            font-size: 13px;
            font-weight: 700;
        }

        .page-item.active .page-link {
            background: #0f172a;
            border-color: #0f172a;
            color: #ffffff;
        }

        @media (max-width: 768px) {
            .news-admin-wrapper {
                padding: 16px;
            }

            .news-page-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 22px;
            }

            .news-create-btn {
                width: 100%;
            }

            .filter-card {
                padding: 18px;
            }

            .editorial-table-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush
