@extends('front.layouts.master')

@section('content')
    <!-- نوار لوکس پیشرفت مطالعه خبر (در بالاترین نقطه صفحه فیکس می‌شود) -->
    <!-- نوار لوکس و روان پیشرفت مطالعه خبر با افکت درخشندگی متریال -->
    <div class="progress rounded-0 sticky-top" style="height: 4px; top: 0; z-index: 1050; background: rgba(0,0,0,0.03);">
        <div id="reading-progress" class="bg-primary" style="
        width: 0%;
        height: 100%;
        transition: width 0.25s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 0 10px #007bff, 0 0 5px #007bff;
    "></div>
    </div>

    <div class="container my-4" dir="rtl" style="text-align: right;">
        <div class="row">

            <!-- ================= ستون سمت راست (8 ستون): محتوای کامل خبر ================= -->
            <div class="col-lg-8 col-md-12 col-12 pb-2">
                <div id="main-news-box" class="bg-white p-4 border rounded style-text transition-all" style="transition: background-color 0.3s, color 0.3s;">

                    <!-- عنوان اصلی خبر -->
                    <h1 id="news-title" class="h4 font-weight-bold mb-3 line-height-text text-dark">{{ $post->title }}</h1>

                    <!-- متای خبر + دکمه حالت مطالعه شب -->
                    <div class="d-flex flex-wrap align-items-center text-muted font_11 border-bottom pb-2 mb-3">
                        <span class="ml-3">
                            <i class="fa fa-calendar-alt ml-1"></i>
                            {{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}
                        </span>
                        <span class="ml-3">
                            <i class="fa fa-eye ml-1"></i>
                            {{ $post->views ?? 0 }} بازدید
                        </span>
                        <span class="ml-3">
                            <i class="fa fa-user ml-1"></i>
                            ارسال شده توسط: {{ $post->user->name ?? 'مدیر سایت' }}
                        </span>

                        <!-- دکمه سوییچ حالت مطالعه -->
                        <button id="toggle-dark-reader" type="button" class="btn btn-sm btn-light border p-1 px-2 font_10 mr-auto text-secondary shadow-sm">
                            <i class="fa fa-moon ml-1"></i> حالت مطالعه
                        </button>
                    </div>

                    <!-- تصویر شاخص خبر -->
                    @if($post->blog_category_id == 6)
                    @else
                        @if($post->main_image_url)
                            <div class="mb-3 text-center img-news-bartar">
                                <img src="{{ $post->main_image_url }}"
                                     class="img-fluid rounded w-100"
                                     alt="{{ $post->title }}"
                                     style="max-height: 420px;object-fit: contain">
                            </div>
                        @endif
                    @endif


                    <!-- لید یا خلاصه خبر -->
                    @if($post->summary)
                        <div id="news-summary" class="p-3 bg-light border-right border-secondary font_13 text-muted line-height-text mb-3 text-justify">
                            <strong>خلاصه خبر:</strong> {{ $post->summary }}
                        </div>
                    @endif

                    <!-- متن کامل خبر -->
                    <div id="news-body" class="font_14 text-p line-height-text text-justify text-dark mb-4">
                        {!! $post->body !!}
                    </div>

                    <!-- دکمه‌های اشتراک‌گذاری انتهای مطلب -->
                    <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-4">
                        <span class="font_12 text-muted">اشتراک‌گذاری این مطلب:</span>
                        <div>
                            <a href="https://telegram.me/share/url?url={{ request()->url() }}&text={{ $post->title }}" target="_blank" class="btn btn-sm btn-outline-info p-1 px-2 font_11">
                                <i class="fab fa-telegram-plane ml-1"></i> تلگرام
                            </a>
                            <a href="https://whatsapp://send?text={{ request()->url() }}" target="_blank" class="btn btn-sm btn-outline-success p-1 px-2 font_11">
                                <i class="fab fa-whatsapp ml-1"></i> واتساپ
                            </a>
                        </div>
                    </div>

                </div>
            </div>


            <!-- ================= ستون سمت چپ (4 ستون): سایدبار بلاگ جامع ================= -->
            <div class="col-lg-4 col-md-12 col-12">
                <div class="sticky-top" style="top: 20px; z-index: 10;">

                    <!-- ۱. ابزارک ساعت زنده و تقویم شمسی بومی -->
                    <div class="bg-white p-3 border rounded mb-3 text-center shadow-sm">
                        <div class="border-bottom pb-2 mb-3">
                            <i class="fa fa-calendar-check text-primary ml-1"></i>
                            <span class="font_12 font-weight-bold text-dark">امروز در یک نگاه</span>
                        </div>
                        <div class="row no-gutters">
                            <!-- بخش ساعت دیجیتال زنده -->
                            <div class="col-5 border-left py-2 bg-light rounded-right">
                                <div id="live-clock" class="h5 font-weight-bold mb-0 text-primary" style="font-family: monospace, sans-serif; letter-spacing: 1px;">00:00:00</div>
                                <small class="text-muted font_10">ساعت رسمی</small>
                            </div>
                            <!-- بخش تاریخ شمسی داینامیک -->
                            <div class="col-7 py-2 bg-light rounded-left d-flex flex-column justify-content-center">
                                <div id="persian-date" class="font_12 font-weight-bold text-dark px-2">در حال بارگذاری...</div>
                            </div>
                        </div>
                    </div>

                    <!-- ۲. باکس جستجو در مطالب -->
                    <div class="bg-white p-3 border rounded mb-3">
                        <div class="border-bottom pb-2 mb-3">
                            <span class="font_12 font-weight-bold text-dark">جستجو در مطالب</span>
                        </div>
                        <form action="#" method="GET">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control font_12 border" placeholder="کلمه کلیدی را وارد کنید...">
                                <div class="input-group-append">
                                    <button class="btn btn-primary font_12" type="submit">جستجو</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- ۳. باکس آخرین اخبار سایت -->
                    <div class="bg-white p-3 border rounded mb-3">
                        <div class="border-bottom pb-2 mb-3 d-flex align-items-center">
                            <div class="circle-title2 ml-2" style="width: 6px; height: 6px; background: #007bff; border-radius: 50%;"></div>
                            <span class="font_12 font-weight-bold text-dark">آخرین اخبار سایت</span>
                        </div>

                        @foreach($latestPosts->take(5) as $item)
                            <div class="d-flex align-items-start mb-3 pb-2 border-bottom">
                                @if($item->main_image_url)
                                    <img src="{{ $item->main_image_url }}"
                                         class="rounded ml-2"
                                         alt="{{ $item->title }}"
                                         style="width: 55px; height: 55px; object-fit: cover;">
                                @endif

                                <div style="flex: 1;">
                                    <a href="{{ route('front.posts.show', $item->slug) }}"
                                       class="text-decoration-none text-dark d-block font_12 line-height-text mb-1">
                                        {{ \Illuminate\Support\Str::limit($item->title, 55) }}
                                    </a>

                                    <small class="text-muted font_10">
                                        <i class="fa fa-calendar-alt ml-1"></i>
                                        {{ $item->published_at ? $item->published_at->format('Y-m-d') : $item->created_at->format('Y-m-d') }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ۴. باکس برچسب‌های کپسولی شیک -->
                    <div class="bg-white p-3 border rounded mb-3">
                        <div class="border-bottom pb-2 mb-3 d-flex align-items-center">
                            <div class="circle-title2 ml-2" style="width: 6px; height: 6px; background: #ffc107; border-radius: 50%;"></div>
                            <span class="font_12 font-weight-bold text-dark">برچسب‌های کلیدی</span>
                        </div>
                        <div class="d-flex flex-wrap">
                            @if(isset($post->tags) && $post->tags->count() > 0)
                                @foreach($post->tags as $tag)
                                    <a href="#" class="badge badge-light border p-2 font_11 text-secondary m-1 rounded-pill">#{{ $tag->name }}</a>
                                @endforeach
                            @else
                                <a href="#" class="badge badge-light border p-2 font_11 text-secondary m-1 rounded-pill">#اخبار_روز</a>
                                <a href="#" class="badge badge-light border p-2 font_11 text-secondary m-1 rounded-pill">#اقتصاد_و_تجارت</a>
                                <a href="#" class="badge badge-light border p-2 font_11 text-secondary m-1 rounded-pill">#گزارش_اختصاصی</a>
                            @endif
                        </div>
                    </div>

                    <!-- ۵. باکس تعاملی نظرسنجی روز -->
                    <div class="bg-white p-3 border rounded mb-3">
                        <div class="border-bottom pb-2 mb-3">
                            <span class="font_12 font-weight-bold text-dark">نظرسنجی روز</span>
                        </div>
                        <p class="font_12 text-muted line-height-text mb-2">کیفیت و پوشش اخبار مجموعه را چگونه ارزیابی می‌کنید؟</p>
                        <div class="font_12">
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="poll1" name="poll_option" class="custom-control-input">
                                <label class="custom-control-label text-secondary" for="poll1">عالی و به موقع</label>
                            </div>
                            <div class="custom-control custom-radio mb-2">
                                <input type="radio" id="poll2" name="poll_option" class="custom-control-input">
                                <label class="custom-control-label text-secondary" for="poll2">متوسط و نیازمند بهبود</label>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary btn-block font_11 mt-2">ثبت رای</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // --- ۱. آپدیت ثانیه‌شمار ساعت و تاریخ شمسی بومی مرورگر ---
        function updateClockAndDate() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            const clockEl = document.getElementById('live-clock');
            if(clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds}`;

            const dateEl = document.getElementById('persian-date');
            if(dateEl) {
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                dateEl.textContent = new Intl.DateTimeFormat('fa-IR', options).format(now);
            }
        }
        updateClockAndDate();
        setInterval(updateClockAndDate, 1000);

        // --- ۲. محاسبه نوار پیشرفت مطالعه خبر (Reading Progress Bar) ---
        window.addEventListener('scroll', function() {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            const progressEl = document.getElementById("reading-progress");
            if(progressEl) progressEl.style.width = scrolled + "%";
        });

        // --- ۳. سوییچ حالت مطالعه در شب (Dark Mode لایه‌دار) ---
        document.getElementById('toggle-dark-reader')?.addEventListener('click', function() {
            const mainBox = document.getElementById('main-news-box');
            const titleEl = document.getElementById('news-title');
            const bodyEl = document.getElementById('news-body');
            const summaryEl = document.getElementById('news-summary');

            if (mainBox) {
                // تغییر استایل باکس اصلی
                if(mainBox.style.backgroundColor === 'rgb(30, 30, 30)' || mainBox.classList.contains('bg-dark')) {
                    mainBox.style.backgroundColor = '#ffffff';
                    mainBox.style.color = '#212529';
                    if(titleEl) titleEl.style.color = '#212529';
                    if(bodyEl) bodyEl.style.color = '#212529';
                    if(summaryEl) {
                        summaryEl.style.backgroundColor = '#f8f9fa';
                        summaryEl.style.color = '#6c757d';
                    }
                    this.innerHTML = '<i class="fa fa-moon ml-1"></i> حالت مطالعه';
                    this.className = 'btn btn-sm btn-light border p-1 px-2 font_10 mr-auto text-secondary shadow-sm';
                } else {
                    mainBox.style.backgroundColor = '#1e1e1e';
                    mainBox.style.color = '#f8f9fa';
                    if(titleEl) titleEl.style.color = '#ffffff';
                    if(bodyEl) bodyEl.style.color = '#e0e0e0';
                    if(summaryEl) {
                        summaryEl.style.backgroundColor = '#2d2d2d';
                        summaryEl.style.color = '#b0b0b0';
                    }
                    this.innerHTML = '<i class="fa fa-sun ml-1"></i> روز خورشیدی';
                    this.className = 'btn btn-sm btn-warning p-1 px-2 font_10 mr-auto text-dark shadow-sm';
                }
            }
        });
    </script>
@endpush
