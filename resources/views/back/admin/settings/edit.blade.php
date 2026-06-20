@extends('back.admin.layouts.master')

@section('content')

<div class="container-fluid mt-4" dir="rtl" style="text-align: right;">
    <div class="card border-0 shadow-sm rounded-lg bg-white p-4">

        <div class="d-flex align-items-center mb-4 pb-2 border-bottom">
            <h5 class="font-weight-bold text-dark mb-0">
                <i class="fa fa-cogs ml-2 text-success"></i> تنظیمات و مدیریت فوتر سایت
            </h5>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 rounded-lg font_12 p-3 mb-4">
                <i class="fa fa-check-circle ml-2"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-12 mb-4">
                    <label class="form-label font_12 font-weight-bold text-secondary mb-2">متن کپی‌رایت فوتر</label>
                    <textarea name="copyright" rows="3" class="form-control font_12 rounded-lg p-3" placeholder="متن کپی‌رایت پایین سایت را اینجا بنویسید...">{{ old('copyright', $settings->copyright) }}</textarea>
                    @error('copyright') <span class="text-danger font_10 d-block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label font_12 font-weight-bold text-secondary mb-1.5">لینک تلگرام</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-left-0 rounded-right-lg"><i class="fab fa-telegram-plane text-muted"></i></span>
                        <input type="text" name="telegram" class="form-control bg-light font_12 rounded-left-lg text-left" value="{{ old('telegram', $settings->telegram) }}" placeholder="https://t.me/username" dir="ltr">
                    </div>
                </div>

                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label font_12 font-weight-bold text-secondary mb-1.5">لینک اینستاگرام</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-left-0 rounded-right-lg"><i class="fab fa-instagram text-muted"></i></span>
                        <input type="text" name="instagram" class="form-control bg-light font_12 rounded-left-lg text-left" value="{{ old('instagram', $settings->instagram) }}" placeholder="https://instagram.com/username" dir="ltr">
                    </div>
                </div>

                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label font_12 font-weight-bold text-secondary mb-1.5">لینک توییتر (X)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-left-0 rounded-right-lg"><i class="fab fa-twitter text-muted"></i></span>
                        <input type="text" name="twitter" class="form-control bg-light font_12 rounded-left-lg text-left" value="{{ old('twitter', $settings->twitter) }}" placeholder="https://twitter.com/username" dir="ltr">
                    </div>
                </div>

                <div class="col-md-6 col-12 mb-4">
                    <label class="form-label font_12 font-weight-bold text-secondary mb-1.5">لینک واتس‌اپ</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-left-0 rounded-right-lg"><i class="fab fa-whatsapp text-muted"></i></span>
                        <input type="text" name="whatsapp" class="form-control bg-light font_12 rounded-left-lg text-left" value="{{ old('whatsapp', $settings->whatsapp) }}" placeholder="https://wa.me/number" dir="ltr">
                    </div>
                </div>

                <div class="col-12 text-left">
                    <button type="submit" class="btn btn-success font_12 fw-bold px-4 py-2.5 rounded-lg shadow-sm">
                        <i class="fa fa-save ml-1"></i> ذخیره و بروزرسانی فوتر
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
