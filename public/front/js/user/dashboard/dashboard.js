const sidebar = document.querySelector('[data-user-sidebar]');
const sidebarToggle = document.querySelector('[data-user-sidebar-toggle]');
const sidebarOverlay = document.querySelector('[data-user-sidebar-overlay]');

const openSidebar = () => {
    if (!sidebar || !sidebarOverlay) {
        return;
    }

    sidebar.classList.add('is-open');
    sidebarOverlay.classList.add('is-visible');

    document.body.style.overflow = 'hidden';
};

const closeSidebar = () => {
    if (!sidebar || !sidebarOverlay) {
        return;
    }

    sidebar.classList.remove('is-open');
    sidebarOverlay.classList.remove('is-visible');

    document.body.style.overflow = '';
};

sidebarToggle?.addEventListener('click', openSidebar);
sidebarOverlay?.addEventListener('click', closeSidebar);

window.addEventListener('resize', () => {
    if (window.innerWidth > 850) {
        closeSidebar();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeSidebar();
    }
});
