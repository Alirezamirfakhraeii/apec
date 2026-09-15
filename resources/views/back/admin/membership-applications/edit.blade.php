@php
    $profile = $application->companyProfile;
@endphp

@extends('back.admin.layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('back/css/companies/index.css') }}">
    <style>
        .membership-detail-card {
            margin-bottom: 20px;
        }

        .membership-detail-body {
            padding: 20px 22px;
        }

        .membership-form-grid {
            display: grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .membership-form-span-3 {
            grid-column: 1 / -1;
        }

        .membership-form-grid .form-group {
            margin-bottom: 0;
        }

        .membership-form-grid label {
            display: block;
            margin-bottom: 7px;
            color: #475467;
            font-size: 11px;
            font-weight: 700;
        }

        .membership-form-grid .form-control,
        .membership-document-edit-item .form-control,
        .membership-shareholder-row .form-control {
            min-height: 42px;
            border: 1px solid #e2e7ee;
            border-radius: 9px;
            box-shadow: none;
            font-size: 12px;
        }

        .membership-form-grid textarea.form-control {
            min-height: 90px;
            resize: vertical;
            line-height: 1.9;
        }

        .membership-checkbox-grid {
            display: grid;
            grid-template-columns:repeat(3, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }

        .membership-checkbox-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            border: 1px solid #edf0f4;
            border-radius: 10px;
            background: #fafbfc;
            cursor: pointer;
        }

        .membership-shareholder-row {
            display: grid;
            grid-template-columns:minmax(0, 2fr) minmax(130px, .7fr) 40px;
            gap: 10px;
            margin-bottom: 10px;
        }

        .membership-remove-row {
            border: 0;
            border-radius: 9px;
            background: #fff1f2;
            color: #dc2626;
            cursor: pointer;
        }

        .membership-add-row {
            border: 0;
            border-radius: 9px;
            padding: 10px 14px;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .membership-document-edit-grid {
            display: grid;
            grid-template-columns:repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .membership-document-edit-item {
            padding: 14px;
            border: 1px solid #edf0f4;
            border-radius: 12px;
            background: #fafbfc;
        }

        .membership-document-edit-item strong {
            display: block;
            margin-bottom: 5px;
            color: #344054;
            font-size: 12px;
        }

        .membership-document-edit-item span {
            display: block;
            margin-bottom: 10px;
            font-size: 11px;
            color: #667085;
        }

        .membership-current-document {
            margin-bottom: 12px;
            padding: 10px 12px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 10px;

            border: 1px solid #dfe5ec;
            border-radius: 9px;

            background: #ffffff;
        }

        .membership-current-document-info {
            min-width: 0;

            display: flex;
            align-items: center;

            gap: 9px;
        }

        .membership-current-document-icon {
            width: 34px;
            height: 34px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 8px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 15px;
        }

        .membership-current-document-name {
            display: block;

            max-width: 220px;

            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            color: #475467;

            font-size: 11px;
        }

        .membership-current-document-btn {
            flex-shrink: 0;

            padding: 8px 12px;

            display: inline-flex;
            align-items: center;

            gap: 5px;

            border-radius: 8px;

            background: #eef2ff;
            color: #4f46e5 !important;

            font-size: 11px !important;
            font-weight: 700;

            text-decoration: none !important;

            transition: 0.2s ease;
        }

        .membership-current-document-btn:hover {
            background: #4f46e5;
            color: #ffffff !important;
        }

        .membership-edit-footer {
            position: sticky;
            bottom: 12px;
            z-index: 10;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 14px;
            margin-top: 20px;
            border: 1px solid #e8ecf2;
            border-radius: 14px;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 8px 25px rgba(15, 23, 42, .08);
        }

        .membership-edit-save {
            border: 0;
            border-radius: 9px;
            padding: 11px 18px;
            background: #4f46e5;
            color: #fff;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .membership-edit-cancel {
            border-radius: 9px;
            padding: 11px 18px;
            background: #f4f6f9;
            color: #667085;
            font-size: 12px;
        }

        .membership-validation-alert ul {
            margin: 8px 0 0;
        }

        @media (max-width: 991px) {
            .membership-form-grid, .membership-checkbox-grid, .membership-document-edit-grid {
                grid-template-columns:repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 576px) {
            .membership-form-grid, .membership-checkbox-grid, .membership-document-edit-grid {
                grid-template-columns:1fr
            }

            .membership-shareholder-row {
                grid-template-columns:1fr
            }

            .membership-remove-row {
                height: 40px
            }

            .membership-form-span-3 {
                grid-column: auto
            }
        }
    </style>
@endpush

@section('content')
    <div class="company-admin-wrapper">
        <div class="company-page-header">
            <div class="company-page-heading">
                <span class="company-page-icon"><i class="fa fa-edit"></i></span>
                <div>
                    <h1>ویرایش پرونده عضویت #{{ $application->id }}</h1>
                    <p>ویرایش اطلاعات پرونده توسط مدیر یا کارشناس مسئول مرحله فعلی</p>
                </div>
            </div>
            <div class="company-header-actions">
                <a href="{{ route('admin.membership-applications.show', $application) }}" class="company-export-btn"><i
                        class="fa fa-arrow-right ml-1"></i> بازگشت به پرونده</a>
            </div>
        </div>


        @if($errors->any())
            <div class="alert alert-danger company-alert membership-validation-alert">
                <i class="fa fa-exclamation-circle ml-2"></i>
                اطلاعات فرم را بررسی کنید.
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        @if(session()->has('error'))

            <div class="alert alert-danger company-alert">

                <i class="fa fa-exclamation-circle ml-2"></i>

                {{ session('error') }}

            </div>

        @endif


        <form action="{{ route('admin.membership-applications.update', $application) }}" method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('back.admin.membership-applications.partials.application-fields', [
                'application' => $application,
                'mode' => 'edit',
            ])

            <div class="membership-edit-footer">
                <a href="{{ route('admin.membership-applications.show', $application) }}"
                   class="membership-edit-cancel">انصراف</a>
                <button type="submit" class="membership-edit-save"><i class="fa fa-save ml-1"></i> ذخیره تغییرات
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button = document.getElementById('add-shareholder');
            const container = document.getElementById('shareholders-container');
            if (!button || !container) return;
            button.addEventListener('click', function () {
                const index = container.querySelectorAll('.membership-shareholder-row').length;
                const row = document.createElement('div');
                row.className = 'membership-shareholder-row';
                row.innerHTML = `
                <input type="text" name="shareholders[${index}][full_name]" class="form-control" placeholder="نام و نام خانوادگی">
                <input type="number" step="0.01" min="0" max="100" name="shareholders[${index}][ownership_percentage]" class="form-control" placeholder="درصد سهام">
                <button type="button" class="membership-remove-row"><i class="fa fa-trash"></i></button>
            `;
                row.querySelector('.membership-remove-row').addEventListener('click', () => row.remove());
                container.appendChild(row);
            });
        });
    </script>
@endsection
