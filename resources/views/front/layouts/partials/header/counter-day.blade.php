<style>
    .assembly-announcement {
        position: relative;
        width: 100%;
        background: #14254E;
        color: #fff;
        padding: 10px 42px;
        box-sizing: border-box;
        overflow: hidden;
        isolation: isolate;
        font-family: inherit;
        text-align: center;
    }

    .assembly-announcement[hidden] {
        display: none !important;
    }

    /* رد نور متحرک */
    .assembly-announcement::before {
        content: "";
        position: absolute;
        top: 0;
        right: -60%;
        width: 40%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.02),
            rgba(255,255,255,.17),
            rgba(255,255,255,.02),
            transparent
        );
        transform: skewX(-25deg);
        animation: assemblyShine 5s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }

    .assembly-announcement__content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        min-width: 0;
    }

    .assembly-announcement__icon {
        color: #eac47b;
        font-size: 18px;
        flex-shrink: 0;
        animation: assemblyGlow 2.5s ease-in-out infinite;
    }

    .assembly-announcement__title {
        font-size: 13px;
        font-weight: 500;
        white-space: nowrap;
    }

    /* شمارش معکوس قرمز */
    .assembly-announcement__countdown {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #922638;
        border: 1px solid #C44B61;
        border-radius: 5px;
        padding: 4px 13px;
        font-size: 13px;
        font-weight: 800;
        color: #fff;
        white-space: nowrap;
        box-shadow: 0 2px 10px rgba(143,32,54,.22);
    }

    .assembly-announcement__date {
        color: #eac47b;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .assembly-announcement__close {
        position: absolute;
        top: 50%;
        left: 12px;
        z-index: 2;
        transform: translateY(-50%);
        background: transparent;
        border: 0;
        color: #fff;
        font-size: 23px;
        line-height: 1;
        opacity: .7;
        cursor: pointer;
        padding: 5px;
    }

    .assembly-announcement__close:hover {
        opacity: 1;
    }

    @keyframes assemblyShine {
        0%, 15% {
            right: -60%;
        }
        45%, 100% {
            right: 120%;
        }
    }

    @keyframes assemblyGlow {
        0%, 100% {
            opacity: .5;
            transform: scale(.9);
        }
        50% {
            opacity: 1;
            transform: scale(1.15);
        }
    }

    /* موبایل: کوتاه، جمع‌وجور و تک‌خطی */
    @media (max-width: 640px) {
        .assembly-announcement {
            padding: 7px 35px;
            border-radius: 4px;
        }

        .assembly-announcement__content {
            gap: 7px;
            flex-wrap: nowrap;
        }

        .assembly-announcement__title,
        .assembly-announcement__date {
            display: none;
        }

        .assembly-announcement__icon {
            font-size: 15px;
        }

        .assembly-announcement__countdown {
            font-size: 12px;
            padding: 3px 10px;
            line-height: 1.6;
            box-shadow: none;
        }

        .assembly-announcement__close {
            left: 7px;
            font-size: 20px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .assembly-announcement::before,
        .assembly-announcement__icon {
            animation: none;
        }
    }
</style>

<div
    id="assemblyAnnouncement"
    class="assembly-announcement"
    role="region"
    aria-label="اطلاعیه مجمع عمومی"
    dir="rtl"
    hidden
>
    <div class="assembly-announcement__content">

        <span
            class="assembly-announcement__icon"
            aria-hidden="true"
        >✦</span>

        <span class="assembly-announcement__title">
            مجمع عمومی سالیانه و مجمع عمومی فوق‌العاده
        </span>

        <span
            id="assemblyCountdown"
            class="assembly-announcement__countdown"
        ></span>

        <span class="assembly-announcement__date">
            ۱۳ آبان ۱۴۰۵
        </span>

    </div>

    <button
        type="button"
        class="assembly-announcement__close"
        aria-label="بستن اطلاعیه"
    >&times;</button>
</div>

<script>
    (() => {
        function initAssemblyAnnouncement() {
            const banner = document.getElementById(
                'assemblyAnnouncement'
            );

            const countdown = document.getElementById(
                'assemblyCountdown'
            );

            if (!banner || !countdown) return;

            const closeButton = banner.querySelector(
                '.assembly-announcement__close'
            );

            // تاریخ برگزاری: ۱۳ آبان ۱۴۰۵
            // معادل: ۴ نوامبر ۲۰۲۶
            const eventYear = 2026;
            const eventMonth = 11;
            const eventDay = 4;

            // پایان روز مجمع به وقت تهران
            const expiry = new Date(
                '2026-11-04T20:30:00Z'
            );

            // محاسبه تاریخ جاری براساس تقویم تهران
            const tehranFormatter = new Intl.DateTimeFormat(
                'en-US',
                {
                    timeZone: 'Asia/Tehran',
                    year: 'numeric',
                    month: 'numeric',
                    day: 'numeric'
                }
            );

            function updateCountdown() {
                const now = new Date();

                if (now >= expiry) {
                    banner.hidden = true;
                    return;
                }

                const parts = tehranFormatter.formatToParts(now);

                const getPart = (type) => Number(
                    parts.find(p => p.type === type)?.value
                );

                const year = getPart('year');
                const month = getPart('month');
                const day = getPart('day');

                // اختلاف روزهای تقویمی، مستقل از ساعت
                const todayUTC = Date.UTC(
                    year, month - 1, day
                );

                const eventUTC = Date.UTC(
                    eventYear, eventMonth - 1, eventDay
                );

                const daysLeft = Math.max(
                    0,
                    Math.round(
                        (eventUTC - todayUTC) / 86400000
                    )
                );

                if (daysLeft === 0) {
                    countdown.textContent =
                        'امروز، روز برگزاری مجمع';
                } else if (daysLeft === 1) {
                    countdown.textContent =
                        'فقط ۱ روز تا مجمع';
                } else {
                    const persianDays = daysLeft.toLocaleString(
                        'fa-IR'
                    );

                    countdown.textContent =
                        `فقط ${persianDays} روز تا مجمع`;
                }

                banner.hidden = false;
            }

            updateCountdown();

            // به‌روزرسانی خودکار هنگام باز بودن سایت
            const timer = setInterval(
                updateCountdown,
                60 * 1000
            );

            closeButton?.addEventListener('click', () => {
                banner.hidden = true;
                clearInterval(timer);
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener(
                'DOMContentLoaded',
                initAssemblyAnnouncement
            );
        } else {
            initAssemblyAnnouncement();
        }
    })();
</script>

