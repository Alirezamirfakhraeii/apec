@php
    use App\Enums\ApplicationReviewDecision;
    use App\Enums\MembershipApplicationState;
    use App\Support\PersianDate;

    /*
    |--------------------------------------------------------------------------
    | Current User
    |--------------------------------------------------------------------------
    */

    $currentUser = auth()->user();


    /*
    |--------------------------------------------------------------------------
    | Can Review Current Stage
    |--------------------------------------------------------------------------
    */

    $canReviewCurrentStage =
        $application->state === MembershipApplicationState::InReview
        &&
        $application->currentStage
        &&
        $application->currentStage->required_permission
        &&
        $currentUser?->can(
            $application->currentStage->required_permission
        );


    /*
    |--------------------------------------------------------------------------
    | Final Stage
    |--------------------------------------------------------------------------
    */

    $isFinalReviewStage =
        (bool) $application->currentStage?->is_final;


    /*
    |--------------------------------------------------------------------------
    | Submitted Date
    |--------------------------------------------------------------------------
    */

    $submittedDate = $application->submitted_at
        ? PersianDate::fromGregorian(
            $application
                ->submitted_at
                ->format('Y-m-d')
        )
        : null;


    /*
    |--------------------------------------------------------------------------
    | Closed Application
    |--------------------------------------------------------------------------
    */

    $isClosedApplication = in_array(
        $application->state,
        [
            MembershipApplicationState::Approved,
            MembershipApplicationState::Rejected,
        ],
        true
    );


    /*
    |--------------------------------------------------------------------------
    | Workflow Manager
    |--------------------------------------------------------------------------
    */

    $canManageWorkflow =
        $currentUser?->hasRole('admin')
        ||
        $currentUser?->can(
            'membership.application.manage'
        );

@endphp


@extends('back.admin.layouts.master')


