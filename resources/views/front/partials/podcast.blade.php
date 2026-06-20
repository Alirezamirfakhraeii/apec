<div class="mt-5" dir="rtl" style="text-align: right;" id="podcast-section">

    <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom" style="border-width: 2px !important; border-color: #10b981 !important;">
        <div class="d-flex align-items-center">
            <span style="width: 12px; height: 12px; background: #10b981; display: inline-block; border-radius: 2px; margin-left: 10px;"></span>
            <h2 class="h5 font-weight-bold text-dark mb-0" style="letter-spacing: -0.5px;">رادیو نفت و توسعه</h2>
        </div>
        <a href="#" class="font_12 text-decoration-none fw-bold" style="color: #10b981;">
            آرشیو پادکست‌ها <i class="fa fa-arrow-left font_9 mr-1"></i>
        </a>
    </div>

    @if(isset($podcasts) && $podcasts->count() > 0)
        @php $firstPodcast = $podcasts->first(); @endphp

        <div class="row">

            <div class="col-lg-5 col-12 mb-4">
                <div class="position-relative overflow-hidden rounded shadow border bg-dark text-white d-flex flex-column justify-content-between" style="height: 445px;">

                    <img id="main-player-img"
                         src="{{ $firstPodcast->cover_image_url }}"
                         class="position-absolute w-100 h-100"
                         alt="{{ $firstPodcast->title }}"
                         style="object-fit: cover; top:0; right:0; opacity: 0.35; transition: all 0.3s ease;">

                    <div class="position-absolute w-100 h-100" style="top:0; right:0; background: linear-gradient(to top, rgba(10,10,10,1) 0%, rgba(0,0,0,0.4) 70%, transparent 100%);"></div>

                    <div class="position-relative p-4 z-index-10 w-100">
                        <div class="d-flex align-items-center mb-2" style="gap: 5px;">
                            <span class="badge bg-success text-white px-2.5 py-1.5 font_10 rounded-pill shadow-sm">
                                <i class="fa fa-circle ml-1 text-danger animate-pulse" id="playing-dot" style="display:none;"></i> در حال شنیدن
                            </span>
                            <span id="main-player-cat" class="badge bg-secondary text-white px-2.5 py-1.5 font_10 rounded-pill shadow-sm opacity-85">
                                <i class="fa fa-folder ml-1"></i> {{ $firstPodcast->category ? $firstPodcast->category->title : 'بدون دسته‌بندی' }}
                            </span>
                        </div>
                    </div>

                    <div class="position-relative p-4 z-index-10 w-100">
                        <h3 id="main-player-title" class="h5 font-weight-bold line-height-text text-white mb-2" style="transition: all 0.2s;">
                            {{ $firstPodcast->title }}
                        </h3>

                        <p id="main-player-summary" class="text-white-50 font_12 line-height-text text-justify mb-4 text-truncate-2">
                            {{ $firstPodcast->summary }}
                        </p>

                        <div class="w-100 p-2 rounded-lg" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.1);">
                            <audio id="native-audio-element" controls class="w-100 style-audio-player">
                                <source id="main-player-source" src="{{ $firstPodcast->audio_url ? asset('storage/' . $firstPodcast->audio_url) : '' }}" type="audio/mpeg">
                            </audio>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-7 col-12">

                <div class="d-flex align-items-center flex-wrap mb-3" style="gap: 8px;" id="podcast-tabs-container">
                    <button class="btn btn-sm btn-success rounded-pill px-3 filter-tab-btn active" data-target-cat="all">
                        همه موضوعات
                    </button>
                    @foreach($podcastCategories as $cat)
                        <button class="btn btn-sm btn-light border rounded-pill px-3 filter-tab-btn text-secondary" data-target-cat="{{ $cat->id }}">
                            {{ $cat->title }}
                        </button>
                    @endforeach
                </div>

                <div class="d-flex flex-column justify-content-start" style="gap: 10px;" id="podcast-items-list">
                    @foreach($podcasts as $index => $podcast)
                        <div class="bg-white border rounded shadow-sm p-3 transition-all d-flex align-items-center justify-content-between podcast-item-row {{ $index === 0 ? 'active-audio-row' : '' }}"
                             style="cursor: pointer;"
                             data-cat-id="{{ $podcast->category_id ?? 'none' }}"
                             data-title="{{ $podcast->title }}"
                             data-summary="{{ $podcast->summary }}"
                             data-category="{{ $podcast->category ? $podcast->category->title : 'بدون دسته‌بندی' }}"
                             data-image="{{ $podcast->cover_image_url }}"
                             data-audio="{{ $podcast->audio_url ? asset('storage/' . $podcast->audio_url) : '' }}">

                            <div class="d-flex align-items-center overflow-hidden">
                                <div class="position-relative overflow-hidden rounded border bg-light flex-shrink-0" style="width: 65px; height: 65px;">
                                    <img src="{{ $podcast->cover_image_url }}"
                                         class="w-100 h-100"
                                         alt="{{ $podcast->title }}"
                                         style="object-fit: cover;">
                                </div>

                                <div class="mr-3 overflow-hidden">
                                    @if($podcast->category)
                                        <span class="font_10 d-block text-success font-weight-bold mb-1 item-cat-label">
                        <i class="fa fa-tags ml-0.5"></i> {{ $podcast->category->title }}
                    </span>
                                    @endif

                                    <h4 class="font_13 font-weight-bold line-height-text text-dark text-truncate mb-1 item-title-label">
                                        {{ $podcast->title }}
                                    </h4>

                                    <p class="text-muted font_11 mb-0 mt-1">
                    <span class="ml-3">
                        <i class="fa fa-calendar-alt ml-1"></i>
                        {{ $podcast->published_at ? $podcast->published_at->format('Y-m-d') : $podcast->created_at->format('Y-m-d') }}
                    </span>

                                        @if($podcast->duration)
                                            <span>
                            <i class="fa fa-clock ml-1"></i>
                            {{ $podcast->duration }}
                        </span>
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="play-indicator-btn rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                 style="width: 36px; height: 36px; background: #f3f4f6; flex-shrink: 0; transition: all 0.2s;">
                                <i class="fa {{ $index === 0 ? 'fa-volume-up text-success' : 'fa-play text-secondary' }} font_11 mr-0.5"></i>
                            </div>
                        </div>
                    @endforeach

                    <div id="no-podcast-alert" class="bg-white border rounded py-4 text-center text-muted font_12 shadow-sm d-none">
                        <i class="fa fa-microphone-slash d-block mb-2 text-light fa-lg"></i>
                        پادکستی در این دسته‌بندی یافت نشد.
                    </div>
                </div>

            </div>

        </div>
    @else
        <div class="bg-white border rounded py-5 text-center text-muted font_13 shadow-sm">
            <i class="fa fa-microphone-slash fa-2x d-block mb-2 text-light"></i>
            هنوز هیچ پادکستی در سیستم ثبت نشده است.
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tabs = document.querySelectorAll('.filter-tab-btn');
        const rows = document.querySelectorAll('.podcast-item-row');
        const noAudioAlert = document.getElementById('no-podcast-alert');

        const audio = document.getElementById('native-audio-element');
        const audioSource = document.getElementById('main-player-source');
        const mainTitle = document.getElementById('main-player-title');
        const mainSummary = document.getElementById('main-player-summary');
        const mainCat = document.getElementById('main-player-cat');
        const mainImg = document.getElementById('main-player-img');
        const playingDot = document.getElementById('playing-dot');

        // محدود کردن نمایش لیست اولیه به حداکثر ۴ آیتم اول در حالت "همه موضوعات"
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

            // نمایش هشدار خالی بودن
            if (visibleCount === 0) {
                noAudioAlert.classList.remove('d-none');
            } else {
                noAudioAlert.classList.add('d-none');
            }
        }

        // اجرای فیلتر اولیه (نمایش حداکثر ۴ پادکست کل سایت در شروع کار)
        applyLimit('all');

        // کنترل کلیک روی تب‌های دسته‌بندی بالای لیست
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                tabs.forEach(t => {
                    t.classList.remove('btn-success', 'active');
                    t.classList.add('btn-light', 'text-secondary');
                });
                this.classList.remove('btn-light', 'text-secondary');
                this.classList.add('btn-success', 'active');

                const targetCat = this.getAttribute('data-target-cat');
                applyLimit(targetCat);
            });
        });

        // کنترل کلیک روی هر ردیف پادکست جهت انتقال داده به پلیر سمت راست
        rows.forEach(row => {
            row.addEventListener('click', function() {
                rows.forEach(r => {
                    r.classList.remove('active-audio-row');
                    r.querySelector('.play-indicator-btn i').className = 'fa fa-play text-secondary font_11 mr-0.5';
                });

                this.classList.add('active-audio-row');
                this.querySelector('.play-indicator-btn i').className = 'fa fa-volume-up text-success font_11 mr-0.5';

                const audioUrl = this.getAttribute('data-audio');
                const title = this.getAttribute('data-title');
                const summary = this.getAttribute('data-summary');
                const category = this.getAttribute('data-category');
                const image = this.getAttribute('data-image');

                mainTitle.textContent = title;
                mainSummary.textContent = summary ? summary : '';
                mainCat.innerHTML = `<i class="fa fa-folder ml-1"></i> ${category}`;
                mainImg.src = image;

                if (audioUrl) {
                    audioSource.src = audioUrl;
                    audio.load();
                    audio.play()
                        .then(() => playingDot.style.display = 'inline-block')
                        .catch(err => console.log("Playback interaction error:", err));
                } else {
                    audioSource.src = '';
                    audio.load();
                    playingDot.style.display = 'none';
                }
            });
        });

        audio.addEventListener('play', () => { playingDot.style.display = 'inline-block'; });
        audio.addEventListener('pause', () => { playingDot.style.display = 'none'; });
        audio.addEventListener('ended', () => { playingDot.style.display = 'none'; });
    });
</script>

<style>
    .active-audio-row {
        background-color: #f0fdf4 !important;
        border-color: #10b981 !important;
        box-shadow: 0 .25rem .75rem rgba(16, 185, 129, 0.15) !important;
    }
    .active-audio-row .item-title-label {
        color: #10b981 !important;
    }
    .active-audio-row .play-indicator-btn {
        background: #dcfce7 !important;
    }
    .podcast-item-row {
        transition: all 0.25s ease-in-out;
    }
    .podcast-item-row:hover:not(.active-audio-row) {
        transform: translateX(-3px);
        background-color: #f9fafb !important;
    }
    .style-audio-player {
        outline: none;
    }
    .style-audio-player::-webkit-media-controls-enclosure {
        background-color: rgba(20, 20, 20, 0.95);
    }
    .filter-tab-btn {
        font-size: 11px !important;
        font-weight: bold;
        transition: all 0.2s;
    }
</style>
