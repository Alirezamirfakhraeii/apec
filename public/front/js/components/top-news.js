document.addEventListener('DOMContentLoaded', function () {

    const premiumCarousel = document.getElementById(
        'premiumNewsCarousel'
    );

    if (!premiumCarousel) {
        return;
    }


    const premiumIndicators = premiumCarousel.querySelectorAll(
        '.premium-indicators .hero-news-list-item'
    );


    if (!premiumIndicators.length) {
        return;
    }


    const carouselInstance =
        bootstrap.Carousel.getOrCreateInstance(
            premiumCarousel
        );


    /**
     * Set active carousel list item.
     */
    function setActiveIndicator(nextIndex) {

        premiumIndicators.forEach(function (item, index) {

            const itemIndex = parseInt(
                item.dataset.slideIndex ?? index,
                10
            );

            const isActive =
                itemIndex === nextIndex;


            if (isActive) {

                item.classList.add('active');

                item.setAttribute(
                    'aria-current',
                    'true'
                );


                /*
                 * Restart progress animation.
                 */
                const progressBar =
                    item.querySelector(
                        '.hero-list-progress'
                    );

                if (progressBar) {

                    progressBar.style.animation =
                        'none';

                    void progressBar.offsetWidth;

                    progressBar.style.animation =
                        '';

                }


                /*
                 * Keep active item visible.
                 */
                const list =
                    item.parentElement;

                if (list) {

                    const visibleHeight =
                        list.clientHeight;

                    const itemTop =
                        item.offsetTop;

                    const itemHeight =
                        item.clientHeight;


                    list.scrollTo({
                        top:
                            itemTop -
                            (visibleHeight / 2) +
                            (itemHeight / 2),

                        behavior: 'smooth'
                    });

                }

            } else {

                item.classList.remove(
                    'active'
                );

                item.removeAttribute(
                    'aria-current'
                );

            }

        });

    }


    /**
     * Select news from list.
     */
    premiumIndicators.forEach(function (item, index) {

        const selectButton =
            item.querySelector(
                '.hero-news-list-select'
            );


        if (!selectButton) {
            return;
        }


        selectButton.addEventListener(
            'click',
            function () {

                const slideIndex =
                    parseInt(
                        item.dataset.slideIndex ??
                        index,
                        10
                    );


                setActiveIndicator(
                    slideIndex
                );


                carouselInstance.to(
                    slideIndex
                );

            }
        );

    });


    /**
     * Bootstrap carousel event.
     */
    premiumCarousel.addEventListener(
        'slide.bs.carousel',
        function (event) {

            setActiveIndicator(
                event.to
            );

        }
    );

});
