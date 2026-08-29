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
