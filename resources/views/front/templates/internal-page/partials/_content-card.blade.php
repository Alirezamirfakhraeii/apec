{{-- Main page content card --}}
<article id="komyte-main-box" class="komyte-content-card">

    <div class="komyte-content-head">
        <div>
            <span class="komyte-small-title">معرفی و اطلاعات کامل</span>
            <h2>{{ $pageTitle }}</h2>
        </div>

        <button id="komyte-toggle-reader" type="button" class="komyte-reader-btn">
            <i class="fa fa-moon ml-1"></i>
            حالت مطالعه
        </button>
    </div>

    <div class="komyte-meta-strip">
        <div>
            <i class="fa fa-calendar-alt"></i>
            <span>آخرین بروزرسانی:</span>
            <strong>{{ optional($page->updated_at ?? null)->format('Y/m/d') ?? 'ثبت نشده' }}</strong>
        </div>

        <div>
            <i class="fa fa-check-circle"></i>
            <span>وضعیت:</span>
            <strong>منتشر شده</strong>
        </div>

        <div>
            <i class="fa fa-link"></i>
            <span>آدرس:</span>
            <strong>{{ $path ?? request()->path() }}</strong>
        </div>
    </div>

    @if($pageImage)
        <figure class="komyte-cover-box">
            <img src="{{ $pageImage }}" alt="{{ $pageTitle }}" class="komyte-cover-img">

            <figcaption>
                <span>{{ $pageTitle }}</span>
            </figcaption>
        </figure>
    @else
        <div class="komyte-cover-placeholder">
            <div>
                <span>{{ mb_substr($pageTitle, 0, 1) }}</span>
                <p>{{ $pageTitle }}</p>
            </div>
        </div>
    @endif

    @if($pageSummary)
        <div class="komyte-summary-box">
            <div class="komyte-summary-icon">
                <i class="fa fa-quote-right"></i>
            </div>

            <div>
                <strong>خلاصه صفحه</strong>
                <p>{{ $pageSummary }}</p>
            </div>
        </div>
    @endif

    <div id="komyte-body" class="komyte-body">
        {!! $pageBody !!}
    </div>

    <div class="komyte-share-box">
        <span>اشتراک‌گذاری این صفحه:</span>

        <div>
            <a href="https://telegram.me/share/url?url={{ request()->url() }}&text={{ $pageTitle }}" target="_blank" rel="noopener">
                <i class="fab fa-telegram-plane"></i>
                تلگرام
            </a>

            <a href="https://whatsapp://send?text={{ request()->url() }}" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i>
                واتساپ
            </a>
        </div>
    </div>

</article>
