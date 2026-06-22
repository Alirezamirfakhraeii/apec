document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.mega-menu-panel').forEach(function (panel) {

        const categories = panel.querySelectorAll('.mega-menu-category');
        const contentArea = panel.querySelector('.mega-menu-content-area');
        const panels = panel.querySelectorAll('.mega-menu-content-panel');

        categories.forEach(function (category) {

            category.addEventListener('mouseenter', function () {
                if (window.innerWidth <= 991) return;

                const targetId = this.getAttribute('data-mega-target');
                const targetPanel = panel.querySelector('#' + targetId);

                categories.forEach(function (item) {
                    item.classList.remove('active');
                });

                panels.forEach(function (item) {
                    item.classList.remove('active');
                });

                this.classList.add('active');

                if (targetPanel) {
                    targetPanel.classList.add('active');

                    if (contentArea) {
                        contentArea.classList.add('has-active');
                    }
                }
            });

            category.addEventListener('click', function (e) {
                if (window.innerWidth <= 991) {
                    const targetId = this.getAttribute('data-mega-target');
                    const targetPanel = panel.querySelector('#' + targetId);

                    if (targetPanel) {
                        e.preventDefault();

                        categories.forEach(function (item) {
                            if (item !== category) {
                                item.classList.remove('active');
                            }
                        });

                        panels.forEach(function (item) {
                            if (item !== targetPanel) {
                                item.classList.remove('active');
                            }
                        });

                        category.classList.toggle('active');
                        targetPanel.classList.toggle('active');

                        if (contentArea) {
                            if (panel.querySelector('.mega-menu-content-panel.active')) {
                                contentArea.classList.add('has-active');
                            } else {
                                contentArea.classList.remove('has-active');
                            }
                        }
                    }
                }
            });

        });

        panel.addEventListener('mouseleave', function () {
            if (window.innerWidth <= 991) return;

            categories.forEach(function (item) {
                item.classList.remove('active');
            });

            panels.forEach(function (item) {
                item.classList.remove('active');
            });

            if (contentArea) {
                contentArea.classList.remove('has-active');
            }
        });

    });

    document.querySelectorAll('.mega-main-link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            if (window.innerWidth <= 991) {
                const navItem = this.closest('.mega-nav-item');
                const panel = navItem ? navItem.querySelector('.mega-menu-panel') : null;

                if (panel) {
                    e.preventDefault();

                    document.querySelectorAll('.mega-nav-item.open').forEach(function (item) {
                        if (item !== navItem) {
                            item.classList.remove('open');
                        }
                    });

                    navItem.classList.toggle('open');
                }
            }
        });
    });

});