@push('styles')

    <link
        rel="stylesheet"
        href="{{ asset('back/css/companies/index.css') }}"
    >


    <style>

        /*
        |--------------------------------------------------------------------------
        | Main Layout
        |--------------------------------------------------------------------------
        */

        .membership-detail-layout {
            display: grid;

            grid-template-columns:
                minmax(300px, 0.75fr)
                minmax(0, 2fr);

            grid-template-areas:
                "sidebar main";

            gap: 22px;

            align-items: start;
        }

        .membership-detail-main {
            grid-area: main;
            min-width: 0;
        }

        .membership-detail-sidebar {
            grid-area: sidebar;
            min-width: 0;
        }

        .membership-history-sticky {
            position: sticky;
            top: 95px;
        }


        /*
        |--------------------------------------------------------------------------
        | Cards
        |--------------------------------------------------------------------------
        */

        .membership-detail-card,
        .membership-summary-card,
        .membership-workflow-card,
        .membership-review-card {
            margin-bottom: 20px;
        }

        .membership-detail-body {
            padding: 20px 22px;
        }


        /*
        |--------------------------------------------------------------------------
        | Information Grid
        |--------------------------------------------------------------------------
        */

        .membership-show-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 14px;
        }

        .membership-info-item {
            padding: 15px 16px;

            border: 1px solid #edf0f4;
            border-radius: 12px;

            background: #fafbfc;
        }

        .membership-info-item span {
            display: block;

            margin-bottom: 6px;

            color: #8a93a3;

            font-size: 11px;
        }

        .membership-info-item strong {
            display: block;

            color: #1f2937;

            font-size: 13px;
            font-weight: 700;

            word-break: break-word;
        }

        .membership-info-span-3 {
            grid-column: 1 / -1;
        }


        /*
        |--------------------------------------------------------------------------
        | Current Stage
        |--------------------------------------------------------------------------
        */

        .membership-current-stage {
            padding: 17px;

            display: flex;
            align-items: center;

            gap: 13px;

            border: 1px solid #e4e7ec;
            border-radius: 14px;

            background: #ffffff;
        }

        .membership-stage-number {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #eef2ff;
            color: #4f46e5;

            font-weight: 800;
        }

        .membership-current-stage strong {
            display: block;

            margin-bottom: 4px;

            color: #1f2937;

            font-size: 13px;
        }

        .membership-current-stage span {
            color: #98a2b3;

            font-size: 11px;
        }


        /*
        |--------------------------------------------------------------------------
        | Documents
        |--------------------------------------------------------------------------
        */

        .membership-document-list {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 12px;
        }

        .membership-document-item {
            padding: 14px 16px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;

            border: 1px solid #edf0f4;
            border-radius: 12px;

            background: #ffffff;
        }

        .membership-document-info {
            min-width: 0;
        }

        .membership-document-info strong {
            display: block;

            margin-bottom: 4px;

            color: #344054;

            font-size: 12px;
        }

        .membership-document-info span {
            display: block;

            max-width: 260px;

            overflow: hidden;

            text-overflow: ellipsis;
            white-space: nowrap;

            color: #98a2b3;

            font-size: 11px;
        }

        .membership-document-btn {
            width: 36px;
            height: 36px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 9px;

            background: #eef2ff;
            color: #4f46e5;

            transition: .2s ease;
        }

        .membership-document-btn:hover {
            background: #4f46e5;
            color: #ffffff;
        }


        /*
        |--------------------------------------------------------------------------
        | Activity Tags
        |--------------------------------------------------------------------------
        */

        .membership-activity-tags {
            display: flex;
            flex-wrap: wrap;

            gap: 8px;

            margin-top: 16px;
        }

        .membership-activity-tags span {
            padding: 6px 10px;

            border-radius: 999px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 10px;
            font-weight: 700;
        }


        /*
        |--------------------------------------------------------------------------
        | Summary
        |--------------------------------------------------------------------------
        */

        .membership-summary-body,
        .membership-workflow-body,
        .membership-review-body {
            padding: 18px 20px;
        }

        .membership-summary-row {
            padding: 10px 0;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            border-bottom: 1px solid #f0f2f5;
        }

        .membership-summary-row:last-child {
            border-bottom: 0;
        }

        .membership-summary-row span {
            color: #98a2b3;

            font-size: 11px;
        }

        .membership-summary-row strong {
            color: #344054;

            font-size: 12px;

            text-align: left;
        }


        /*
        |--------------------------------------------------------------------------
        | Workflow
        |--------------------------------------------------------------------------
        */

        .membership-workflow-current {
            margin-bottom: 18px;
            padding: 14px;

            display: flex;
            align-items: center;

            gap: 11px;

            border: 1px solid #e4e7ec;
            border-radius: 11px;

            background: #f8fafc;
        }

        .membership-workflow-current-icon {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 16px;
        }

        .membership-workflow-current span {
            display: block;

            margin-bottom: 3px;

            color: #98a2b3;

            font-size: 10px;
        }

        .membership-workflow-current strong {
            display: block;

            color: #344054;

            font-size: 12px;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | Workflow Fields
        |--------------------------------------------------------------------------
        */

        .membership-workflow-field {
            margin-bottom: 15px;
        }

        .membership-workflow-field label {
            display: block;

            margin-bottom: 7px;

            color: #475467;

            font-size: 11px;
            font-weight: 700;
        }

        .membership-workflow-field .form-control {
            min-height: 42px;

            border: 1px solid #e2e7ee;
            border-radius: 9px;

            color: #344054;

            font-size: 12px;

            box-shadow: none;
        }

        .membership-workflow-field textarea.form-control {
            min-height: 100px;

            resize: vertical;

            line-height: 1.9;
        }

        .membership-workflow-field .form-control:focus {
            border-color: #a5b4fc;

            box-shadow:
                0 0 0 3px
                rgba(99, 102, 241, .10);
        }

        .membership-workflow-error {
            display: block;

            margin-top: 6px;

            color: #dc2626;

            font-size: 10px;
        }

        .membership-workflow-help {
            display: block;

            margin-top: 6px;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.8;
        }


        /*
        |--------------------------------------------------------------------------
        | Workflow Buttons
        |--------------------------------------------------------------------------
        */

        .membership-workflow-submit,
        .membership-status-update-submit {
            width: 100%;

            padding: 11px 14px;

            border: 0;
            border-radius: 9px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            color: #ffffff;

            font-size: 12px;
            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }

        .membership-workflow-submit {
            background: #4f46e5;
        }

        .membership-workflow-submit:hover {
            background: #4338ca;
        }

        .membership-status-update-submit {
            background: #111827;
        }

        .membership-status-update-submit:hover {
            background: #000000;
        }


        /*
        |--------------------------------------------------------------------------
        | Reviewer Card
        |--------------------------------------------------------------------------
        */

        .membership-review-banner {
            margin-bottom: 17px;
            padding: 13px 14px;

            display: flex;
            align-items: center;

            gap: 11px;

            border: 1px solid #dbeafe;
            border-radius: 11px;

            background: #eff6ff;
        }

        .membership-review-banner-icon {
            width: 38px;
            height: 38px;

            flex-shrink: 0;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #dbeafe;
            color: #2563eb;

            font-size: 16px;
        }

        .membership-review-banner span {
            display: block;

            margin-bottom: 3px;

            color: #64748b;

            font-size: 10px;
        }

        .membership-review-banner strong {
            display: block;

            color: #1e3a8a;

            font-size: 12px;
            font-weight: 800;
        }


        /*
        |--------------------------------------------------------------------------
        | Final Review Warning
        |--------------------------------------------------------------------------
        */

        .membership-final-review-notice {
            margin-bottom: 16px;
            padding: 12px 13px;

            border: 1px solid #bbf7d0;
            border-radius: 10px;

            background: #f0fdf4;
        }

        .membership-final-review-notice strong {
            display: block;

            margin-bottom: 4px;

            color: #166534;

            font-size: 11px;
        }

        .membership-final-review-notice span {
            display: block;

            color: #4b5563;

            font-size: 10px;

            line-height: 1.8;
        }


        /*
        |--------------------------------------------------------------------------
        | Reviewer Buttons
        |--------------------------------------------------------------------------
        */

        .membership-review-actions {
            display: grid;

            gap: 9px;
        }

        .membership-review-btn {
            width: 100%;

            padding: 11px 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            border-radius: 9px;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;

            transition: .2s ease;
        }

        .membership-review-btn i {
            font-size: 13px;
        }


        /*
        | Approve
        */

        .membership-review-approve {
            border: 1px solid #16a34a;

            background: #16a34a;
            color: #ffffff;
        }

        .membership-review-approve:hover {
            border-color: #15803d;

            background: #15803d;
            color: #ffffff;
        }


        /*
        | Correction
        */

        .membership-review-correction {
            border: 1px solid #fed7aa;

            background: #fff7ed;
            color: #c2410c;
        }

        .membership-review-correction:hover {
            border-color: #fdba74;

            background: #ffedd5;
            color: #9a3412;
        }


        /*
        | Reject
        */

        .membership-review-reject {
            border: 1px solid #fecaca;

            background: #fef2f2;
            color: #dc2626;
        }

        .membership-review-reject:hover {
            border-color: #fca5a5;

            background: #fee2e2;
            color: #b91c1c;
        }


        /*
        |--------------------------------------------------------------------------
        | Locked Workflow
        |--------------------------------------------------------------------------
        */

        .membership-workflow-locked {
            padding: 15px;

            border: 1px solid #e4e7ec;
            border-radius: 11px;

            background: #f8fafc;

            text-align: center;
        }

        .membership-workflow-locked-icon {
            width: 42px;
            height: 42px;

            margin: 0 auto 9px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #f2f4f7;
            color: #667085;

            font-size: 16px;
        }

        .membership-workflow-locked strong {
            display: block;

            margin-bottom: 4px;

            color: #344054;

            font-size: 12px;
        }

        .membership-workflow-locked p {
            margin: 0;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.8;
        }


        /*
        |--------------------------------------------------------------------------
        | Manual Status Correction
        |--------------------------------------------------------------------------
        */

        .membership-status-edit-trigger {
            margin-top: 14px;
            padding: 0;

            border: 0;

            background: transparent;

            color: #4f46e5;

            font-size: 11px;
            font-weight: 700;

            cursor: pointer;
        }

        .membership-status-edit-trigger:hover {
            color: #3730a3;
        }

        .membership-status-edit-form {
            display: none;

            margin-top: 12px;
            padding: 15px;

            border: 1px solid #e4e7ec;
            border-radius: 11px;

            background: #ffffff;
        }

        .membership-status-edit-form.is-open {
            display: block;
        }

        .membership-status-edit-header {
            margin-bottom: 17px;
            padding-bottom: 13px;

            border-bottom: 1px solid #eef1f5;
        }

        .membership-status-edit-header strong {
            display: block;

            margin-bottom: 4px;

            color: #344054;

            font-size: 12px;
            font-weight: 800;
        }

        .membership-status-edit-header span {
            display: block;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.7;
        }


        /*
        |--------------------------------------------------------------------------
        | History
        |--------------------------------------------------------------------------
        */

        .membership-history-list {
            padding: 22px 24px 22px 18px;
        }

        .membership-history-item {
            position: relative;

            padding:
                0
                30px
                24px
                0;

            border-right:
                2px solid #eef1f5;
        }

        .membership-history-item:last-child {
            padding-bottom: 0;
        }

        .membership-history-dot {
            position: absolute;

            right: -7px;
            top: 2px;

            width: 12px;
            height: 12px;

            border-radius: 50%;

            background: #4f46e5;

            border: 3px solid #eef2ff;
        }

        .membership-history-title {
            display: block;

            color: #344054;

            font-size: 12px;
            font-weight: 800;

            line-height: 1.8;
        }

        .membership-history-decision {
            display: inline-flex;

            margin-top: 7px;

            padding: 4px 9px;

            border-radius: 999px;

            background: #eef2ff;
            color: #4f46e5;

            font-size: 10px;
            font-weight: 700;
        }

        .membership-history-meta {
            margin-top: 7px;

            color: #98a2b3;

            font-size: 11px;

            line-height: 1.8;
        }

        .membership-history-comment {
            margin-top: 9px;

            padding: 10px 12px;

            border-radius: 9px;

            background: #f8fafc;

            color: #667085;

            font-size: 11px;

            line-height: 1.9;

            white-space: pre-line;
        }


        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1199px) {

            .membership-detail-layout {
                grid-template-columns:
                    minmax(270px, .8fr)
                    minmax(0, 1.7fr);
            }

            .membership-show-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }

            .membership-document-list {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 991px) {

            .membership-detail-layout {
                grid-template-columns: 1fr;

                grid-template-areas:
                    "main"
                    "sidebar";
            }

            .membership-history-sticky {
                position: static;
            }

        }


        @media (max-width: 576px) {

            .membership-show-grid {
                grid-template-columns: 1fr;
            }

            .membership-info-span-3 {
                grid-column: auto;
            }

            .membership-detail-body,
            .membership-summary-body,
            .membership-workflow-body,
            .membership-review-body {
                padding: 16px;
            }

        }

    </style>

