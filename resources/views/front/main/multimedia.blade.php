<div class="magazine-premium-section mt-5" dir="rtl">

    <div class="magazine-premium-heading">
        <div class="magazine-heading-right">
            <span class="magazine-heading-mark"></span>

            <div>
                <span class="magazine-kicker">آرشیو تخصصی</span>
                <h2>نشریه نفت و توسعه</h2>
            </div>
        </div>

        @if(isset($magazineCategory))
            <a href="{{ route('front.categories.show', $magazineCategory->slug) }}" class="magazine-archive-btn">
                آرشیو نشریه
                <i class="fa fa-arrow-left"></i>
            </a>
        @endif
    </div>

    @if(isset($magazinePosts) && $magazinePosts->count() > 0)

        @php
            $mainMagazine = $magazinePosts->first();
            $mainDate = $mainMagazine->published_at ?? $mainMagazine->created_at;
        @endphp

        <section class="magazine-hero-card">

            <div class="magazine-hero-content">
                <span class="magazine-issue-badge">
                    <i class="fa fa-book-open"></i>
                    آخرین شماره منتشر شده
                </span>

                <a href="{{ route('front.posts.show', $mainMagazine->slug) }}" class="magazine-main-title">
                    {{ $mainMagazine->title }}
                </a>

                @if($mainMagazine->summary)
                    <p class="magazine-main-summary">
                        {{ Str::limit($mainMagazine->summary, 220) }}
                    </p>
                @else
                    <p class="magazine-main-summary">
                        تازه‌ترین شماره نشریه نفت و توسعه را مطالعه کنید؛ شامل تحلیل‌ها، گزارش‌ها و روایت‌های تخصصی حوزه انرژی و توسعه.
                    </p>
                @endif

                <div class="magazine-main-meta">
                    <span>
                        <i class="fa fa-calendar-alt"></i>
                        {{ verta($mainDate)->format('Y/m/d') }}
                    </span>

                    <span>
                        <i class="fa fa-layer-group"></i>
                        نشریه نفت و توسعه
                    </span>
                </div>

                <div class="magazine-main-actions">
                    <a href="{{ route('front.posts.show', $mainMagazine->slug) }}" class="magazine-read-btn">
                        مطالعه شماره جدید
                        <i class="fa fa-chevron-left"></i>
                    </a>

                    @if(isset($magazineCategory))
                        <a href="{{ route('front.categories.show', $magazineCategory->slug) }}" class="magazine-outline-btn">
                            مشاهده همه شماره‌ها
                        </a>
                    @endif
                </div>
            </div>

            <a href="{{ route('front.posts.show', $mainMagazine->slug) }}" class="magazine-cover-stage">
                <span class="magazine-cover-shadow"></span>

                <div class="magazine-cover-frame">
                    <img src="{{ $mainMagazine->main_image_url }}"
                         alt="{{ $mainMagazine->title }}">
                </div>

                <span class="magazine-cover-label">جدید</span>
            </a>

        </section>

        @if($magazinePosts->count() > 1)
            <div class="magazine-mini-heading">
                <h3>شماره‌های قبلی</h3>
                <span>منتخب آخرین مطالب منتشر شده در نشریه</span>
            </div>

            <div class="magazine-issues-grid">
                @foreach($magazinePosts->skip(1)->take(4) as $post)
                    @php
                        $postDate = $post->published_at ?? $post->created_at;
                    @endphp

                    <article class="magazine-issue-card">
                        <a href="{{ route('front.posts.show', $post->slug) }}" class="magazine-issue-cover">
                            <img src="{{ $post->main_image_url }}" alt="{{ $post->title }}">
                        </a>

                        <div class="magazine-issue-body">
                            <a href="{{ route('front.posts.show', $post->slug) }}" class="magazine-issue-title">
                                {{ $post->title }}
                            </a>

                            <div class="magazine-issue-footer">
                                <span>
                                    <i class="fa fa-calendar-alt"></i>
                                    {{ verta($postDate)->format('Y/m/d') }}
                                </span>

                                <a href="{{ route('front.posts.show', $post->slug) }}">
                                    مطالعه
                                    <i class="fa fa-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

    @else
        <div class="magazine-empty-state">
            <i class="fa fa-book-open"></i>
            <h3>هنوز شماره‌ای از نشریه ثبت نشده است</h3>
            <p>بعد از ثبت مطالب نشریه نفت و توسعه، این بخش به‌صورت خودکار نمایش داده می‌شود.</p>
        </div>
    @endif

