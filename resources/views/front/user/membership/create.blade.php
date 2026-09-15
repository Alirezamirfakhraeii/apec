@extends('front.user.layouts.app')
@section('title','شروع درخواست عضویت')
@section('styles')
    <link rel="stylesheet" href="{{ asset('front/css/membership/style.css') }}">
@endsection
@section('content')
    <div class="membership-form-page">
        <div class="membership-form-header">
            <div><h1>درخواست عضویت</h1>
                <p>برای شروع، اطلاعات اولیه شرکت و نماینده را وارد کنید.</p></div>
        </div>
        <div id="membership-intake-error" class="membership-alert membership-alert--error" style="display:none;"></div>
        <div class="membership-form-card">
            <div class="membership-form-card__header"><span class="membership-step-badge">شروع</span>
                <div><h2>اطلاعات اولیه</h2>
                    <p>پس از ثبت این اطلاعات وارد مراحل اصلی فرم می‌شوید.</p></div>
            </div>
            <form id="membership-intake-form" action="{{ route('user.membership.intake.store') }}" method="POST">@csrf
                <div class="membership-form-grid">
                    <div class="membership-form-group"><label for="intake_company_name">نام شرکت
                            <span>*</span></label><input type="text" id="intake_company_name" name="intake_company_name"
                                                         value="{{ old('intake_company_name',$application?->intake_company_name) }}"><span
                            class="membership-field-error" data-error="intake_company_name"></span></div>
                    <div class="membership-form-group"><label for="representative_name">نام نماینده شرکت <span>*</span></label><input
                            type="text" id="representative_name" name="representative_name"
                            value="{{ old('representative_name',$application?->representative_name ?? auth()->user()->name) }}"><span
                            class="membership-field-error" data-error="representative_name"></span></div>
                    <div class="membership-form-group"><label for="representative_mobile">شماره تماس نماینده
                            <span>*</span></label><input type="text" id="representative_mobile"
                                                         name="representative_mobile" inputmode="numeric"
                                                         value="{{ old('representative_mobile',$application?->representative_mobile) }}"
                                                         placeholder="09121234567"><span class="membership-field-error"
                                                                                         data-error="representative_mobile"></span>
                    </div>
                </div>
                <div class="membership-form-actions">
                    <button type="submit" id="membership-intake-submit" class="membership-primary-button">ثبت و ادامه
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('membership-intake-form'),
                button = document.getElementById('membership-intake-submit'),
                generalError = document.getElementById('membership-intake-error');
            if (!form) return;

            function clearErrors() {
                document.querySelectorAll('[data-error]').forEach(e => e.textContent = '');
                generalError.style.display = 'none';
                generalError.textContent = '';
            }

            function showErrors(errors) {
                Object.entries(errors).forEach(([field, messages]) => {
                    const e = document.querySelector(`[data-error="${field}"]`);
                    if (e) e.textContent = messages[0];
                });
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();
                clearErrors();
                button.disabled = true;
                button.textContent = 'در حال ثبت...';
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'},
                        body: new FormData(form)
                    });
                    const data = await response.json();
                    if (response.status === 422) {
                        showErrors(data.errors ?? {});
                        return;
                    }
                    if (!response.ok) throw new Error();
                    if (data.redirect) {
                        window.location.href = data.redirect;
                        return;
                    }
                } catch (error) {
                    console.error(error);
                    generalError.textContent = 'در ثبت اطلاعات مشکلی پیش آمد. لطفاً دوباره تلاش کنید.';
                    generalError.style.display = 'block';
                } finally {
                    button.disabled = false;
                    button.textContent = 'ثبت و ادامه';
                }
            });
        });
    </script>
@endpush
