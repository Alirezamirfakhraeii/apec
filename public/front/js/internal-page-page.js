(function () {
    'use strict';

    function updateClockAndDate() {
        const now = new Date();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const clockEl = document.getElementById('komyte-live-clock');

        if (clockEl) {
            clockEl.textContent = `${hours}:${minutes}:${seconds}`;
        }

        const dateEl = document.getElementById('komyte-persian-date');

        if (dateEl) {
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };

            dateEl.textContent = new Intl.DateTimeFormat('fa-IR', options).format(now);
        }
    }

    function updateReadingProgress() {
        const progressEl = document.getElementById('komyte-reading-progress-bar');

        if (!progressEl) {
            return;
        }

        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = height > 0 ? (winScroll / height) * 100 : 0;

        progressEl.style.width = `${scrolled}%`;
    }

    function initReaderMode() {
        const readerButton = document.getElementById('komyte-toggle-reader');

        if (!readerButton) {
            return;
        }

        readerButton.addEventListener('click', function () {
            document.body.classList.toggle('komyte-reader-dark');

            if (document.body.classList.contains('komyte-reader-dark')) {
                readerButton.innerHTML = '<i class="fa fa-sun ml-1"></i> حالت روز';
            } else {
                readerButton.innerHTML = '<i class="fa fa-moon ml-1"></i> حالت مطالعه';
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        updateClockAndDate();
        setInterval(updateClockAndDate, 1000);

        updateReadingProgress();
        window.addEventListener('scroll', updateReadingProgress);

        initReaderMode();
    });
})();
