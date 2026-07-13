<script>
document.addEventListener("DOMContentLoaded", function () {
        var premiumCarousel = document.getElementById('premiumNewsCarousel');
        var premiumIndicators = document.querySelectorAll('.premium-indicators .hero-news-list-item');

        if (premiumCarousel && premiumIndicators.length) {
            premiumCarousel.addEventListener('slide.bs.carousel', function (e) {
                var nextIdx = e.to;

                premiumIndicators.forEach(function (btn, idx) {
                    if (idx === nextIdx) {
                        btn.classList.add('active');
                        btn.setAttribute('aria-current', 'true');

                        var progressBar = btn.querySelector('.hero-list-progress');

                        if (progressBar) {
                            progressBar.style.animation = 'none';
                            void progressBar.offsetWidth;
                            progressBar.style.animation = null;
                        }

                        var list = btn.parentElement;

                        if (list) {
                            var visibleHeight = list.clientHeight;
                            var itemTop = btn.offsetTop;
                            var itemHeight = btn.clientHeight;

                            list.scrollTo({
                                top: itemTop - (visibleHeight / 2) + (itemHeight / 2),
                                behavior: 'smooth'
                            });
                        }
                    } else {
                        btn.classList.remove('active');
                        btn.removeAttribute('aria-current');
                    }
                });
            });
        }
    });
</script>
