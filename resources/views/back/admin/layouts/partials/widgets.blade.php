<style>
    .news-dashboard-cards {
        direction: rtl;
    }

    .news-stat-card {
        background: #ffffff;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        padding: 20px;
        min-height: 210px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        margin-bottom: 20px;
    }

    .news-stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #e5e7eb, #f8fafc);
    }

    .news-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.09);
    }

    .news-stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 22px;
    }

    .news-stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .news-stat-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 999px;
    }

    .news-stat-body h6 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .news-stat-body h3 {
        font-size: 31px;
        color: #0f172a;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .news-stat-body p {
        font-size: 12px;
        color: #94a3b8;
        line-height: 1.9;
        margin-bottom: 0;
        min-height: 45px;
    }

    .news-stat-footer {
        border-top: 1px solid #f1f5f9;
        margin-top: 18px;
        padding-top: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .news-stat-footer span {
        font-size: 12px;
        color: #94a3b8;
    }

    .news-stat-footer strong {
        font-size: 12px;
        color: #334155;
        font-weight: 700;
    }

    /* Colors */
    .icon-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .icon-orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .icon-green {
        background: #ecfdf5;
        color: #16a34a;
    }

    .icon-purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .badge-blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .badge-orange {
        background: #fff7ed;
        color: #ea580c;
    }

    .badge-green {
        background: #ecfdf5;
        color: #16a34a;
    }

    .badge-purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    @media (max-width: 767px) {
        .news-stat-card {
            min-height: auto;
            padding: 18px;
        }

        .news-stat-body h3 {
            font-size: 26px;
        }
    }
</style>





<div class="row row-sm news-dashboard-cards">

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="news-stat-card">
            <div class="news-stat-header">
                <div class="news-stat-icon icon-blue">
                    <i class="fas fa-newspaper"></i>
                </div>
                <span class="news-stat-badge badge-blue">امروز</span>
            </div>

            <div class="news-stat-body">
                <h6>اخبار منتشر شده امروز</h6>
                <h3>{{ number_format($todayPublishedPostsCount ?? 0) }}</h3>
                <p>تعداد خبرهایی که امروز روی سایت منتشر شده‌اند</p>
            </div>

            <div class="news-stat-footer">
                <span>وضعیت انتشار</span>
                <strong>فعال</strong>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="news-stat-card">
            <div class="news-stat-header">
                <div class="news-stat-icon icon-orange">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="news-stat-badge badge-orange">بازبینی</span>
            </div>

            <div class="news-stat-body">
                <h6>اخبار در انتظار بررسی</h6>
                <h3>{{ number_format($pendingPostsCount ?? 0) }}</h3>
                <p>خبرهایی که هنوز نیازمند تأیید یا ویرایش سردبیر هستند</p>
            </div>

            <div class="news-stat-footer">
                <span>وضعیت تحریریه</span>
                <strong>در انتظار</strong>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="news-stat-card">
            <div class="news-stat-header">
                <div class="news-stat-icon icon-green">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="news-stat-badge badge-green">منتشر شده</span>
            </div>

            <div class="news-stat-body">
                <h6>کل اخبار منتشر شده</h6>
                <h3>{{ number_format($publishedPostsCount ?? 0) }}</h3>
                <p>مجموع خبرهای فعال و قابل نمایش در آرشیو سایت</p>
            </div>

            <div class="news-stat-footer">
                <span>آرشیو خبری</span>
                <strong>فعال</strong>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
        <div class="news-stat-card">
            <div class="news-stat-header">
                <div class="news-stat-icon icon-purple">
                    <i class="fas fa-eye"></i>
                </div>
                <span class="news-stat-badge badge-purple">زنده</span>
            </div>

            <div class="news-stat-body">
                <h6>بازدید امروز سایت</h6>
                <h3>{{ number_format($todayViewsCount ?? 0) }}</h3>
                <p>تعداد بازدید ثبت‌شده برای محتوای خبری در امروز</p>
            </div>

            <div class="news-stat-footer">
                <span>آمار بازدید</span>
                <strong>امروز</strong>
            </div>
        </div>
    </div>

</div>
