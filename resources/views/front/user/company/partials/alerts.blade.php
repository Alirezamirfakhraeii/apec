@if(session('success'))
    <div class="company-edit-alert company-edit-alert--success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="company-edit-alert company-edit-alert--danger">
        <strong>ذخیره انجام نشد.</strong>
        لطفاً فیلدهای مشخص‌شده را بررسی کنید.
    </div>
@endif
