@extends('back.admin.layouts.master')

@section('content')
<div class="container-fluid mt-4" dir="rtl" style="text-align: right;">
    <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="font-weight-bold text-dark mb-0">
                <i class="fa fa-envelope ml-2 text-success"></i> پیام‌های دریافتی کاربران
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                    <tr>
                        <th class="border-0 py-3 font_13">#</th>
                        <th class="border-0 py-3 font_13">نام فرستنده</th>
                        <th class="border-0 py-3 font_13">پل ارتباطی (ایمیل/موبایل)</th>
                        <th class="border-0 py-3 font_13">موضوع پیام</th>
                        <th class="border-0 py-3 font_13">تاریخ ارسال</th>
                        <th class="border-0 py-3 font_13 text-center">عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($messages as $msg)
                        <tr>
                            <td class="font_12">{{ $msg->id }}</td>
                            <td class="font_12 font-weight-bold text-dark">{{ $msg->name }}</td>
                            <td class="font_12" dir="ltr text-right">{{ $msg->contact }}</td>
                            <td class="font_12 text-muted">{{ $msg->subject ?? 'بدون موضوع' }}</td>
                            <td class="font_12">{{ jdate($msg->created_at)->format('Y/m/d H:i') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.contacts.show', $msg->id) }}" class="btn btn-sm btn-outline-success rounded-pill px-3 font_11">
                                    <i class="fa fa-eye ml-1"></i> مشاهده پیام
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted font_13">
                                <i class="fa fa-folder-open d-block mb-2 fa-2x text-light"></i>
                                هیچ پیامی تا این لحظه دریافت نشده است.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($messages->hasPages())
            <div class="card-footer bg-white d-flex justify-content-center py-3">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</div>
@endsection('content')