@endpush


@section('content')

    <div class="company-admin-wrapper">


        {{-- =========================================================
            Page Header
        ========================================================== --}}

        <div class="company-page-header">

            <div class="company-page-heading">

                <span class="company-page-icon">
                    <i class="fa fa-file-text-o"></i>
                </span>


                <div>

                    <h1>
                        پرونده درخواست عضویت
                        #{{ $application->id }}
                    </h1>

                    <p>
                        مشاهده اطلاعات کامل درخواست ارسال‌شده توسط شرکت
                    </p>

                </div>

            </div>


            <div class="company-header-actions">

                @can(
                    'update',
                    $application
                )

                    <a
                        href="{{ route(
                            'admin.membership-applications.edit',
                            $application
                        ) }}"
                        class="company-create-btn"
                    >

                        <i class="fa fa-edit ml-1"></i>

                        ویرایش پرونده

                    </a>

                @endcan


                <a
                    href="{{ route(
                        'admin.membership-applications.index'
                    ) }}"
                    class="company-export-btn"
                >

                    <i class="fa fa-arrow-right ml-1"></i>

                    بازگشت به درخواست‌ها

                </a>

            </div>

        </div>


        {{-- =========================================================
            Messages
        ========================================================== --}}

        @if(session('success'))

            <div class="alert alert-success company-alert">

                <i class="fa fa-check-circle ml-2"></i>

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div class="alert alert-danger company-alert">

                <i class="fa fa-exclamation-circle ml-2"></i>

                {{ session('error') }}

            </div>

        @endif


        @error('application')

        <div class="alert alert-danger company-alert">

            <i class="fa fa-exclamation-circle ml-2"></i>

            {{ $message }}

        </div>

        @enderror


        {{-- =========================================================
            Main Layout
        ========================================================== --}}

        <div class="membership-detail-layout">


            {{-- =====================================================
                Main Content
            ====================================================== --}}

            <main class="membership-detail-main">


                {{-- =================================================
                    Status
                ================================================== --}}

                <div class="company-table-card membership-detail-card">

                    <div class="company-table-header">

                        <div>

                            <h2>

                                <i class="fa fa-info-circle ml-1"></i>

                                وضعیت پرونده

                            </h2>

                            <p>
                                وضعیت و مرحله فعلی فرآیند بررسی
                            </p>

                        </div>


                        @switch($application->state)

                            @case(
                                MembershipApplicationState::Approved
                            )

                                <span
                                    class="
                                        company-status
                                        company-status-active
                                    "
                                >
                                    تأیید شده
                                </span>

                                @break


                            @case(
                                MembershipApplicationState::InReview
                            )

                                <span
                                    class="
                                        company-status
                                        company-status-suspended
                                    "
                                >
                                    در حال بررسی
                                </span>

                                @break


                            @case(
                                MembershipApplicationState::NeedsCorrection
                            )

                                <span
                                    class="
                                        company-status
                                        company-status-cancelled
                                    "
                                >
                                    نیازمند اصلاح
                                </span>

                                @break


                            @case(
                                MembershipApplicationState::Rejected
                            )

                                <span
                                    class="
                                        company-status
                                        company-status-cancelled
                                    "
                                >
                                    رد شده
                                </span>

                                @break


                            @default

                                <span
                                    class="
                                        company-status
                                        company-status-unknown
                                    "
                                >
                                    {{
                                        $application
                                            ->state
                                            ->label()
                                    }}
                                </span>

                        @endswitch

                    </div>


                    <div class="membership-detail-body">

                        @if($application->currentStage)

                            <div class="membership-current-stage">

                                <span class="membership-stage-number">

                                    {{
                                        $application
                                            ->currentStage
                                            ->position
                                    }}

                                </span>


                                <div>

                                    <strong>

                                        {{
                                            $application
                                                ->currentStage
                                                ->name
                                        }}

                                    </strong>

                                    <span>
                                        مرحله فعلی بررسی درخواست
                                    </span>

                                </div>

                            </div>

                        @else

                            <span class="company-secondary-text">
                                مرحله فعالی برای این درخواست
                                ثبت نشده است.
                            </span>

                        @endif

                    </div>

                </div>


                {{-- =================================================
                    Application Fields
                ================================================== --}}

                @include(
                    'back.admin.membership-applications.partials.application-fields',
                    [
                        'application' => $application,
                        'mode' => 'show',
                    ]
                )

            </main>


            {{-- =====================================================
                Sidebar
            ====================================================== --}}

            <aside class="membership-detail-sidebar">

                <div class="membership-history-sticky">


                    {{-- =================================================
                        Summary
                    ================================================== --}}

                    <div class="company-table-card membership-summary-card">

                        <div class="company-table-header">

                            <div>

                                <h2>

                                    <i class="fa fa-info-circle ml-1"></i>

                                    خلاصه پرونده

                                </h2>

                            </div>

                        </div>


                        <div class="membership-summary-body">

                            <div class="membership-summary-row">

                                <span>
                                    شماره درخواست
                                </span>

                                <strong>
                                    #{{ $application->id }}
                                </strong>

                            </div>


                            <div class="membership-summary-row">

                                <span>
                                    وضعیت
                                </span>

                                <strong>
                                    {{
                                        $application
                                            ->state
                                            ->label()
                                    }}
                                </strong>

                            </div>


                            <div class="membership-summary-row">

                                <span>
                                    مرحله فعلی
                                </span>

                                <strong>
                                    {{
                                        $application
                                            ->currentStage?->name
                                        ?: '—'
                                    }}
                                </strong>

                            </div>


                            <div class="membership-summary-row">

                                <span>
                                    تاریخ ارسال
                                </span>

                                <strong>
                                    {{ $submittedDate ?: '—' }}
                                </strong>

                            </div>


                            <div class="membership-summary-row">

                                <span>
                                    تعداد مدارک
                                </span>

                                <strong>
                                    {{
                                        $application
                                            ->documents
                                            ->count()
                                    }}
                                </strong>

                            </div>


                            <div class="membership-summary-row">

                                <span>
                                    تعداد سهامداران
                                </span>

                                <strong>
                                    {{
                                        $application
                                            ->shareholders
                                            ->count()
                                    }}
                                </strong>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        Reviewer Decision
                    ================================================== --}}

                    @if($canReviewCurrentStage)

                        <div
                            class="
                                company-table-card
                                membership-review-card
                            "
                        >

                            <div class="company-table-header">

                                <div>

                                    <h2>

                                        <i
                                            class="
                                                fa
                                                fa-check-square-o
                                                ml-1
                                            "
                                        ></i>

                                        بررسی پرونده

                                    </h2>


                                    <p>

                                        @if($isFinalReviewStage)

                                            تصمیم نهایی عضویت شرکت

                                        @else

                                            ثبت نتیجه بررسی این مرحله

                                        @endif

                                    </p>

                                </div>

                            </div>


                            <div class="membership-review-body">


                                {{-- Current Reviewer Stage --}}

                                <div class="membership-review-banner">

                                    <span
                                        class="
                                            membership-review-banner-icon
                                        "
                                    >

                                        <i
                                            class="
                                                fa
                                                fa-user-circle-o
                                            "
                                        ></i>

                                    </span>


                                    <div>

                                        <span>
                                            مسئول بررسی فعلی
                                        </span>

                                        <strong>
                                            {{
                                                $application
                                                    ->currentStage
                                                    ->name
                                            }}
                                        </strong>

                                    </div>

                                </div>


                                {{-- Final Stage Notice --}}

                                @if($isFinalReviewStage)

                                    <div
                                        class="
                                            membership-final-review-notice
                                        "
                                    >

                                        <strong>

                                            <i
                                                class="
                                                    fa
                                                    fa-check-circle
                                                    ml-1
                                                "
                                            ></i>

                                            مرحله تأیید نهایی

                                        </strong>


                                        <span>

                                            با تأیید این پرونده،
                                            عضویت شرکت نهایی شده و
                                            اطلاعات شرکت وارد اطلاعات
                                            رسمی اعضای انجمن خواهد شد.

                                        </span>

                                    </div>

                                @endif


                                {{-- Review Form --}}

                                <form
                                    action="{{ route(
                                        'admin.membership-applications.review',
                                        $application
                                    ) }}"
                                    method="POST"
                                    id="membership-review-form"
                                >

                                    @csrf


                                    {{-- Comment --}}

                                    <div class="membership-workflow-field">

                                        <label for="review_comment">
                                            توضیحات بررسی
                                        </label>


                                        <textarea
                                            name="comment"
                                            id="review_comment"
                                            class="form-control"
                                            rows="5"
                                            placeholder="توضیحات مربوط به بررسی این پرونده را وارد کنید..."
                                        >{{ old('comment') }}</textarea>


                                        @error('comment')

                                        <span
                                            class="
                                                    membership-workflow-error
                                                "
                                        >
                                                {{ $message }}
                                            </span>

                                        @enderror


                                        <span
                                            class="
                                                membership-workflow-help
                                            "
                                        >

                                            برای «نیازمند اصلاح»
                                            و «رد درخواست»،
                                            ثبت توضیحات الزامی است.

                                        </span>

                                    </div>


                                    @error('decision')

                                    <span
                                        class="
                                                membership-workflow-error
                                            "
                                        style="
                                                display:block;
                                                margin-bottom:12px;
                                            "
                                    >
                                            {{ $message }}
                                        </span>

                                    @enderror


                                    {{-- Actions --}}

                                    <div class="membership-review-actions">


                                        {{-- Approve --}}

                                        <button
                                            type="submit"
                                            name="decision"
                                            value="{{
                                                ApplicationReviewDecision
                                                    ::Approved
                                                    ->value
                                            }}"
                                            class="
                                                membership-review-btn
                                                membership-review-approve
                                            "
                                            onclick="
                                                return confirmReviewApproval(
                                                    {{
                                                        $isFinalReviewStage
                                                            ? 'true'
                                                            : 'false'
                                                    }}
                                                );
                                            "
                                        >

                                            <i class="fa fa-check"></i>


                                            @if($isFinalReviewStage)

                                                تأیید نهایی عضویت

                                            @else

                                                تأیید و ارسال به مرحله بعد

                                            @endif

                                        </button>


                                        {{-- Needs Correction --}}

                                        <button
                                            type="submit"
                                            name="decision"
                                            value="{{
                                                ApplicationReviewDecision
                                                    ::NeedsCorrection
                                                    ->value
                                            }}"
                                            class="
                                                membership-review-btn
                                                membership-review-correction
                                            "
                                            onclick="
                                                return validateReviewComment(
                                                    'برای درخواست اصلاح، توضیحات را وارد کنید.'
                                                );
                                            "
                                        >

                                            <i
                                                class="
                                                    fa
                                                    fa-pencil-square-o
                                                "
                                            ></i>

                                            نیازمند اصلاح

                                        </button>


                                        {{-- Reject --}}

                                        <button
                                            type="submit"
                                            name="decision"
                                            value="{{
                                                ApplicationReviewDecision
                                                    ::Rejected
                                                    ->value
                                            }}"
                                            class="
                                                membership-review-btn
                                                membership-review-reject
                                            "
                                            onclick="
                                                return validateReviewComment(
                                                    'برای رد درخواست، دلیل رد را وارد کنید.'
                                                );
                                            "
                                        >

                                            <i class="fa fa-times"></i>

                                            رد درخواست

                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        Admin Workflow Management
                    ================================================== --}}

                    @if($canManageWorkflow)

                        <div
                            class="
                                company-table-card
                                membership-workflow-card
                            "
                        >

                            <div class="company-table-header">

                                <div>

                                    <h2>

                                        <i class="fa fa-random ml-1"></i>

                                        مدیریت گردش پرونده

                                    </h2>

                                    <p>
                                        ارجاع درخواست به واحد بررسی
                                    </p>

                                </div>

                            </div>


                            <div class="membership-workflow-body">


                                <div class="membership-workflow-current">

                                    <span
                                        class="
                                            membership-workflow-current-icon
                                        "
                                    >

                                        <i
                                            class="
                                                fa
                                                fa-user-circle-o
                                            "
                                        ></i>

                                    </span>


                                    <div>

                                        <span>
                                            پرونده در حال حاضر در اختیار
                                        </span>

                                        <strong>
                                            {{
                                                $application
                                                    ->currentStage?->name
                                                ?: 'بدون مرحله'
                                            }}
                                        </strong>

                                    </div>

                                </div>


                                @if($isClosedApplication)


                                    {{-- =========================================
                                        Closed Workflow
                                    ========================================== --}}

                                    <div class="membership-workflow-locked">

                                        <span
                                            class="
                                                membership-workflow-locked-icon
                                            "
                                        >
                                            <i class="fa fa-lock"></i>
                                        </span>


                                        <strong>
                                            گردش پرونده بسته شده است
                                        </strong>


                                        <p>

                                            این درخواست

                                            {{
                                                $application->state ===
                                                MembershipApplicationState::Approved
                                                    ? 'تأیید نهایی شده'
                                                    : 'رد شده'
                                            }}

                                            و گردش عادی پرونده متوقف شده است.

                                        </p>


                                        <button
                                            type="button"
                                            class="
                                                membership-status-edit-trigger
                                            "
                                            onclick="
                                                document
                                                    .getElementById(
                                                        'membership-status-edit-form'
                                                    )
                                                    .classList
                                                    .toggle('is-open');
                                            "
                                        >

                                            <i class="fa fa-pencil ml-1"></i>

                                            نیازمند اصلاح وضعیت؟

                                        </button>

                                    </div>


                                    {{-- =========================================
                                        Manual Status Update
                                    ========================================== --}}

                                    <div
                                        id="membership-status-edit-form"
                                        class="
                                            membership-status-edit-form

                                            {{
                                                $errors->has('state')
                                                ||
                                                $errors->has('stage_id')
                                                ||
                                                $errors->has('comment')
                                                    ? 'is-open'
                                                    : ''
                                            }}
                                        "
                                    >

                                        <div
                                            class="
                                                membership-status-edit-header
                                            "
                                        >

                                            <strong>
                                                اصلاح دستی وضعیت پرونده
                                            </strong>

                                            <span>
                                                این عملیات در تاریخچه
                                                پرونده ثبت می‌شود.
                                            </span>

                                        </div>


                                        <form
                                            action="{{ route(
                                                'admin.membership-applications.status.update',
                                                $application
                                            ) }}"
                                            method="POST"
                                            onsubmit="
                                                return confirm(
                                                    'آیا از تغییر وضعیت این پرونده اطمینان دارید؟'
                                                );
                                            "
                                        >

                                            @csrf

                                            @method('PATCH')


                                            {{-- State --}}

                                            <div
                                                class="
                                                    membership-workflow-field
                                                "
                                            >

                                                <label for="manual_state">
                                                    وضعیت جدید
                                                </label>


                                                <select
                                                    name="state"
                                                    id="manual_state"
                                                    class="form-control"
                                                    required
                                                    onchange="
                                                        toggleMembershipStageField(
                                                            this.value
                                                        )
                                                    "
                                                >

                                                    <option value="">
                                                        انتخاب وضعیت
                                                    </option>


                                                    <option
                                                        value="{{
                                                            MembershipApplicationState
                                                                ::InReview
                                                                ->value
                                                        }}"
                                                        @selected(
                                                            old('state')
                                                            ===
                                                            MembershipApplicationState
                                                                ::InReview
                                                                ->value
                                                        )
                                                    >
                                                        در حال بررسی
                                                    </option>


                                                    <option
                                                        value="{{
                                                            MembershipApplicationState
                                                                ::NeedsCorrection
                                                                ->value
                                                        }}"
                                                        @selected(
                                                            old('state')
                                                            ===
                                                            MembershipApplicationState
                                                                ::NeedsCorrection
                                                                ->value
                                                        )
                                                    >
                                                        نیازمند اصلاح
                                                    </option>


                                                    <option
                                                        value="{{
                                                            MembershipApplicationState
                                                                ::Rejected
                                                                ->value
                                                        }}"
                                                        @selected(
                                                            old('state')
                                                            ===
                                                            MembershipApplicationState
                                                                ::Rejected
                                                                ->value
                                                        )
                                                    >
                                                        رد شده
                                                    </option>


                                                    <option
                                                        value="{{
                                                            MembershipApplicationState
                                                                ::Approved
                                                                ->value
                                                        }}"
                                                        @selected(
                                                            old('state')
                                                            ===
                                                            MembershipApplicationState
                                                                ::Approved
                                                                ->value
                                                        )
                                                    >
                                                        تأیید شده
                                                    </option>

                                                </select>


                                                @error('state')

                                                <span
                                                    class="
                                                            membership-workflow-error
                                                        "
                                                >
                                                        {{ $message }}
                                                    </span>

                                                @enderror

                                            </div>


                                            {{-- Stage --}}

                                            <div
                                                id="manual-stage-wrapper"
                                                class="
                                                    membership-workflow-field
                                                "
                                                style="display:none;"
                                            >

                                                <label for="manual_stage_id">
                                                    مرحله پرونده
                                                </label>


                                                <select
                                                    name="stage_id"
                                                    id="manual_stage_id"
                                                    class="form-control"
                                                >

                                                    <option value="">
                                                        انتخاب مرحله
                                                    </option>


                                                    @foreach(
                                                        $workflowStages
                                                        as $stage
                                                    )

                                                        <option
                                                            value="{{ $stage->id }}"
                                                            @selected(
                                                                (string)
                                                                old('stage_id')
                                                                ===
                                                                (string)
                                                                $stage->id
                                                            )
                                                        >

                                                            مرحله
                                                            {{ $stage->position }}

                                                            -

                                                            {{ $stage->name }}

                                                        </option>

                                                    @endforeach

                                                </select>


                                                @error('stage_id')

                                                <span
                                                    class="
                                                            membership-workflow-error
                                                        "
                                                >
                                                        {{ $message }}
                                                    </span>

                                                @enderror

                                            </div>


                                            {{-- Comment --}}

                                            <div
                                                class="
                                                    membership-workflow-field
                                                "
                                            >

                                                <label for="status_comment">
                                                    علت اصلاح وضعیت
                                                </label>


                                                <textarea
                                                    name="comment"
                                                    id="status_comment"
                                                    class="form-control"
                                                    rows="4"
                                                    required
                                                >{{ old('comment') }}</textarea>


                                                @error('comment')

                                                <span
                                                    class="
                                                            membership-workflow-error
                                                        "
                                                >
                                                        {{ $message }}
                                                    </span>

                                                @enderror

                                            </div>


                                            <button
                                                type="submit"
                                                class="
                                                    membership-status-update-submit
                                                "
                                            >

                                                <i class="fa fa-save"></i>

                                                ثبت وضعیت جدید

                                            </button>

                                        </form>

                                    </div>

                                @else


                                    {{-- =========================================
                                        Route Application
                                    ========================================== --}}

                                    <form
                                        action="{{ route(
                                            'admin.membership-applications.route',
                                            $application
                                        ) }}"
                                        method="POST"
                                        onsubmit="
                                            return confirm(
                                                'آیا از ارجاع این پرونده به مرحله انتخاب‌شده اطمینان دارید؟'
                                            );
                                        "
                                    >

                                        @csrf


                                        <div
                                            class="
                                                membership-workflow-field
                                            "
                                        >

                                            <label for="stage_id">
                                                ارجاع پرونده به
                                            </label>


                                            <select
                                                name="stage_id"
                                                id="stage_id"
                                                class="form-control"
                                                required
                                            >

                                                <option value="">
                                                    انتخاب مرحله مقصد
                                                </option>


                                                @foreach(
                                                    $workflowStages
                                                    as $stage
                                                )

                                                    <option
                                                        value="{{ $stage->id }}"

                                                        @selected(
                                                            (string)
                                                            old('stage_id')
                                                            ===
                                                            (string)
                                                            $stage->id
                                                        )

                                                        @disabled(
                                                            $application
                                                                ->current_stage_id
                                                            ===
                                                            $stage->id
                                                        )
                                                    >

                                                        مرحله
                                                        {{ $stage->position }}

                                                        -

                                                        {{ $stage->name }}


                                                        @if(
                                                            $application
                                                                ->current_stage_id
                                                            ===
                                                            $stage->id
                                                        )

                                                            (مرحله فعلی)

                                                        @endif

                                                    </option>

                                                @endforeach

                                            </select>


                                            @error('stage_id')

                                            <span
                                                class="
                                                        membership-workflow-error
                                                    "
                                            >
                                                    {{ $message }}
                                                </span>

                                            @enderror

                                        </div>


                                        <div
                                            class="
                                                membership-workflow-field
                                            "
                                        >

                                            <label for="route_comment">
                                                توضیحات ارجاع
                                            </label>


                                            <textarea
                                                name="comment"
                                                id="route_comment"
                                                class="form-control"
                                                rows="4"
                                                placeholder="مثلاً: لطفاً مدارک ثبتی و روزنامه رسمی بررسی شود."
                                            >{{ old('comment') }}</textarea>


                                            @error('comment')

                                            <span
                                                class="
                                                        membership-workflow-error
                                                    "
                                            >
                                                    {{ $message }}
                                                </span>

                                            @enderror

                                        </div>


                                        <button
                                            type="submit"
                                            class="
                                                membership-workflow-submit
                                            "
                                        >

                                            <i class="fa fa-share"></i>

                                            ارجاع پرونده

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    @endif


                    {{-- =================================================
                        Review History
                    ================================================== --}}

                    <div class="company-table-card">

                        <div class="company-table-header">

                            <div>

                                <h2>

                                    <i class="fa fa-history ml-1"></i>

                                    تاریخچه بررسی

                                </h2>

                                <p>
                                    روند تصمیم‌گیری روی پرونده
                                </p>

                            </div>

                        </div>


                        <div class="membership-history-list">

                            @forelse(
                                $application->reviews
                                as $review
                            )

                                <div class="membership-history-item">

                                    <span
                                        class="
                                            membership-history-dot
                                        "
                                    ></span>


                                    <span
                                        class="
                                            membership-history-title
                                        "
                                    >
                                        {{
                                            $review
                                                ->stage?->name
                                            ?: 'مرحله بررسی'
                                        }}
                                    </span>


                                    <span
                                        class="
                                            membership-history-decision
                                        "
                                    >
                                        {{
                                            $review
                                                ->decision
                                                ->label()
                                        }}
                                    </span>


                                    <div
                                        class="
                                            membership-history-meta
                                        "
                                    >

                                        بررسی‌کننده:

                                        {{
                                            $review
                                                ->reviewer?->name
                                            ?: 'سیستم'
                                        }}

                                    </div>


                                    @if($review->created_at)

                                        <div
                                            class="
                                                membership-history-meta
                                            "
                                        >

                                            تاریخ:

                                            {{
                                                PersianDate::fromGregorian(
                                                    $review
                                                        ->created_at
                                                        ->format('Y-m-d')
                                                )
                                            }}

                                            -

                                            {{
                                                $review
                                                    ->created_at
                                                    ->format('H:i')
                                            }}

                                        </div>

                                    @endif


                                    @if($review->comment)

                                        <div
                                            class="
                                                membership-history-comment
                                            "
                                        >
                                            {{ $review->comment }}
                                        </div>

                                    @endif

                                </div>

                            @empty

                                <div class="company-empty-state">

                                    <span class="company-empty-icon">

                                        <i class="fa fa-history"></i>

                                    </span>

                                    <h3>
                                        هنوز بررسی نشده است
                                    </h3>

                                    <p>
                                        اولین تصمیم روی این پرونده
                                        هنوز ثبت نشده است.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>


    {{-- =========================================================
        Scripts
    ========================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | Manual Status Stage
        |--------------------------------------------------------------------------
        */

        function toggleMembershipStageField(state) {

            const wrapper =
                document.getElementById(
                    'manual-stage-wrapper'
                );

            const select =
                document.getElementById(
                    'manual_stage_id'
                );


            if (! wrapper || ! select) {
                return;
            }


            const needsStage = [
                'in_review',
                'needs_correction'
            ].includes(state);


            wrapper.style.display =
                needsStage
                    ? 'block'
                    : 'none';


            select.required =
                needsStage;


            if (! needsStage) {
                select.value = '';
            }

        }


        /*
        |--------------------------------------------------------------------------
        | Validate Review Comment
        |--------------------------------------------------------------------------
        */

        function validateReviewComment(message) {

            const commentElement =
                document.getElementById(
                    'review_comment'
                );


            const comment =
                commentElement
                    ? commentElement.value.trim()
                    : '';


            if (! comment) {

                alert(message);

                if (commentElement) {
                    commentElement.focus();
                }

                return false;
            }


            return confirm(
                'آیا از ثبت این تصمیم اطمینان دارید؟'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Approve Confirmation
        |--------------------------------------------------------------------------
        */

        function confirmReviewApproval(
            isFinalStage
        ) {

            if (isFinalStage) {

                return confirm(
                    'با تأیید نهایی، شرکت به اعضای رسمی انجمن اضافه خواهد شد. آیا اطمینان دارید؟'
                );

            }


            return confirm(
                'پرونده تأیید و به مرحله بعد ارسال خواهد شد. آیا اطمینان دارید؟'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DOM Ready
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                const stateSelect =
                    document.getElementById(
                        'manual_state'
                    );


                if (stateSelect) {

                    toggleMembershipStageField(
                        stateSelect.value
                    );

                }

            }
        );

    </script>

@endsection