</div>

<style>
    .magazine-premium-section {
        text-align: right;
        position: relative;
    }

    .magazine-premium-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 22px;
    }

    .magazine-heading-right {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .magazine-heading-mark {
        width: 14px;
        height: 42px;
        display: inline-block;
        border-radius: 999px;
        background: linear-gradient(180deg, #e00000, #7f1d1d);
        box-shadow: 0 8px 22px rgba(224, 0, 0, 0.24);
        flex-shrink: 0;
    }

    .magazine-kicker {
        display: block;
        color: #e00000;
        font-size: 11px;
        font-weight: 900;
        margin-bottom: 4px;
    }

    .magazine-premium-heading h2 {
        margin: 0;
        color: #0f172a;
        font-size: 22px;
        font-weight: 950;
        letter-spacing: -0.5px;
    }

    .magazine-archive-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 15px;
        border-radius: 999px;
        background: #fff1f2;
        color: #e00000;
        border: 1px solid rgba(224, 0, 0, 0.13);
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
        transition: 0.24s ease;
        white-space: nowrap;
    }

    .magazine-archive-btn:hover {
        background: #e00000;
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(224, 0, 0, 0.22);
    }

    .magazine-hero-card {
        position: relative;
        overflow: hidden;
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 28px;
        align-items: center;
        min-height: 430px;
        padding: 34px;
        border-radius: 34px;
        background:
            radial-gradient(circle at 17% 18%, rgba(224, 0, 0, 0.20), transparent 30%),
            linear-gradient(135deg, #111827 0%, #1f2937 48%, #0f172a 100%);
        box-shadow: 0 26px 75px rgba(15, 23, 42, 0.22);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .magazine-hero-card::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
        background-size: 32px 32px;
        pointer-events: none;
    }

    .magazine-hero-content,
    .magazine-cover-stage {
        position: relative;
        z-index: 2;
    }

    .magazine-issue-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: fit-content;
        padding: 8px 13px;
        margin-bottom: 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.10);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #fecaca;
        font-size: 12px;
        font-weight: 850;
        backdrop-filter: blur(8px);
    }

    .magazine-main-title {
        display: block;
        max-width: 680px;
        color: #ffffff;
        font-size: 28px;
        font-weight: 950;
        line-height: 1.75;
        text-decoration: none;
        margin-bottom: 14px;
        transition: 0.22s ease;
    }

    .magazine-main-title:hover {
        color: #fecaca;
        text-decoration: none;
    }

    .magazine-main-summary {
        max-width: 650px;
        color: #cbd5e1;
        font-size: 13px;
        line-height: 2.15;
        margin-bottom: 20px;
    }

    .magazine-main-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 26px;
    }

    .magazine-main-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 12px;
        border-radius: 14px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.10);
        color: #e2e8f0;
        font-size: 11px;
    }

    .magazine-main-actions {
        display: flex;
        align-items: center;
        gap: 11px;
        flex-wrap: wrap;
    }

    .magazine-read-btn,
    .magazine-outline-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 44px;
        padding: 0 18px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 900;
        text-decoration: none;
        transition: 0.24s ease;
    }

    .magazine-read-btn {
        background: #e00000;
        color: #ffffff;
        box-shadow: 0 14px 28px rgba(224, 0, 0, 0.24);
    }

    .magazine-read-btn:hover {
        background: #ffffff;
        color: #e00000;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .magazine-outline-btn {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.13);
    }

    .magazine-outline-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .magazine-cover-stage {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 360px;
        text-decoration: none;
        perspective: 1100px;
    }

    .magazine-cover-shadow {
        position: absolute;
        width: 260px;
        height: 36px;
        bottom: 18px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.35);
        filter: blur(14px);
    }

    .magazine-cover-frame {
        position: relative;
        width: 255px;
        height: 345px;
        padding: 10px;
        border-radius: 22px;
        background: #ffffff;
        box-shadow:
            -18px 22px 45px rgba(0, 0, 0, 0.28),
            inset 0 0 0 1px rgba(15, 23, 42, 0.08);
        transform: rotateY(-9deg) rotateZ(2deg);
        transition: 0.35s ease;
    }

    .magazine-cover-frame::before {
        content: "";
        position: absolute;
        top: 10px;
        bottom: 10px;
        right: 10px;
        width: 12px;
        border-radius: 12px;
        background: linear-gradient(180deg, rgba(15, 23, 42, 0.16), rgba(15, 23, 42, 0.03));
        z-index: 2;
    }

    .magazine-cover-stage:hover .magazine-cover-frame {
        transform: rotateY(-3deg) rotateZ(0deg) translateY(-6px);
        box-shadow:
            -22px 30px 55px rgba(0, 0, 0, 0.34),
            inset 0 0 0 1px rgba(15, 23, 42, 0.08);
    }

    .magazine-cover-frame img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        border-radius: 15px;
        background: #f8fafc;
    }

    .magazine-cover-label {
        position: absolute;
        top: 20px;
        left: 34px;
        z-index: 4;
        padding: 6px 11px;
        border-radius: 999px;
        background: #e00000;
        color: #fff;
        font-size: 11px;
        font-weight: 900;
        box-shadow: 0 10px 22px rgba(224, 0, 0, 0.28);
    }

    .magazine-mini-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 16px;
        margin: 26px 0 16px;
    }

    .magazine-mini-heading h3 {
        margin: 0;
        color: #0f172a;
        font-size: 17px;
        font-weight: 950;
    }

    .magazine-mini-heading span {
        color: #64748b;
        font-size: 12px;
    }

    .magazine-issues-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .magazine-issue-card {
        overflow: hidden;
        border-radius: 24px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.07);
        transition: 0.28s ease;
    }

    .magazine-issue-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 26px 62px rgba(15, 23, 42, 0.13);
        border-color: rgba(224, 0, 0, 0.22);
    }

    .magazine-issue-cover {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 205px;
        padding: 14px;
        background:
            radial-gradient(circle at top left, rgba(224, 0, 0, 0.08), transparent 35%),
            #f8fafc;
        text-decoration: none;
    }

    .magazine-issue-cover img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        display: block;
        filter: drop-shadow(0 12px 16px rgba(15, 23, 42, 0.12));
        transition: 0.28s ease;
    }

    .magazine-issue-card:hover .magazine-issue-cover img {
        transform: scale(1.045) rotateZ(-1deg);
    }

    .magazine-issue-body {
        padding: 15px 16px 16px;
    }

    .magazine-issue-title {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 46px;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.75;
        text-decoration: none;
        margin-bottom: 12px;
    }

    .magazine-issue-title:hover {
        color: #e00000;
        text-decoration: none;
    }

    .magazine-issue-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .magazine-issue-footer span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #94a3b8;
        font-size: 10px;
        white-space: nowrap;
    }

    .magazine-issue-footer a {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #e00000;
        font-size: 11px;
        font-weight: 900;
        text-decoration: none;
        white-space: nowrap;
    }

    .magazine-empty-state {
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        border-radius: 28px;
        padding: 58px 24px;
        text-align: center;
        color: #64748b;
        box-shadow: 0 16px 42px rgba(15, 23, 42, 0.05);
    }

    .magazine-empty-state i {
        font-size: 42px;
        color: #cbd5e1;
        margin-bottom: 14px;
    }

    .magazine-empty-state h3 {
        color: #0f172a;
        font-size: 18px;
        font-weight: 950;
        margin-bottom: 8px;
    }

    .magazine-empty-state p {
        margin: 0;
        font-size: 12px;
    }

    @media (max-width: 1199px) {
        .magazine-hero-card {
            grid-template-columns: 1fr 310px;
        }

        .magazine-cover-frame {
            width: 230px;
            height: 315px;
        }
    }

    @media (max-width: 991px) {
        .magazine-hero-card {
            grid-template-columns: 1fr;
        }

        .magazine-cover-stage {
            order: -1;
            min-height: 320px;
        }

        .magazine-issues-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 575px) {
        .magazine-premium-heading,
        .magazine-mini-heading {
            flex-direction: column;
            align-items: flex-start;
        }

        .magazine-premium-heading h2 {
            font-size: 19px;
        }

        .magazine-hero-card {
            padding: 22px;
            border-radius: 24px;
        }

        .magazine-main-title {
            font-size: 20px;
        }

        .magazine-cover-stage {
            min-height: 275px;
        }

        .magazine-cover-frame {
            width: 200px;
            height: 270px;
            border-radius: 18px;
        }

        .magazine-issues-grid {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .magazine-issue-cover {
            height: 220px;
        }
    }
</style>
