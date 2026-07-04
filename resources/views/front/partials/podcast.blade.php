<style>
    #podcast-section {
        --podcast-primary: #10b981;
        --podcast-primary-dark: #047857;
        --podcast-dark: #0f172a;
        --podcast-soft: #f8fafc;
        --podcast-border: #e5e7eb;
        --podcast-muted: #64748b;
    }

    #podcast-section .podcast-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 14px;
        border-bottom: 1px solid var(--podcast-border);
        margin-bottom: 24px;
    }

    #podcast-section .podcast-section-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #podcast-section .podcast-title-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        color: var(--podcast-primary-dark);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #bbf7d0;
    }

    #podcast-section .podcast-section-title {
        color: #111827;
        font-size: 18px;
        font-weight: 900;
        margin: 0;
    }

    #podcast-section .podcast-section-subtitle {
        color: var(--podcast-muted);
        font-size: 12px;
        margin-top: 3px;
    }

    #podcast-section .podcast-archive-link {
        color: var(--podcast-primary-dark);
        background: #ecfdf5;
        border: 1px solid #bbf7d0;
        border-radius: 999px;
        padding: 8px 14px;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: 0.2s ease;
    }

    #podcast-section .podcast-archive-link:hover {
        background: var(--podcast-primary);
        color: #ffffff;
        text-decoration: none;
    }

    #podcast-section .podcast-feature-card {
        height: 470px;
        border-radius: 24px;
        position: relative;
        overflow: hidden;
        background: #020617;
        box-shadow: 0 22px 50px rgba(15, 23, 42, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    #podcast-section .podcast-feature-img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.45;
        transform: scale(1.02);
        transition: 0.35s ease;
    }

    #podcast-section .podcast-feature-card:hover .podcast-feature-img {
        transform: scale(1.06);
        opacity: 0.52;
    }

    #podcast-section .podcast-feature-overlay {
        position: absolute;
        inset: 0;
        background:
            radial-gradient(circle at top left, rgba(16, 185, 129, 0.28), transparent 34%),
            linear-gradient(to top, rgba(2, 6, 23, 0.98) 0%, rgba(2, 6, 23, 0.78) 45%, rgba(2, 6, 23, 0.25) 100%);
    }

    #podcast-section .podcast-feature-content {
        position: relative;
        z-index: 2;
        height: 100%;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    #podcast-section .podcast-badge-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;
    }

    #podcast-section .podcast-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border-radius: 999px;
        padding: 7px 11px;
        font-size: 11px;
        font-weight: 800;
        color: #ffffff;
        background: rgba(255, 255, 255, 0.11);
        border: 1px solid rgba(255, 255, 255, 0.14);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    #podcast-section .podcast-badge.is-live {
        background: rgba(16, 185, 129, 0.22);
        border-color: rgba(16, 185, 129, 0.35);
    }

    #podcast-section .playing-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #ef4444;
        display: none;
        box-shadow: 0 0 0 rgba(239, 68, 68, 0.7);
        animation: podcastPulse 1.3s infinite;
    }

    @keyframes podcastPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.65);
        }

        70% {
            box-shadow: 0 0 0 8px rgba(239, 68, 68, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
        }
    }

    #podcast-section .podcast-feature-title {
        color: #ffffff;
        font-size: 20px;
        font-weight: 900;
        line-height: 1.8;
        margin-bottom: 10px;
    }

    #podcast-section .podcast-feature-summary {
        color: rgba(255, 255, 255, 0.72);
        font-size: 12px;
        line-height: 2;
        margin-bottom: 18px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #podcast-section .custom-podcast-player {
        width: 100%;
        padding: 17px;
        border-radius: 22px;
        background:
            radial-gradient(circle at 15% 0%, rgba(52, 211, 153, 0.22), transparent 32%),
            linear-gradient(135deg, rgba(15, 23, 42, 0.94) 0%, rgba(30, 41, 59, 0.92) 100%);
        border: 1px solid rgba(255, 255, 255, 0.13);
        box-shadow:
            0 18px 40px rgba(0, 0, 0, 0.35),
            inset 0 1px 0 rgba(255, 255, 255, 0.09);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
    }

    #podcast-section .player-main-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
    }

    #podcast-section .player-controls {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    #podcast-section .player-play-btn {
        width: 58px;
        height: 58px;
        min-width: 58px;
        border-radius: 19px;
        border: 0;
        background: linear-gradient(135deg, #ffffff 0%, #d1fae5 100%);
        color: #064e3b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        cursor: pointer;
        box-shadow:
            0 14px 28px rgba(0, 0, 0, 0.28),
            inset 0 1px 0 rgba(255, 255, 255, 0.9);
        transition: 0.2s ease;
        outline: none;
    }

    #podcast-section .player-play-btn:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 100%);
    }

    #podcast-section .player-play-btn.is-playing {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
    }

    #podcast-section .player-seek-btn {
        width: 42px;
        height: 42px;
        min-width: 42px;
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        background: rgba(255, 255, 255, 0.10);
        color: #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 3px;
        font-size: 12px;
        font-weight: 900;
        cursor: pointer;
        transition: 0.2s ease;
        outline: none;
    }

    #podcast-section .player-seek-btn span {
        font-size: 10px;
        line-height: 1;
        font-weight: 900;
    }

    #podcast-section .player-seek-btn:hover {
        background: rgba(16, 185, 129, 0.22);
        border-color: rgba(16, 185, 129, 0.45);
        color: #ffffff;
        transform: translateY(-1px);
    }

    #podcast-section .player-info {
        min-width: 0;
        flex: 1;
    }

    #podcast-section .player-label {
        color: #6ee7b7;
        font-size: 11px;
        font-weight: 800;
        margin-bottom: 5px;
    }

    #podcast-section .player-title {
        color: #ffffff;
        font-size: 13px;
        font-weight: 900;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #podcast-section .player-time {
        color: #cbd5e1;
        font-size: 11px;
        font-weight: 800;
        direction: ltr;
        white-space: nowrap;
    }

    #podcast-section .player-progress-wrap {
        width: 100%;
        height: 9px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
        cursor: pointer;
        overflow: hidden;
        position: relative;
    }

    #podcast-section .player-progress {
        width: 0;
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #10b981 0%, #34d399 45%, #67e8f9 100%);
        box-shadow: 0 0 18px rgba(52, 211, 153, 0.55);
        transition: width 0.12s linear;
    }

    #podcast-section .podcast-side-panel {
        background: #ffffff;
        border: 1px solid var(--podcast-border);
        border-radius: 22px;
        padding: 18px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.07);
        height: 470px;
        display: flex;
        flex-direction: column;
    }

    #podcast-section .podcast-panel-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 14px;
    }

    #podcast-section .podcast-panel-title {
        color: #111827;
        font-size: 14px;
        font-weight: 900;
        margin: 0;
    }

    #podcast-section .podcast-panel-count {
        color: var(--podcast-muted);
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 800;
    }

    #podcast-section .podcast-tabs {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 15px;
    }

    #podcast-section .podcast-tab-btn {
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        border-radius: 999px;
        padding: 7px 13px;
        font-size: 11px;
        font-weight: 800;
        cursor: pointer;
        transition: 0.2s ease;
    }

    #podcast-section .podcast-tab-btn:hover {
        border-color: #bbf7d0;
        background: #ecfdf5;
        color: #047857;
    }

    #podcast-section .podcast-tab-btn.active {
        background: var(--podcast-primary);
        border-color: var(--podcast-primary);
        color: #ffffff;
        box-shadow: 0 8px 18px rgba(16, 185, 129, 0.24);
    }

    #podcast-section .podcast-items-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        overflow-y: auto;
        padding-left: 3px;
    }

    #podcast-section .podcast-items-list::-webkit-scrollbar {
        width: 5px;
    }

    #podcast-section .podcast-items-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    #podcast-section .podcast-item-row {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 17px;
        padding: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        transition: 0.2s ease;
    }

    #podcast-section .podcast-item-row:hover {
        border-color: #bbf7d0;
        background: #fbfefc;
        transform: translateX(-3px);
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.06);
    }

    #podcast-section .podcast-item-row.active-audio-row {
        background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
        border-color: #86efac;
        box-shadow: 0 10px 24px rgba(16, 185, 129, 0.14);
    }

    #podcast-section .podcast-item-main {
        display: flex;
        align-items: center;
        min-width: 0;
        flex: 1;
    }

    #podcast-section .podcast-item-cover {
        width: 66px;
        height: 66px;
        min-width: 66px;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        position: relative;
    }

    #podcast-section .podcast-item-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #podcast-section .podcast-item-body {
        margin-right: 12px;
        overflow: hidden;
        min-width: 0;
    }

    #podcast-section .podcast-item-cat {
        color: #059669;
        font-size: 10px;
        font-weight: 900;
        margin-bottom: 5px;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #podcast-section .podcast-item-title {
        color: #111827;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.7;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #podcast-section .active-audio-row .podcast-item-title {
        color: #047857;
    }

    #podcast-section .podcast-item-meta {
        color: #94a3b8;
        font-size: 11px;
        font-weight: 700;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    #podcast-section .play-indicator-btn {
        width: 38px;
        height: 38px;
        min-width: 38px;
        border-radius: 13px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.2s ease;
    }

    #podcast-section .active-audio-row .play-indicator-btn {
        background: #d1fae5;
        border-color: #86efac;
        color: #047857;
    }

    #podcast-section .podcast-empty-box {
        background: #ffffff;
        border: 1px dashed #cbd5e1;
        border-radius: 18px;
        padding: 35px 15px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
    }

    #podcast-section .podcast-empty-box i {
        font-size: 26px;
        display: block;
        margin-bottom: 10px;
        color: #cbd5e1;
    }

    @media (max-width: 991px) {
        #podcast-section .podcast-feature-card,
        #podcast-section .podcast-side-panel {
            height: auto;
        }

        #podcast-section .podcast-side-panel {
            margin-top: 16px;
        }

        #podcast-section .podcast-items-list {
            max-height: none;
            overflow: visible;
        }
    }

    @media (max-width: 576px) {
        #podcast-section .podcast-section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        #podcast-section .podcast-archive-link {
            width: 100%;
            text-align: center;
        }

        #podcast-section .podcast-feature-content {
            padding: 18px;
        }

        #podcast-section .player-main-row {
            flex-wrap: wrap;
        }

        #podcast-section .player-controls {
            width: 100%;
            justify-content: center;
        }

        #podcast-section .player-play-btn {
            width: 54px;
            height: 54px;
            min-width: 54px;
            border-radius: 17px;
        }

        #podcast-section .player-time {
            margin-right: auto;
        }
    }
