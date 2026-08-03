@php
    $companyDisplayName = static function ($company) {
        return $company->short_name
            ?? $company->registered_name
            ?? $company->company_name
            ?? $company->name
            ?? 'شرکت بدون نام';
    };
@endphp

@extends('back.admin.layouts.master')

@push('styles')
    <link rel="stylesheet"
          href="{{ asset('back/css/posts/index.css') }}">

    <style>
        .project-form-wrapper {
            padding-bottom: 40px;
        }

        .project-form-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
            overflow: hidden;
        }

        .project-form-header {
            padding: 20px 24px;
            background: #fff;
            border-bottom: 1px solid #edf0f5;
        }

        .project-form-title {
            margin-bottom: 6px;
            color: #253858;
            font-size: 17px;
            font-weight: 700;
        }

        .project-form-subtitle {
            color: #8792a2;
            font-size: 13px;
        }

        .project-form-body {
            padding: 24px;
        }

        .project-form-group {
            margin-bottom: 22px;
        }

        .project-form-group label {
            display: block;
            margin-bottom: 8px;
            color: #3f4d67;
            font-size: 13px;
            font-weight: 600;
        }

        .project-required {
            margin-right: 3px;
            color: #e74c3c;
        }

        .project-form-control {
            min-height: 45px;
            border: 1px solid #dfe4ea;
            border-radius: 7px;
            font-size: 13px;
            transition: all .2s ease;
        }

        .project-form-control:focus {
            border-color: #4c84ff;
            box-shadow: 0 0 0 3px rgba(76, 132, 255, .12);
        }

        textarea.project-form-control {
            min-height: 150px;
            resize: vertical;
        }

        .project-form-footer {
            padding: 18px 24px;
            background: #fafbfc;
            border-top: 1px solid #edf0f5;
        }

        .project-submit-btn {
            min-width: 150px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 600;
        }

        .project-cancel-btn {
            min-width: 110px;
            border-radius: 7px;
            font-size: 13px;
        }

        .project-field-help {
            display: block;
            margin-top: 6px;
            color: #98a1b2;
            font-size: 11px;
        }

        .project-error {
            display: block;
            margin-top: 6px;
            color: #e74c3c;
            font-size: 12px;
        }

        .project-form-control.is-invalid {
            border-color: #e74c3c;
        }
    </style>
@endpush

