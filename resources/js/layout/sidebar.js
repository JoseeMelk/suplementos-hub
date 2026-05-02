// Activar link del sidebar según la URL actual
document.addEventListener('DOMContentLoaded', () => {
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar-link[data-href]');

    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        const linkPath = new URL(link.dataset.href, window.location.origin).pathname;
        if (currentPath === linkPath) {
            link.classList.add('active');
        }
    });
});