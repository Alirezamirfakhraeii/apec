@php
    $isRtl = app()->isLocale('fa');
@endphp

@once
    <link
        rel="stylesheet"
        href="{{ asset('front/css/components/contact.css') }}"
    >
@endonce


<section
    class="contact-premium-section my-5"
    dir="{{ $isRtl ? 'rtl' : 'ltr' }}"
    id="contact-section"
>

    {{-- =====================================================
         HEADING
    ====================================================== --}}
    <div class="contact-premium-heading">

        <div>
            <span class="contact-premium-kicker">
                <i
                    class="fa fa-envelope-open-text"
                    aria-hidden="true"
                ></i>

                {{ __('contact.kicker') }}
            </span>

            <h2>
                {{ __('contact.title') }}
            </h2>

            <p>
                {{ __('contact.description') }}
            </p>
        </div>


        <a
            href="tel:02188318701"
            class="contact-premium-call-btn"
        >
            <i
                class="fa fa-phone"
                aria-hidden="true"
            ></i>

            {{ __('contact.quick_call') }}
        </a>

    </div>


    <div class="row align-items-stretch">

        {{-- =================================================
             CONTACT INFORMATION
        ================================================== --}}
        <div class="col-lg-5 col-12 mb-4 mb-lg-0">

            <div class="contact-info-premium-card h-100">

                <div class="contact-info-glow contact-info-glow-one"></div>
                <div class="contact-info-glow contact-info-glow-two"></div>


                <div class="contact-info-content">

                    <span class="contact-info-badge">
                        <i
                            class="fa fa-headset"
                            aria-hidden="true"
                        ></i>

                        {{ __('contact.communication_methods') }}
                    </span>


                    <h3>
                        {{ __('contact.contact_information') }}
                    </h3>


                    <p>
                        {{ __('contact.contact_information_description') }}
                    </p>


                    <div class="contact-info-list">

                        {{-- Phone --}}
                        <div class="contact-info-row">

                            <div class="contact-info-icon">
                                <i
                                    class="fa fa-phone"
                                    aria-hidden="true"
                                ></i>
                            </div>

                            <div>
                                <span>
                                    {{ __('contact.direct_phone') }}
                                </span>

                                <a
                                    href="tel:02188318701"
                                    dir="ltr"
                                >
                                    021-88318701
                                </a>
                            </div>

                        </div>


                        {{-- WhatsApp --}}
                        <div class="contact-info-row">

                            <div class="contact-info-icon">
                                <i
                                    class="fab fa-whatsapp"
                                    aria-hidden="true"
                                ></i>
                            </div>

                            <div>
                                <span>
                                    {{ __('contact.whatsapp') }}
                                </span>

                                <a
                                    href="https://wa.me/989122044158"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    dir="ltr"
                                >
                                    09122044158
                                </a>
                            </div>

                        </div>


                        {{-- Fax --}}
                        <div class="contact-info-row">

                            <div class="contact-info-icon">
                                <i
                                    class="fa fa-fax"
                                    aria-hidden="true"
                                ></i>
                            </div>

                            <div>
                                <span>
                                    {{ __('contact.fax') }}
                                </span>

                                <strong dir="ltr">
                                    021-88824669
                                </strong>
                            </div>

                        </div>


                        {{-- Working Hours --}}
                        <div class="contact-info-row">

                            <div class="contact-info-icon">
                                <i
                                    class="fa fa-clock"
                                    aria-hidden="true"
                                ></i>
                            </div>

                            <div>
                                <span>
                                    {{ __('contact.working_hours') }}
                                </span>

                                <strong>
                                    {{ __('contact.working_hours_value') }}
                                </strong>
                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="contact-info-row contact-address-row">

                            <div class="contact-info-icon">
                                <i
                                    class="fa fa-map-marker-alt"
                                    aria-hidden="true"
                                ></i>
                            </div>

                            <div>
                                <span>
                                    {{ __('contact.head_office') }}
                                </span>

                                <strong>
                                    {{ __('contact.address') }}
                                </strong>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SOCIAL NETWORKS
                ================================================== --}}
                <div class="contact-social-strip">

                    <span>
                        {{ __('contact.follow_us') }}
                    </span>

                    <div>

                        <a
                            href="https://x.com/irapec"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="{{ __('contact.twitter') }}"
                            aria-label="{{ __('contact.twitter') }}"
                        >
                            <i
                                class="fab fa-twitter"
                                aria-hidden="true"
                            ></i>
                        </a>


                        <a
                            href="https://www.instagram.com/irapec_info?igsh=MXczdDBzN2Nia2J1eQ=="
                            target="_blank"
                            rel="noopener noreferrer"
                            title="{{ __('contact.instagram') }}"
                            aria-label="{{ __('contact.instagram') }}"
                        >
                            <i
                                class="fab fa-instagram"
                                aria-hidden="true"
                            ></i>
                        </a>


                        <a
                            href="https://www.linkedin.com/in/apec-association?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="{{ __('contact.linkedin') }}"
                            aria-label="{{ __('contact.linkedin') }}"
                        >
                            <i
                                class="fab fa-linkedin-in"
                                aria-hidden="true"
                            ></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>



        {{-- =====================================================
             CONTACT FORM
        ====================================================== --}}
        <div class="col-lg-7 col-12">

            <div class="contact-form-premium-card h-100">

                <div class="contact-form-header">

                    <div>
                        <span>
                            {{ __('contact.direct_contact_form') }}
                        </span>

                        <h3>
                            {{ __('contact.send_message_title') }}
                        </h3>
                    </div>


                    <div class="contact-form-icon">
                        <i
                            class="fa fa-paper-plane"
                            aria-hidden="true"
                        ></i>
                    </div>

                </div>


                <p class="contact-form-description">
                    {{ __('contact.form_description') }}
                </p>


                {{-- Success --}}
                @if(session('contact_success'))

                    <div class="contact-success-alert">

                        <i
                            class="fa fa-check-circle"
                            aria-hidden="true"
                        ></i>

                        <span>
                            {{ session('contact_success') }}
                        </span>

                    </div>

                @endif


                <form
                    action="{{ route('front.contact.store') }}"
                    method="POST"
                    id="front-contact-form"
                    class="contact-premium-form"
                >

                    @csrf


                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6 col-12 mb-3">

                            <label for="contact-name">
                                {{ __('contact.full_name') }}

                                <span>*</span>
                            </label>


                            <div class="contact-input-wrap">

                                <i
                                    class="fa fa-user"
                                    aria-hidden="true"
                                ></i>

                                <input
                                    id="contact-name"
                                    type="text"
                                    name="name"
                                    class="@error('name') is-invalid @enderror"
                                    value="{{ old('name') }}"
                                    placeholder="{{ __('contact.full_name_placeholder') }}"
                                    required
                                >

                            </div>


                            @error('name')
                            <small class="contact-error-text">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>



                        {{-- Contact --}}
                        <div class="col-md-6 col-12 mb-3">

                            <label for="contact-value">
                                {{ __('contact.mobile_or_email') }}

                                <span>*</span>
                            </label>


                            <div class="contact-input-wrap ltr-input-wrap">

                                <i
                                    class="fa fa-phone-alt"
                                    aria-hidden="true"
                                ></i>

                                <input
                                    id="contact-value"
                                    type="text"
                                    name="contact"
                                    class="@error('contact') is-invalid @enderror"
                                    value="{{ old('contact') }}"
                                    placeholder="{{ __('contact.mobile_or_email_placeholder') }}"
                                    required
                                    dir="ltr"
                                >

                            </div>


                            @error('contact')
                            <small class="contact-error-text">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>



                        {{-- Subject --}}
                        <div class="col-12 mb-3">

                            <label for="contact-subject">
                                {{ __('contact.message_subject') }}
                            </label>


                            <div class="contact-input-wrap">

                                <i
                                    class="fa fa-question-circle"
                                    aria-hidden="true"
                                ></i>

                                <input
                                    id="contact-subject"
                                    type="text"
                                    name="subject"
                                    class="@error('subject') is-invalid @enderror"
                                    value="{{ old('subject') }}"
                                    placeholder="{{ __('contact.subject_placeholder') }}"
                                >

                            </div>


                            @error('subject')
                            <small class="contact-error-text">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>



                        {{-- Message --}}
                        <div class="col-12 mb-4">

                            <label for="contact-message">
                                {{ __('contact.message') }}

                                <span>*</span>
                            </label>


                            <div class="contact-textarea-wrap">

                                <textarea
                                    id="contact-message"
                                    name="message"
                                    rows="5"
                                    class="@error('message') is-invalid @enderror"
                                    placeholder="{{ __('contact.message_placeholder') }}"
                                    required
                                >{{ old('message') }}</textarea>

                            </div>


                            @error('message')
                            <small class="contact-error-text">
                                {{ $message }}
                            </small>
                            @enderror

                        </div>



                        {{-- Footer --}}
                        <div class="col-12">

                            <div class="contact-form-footer">

                                <span>
                                    <i
                                        class="fa fa-lock"
                                        aria-hidden="true"
                                    ></i>

                                    {{ __('contact.privacy_message') }}
                                </span>


                                <button
                                    type="submit"
                                    class="contact-submit-premium-btn"
                                >
                                    {{ __('contact.send_message') }}

                                    <i
                                        class="fa {{ $isRtl ? 'fa-arrow-left' : 'fa-arrow-right' }}"
                                        aria-hidden="true"
                                    ></i>
                                </button>

                            </div>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>
