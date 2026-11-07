<div class="company-quick-nav" aria-label="دسترسی سریع به بخش‌های اطلاعات شرکت">
    <div class="company-quick-nav__header">
        <div class="company-quick-nav__heading">
            <span class="company-quick-nav__heading-icon" aria-hidden="true">
                <i class="fa fa-compass"></i>
            </span>

            <div>
                <strong>دسترسی سریع</strong>
                <span>بخش موردنظر را انتخاب کنید تا مستقیماً به همان قسمت بروید.</span>
            </div>
        </div>
    </div>

    <div class="company-quick-nav__items">
        <a href="#company-section-files" class="company-quick-nav__item">
            <i class="fa fa-folder-open-o" aria-hidden="true"></i>
            <span>مدارک</span>
        </a>

        <a href="#company-section-general" class="company-quick-nav__item">
            <i class="fa fa-building-o" aria-hidden="true"></i>
            <span>مشخصات شرکت</span>
        </a>

        <a href="#company-section-registration" class="company-quick-nav__item">
            <i class="fa fa-id-card-o" aria-hidden="true"></i>
            <span>اطلاعات ثبتی</span>
        </a>

        <a href="#company-section-contact" class="company-quick-nav__item">
            <i class="fa fa-phone" aria-hidden="true"></i>
            <span>اطلاعات تماس</span>
        </a>

        <a href="#company-section-additional" class="company-quick-nav__item">
            <i class="fa fa-info-circle" aria-hidden="true"></i>
            <span>اطلاعات تکمیلی</span>
        </a>

        <a href="#company-section-ceo" class="company-quick-nav__item">
            <i class="fa fa-user-circle-o" aria-hidden="true"></i>
            <span>مدیرعامل</span>
        </a>

        <a href="#company-section-chairman" class="company-quick-nav__item">
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <span>رئیس هیئت‌مدیره</span>
        </a>

        <a href="#company-section-association-contact" class="company-quick-nav__item">
            <i class="fa fa-address-book-o" aria-hidden="true"></i>
            <span>رابط انجمن</span>
        </a>

        <a href="#company-section-membership" class="company-quick-nav__item">
            <i class="fa fa-certificate" aria-hidden="true"></i>
            <span>عضویت</span>
        </a>

        <a href="#company-section-commercial" class="company-quick-nav__item">
            <i class="fa fa-credit-card" aria-hidden="true"></i>
            <span>کارت‌های بازرگانی</span>
        </a>

        <a href="#company-section-activities" class="company-quick-nav__item">
            <i class="fa fa-briefcase" aria-hidden="true"></i>
            <span>نوع فعالیت</span>
        </a>

        <a href="#company-section-activity-fields" class="company-quick-nav__item">
            <i class="fa fa-sitemap" aria-hidden="true"></i>
            <span>حوزه‌های فعالیت</span>
        </a>

        <a href="#company-section-shareholders" class="company-quick-nav__item">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>سهامداران</span>
        </a>

        <a href="#company-section-projects" class="company-quick-nav__item">
            <i class="fa fa-tasks" aria-hidden="true"></i>
            <span>پروژه‌ها</span>
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = Array.from(
            document.querySelectorAll('.company-quick-nav__item')
        );

        const sections = navLinks
            .map(function (link) {
                const target = document.querySelector(link.getAttribute('href'));

                return target
                    ? { link: link, target: target }
                    : null;
            })
            .filter(Boolean);

        function setActiveLink(activeLink) {
            navLinks.forEach(function (link) {
                link.classList.toggle('is-active', link === activeLink);
            });
        }

        navLinks.forEach(function (link) {
            link.addEventListener('click', function (event) {
                const target = document.querySelector(link.getAttribute('href'));

                if (!target) {
                    return;
                }

                event.preventDefault();
                setActiveLink(link);

                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                if (history.replaceState) {
                    history.replaceState(null, '', link.getAttribute('href'));
                }
            });
        });

        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(
                function (entries) {
                    const visibleEntries = entries
                        .filter(function (entry) {
                            return entry.isIntersecting;
                        })
                        .sort(function (a, b) {
                            return b.intersectionRatio - a.intersectionRatio;
                        });

                    if (!visibleEntries.length) {
                        return;
                    }

                    const activeSection = sections.find(function (section) {
                        return section.target === visibleEntries[0].target;
                    });

                    if (activeSection) {
                        setActiveLink(activeSection.link);
                    }
                },
                {
                    rootMargin: '-18% 0px -62% 0px',
                    threshold: [0, 0.05, 0.15, 0.3]
                }
            );

            sections.forEach(function (section) {
                observer.observe(section.target);
            });
        }

        if (window.location.hash) {
            const initialLink = navLinks.find(function (link) {
                return link.getAttribute('href') === window.location.hash;
            });

            if (initialLink) {
                setActiveLink(initialLink);
            }
        }
    });
</script>
