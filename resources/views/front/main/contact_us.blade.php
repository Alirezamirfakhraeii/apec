<div class="contact-premium-section my-5" dir="rtl" id="contact-section">

    <div class="contact-premium-heading">
        <div>
            <span class="contact-premium-kicker">
                <i class="fa fa-envelope-open-text"></i>
                ارتباط با ما
            </span>

            <h2>صدای شما را می‌شنویم</h2>

            <p>
                برای ارسال پیشنهاد، انتقاد، درخواست همکاری یا ارتباط مستقیم با رادیو نفت و توسعه، از اطلاعات تماس یا فرم زیر استفاده کنید.
            </p>
        </div>

        <a href="tel:02188318701" class="contact-premium-call-btn">
            <i class="fa fa-phone"></i>
            تماس سریع
        </a>
    </div>

    <div class="row align-items-stretch">

        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
            <div class="contact-info-premium-card h-100">
                <div class="contact-info-glow contact-info-glow-one"></div>
                <div class="contact-info-glow contact-info-glow-two"></div>

                <div class="contact-info-content">
                    <span class="contact-info-badge">
                        <i class="fa fa-headset"></i>
                        راه‌های ارتباطی
                    </span>

                    <h3>اطلاعات تماس</h3>

                    <p>
                        برای ارتباط مستقیم با انجمن، می‌توانید از شماره تماس، واتساپ یا فرم پیام استفاده کنید. پیام‌های شما توسط تیم مربوطه بررسی خواهد شد.
                    </p>

                    <div class="contact-info-list">

                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fa fa-phone"></i>
                            </div>

                            <div>
                                <span>شماره تماس مستقیم</span>
                                <a href="tel:02188318701" dir="ltr">۰۲۱-۸۸۳۱۸۷۰۱</a>
                            </div>
                        </div>

                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>

                            <div>
                                <span>واتساپ انجمن</span>
                                <a href="https://wa.me/989122044158" target="_blank" dir="ltr">۰۹۱۲۲۰۴۴۱۵۸</a>
                            </div>
                        </div>

                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fa fa-fax"></i>
                            </div>

                            <div>
                                <span>فکس</span>
                                <strong dir="ltr">۰۲۱-۸۸۸۲۴۶۶۹</strong>
                            </div>
                        </div>

                        <div class="contact-info-row">
                            <div class="contact-info-icon">
                                <i class="fa fa-clock"></i>
                            </div>

                            <div>
                                <span>ساعات کاری</span>
                                <strong>روزهای کاری ۸:۳۰ الی ۱۶:۳۰</strong>
                            </div>
                        </div>

                        <div class="contact-info-row contact-address-row">
                            <div class="contact-info-icon">
                                <i class="fa fa-map-marker-alt"></i>
                            </div>

                            <div>
                                <span>دفتر مرکزی</span>
                                <strong>تهران، هفت تیر، خیابان کریمخان، خیابان خردمند شمالی، کوچه هجدهم، پلاک ۱۳</strong>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="contact-social-strip">
                    <span>ما را دنبال کنید</span>

                    <div>
                        <a href="https://x.com/irapec" target="_blank" title="توییتر">
                            <i class="fab fa-twitter"></i>
                        </a>

                        <a href="https://www.instagram.com/irapec_info?igsh=MXczdDBzN2Nia2J1eQ==" target="_blank" title="اینستاگرام">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="https://www.linkedin.com/in/apec-association?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank" title="لینکدین">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-12">
            <div class="contact-form-premium-card h-100">

                <div class="contact-form-header">
                    <div>
                        <span>فرم ارتباط مستقیم</span>
                        <h3>پیام خود را برای ما ارسال کنید</h3>
                    </div>

                    <div class="contact-form-icon">
                        <i class="fa fa-paper-plane"></i>
                    </div>
                </div>

                <p class="contact-form-description">
                    فرم زیر را تکمیل کنید؛ همکاران ما پیام شما را بررسی کرده و در سریع‌ترین زمان ممکن پاسخ خواهند داد.
                </p>

                @if(session('contact_success'))
                    <div class="contact-success-alert">
                        <i class="fa fa-check-circle"></i>
                        <span>{{ session('contact_success') }}</span>
                    </div>
                @endif

                <form action="{{ route('front.contact.store') }}" method="POST" id="front-contact-form" class="contact-premium-form">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 col-12 mb-3">
                            <label>
                                نام و نام خانوادگی
                                <span>*</span>
                            </label>

                            <div class="contact-input-wrap">
                                <i class="fa fa-user"></i>
                                <input type="text"
                                       name="name"
                                       class="@error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="مثال: علی علوی"
                                       required>
                            </div>

                            @error('name')
                            <small class="contact-error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12 mb-3">
                            <label>
                                شماره موبایل یا ایمیل
                                <span>*</span>
                            </label>

                            <div class="contact-input-wrap ltr-input-wrap">
                                <i class="fa fa-phone-alt"></i>
                                <input type="text"
                                       name="contact"
                                       class="@error('contact') is-invalid @enderror"
                                       value="{{ old('contact') }}"
                                       placeholder="09123456789 یا email@domain.com"
                                       required
                                       dir="ltr">
                            </div>

                            @error('contact')
                            <small class="contact-error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mb-3">
                            <label>موضوع پیام</label>

                            <div class="contact-input-wrap">
                                <i class="fa fa-question-circle"></i>
                                <input type="text"
                                       name="subject"
                                       class="@error('subject') is-invalid @enderror"
                                       value="{{ old('subject') }}"
                                       placeholder="موضوع درخواست یا پیشنهاد شما">
                            </div>

                            @error('subject')
                            <small class="contact-error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12 mb-4">
                            <label>
                                متن پیام
                                <span>*</span>
                            </label>

                            <div class="contact-textarea-wrap">
                                <textarea name="message"
                                          rows="5"
                                          class="@error('message') is-invalid @enderror"
                                          placeholder="پیام خود را در این قسمت بنویسید..."
                                          required>{{ old('message') }}</textarea>
                            </div>

                            @error('message')
                            <small class="contact-error-text">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="contact-form-footer">
                                <span>
                                    <i class="fa fa-lock"></i>
                                    اطلاعات شما نزد ما محفوظ است.
                                </span>

                                <button type="submit" class="contact-submit-premium-btn">
                                    ارسال پیام
                                    <i class="fa fa-arrow-left"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<style>
    .contact-premium-section,
    .contact-premium-section * {
        box-sizing: border-box;
    }

    .contact-premium-section {
        text-align: right;
    }

    .contact-premium-heading {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 24px;
        padding-bottom: 18px;
        border-bottom: 1px solid #e2e8f0;
    }

    .contact-premium-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        border-radius: 999px;
        background: #EEF2F8;
        color: #0F1D3D;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .contact-premium-heading h2 {
        margin: 0 0 8px;
        color: #0f172a;
        font-size: 24px;
        font-weight: 950;
        letter-spacing: -0.6px;
    }

    .contact-premium-heading p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.9;
        max-width: 680px;
    }

    .contact-premium-call-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-width: 118px;
        height: 42px;
        padding: 0 16px;
        border-radius: 15px;
        background: #0f172a;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        text-decoration: none;
        white-space: nowrap;
        box-shadow: 0 14px 32px rgba(15, 23, 42, 0.16);
        transition: 0.24s ease;
    }

    .contact-premium-call-btn:hover {
        background: #14254E;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .contact-info-premium-card {
        position: relative;
        overflow: hidden;
        min-height: 470px;
        padding: 28px;
        border-radius: 30px;
        background:
            radial-gradient(circle at 12% 10%, rgba(20, 37, 78, 0.22), transparent 32%),
            linear-gradient(135deg, #0f172a 0%, #172033 45%, #111827 100%);
        color: #ffffff;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.18);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .contact-info-glow {
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        filter: blur(2px);
    }

    .contact-info-glow-one {
        width: 230px;
        height: 230px;
        left: -95px;
        top: -95px;
        background: rgba(20, 37, 78, 0.14);
    }

    .contact-info-glow-two {
        width: 190px;
        height: 190px;
        right: -95px;
        bottom: -95px;
        background: rgba(37, 99, 235, 0.14);
    }

    .contact-info-content,
    .contact-social-strip {
        position: relative;
        z-index: 2;
    }

    .contact-info-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.09);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #C8D3E6;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .contact-info-premium-card h3 {
        margin: 0 0 10px;
        font-size: 21px;
        font-weight: 950;
        color: #ffffff;
    }

    .contact-info-premium-card p {
        margin: 0 0 24px;
        color: rgba(255, 255, 255, 0.66);
        font-size: 12px;
        line-height: 2;
    }

    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .contact-info-row {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 12px;
        border-radius: 18px;
        background: rgba(255, 255, 255, 0.055);
        border: 1px solid rgba(255, 255, 255, 0.08);
        transition: 0.24s ease;
    }

    .contact-info-row:hover {
        background: rgba(20, 37, 78, 0.11);
        border-color: rgba(20, 37, 78, 0.34);
        transform: translateX(-4px);
    }

    .contact-address-row {
        align-items: flex-start;
    }

    .contact-info-icon {
        width: 42px;
        height: 42px;
        border-radius: 15px;
        flex: 0 0 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.09);
        color: #8EA2C9;
    }

    .contact-info-row span {
        display: block;
        margin-bottom: 4px;
        color: rgba(255, 255, 255, 0.52);
        font-size: 10px;
    }

    .contact-info-row a,
    .contact-info-row strong {
        display: block;
        color: #ffffff;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.8;
        text-decoration: none;
    }

    .contact-info-row a:hover {
        color: #C8D3E6;
        text-decoration: none;
    }

    .contact-social-strip {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid rgba(255, 255, 255, 0.10);
    }

    .contact-social-strip > span {
        color: rgba(255, 255, 255, 0.56);
        font-size: 11px;
    }

    .contact-social-strip div {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-social-strip a {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.10);
        color: rgba(255, 255, 255, 0.72);
        text-decoration: none;
        transition: 0.22s ease;
    }

    .contact-social-strip a:hover {
        background: #14254E;
        border-color: #14254E;
        color: #ffffff;
        transform: translateY(-3px);
        text-decoration: none;
    }

    .contact-form-premium-card {
        min-height: 470px;
        padding: 28px;
        border-radius: 30px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.09);
    }

    .contact-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 8px;
    }

    .contact-form-header span {
        display: block;
        color: #14254E;
        font-size: 11px;
        font-weight: 850;
        margin-bottom: 6px;
    }

    .contact-form-header h3 {
        margin: 0;
        color: #0f172a;
        font-size: 21px;
        font-weight: 950;
    }

    .contact-form-icon {
        width: 52px;
        height: 52px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #EEF2F8;
        color: #14254E;
        font-size: 18px;
        flex: 0 0 52px;
    }

    .contact-form-description {
        margin: 0 0 20px;
        color: #64748b;
        font-size: 12px;
        line-height: 1.9;
    }

    .contact-success-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        padding: 13px 14px;
        border-radius: 16px;
        background: #EEF2F8;
        color: #0F1D3D;
        border: 1px solid #C8D3E6;
        font-size: 12px;
        font-weight: 750;
    }

    .contact-premium-form label {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 12px;
        font-weight: 850;
    }

    .contact-premium-form label span {
        color: #ef4444;
    }

    .contact-input-wrap,
    .contact-textarea-wrap {
        position: relative;
    }

    .contact-input-wrap i {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        z-index: 2;
    }

    .contact-input-wrap input,
    .contact-textarea-wrap textarea {
        width: 100%;
        border: 1px solid #e2e8f0;
        outline: 0;
        background: #f8fafc;
        color: #0f172a;
        font-size: 12px;
        transition: 0.22s ease;
    }

    .contact-input-wrap input {
        height: 47px;
        border-radius: 16px;
        padding: 0 42px 0 14px;
    }

    .ltr-input-wrap input {
        text-align: left;
        direction: ltr;
        padding-left: 14px;
        padding-right: 42px;
    }

    .contact-textarea-wrap textarea {
        min-height: 136px;
        resize: none;
        border-radius: 18px;
        padding: 14px;
        line-height: 1.9;
    }

    .contact-input-wrap input:focus,
    .contact-textarea-wrap textarea:focus {
        background: #ffffff;
        border-color: rgba(20, 37, 78, 0.70);
        box-shadow: 0 0 0 4px rgba(20, 37, 78, 0.10);
    }

    .contact-input-wrap input.is-invalid,
    .contact-textarea-wrap textarea.is-invalid {
        border-color: #ef4444;
        background: #fff7f7;
    }

    .contact-error-text {
        display: block;
        margin-top: 6px;
        color: #ef4444;
        font-size: 10px;
    }

    .contact-form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .contact-form-footer > span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #94a3b8;
        font-size: 11px;
    }

    .contact-submit-premium-btn {
        height: 46px;
        min-width: 132px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 16px;
        background: #14254E;
        color: #ffffff;
        font-size: 12px;
        font-weight: 850;
        cursor: pointer;
        box-shadow: 0 14px 30px rgba(20, 37, 78, 0.24);
        transition: 0.24s ease;
    }

    .contact-submit-premium-btn:hover {
        background: #0F1D3D;
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(20, 37, 78, 0.30);
    }

    @media (max-width: 767.98px) {
        .contact-premium-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .contact-premium-heading h2 {
            font-size: 21px;
        }

        .contact-info-premium-card,
        .contact-form-premium-card {
            border-radius: 24px;
            padding: 22px;
        }

        .contact-social-strip,
        .contact-form-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .contact-submit-premium-btn {
            width: 100%;
        }
    }
</style>
