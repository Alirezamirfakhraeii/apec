
@php
    $tenderItems = collect($tenders ?? []);

    $featuredTender = $tenderItems->first();
    $otherTenders = $tenderItems->skip(1)->take(3);

    /*
     | آدرس‌ها و فیلد تصویر را با ساختار پروژه تنظیم کن.
     | این قسمت بر اساس مدل متداول Post نوشته شده است.
     */
    $tendersUrl = url('/category/mnaksat');

    $tenderUrl = fn ($post) => url('/news/' . $post->slug);

    $tenderImage = function ($post) {
        $path = $post->image ?? null;

        if (!$path) {
            return asset('images/default-tender.jpg');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    };
@endphp

<style>
    /* =====================================
       APEC TENDERS SECTION
    ===================================== */

    .ap-tenders {
        direction: rtl;
        margin: 65px 0;
        font-family: inherit;
    }

    .ap-tenders,
    .ap-tenders * {
        box-sizing: border-box;
    }

    /* Header */

    .ap-tenders-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .ap-tenders-heading {
        display: flex;
        align-items: center;
        gap: 13px;
    }

    .ap-tenders-accent {
        width: 7px;
        height: 45px;
        border-radius: 10px;
        background: linear-gradient(180deg, #ef1425, #930917);
        box-shadow: 0 5px 15px rgba(193, 0, 16, .16);
    }

    .ap-tenders-heading span {
        display: block;
        color: #ce1222;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .ap-tenders-heading h2 {
        font-size: 24px;
        font-weight: 900;
        color: #14264f;
        margin: 0;
    }

    .ap-tenders-all {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        color: #fff;
        background: #14264f;
        border-radius: 30px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
        transition: all .25s ease;
    }

    .ap-tenders-all:hover {
        background: #c5091a;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Main Panel */

    .ap-tenders-shell {
        background: linear-gradient(
            140deg,
            #edf0f6,
            #fbfcfe 65%
        );
        padding: 16px;
        border: 1px solid #e4e8f0;
        border-radius: 25px;
        box-shadow: 0 13px 34px rgba(17,36,72,.09);
    }

    .ap-tenders-grid {
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 14px;
        min-height: 395px;
    }

    /* Featured Tender */

    .ap-tender-hero {
        position: relative;
        display: block;
        min-height: 395px;
        border-radius: 19px;
        overflow: hidden;
        background: #1a3458;
        text-decoration: none;
        isolation: isolate;
    }

    .ap-tender-hero-image {
        width: 100%;
        height: 100%;
        position: absolute;
        inset: 0;
        object-fit: contain;
        transition: transform .6s ease;
    }

    .ap-tender-hero:hover .ap-tender-hero-image {
        transform: scale(1.055);
    }

    .ap-tender-hero::after {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(
            0deg,
            rgba(9,24,52,.97),
            rgba(13,29,53,.55) 45%,
            rgba(13,29,53,.12) 85%
        );
        z-index: 1;
    }

    .ap-tender-hero-content {
        position: absolute;
        bottom: 0;
        right: 0;
        left: 0;
        z-index: 2;
        padding: 26px;
        color: #fff;
    }

    .ap-tender-tag {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #d71021;
        padding: 8px 13px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        color: #fff;
    }

    .ap-tender-tag::before {
        content: "";
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
    }

    .ap-tender-hero-title {
        font-size: 22px;
        line-height: 1.9;
        font-weight: 900;
        color: #fff;
        margin: 16px 0;
    }

    .ap-tender-hero-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        border-top: 1px solid rgba(255,255,255,.25);
        padding-top: 16px;
        font-size: 12px;
        color: #dce3f0;
    }

    .ap-tender-hero-more {
        font-weight: 800;
        color: #fff;
        transition: .2s;
    }

    .ap-tender-hero:hover .ap-tender-hero-more {
        color: #ffbdc6;
    }

    /* Small Cards */

    .ap-tenders-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .ap-tender-small {
        display: flex;
        align-items: center;
        flex: 1;
        min-height: 115px;
        gap: 13px;
        padding: 10px;
        background: #fff;
        border: 1px solid #e6eaf2;
        border-radius: 16px;
        text-decoration: none;
        box-shadow: 0 3px 12px rgba(33,59,89,.035);
        transition: all .25s;
        overflow: hidden;
    }

    .ap-tender-small:hover {
        border-color: #afbcd3;
        background: #fdfdff;
        transform: translateY(-2px);
        box-shadow: 0 9px 20px rgba(20,38,79,.08);
    }

    .ap-tender-small-image {
        width: 118px;
        height: 94px;
        flex-shrink: 0;
        object-fit: cover;
        border-radius: 11px;
        background: #dae2ec;
    }

    .ap-tender-small-body {
        flex: 1;
        min-width: 0;
    }

    .ap-tender-small-kicker {
        color: #c50b20;
        font-size: 11px;
        font-weight: 800;
    }

    .ap-tender-small-title {
        color: #142951;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.9;
        margin: 7px 0;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }

    .ap-tender-small-date {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #8693ad;
        font-size: 11px;
    }

    /* Footer */

    .ap-tenders-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-top: 16px;
        padding: 0 6px;
    }

    .ap-tenders-footer-note {
        font-size: 11px;
        color: #71819d;
    }

    .ap-tenders-footer-category {
        font-size: 11px;
        color: #c20c1f;
        font-weight: 800;
        text-decoration: none;
    }

    .ap-tenders-footer-category:hover {
        color: #14264f;
    }

    .ap-tenders-empty {
        background: #fff;
        padding: 55px 20px;
        text-align: center;
        border-radius: 17px;
        color: #71819d;
        font-size: 13px;
    }

    /* Responsive */

    @media (max-width: 991px) {
        .ap-tenders-grid {
            grid-template-columns: 1fr;
        }

        .ap-tender-hero {
            min-height: 380px;
        }
    }

    @media (max-width: 767px) {
        .ap-tenders {
            margin: 42px 0;
        }

        .ap-tenders-header {
            gap: 12px;
            align-items: flex-start;
            flex-direction: column;
        }

        .ap-tenders-heading h2 {
            font-size: 21px;
        }

        .ap-tenders-shell {
            padding: 11px;
            border-radius: 18px;
        }

        .ap-tender-hero {
            min-height: 335px;
        }

        .ap-tender-hero-content {
            padding: 19px;
        }

        .ap-tender-hero-title {
            font-size: 18px;
        }

        .ap-tender-small {
            min-height: 105px;
            gap: 10px;
        }

        .ap-tender-small-image {
            width: 105px;
            height: 85px;
        }

        .ap-tender-small-title {
            font-size: 12px;
        }
    }

    @media (max-width: 400px) {
        .ap-tender-small-image {
            width: 85px;
            height: 82px;
        }

        .ap-tender-hero-info {
            font-size: 10px;
        }
    }
</style>

<section class="ap-tenders">

    {{-- Section Header --}}
    <div class="ap-tenders-header">

        <div class="ap-tenders-heading">
            <div class="ap-tenders-accent"></div>

            <div>
                <span>فرصت‌های همکاری و مشارکت</span>
                <h2>آخرین مناقصات</h2>
            </div>
        </div>

        <a href="{{ $tendersUrl }}" class="ap-tenders-all">
            مشاهده همه مناقصات
            <i class="bi bi-arrow-left"></i>
        </a>

    </div>

    {{-- Section Content --}}
    <div class="ap-tenders-shell">

        @if($featuredTender)

            <div class="ap-tenders-grid">

                {{-- Featured Tender --}}
                <a href="{{ $tenderUrl($featuredTender) }}"
                   class="ap-tender-hero">

                    <img
                        src="{{ $tenderImage($featuredTender) }}"
                        alt="{{ $featuredTender->title }}"
                        class="ap-tender-hero-image"
                        loading="lazy"
                    >

                    <div class="ap-tender-hero-content">

                        <span class="ap-tender-tag">
                            جدیدترین فراخوان
                        </span>

                        <h3 class="ap-tender-hero-title">
                            {{ $featuredTender->title }}
                        </h3>

                        <div class="ap-tender-hero-info">

                            <span>
                                <i class="bi bi-calendar3 ms-1"></i>
                                {{ $featuredTender->created_at?->format('Y/m/d') }}
                            </span>

                            <span class="ap-tender-hero-more">
                                مشاهده جزئیات مناقصه
                                <i class="bi bi-arrow-left me-1"></i>
                            </span>

                        </div>

                    </div>

                </a>

                {{-- Other Tenders --}}
                <div class="ap-tenders-list">

                    @foreach($otherTenders as $tender)

                        <a href="{{ $tenderUrl($tender) }}"
                           class="ap-tender-small">

                            <img
                                src="{{ $tenderImage($tender) }}"
                                alt="{{ $tender->title }}"
                                class="ap-tender-small-image"
                                loading="lazy"
                            >

                            <div class="ap-tender-small-body">

                                <span class="ap-tender-small-kicker">
                                    اطلاعیه مناقصه
                                </span>

                                <h4 class="ap-tender-small-title">
                                    {{ $tender->title }}
                                </h4>

                                <span class="ap-tender-small-date">
                                    <i class="bi bi-clock"></i>
                                    {{ $tender->created_at?->format('Y/m/d') }}
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>

            </div>

        @else

            <div class="ap-tenders-empty">
                <i class="bi bi-inbox fs-2 d-block mb-3"></i>
                در حال حاضر مناقصه‌ای منتشر نشده است.
            </div>

        @endif

        <div class="ap-tenders-footer">

            <span class="ap-tenders-footer-note">
                آخرین اطلاعیه‌ها و فراخوان‌های مناقصات
            </span>

            <a href="{{ $tendersUrl }}"
               class="ap-tenders-footer-category">
                آرشیو مناقصات
                <i class="bi bi-arrow-left me-1"></i>
            </a>

        </div>

    </div>

</section>
