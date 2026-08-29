document.addEventListener('DOMContentLoaded', function () {

    const premiumCarousel = document.getElementById(
        'premiumNewsCarousel'
    );

    if (!premiumCarousel) {
        return;
    }


    const premiumIndicators = document.querySelectorAll(
        '.premium-indicators .hero-news-list-item'
    );


    if (!premiumIndicators.length) {
        return;
    }


    /**
     * Set active carousel list item.
     */
    function setActiveIndicator(nextIndex) {

        premiumIndicators.forEach(function (button, index) {

            const isActive = index === nextIndex;


            if (isActive) {

                button.classList.add('active');

                button.setAttribute(
                    'aria-current',
                    'true'
                );


                /*
                 * Restart progress animation.
                 */
                const progressBar = button.querySelector(
                    '.hero-list-progress'
                );

                if (progressBar) {

                    progressBar.style.animation = 'none';

                    void progressBar.offsetWidth;

                    progressBar.style.animation = '';

                }


                /*
                 * Keep active item visible.
                 */
                const list = button.parentElement;

                if (list) {

                    const visibleHeight =
                        list.clientHeight;

                    const itemTop =
                        button.offsetTop;

                    const itemHeight =
                        button.clientHeight;


                    list.scrollTo({
                        top:
                            itemTop -
                            (visibleHeight / 2) +
                            (itemHeight / 2),

                        behavior: 'smooth'
                    });

                }

            } else {

                button.classList.remove('active');

                button.removeAttribute(
                    'aria-current'
                );

            }

        });

    }


    /**
     * Bootstrap carousel event.
     */
    premiumCarousel.addEventListener(
        'slide.bs.carousel',
        function (event) {

            setActiveIndicator(event.to);

        }
    );

});
