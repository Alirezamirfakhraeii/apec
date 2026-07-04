<section class="bg-color-gray ">
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-md-inline-block d-none">
                <nav class="navbar navbar-expand-md navbar-dark ">
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon d-none"></span>
                    </button>
                    <div class="navbar-brand d-none " href="#">
                        <i class="fa fa-search mt-2 ml-2 red_social"></i>
                    </div>
                    <div class="navbar-brand d-none d-lg-inline-block "></div>
                </nav>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-12 d-md-inline-block d-none ">
                <div class="row">

                    @if(isset($footerCategories) && $footerCategories->count() > 0)
                        @foreach($footerCategories as $cat)
                            <div class="col-2 mt-5">
                                <a href="#" class="style-title-footer">
                                    {{ $cat->name }}
                                </a>
                                <ul class="px-0 mt-2 line-height-footer" style="list-style: none">
                                    <li>
                                        <a href="#" class="hover-txt-footer">
                                            عناوین کل {{ $cat->name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        <div class="border-top-footer">
            <div class="row">

                <div class="col-md-6 col-12 text-md-right text-center">
                    <div class="style-li">
                        <ul style="list-style: none" class="p-0">
                            {{-- ۲. داینامیک کردن لینک شبکه‌های اجتماعی بر اساس دیتای Settings --}}
                            @if(isset($siteSettings) && $siteSettings->twitter)
                                <li>
                                    <a href="{{ $siteSettings->twitter }}" target="_blank">
                                        <i class="fab fa-twitter color-media"></i>
                                    </a>
                                </li>
                            @endif
                            @if(isset($siteSettings) && $siteSettings->instagram)
                                <li>
                                    <a href="{{ $siteSettings->instagram }}" target="_blank">
                                        <i class="fab fa-instagram color-media"></i>
                                    </a>
                                </li>
                            @endif
                            @if(isset($siteSettings) && $siteSettings->telegram)
                                <li>
                                    <a href="{{ $siteSettings->telegram }}" target="_blank">
                                        <i class="fab fa-telegram color-media"></i>
                                    </a>
                                </li>
                            @endif
                            @if(isset($siteSettings) && $siteSettings->whatsapp)
                                <li>
                                    <a href="{{ $siteSettings->whatsapp }}" target="_blank">
                                        <i class="fab fa-whatsapp color-media"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section>
    <div class="bg-footer">
        <div class="container">
            <div class="row">

                <div class="col-12  col-md-6">
                    <div class="text-center text-md-right font_13 font-weight-bold">
                        {{-- ۳. متن کپی‌رایت داینامیک یا پیش‌فرض قالب --}}
                        {{ $siteSettings->copyright ?? 'کلیه حقوق این سایت متعلق به سایت اپک میباشد و استفاده از مطالب آن با ذکر منبع بلامانع است.' }}
                    </div>
                </div>

                <div class="col-12  col-md-6">
                    <div class="text-center text-md-left font_13 font-weight-bold mt-2 mt-md-0">
                        طراحی و تولید توسط
                        <a style="color: red" href="#">Alireza Mirfakhraei</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="scrolltop" onclick="scroll_top()">
    <i class="fa fa-chevron-up arrow_icon" style="color: #333"></i>
</div>
