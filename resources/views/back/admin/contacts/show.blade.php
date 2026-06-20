@extends('back.admin.layouts.master')

@section('content')
    <div class="container-fluid mt-4" dir="rtl" style="text-align: right;">

        <div class="mb-3">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 font_12">
                <i class="fa fa-arrow-right ml-1"></i> بازگشت به لیست پیام‌ها
            </a>
        </div>

        <div class="row">
            <div class="col-lg-4 col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-lg bg-dark text-white p-4" style="min-height: 350px;">
                    <h5 class="font-weight-bold h6 text-success border-bottom pb-2 mb-3" style="border-color: rgba(255,255,255,0.1) !important;">
                        <i class="fa fa-user-circle ml-2"></i> اطلاعات فرستنده
                    </h5>

                    <div class="d-flex flex-column" style="gap: 15px;">
                        <div>
                            <span class="d-block font_11 text-white-50">نام و نام خانوادگی:</span>
                            <span class="font_13 font-weight-bold text-white">{{ $contact->name }}</span>
                        </div>

                        <div>
                            <span class="d-block font_11 text-white-50">پل ارتباطی (ایمیل / موبایل):</span>
                            <span class="font_13 text-white" dir="ltr">{{ $contact->contact }}</span>
                        </div>

                        <div>
                            <span class="d-block font_11 text-white-50">آی‌پی فرستنده (IP):</span>
                            <span class="font_12 text-white-50" dir="ltr">{{ $contact->ip ?? 'نامشخص' }}</span>
                        </div>

                        <div>
                            <span class="d-block font_11 text-white-50">تاریخ و ساعت ارسال:</span>
                            <span class="font_12 text-white">{{ jdate($contact->created_at)->format('Y/m/d - H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-12 mb-4">
                <div class="card border-0 shadow-sm rounded-lg bg-white p-4" style="min-height: 350px;">
                    <h5 class="font-weight-bold h6 text-dark border-bottom pb-2 mb-3" style="border-color: #e5e7eb !important;">
                        <i class="fa fa-envelope-open ml-2 text-success"></i> محتوای پیام کاربر
                    </h5>

                    <div class="mb-3">
                    <span class="badge bg-light text-secondary font_11 px-2.5 py-1.5 border rounded">
                        موضوع: {{ $contact->subject ?? 'بدون موضوع' }}
                    </span>
                    </div>

                    <div class="p-3 bg-light rounded-lg border font_13 text-dark line-height-text text-justify" style="white-space: pre-line; background-color: #f9fafb !important;">
                        {{ $contact->message }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection('content')