@section('content')

    <div class="news-admin-wrapper project-form-wrapper">

        <br>

        <div class="news-page-header mb-4 d-flex align-items-center justify-content-between">

            <div>
                <h4 class="news-page-title">
                    <i class="fa fa-edit ml-2"></i>
                    ویرایش پروژه
                </h4>

                <div class="news-page-subtitle">
                    ویرایش اطلاعات پروژه «{{ $project->project_name }}»
                </div>
            </div>

            <a href="{{ route('admin.company-projects.index') }}"
               class="btn btn-outline-secondary">

                <i class="fa fa-arrow-right ml-2"></i>
                بازگشت به پروژه‌ها
            </a>

        </div>

        @if($errors->any())

            <div class="alert alert-danger border-0 shadow-sm rounded mb-4">

                <div class="font-weight-bold mb-2">
                    <i class="fa fa-exclamation-circle ml-2"></i>
                    اطلاعات فرم صحیح نیست
                </div>

                <ul class="mb-0 pr-4">

                    @foreach($errors->all() as $error)
                        <li class="mb-1">
                            {{ $error }}
                        </li>
                    @endforeach

                </ul>

            </div>

        @endif

        <form action="{{ route(
                'admin.company-projects.update',
                $project
            ) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="card project-form-card">

                <div class="project-form-header">

                    <div class="project-form-title">
                        <i class="fa fa-briefcase ml-2"></i>
                        اطلاعات پروژه
                    </div>

                    <div class="project-form-subtitle">
                        اطلاعات فعلی پروژه را بررسی و ویرایش کنید.
                    </div>

                </div>

                <div class="project-form-body">

                    <div class="row">

                        {{-- شرکت --}}
                        <div class="col-xl-6 col-lg-6 col-md-12">

                            <div class="project-form-group">

                                <label for="company_id">
                                    شرکت عضو

                                    <span class="project-required">
                                        *
                                    </span>
                                </label>

                                <select name="company_id"
                                        id="company_id"
                                        class="form-control project-form-control
                                        @error('company_id') is-invalid @enderror">

                                    <option value="">
                                        شرکت موردنظر را انتخاب کنید
                                    </option>

                                    @foreach($companies as $company)

                                        <option value="{{ $company->id }}"
                                            {{ (string) old(
                                                'company_id',
                                                $project->company_id
                                            ) === (string) $company->id
                                                ? 'selected'
                                                : ''
                                            }}>

                                            {{ $companyDisplayName($company) }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('company_id')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- نام پروژه --}}
                        <div class="col-xl-6 col-lg-6 col-md-12">

                            <div class="project-form-group">

                                <label for="project_name">
                                    نام پروژه

                                    <span class="project-required">
                                        *
                                    </span>
                                </label>

                                <input type="text"
                                       name="project_name"
                                       id="project_name"
                                       value="{{ old(
                                           'project_name',
                                           $project->project_name
                                       ) }}"
                                       class="form-control project-form-control
                                       @error('project_name') is-invalid @enderror"
                                       placeholder="نام کامل پروژه را وارد کنید">

                                @error('project_name')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- کارفرما --}}
                        <div class="col-xl-6 col-lg-6 col-md-12">

                            <div class="project-form-group">

                                <label for="employer">
                                    کارفرما
                                </label>

                                <input type="text"
                                       name="employer"
                                       id="employer"
                                       value="{{ old(
                                           'employer',
                                           $project->employer
                                       ) }}"
                                       class="form-control project-form-control
                                       @error('employer') is-invalid @enderror"
                                       placeholder="نام کارفرمای پروژه">

                                @error('employer')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- تاریخ شروع --}}
                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="project-form-group">

                                <label for="start_date">
                                    تاریخ شروع
                                </label>

                                <input type="text"
                                       name="start_date"
                                       id="start_date"
                                       value="{{ old(
                                           'start_date',
                                           $startDate
                                       ) }}"
                                       class="form-control project-form-control persian-date-input
                                       @error('start_date') is-invalid @enderror"
                                       placeholder="مثلاً 1405/05/12"
                                       autocomplete="off">

                                <span class="project-field-help">
                                    تاریخ را به‌صورت شمسی وارد کنید.
                                </span>

                                @error('start_date')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- تاریخ پایان --}}
                        <div class="col-xl-3 col-lg-3 col-md-6">

                            <div class="project-form-group">

                                <label for="end_date">
                                    تاریخ پایان
                                </label>

                                <input type="text"
                                       name="end_date"
                                       id="end_date"
                                       value="{{ old(
                                           'end_date',
                                           $endDate
                                       ) }}"
                                       class="form-control project-form-control persian-date-input
                                       @error('end_date') is-invalid @enderror"
                                       placeholder="مثلاً 1406/08/20"
                                       autocomplete="off">

                                <span class="project-field-help">
                                    برای پروژه در حال اجرا خالی بگذارید.
                                </span>

                                @error('end_date')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                        {{-- شرح خدمات --}}
                        <div class="col-12">

                            <div class="project-form-group mb-0">

                                <label for="service_description">
                                    شرح خدمات
                                </label>

                                <textarea name="service_description"
                                          id="service_description"
                                          class="form-control project-form-control
                                          @error('service_description') is-invalid @enderror"
                                          placeholder="خدمات پروژه را توضیح دهید...">{{ old(
                                              'service_description',
                                              $project->service_description
                                          ) }}</textarea>

                                @error('service_description')
                                <span class="project-error">
                                        {{ $message }}
                                    </span>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

                <div class="project-form-footer d-flex align-items-center justify-content-end">

                    <a href="{{ route('admin.company-projects.index') }}"
                       class="btn btn-outline-secondary project-cancel-btn ml-2">

                        انصراف
                    </a>

                    <button type="submit"
                            class="btn btn-primary project-submit-btn">

                        <i class="fa fa-check ml-2"></i>
                        ذخیره تغییرات
                    </button>

                </div>

            </div>

        </form>

    </div>

@endsection
