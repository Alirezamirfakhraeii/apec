<!--begin header area -->
<div class="container my-3">
    <div class="row align-items-center">

        <div class="col-lg-2 col-md-3 col-6 order-1 text-end">
            <a href="{{ route('home') }}">
                <img src="{{ asset('front/img/logo-irapec-min2.png') }}"
                     class="img-fluid header-logo"
                     alt="لوگو">
            </a>
        </div>

        <div class="col-lg-3 d-none d-lg-block order-2 header-social-box">
            <div class="d-flex flex-column align-items-center text-center justify-content-center h-100">
                <span class="font_11 text-muted mb-2">ما را دنبال کنید:</span>

                <div class="social-links d-flex align-items-center justify-content-center header-social-links">

                    <a href="https://www.instagram.com/irapec_info?igsh=MXczdDBzN2Nia2J1eQ=="
                       target="_blank"
                       class="text-secondary custom-social-link"
                       title="اینستاگرام">
                        <i class="fab fa-instagram fa-lg"></i>
                    </a>

                    <a href="https://x.com/irapec"
                       target="_blank"
                       class="text-secondary custom-social-link"
                       title="توییتر">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>

                    <a href="https://www.linkedin.com/in/apec-association?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app"
                       target="_blank"
                       class="text-secondary custom-social-link"
                       title="لینکدین">
                        <i class="fab fa-linkedin-in fa-lg"></i>
                    </a>

                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-5 col-12 order-4 order-md-2 mt-3 mt-md-0">
            <div class="top-search m-0">
                <form method="GET" action="#">
                    <input name="search"
                           type="text"
                           class="form-control"
                           placeholder="جستجو در همه اخبار...">

                    <button type="submit" class="bg-search">
                        <i class="fa fa-search icon-header-color"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-6 order-3 order-md-3 text-start">
            <div class="d-inline-flex flex-column flex-sm-row align-items-end align-items-sm-center gap-2 justify-content-end">

                <span class="header-border-top p-1 low-font-mobile header-date">
                    {{ verta()->format('Y/m/d') }}

                    <span class="mx-1">
                        {{ verta()->format('H:i') }}
                    </span>
                </span>

                <span class="mt-1 mt-sm-0">
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="header-btn-border py-1 px-2 header-lang-btn">
                        English
                    </a>
                </span>

            </div>
        </div>

    </div>
</div>
<!--end header area -->
