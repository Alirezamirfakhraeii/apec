document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('[data-user-sidebar]');
    const overlay = document.querySelector('[data-user-sidebar-overlay]');
    const openButton = document.querySelector('[data-user-sidebar-open]');
    const closeButton = document.querySelector('[data-user-sidebar-close]');

    function openSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.add('is-open');
        overlay.classList.add('is-open');
        document.body.classList.add('user-sidebar-open');
    }

    function closeSidebar() {
        if (!sidebar || !overlay) {
            return;
        }

        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-open');
        document.body.classList.remove('user-sidebar-open');
    }

    openButton?.addEventListener('click', openSidebar);
    closeButton?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeSidebar();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });
});