</style>

<div class="mt-5" dir="rtl" style="text-align: right;" id="podcast-section">

    <div class="podcast-section-header">
        <div class="podcast-section-title-wrap">
            <div class="podcast-title-icon">
                <i class="fa fa-headphones"></i>
            </div>

            <div>
                <h2 class="podcast-section-title">پادکست‌ها</h2>
                <div class="podcast-section-subtitle">
                    تازه‌ترین گفت‌وگوها، روایت‌ها و فایل‌های صوتی
                </div>
            </div>
        </div>

        <a href="{{ route('front.podcasts.archive') }}" class="podcast-archive-link">
            آرشیو پادکست‌ها
            <i class="fa fa-arrow-left font_9 mr-1"></i>
        </a>
    </div>

    @if(isset($podcasts) && $podcasts->count() > 0)
        @php $firstPodcast = $podcasts->first(); @endphp

        <div class="row">

            <div class="col-lg-5 col-12">
                <div class="podcast-feature-card">

                    <img id="main-player-img"
                         src="{{ $firstPodcast->cover_image_url }}"
                         class="podcast-feature-img"
                         alt="{{ $firstPodcast->title }}">

                    <div class="podcast-feature-overlay"></div>

                    <div class="podcast-feature-content">

                        <div class="podcast-badge-row">
                            <span class="podcast-badge is-live">
                                <span class="playing-dot" id="playing-dot"></span>
                                <span id="playing-status-text">آماده پخش</span>
                            </span>

                            <span id="main-player-cat" class="podcast-badge">
                                <i class="fa fa-folder ml-1"></i>
                                {{ $firstPodcast->category ? $firstPodcast->category->title : 'بدون دسته‌بندی' }}
                            </span>
                        </div>

                        <div>
                            <h3 id="main-player-title" class="podcast-feature-title">
                                {{ $firstPodcast->title }}
                            </h3>

                            <p id="main-player-summary" class="podcast-feature-summary">
                                {{ $firstPodcast->summary }}
                            </p>

                            <div class="custom-podcast-player">
                                <audio id="native-audio-element" preload="metadata">
                                    <source id="main-player-source"
                                            src="{{ $firstPodcast->audio_url ? asset('storage/' . $firstPodcast->audio_url) : '' }}"
                                            type="audio/mpeg">
                                </audio>

                                <div class="player-main-row">

                                    <div class="player-controls">
                                        <button type="button"
                                                class="player-seek-btn"
                                                id="player-backward-btn"
                                                aria-label="۱۵ ثانیه عقب">
                                            <i class="fa fa-undo"></i>
                                            <span>15</span>
                                        </button>

                                        <button type="button"
                                                class="player-play-btn"
                                                id="player-play-btn"
                                                aria-label="پخش پادکست">
                                            <i class="fa fa-play" id="player-play-icon"></i>
                                        </button>

                                        <button type="button"
                                                class="player-seek-btn"
                                                id="player-forward-btn"
                                                aria-label="۱۵ ثانیه جلو">
                                            <i class="fa fa-repeat"></i>
                                            <span>15</span>
                                        </button>
                                    </div>

                                    <div class="player-info">
                                        <div class="player-label">در حال پخش</div>
                                        <div class="player-title" id="player-current-title">
                                            {{ $firstPodcast->title ?? 'پادکست' }}
                                        </div>
                                    </div>

                                    <div class="player-time">
                                        <span id="current-time">00:00</span>
                                        /
                                        <span id="duration-time">00:00</span>
                                    </div>
                                </div>

                                <div class="player-progress-wrap" id="player-progress-wrap">
                                    <div class="player-progress" id="player-progress"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-12">

                <div class="podcast-side-panel">

                    <div class="podcast-panel-head">
                        <h3 class="podcast-panel-title">
                            <i class="fa fa-list-ul ml-1"></i>
                            لیست پادکست‌ها
                        </h3>

                        <span class="podcast-panel-count">
                            {{ $podcasts->count() }} قسمت
                        </span>
                    </div>

                    <div class="podcast-tabs" id="podcast-tabs-container">
                        <button type="button" class="podcast-tab-btn filter-tab-btn active" data-target-cat="all">
                            همه موضوعات
                        </button>

                        @foreach($podcastCategories as $cat)
                            <button type="button" class="podcast-tab-btn filter-tab-btn" data-target-cat="{{ $cat->id }}">
                                {{ $cat->title }}
                            </button>
                        @endforeach
                    </div>

                    <div class="podcast-items-list" id="podcast-items-list">
                        @foreach($podcasts as $index => $podcast)
                            <div class="podcast-item-row {{ $index === 0 ? 'active-audio-row' : '' }}"
                                 data-cat-id="{{ $podcast->category_id ?? 'none' }}"
                                 data-title="{{ e($podcast->title) }}"
                                 data-summary="{{ e($podcast->summary) }}"
                                 data-category="{{ $podcast->category ? e($podcast->category->title) : 'بدون دسته‌بندی' }}"
                                 data-image="{{ $podcast->cover_image_url }}"
                                 data-audio="{{ $podcast->audio_url ? asset('storage/' . $podcast->audio_url) : '' }}">

                                <div class="podcast-item-main">
                                    <div class="podcast-item-cover">
                                        <img src="{{ $podcast->cover_image_url }}"
                                             alt="{{ $podcast->title }}">
                                    </div>

                                    <div class="podcast-item-body">
                                        @if($podcast->category)
                                            <span class="podcast-item-cat">
                                                <i class="fa fa-tags ml-1"></i>
                                                {{ $podcast->category->title }}
                                            </span>
                                        @endif

                                        <h4 class="podcast-item-title">
                                            {{ $podcast->title }}
                                        </h4>

                                        <div class="podcast-item-meta">
                                            <span>
                                                <i class="fa fa-calendar ml-1"></i>
                                                {{ $podcast->published_at ? $podcast->published_at->format('Y-m-d') : $podcast->created_at->format('Y-m-d') }}
                                            </span>

                                            @if($podcast->duration)
                                                <span>
                                                    <i class="fa fa-clock-o ml-1"></i>
                                                    {{ $podcast->duration }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="play-indicator-btn">
                                    <i class="fa {{ $index === 0 ? 'fa-volume-up' : 'fa-play' }}"></i>
                                </div>
                            </div>
                        @endforeach

                        <div id="no-podcast-alert" class="podcast-empty-box d-none">
                            <i class="fa fa-microphone-slash"></i>
                            پادکستی در این دسته‌بندی یافت نشد.
                        </div>
                    </div>

                </div>

            </div>

        </div>
    @else
        <div class="podcast-empty-box">
            <i class="fa fa-microphone-slash"></i>
            هنوز هیچ پادکستی در سیستم ثبت نشده است.
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const section = document.getElementById('podcast-section');

        if (!section) {
            return;
        }

        const tabs = section.querySelectorAll('.filter-tab-btn');
        const rows = section.querySelectorAll('.podcast-item-row');
        const noAudioAlert = section.querySelector('#no-podcast-alert');

        const audio = section.querySelector('#native-audio-element');
        const audioSource = section.querySelector('#main-player-source');

        const mainTitle = section.querySelector('#main-player-title');
        const mainSummary = section.querySelector('#main-player-summary');
        const mainCat = section.querySelector('#main-player-cat');
        const mainImg = section.querySelector('#main-player-img');

        const playBtn = section.querySelector('#player-play-btn');
        const playIcon = section.querySelector('#player-play-icon');
        const backwardBtn = section.querySelector('#player-backward-btn');
        const forwardBtn = section.querySelector('#player-forward-btn');

        const progressWrap = section.querySelector('#player-progress-wrap');
        const progress = section.querySelector('#player-progress');
        const currentTimeEl = section.querySelector('#current-time');
        const durationTimeEl = section.querySelector('#duration-time');
        const playerCurrentTitle = section.querySelector('#player-current-title');

        const playingDot = section.querySelector('#playing-dot');
        const playingStatusText = section.querySelector('#playing-status-text');

        let activeRow = section.querySelector('.podcast-item-row.active-audio-row');

        function formatTime(seconds) {
            if (!seconds || isNaN(seconds)) {
                return '00:00';
            }

            const min = Math.floor(seconds / 60);
            const sec = Math.floor(seconds % 60);

            return String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
        }

        function setPlayingState(isPlaying) {
            if (!playBtn || !playIcon) {
                return;
            }

            if (isPlaying) {
                playBtn.classList.add('is-playing');
                playIcon.classList.remove('fa-play');
                playIcon.classList.add('fa-pause');

                if (playingDot) {
                    playingDot.style.display = 'inline-block';
                }

                if (playingStatusText) {
                    playingStatusText.textContent = 'در حال پخش';
                }

                if (activeRow) {
                    const icon = activeRow.querySelector('.play-indicator-btn i');

                    if (icon) {
                        icon.className = 'fa fa-volume-up';
                    }
                }
            } else {
                playBtn.classList.remove('is-playing');
                playIcon.classList.remove('fa-pause');
                playIcon.classList.add('fa-play');

                if (playingDot) {
                    playingDot.style.display = 'none';
                }

                if (playingStatusText) {
                    playingStatusText.textContent = 'آماده پخش';
                }

                if (activeRow) {
                    const icon = activeRow.querySelector('.play-indicator-btn i');

                    if (icon) {
                        icon.className = 'fa fa-play';
                    }
                }
            }
        }

        function resetProgress() {
            if (progress) {
                progress.style.width = '0%';
            }

            if (currentTimeEl) {
                currentTimeEl.textContent = '00:00';
            }

            if (durationTimeEl) {
                durationTimeEl.textContent = '00:00';
            }
        }

        function setActiveRow(row) {
            rows.forEach(item => {
                item.classList.remove('active-audio-row');

                const icon = item.querySelector('.play-indicator-btn i');

                if (icon) {
                    icon.className = 'fa fa-play';
                }
            });

            row.classList.add('active-audio-row');
            activeRow = row;
        }

        function loadPodcastFromRow(row, shouldPlay = true) {
            const audioUrl = row.getAttribute('data-audio') || '';
            const title = row.getAttribute('data-title') || 'پادکست';
            const summary = row.getAttribute('data-summary') || '';
            const category = row.getAttribute('data-category') || 'بدون دسته‌بندی';
            const image = row.getAttribute('data-image') || '';

            setActiveRow(row);

            if (mainTitle) {
                mainTitle.textContent = title;
            }

            if (mainSummary) {
                mainSummary.textContent = summary;
            }

            if (playerCurrentTitle) {
                playerCurrentTitle.textContent = title;
            }

            if (mainCat) {
                mainCat.innerHTML = '<i class="fa fa-folder ml-1"></i> ' + category;
            }

            if (mainImg && image) {
                mainImg.src = image;
            }

            resetProgress();

            if (!audio || !audioSource) {
                return;
            }

            audio.pause();
            setPlayingState(false);

            if (!audioUrl) {
                audioSource.src = '';
                audio.load();
                return;
            }

            audioSource.src = audioUrl;
            audio.load();

            if (shouldPlay) {
                audio.play()
                    .then(() => {
                        setPlayingState(true);
                    })
                    .catch(() => {
                        setPlayingState(false);
                    });
            }
        }

        function applyLimit(targetCatId) {
            let visibleCount = 0;

            rows.forEach(row => {
                const rowCatId = row.getAttribute('data-cat-id');

                if (targetCatId === 'all' || rowCatId === targetCatId) {
                    if (visibleCount < 4) {
                        row.style.setProperty('display', 'flex', 'important');
                        visibleCount++;
                    } else {
                        row.style.setProperty('display', 'none', 'important');
                    }
                } else {
                    row.style.setProperty('display', 'none', 'important');
                }
            });

            if (noAudioAlert) {
                if (visibleCount === 0) {
                    noAudioAlert.classList.remove('d-none');
                } else {
                    noAudioAlert.classList.add('d-none');
                }
            }
        }

        applyLimit('all');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(item => {
                    item.classList.remove('active');
                });

                this.classList.add('active');

                const targetCat = this.getAttribute('data-target-cat');

                applyLimit(targetCat);
            });
        });

        rows.forEach(row => {
            row.addEventListener('click', function () {
                loadPodcastFromRow(this, true);
            });
        });

        if (playBtn && audio) {
            playBtn.addEventListener('click', function () {
                if (!audioSource || !audioSource.getAttribute('src')) {
                    return;
                }

                if (audio.paused) {
                    audio.play()
                        .then(() => {
                            setPlayingState(true);
                        })
                        .catch(() => {
                            setPlayingState(false);
                        });
                } else {
                    audio.pause();
                    setPlayingState(false);
                }
            });
        }

        if (backwardBtn && audio) {
            backwardBtn.addEventListener('click', function () {
                if (!audio.duration) {
                    return;
                }

                audio.currentTime = Math.max(0, audio.currentTime - 15);
            });
        }

        if (forwardBtn && audio) {
            forwardBtn.addEventListener('click', function () {
                if (!audio.duration) {
                    return;
                }

                audio.currentTime = Math.min(audio.duration, audio.currentTime + 15);
            });
        }

        if (audio) {
            audio.addEventListener('loadedmetadata', function () {
                if (durationTimeEl) {
                    durationTimeEl.textContent = formatTime(audio.duration);
                }
            });

            audio.addEventListener('timeupdate', function () {
                const percent = audio.duration ? (audio.currentTime / audio.duration) * 100 : 0;

                if (progress) {
                    progress.style.width = percent + '%';
                }

                if (currentTimeEl) {
                    currentTimeEl.textContent = formatTime(audio.currentTime);
                }

                if (durationTimeEl) {
                    durationTimeEl.textContent = formatTime(audio.duration);
                }
            });

            audio.addEventListener('play', function () {
                setPlayingState(true);
            });

            audio.addEventListener('pause', function () {
                setPlayingState(false);
            });

            audio.addEventListener('ended', function () {
                resetProgress();
                setPlayingState(false);
            });
        }

        if (progressWrap && audio) {
            progressWrap.addEventListener('click', function (event) {
                if (!audio.duration) {
                    return;
                }

                const rect = progressWrap.getBoundingClientRect();
                const clickX = event.clientX - rect.left;
                const percent = Math.max(0, Math.min(1, clickX / rect.width));

                audio.currentTime = percent * audio.duration;
            });
        }
    });
</script>
