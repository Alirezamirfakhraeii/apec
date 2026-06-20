<div class="bg-white-content">
    <div class="p-3">
        <div class="row mb-3">
            <div class="col-12">
                <div class="bg-video p-2 rounded" style="background: rgba(241, 245, 249, 0.6);">
                    <div class="row align-items-center" dir="rtl">
                        <div class="col-6">
                            <div style="text-align: right">
                                <span class="color-teldio font_15 fw-bold text-dark">
                                    <i class="fa fa-bullhorn text-success ml-2"></i>اطلاع‌رسانی
                                </span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div style="text-align: left">
                                @if(isset($announcementCategory))
                                    <a href="" class="text-decoration-none">
                                        <span class="color-video font_13 text-success hover-underline">مشاهده همه مطالب <i class="fa fa-chevron-left font_10 mr-1"></i></span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" dir="rtl">
            @if(isset($announcementPosts) && $announcementPosts->count() > 0)
                <div class="col-12 pb-2">
                    <div id="announcementNewsCarousel" class="carousel slide premium-horizontal-wrapper style-notice-board" data-bs-ride="carousel" data-bs-interval="6000">
                        <div class="row g-0 h-100">

                            <div class="col-md-5 col-12 h-100 h-100-fix order-md-1" style="background-color: #ffffff; border-left: 1px solid rgba(0,0,0,0.05); overflow-y: auto;">
                                <div class="d-flex flex-column p-2 horizontal-indicators" style="gap: 6px;">
                                    @php $faNumbers = ['۰۱', '۰۲', '۰۳', '۰۴', '۰۵']; @endphp
                                    @foreach($announcementPosts->take(5) as $index => $post)
                                        <button type="button" data-bs-target="#announcementNewsCarousel" data-bs-slide-to="{{ $index }}" class="horizontal-list-item border-0 text-right d-flex align-items-center w-100 {{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}">

                                            <div class="flex-shrink-0 notice-index-badge ml-3 d-flex align-items-center justify-content-center font-weight-bold">
                                                {{ $faNumbers[$index] ?? ($index + 1) }}
                                            </div>

                                            <div class="flex-grow-1 overflow-hidden pr-1">
                                                <h4 class="font_12 font-weight-bold mb-0 text-truncate-2 horizontal-list-title transition-all text-dark">
                                                    {{ $post->title }}
                                                </h4>
                                                <span class="text-muted font_9 d-block mt-1">
                                                    <i class="fa fa-clock ml-1" style="font-size: 8px;"></i>
                                                    {{ $post->published_at ? $post->published_at->format('Y-m-d') : $post->created_at->format('Y-m-d') }}
                                                </span>
                                            </div>

                                            <div class="horizontal-progress-bar"></div>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-md-7 col-12 h-100 position-relative order-md-2">
                                <div class="carousel-inner h-100">
                                    @foreach($announcementPosts->take(5) as $index => $post)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                                            <div class="position-relative h-100 w-100 overflow-hidden H-100-fix">

                                                <img src="{{ $post->main_image_url }}"
                                                     class="d-block w-100 h-100 horizontal-img"
                                                     alt="{{ $post->title }}">

                                                <div class="horizontal-overlay d-flex flex-column justify-content-end p-4">
                                                    <div class="mb-2">
                        <span class="badge announce-badge font_9 shadow-sm">
                            <i class="fa fa-volume-up text-warning ml-1"></i>
                            اطلاعیه رسمی
                        </span>
                                                    </div>

                                                    <a href="{{ route('front.posts.show', $post->slug) }}" class="text-decoration-none">
                                                        <h3 class="font_14 font-weight-bold text-white line-height-text mb-0 text-shadow-md horizontal-title-hover text-truncate-2">
                                                            {{ $post->title }}
                                                        </h3>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 py-5 text-center text-muted font_13">
                    <i class="fa fa-info-circle fa-2x d-block mb-2 text-secondary"></i>
                    هیچ مطلبی در بخش اطلاع‌رسانی ثبت نشده است.
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* ----- کادر اصلی اسلایدر افقی ----- */
    .style-notice-board.premium-horizontal-wrapper {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0,0,0,0.05);
        overflow: hidden;
        height: 360px;
    }

    @media (min-width: 768px) {
        .H-100-fix { height: 360px !important; }
    }

    /* ----- بخش تصویر سمت چپ ----- */
    .style-notice-board .horizontal-img { object-fit: cover; transform: scale(1); transition: transform 6s ease-in-out; }
    .style-notice-board .carousel-item.active .horizontal-img { transform: scale(1.05); }

    .style-notice-board .horizontal-overlay {
        position: absolute; bottom: 0; left: 0; right: 0; height: 100%;
        background: linear-gradient(to top, rgba(15, 23, 42, 0.98) 0%, rgba(15, 23, 42, 0.5) 50%, rgba(15, 23, 42, 0) 100%);
    }
    .style-notice-board .announce-badge {
        background: #10b981;
        color: #fff; padding: 4px 8px; border-radius: 6px;
    }
    .text-shadow-md { text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5); }
    .style-notice-board .horizontal-title-hover { transition: color 0.3s; line-height: 1.6; }
    .style-notice-board .horizontal-title-hover:hover { color: #34d399 !important; }

    /* ----- بخش منوی متنی سمت راست ----- */
    .style-notice-board .horizontal-indicators::-webkit-scrollbar { width: 4px; }
    .style-notice-board .horizontal-indicators::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }

    .style-notice-board .horizontal-list-item {
        background: transparent;
        border-radius: 0px;
        padding: 12px 14px;
        position: relative;
        overflow: hidden;
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(0,0,0,0.03) !important;
        min-height: 68px;
    }

    /* طراحی شمارنده عددی مینی‌مال */
    .style-notice-board .notice-index-badge {
        width: 32px; height: 32px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 8px;
        font-size: 13px;
        transition: all 0.3s ease;
    }

    .style-notice-board .horizontal-list-item:hover {
        background: rgba(241, 245, 249, 0.4);
    }
    .style-notice-board .horizontal-list-item:hover .notice-index-badge {
        background: #cbd5e1;
        color: #1e293b;
    }

    /* استایل وضعیت فعال (Active) */
    .style-notice-board .horizontal-list-item.active {
        background: rgba(16, 185, 129, 0.03);
        border-bottom: 1px solid rgba(16, 185, 129, 0.1) !important;
    }
    .style-notice-board .horizontal-list-item.active .notice-index-badge {
        background: #10b981;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.25);
    }
    .style-notice-board .horizontal-list-item.active .horizontal-list-title {
        color: #10b981 !important;
    }

    /* نوار پیشرفت عمودی لبه کادر فعال */
    .style-notice-board .horizontal-progress-bar {
        position: absolute; top: 0; right: 0; bottom: 0; width: 3px; background: #10b981; height: 0;
    }
    .style-notice-board .horizontal-list-item.active .horizontal-progress-bar {
        animation: vertProgress 6s linear forwards;
    }
    @keyframes vertProgress { 0% { height: 0; } 100% { height: 100%; } }

    .text-truncate-2 {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.5;
    }
    .hover-underline:hover { text-decoration: underline !important; }
    .transition-all { transition: all 0.3s ease; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var myHorizCarousel = document.getElementById('announcementNewsCarousel');
        var horizIndicators = document.querySelectorAll('.style-notice-board .horizontal-list-item');

        if (myHorizCarousel) {
            myHorizCarousel.addEventListener('slide.bs.carousel', function (e) {
                var nextIdx = e.to;

                horizIndicators.forEach(function(btn, idx) {
                    if(idx === nextIdx) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-current', 'true');

                        var progressBar = btn.querySelector('.horizontal-progress-bar');
                        if (progressBar) {
                            progressBar.style.animation = 'none';
                            progressBar.offsetHeight;
                            progressBar.style.animation = null;
                        }

                        var container = btn.parentElement;
                        if (container) {
                            var containerVisibleHeight = container.clientHeight;
                            var itemTop = btn.offsetTop;
                            var itemHeight = btn.clientHeight;

                            container.scrollTo({
                                top: itemTop - (containerVisibleHeight / 2) + (itemHeight / 2),
                                behavior: 'smooth'
                            });
                        }
                    } else {
                        btn.classList.remove('active');
                        btn.removeAttribute('aria-current');
                    }
                });
            });
        }
    });
</script>
