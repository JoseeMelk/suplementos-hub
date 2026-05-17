// Activar link del sidebar según la URL actual
function activateSidebarLink() {
    const currentPath = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('a.sidebar-link[data-href]');

    sidebarLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('data-href');
        
        // Extraer solo la ruta de la URL (sin protocolo, host, etc)
        let hrefPath = '';
        try {
            const url = new URL(href, window.location.origin);
            hrefPath = url.pathname;
        } catch (e) {
            // Si no es una URL válida, usarla como está
            hrefPath = href.split('?')[0];
        }
        
        // Comparación exacta
        if (currentPath === hrefPath) {
            link.classList.add('active');
        }
    });
}

// Ejecutar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', activateSidebarLink);

// También ejecutar después de que se cargue la página completamente
window.addEventListener('load', activateSidebarLink);

// Re-activar si cambia la ruta (para SPAs o navegación posterior)
window.addEventListener('popstate', activateSidebarLink);