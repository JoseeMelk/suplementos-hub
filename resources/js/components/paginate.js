/**
 * Renderizar controles de paginación
 * @param {Object} meta - Objeto con información de paginación
 * @returns {string} HTML de los controles de paginación
 */
export function renderPaginate(meta) {
    if (!meta || !meta.last_page) {
        return '';
    }

    const { current_page, last_page } = meta;
    let html = '';

    // Botón anterior
    const prevClass = current_page === 1 ? 'disabled' : '';
    const prevPage = current_page === 1 ? '#' : current_page - 1;
    html += `<li class="page-item ${prevClass}">
        <a class="page-link" href="#" data-page="${prevPage}" tabindex="-1">
            <i class="bi-chevron-left"></i>
        </a>
    </li>`;

    // Lógica para mostrar páginas
    const delta = 2; // Páginas a mostrar a cada lado de la actual
    const range = [];

    // Siempre mostrar primera página
    if (1 < current_page - delta) {
        range.push(1);
    }

    // Páginas alrededor de la actual
    for (let i = Math.max(1, current_page - delta); i <= Math.min(last_page, current_page + delta); i++) {
        range.push(i);
    }

    // Siempre mostrar última página
    if (current_page + delta < last_page) {
        range.push(last_page);
    }

    // Eliminar duplicados y ordenar
    const pages = Array.from(new Set(range)).sort((a, b) => a - b);

    // Renderizar páginas
    let prevPage_ = 0;
    pages.forEach((page) => {
        // Mostrar ellipsis si hay salto
        if (page - prevPage_ > 1) {
            html += `<li class="page-item disabled">
                <span class="page-link">...</span>
            </li>`;
        }

        // Página actual o enlace
        const activeClass = page === current_page ? 'active' : '';
        html += `<li class="page-item ${activeClass}">
            <a class="page-link" href="#" data-page="${page}">${page}</a>
        </li>`;

        prevPage_ = page;
    });

    // Botón siguiente
    const nextClass = current_page === last_page ? 'disabled' : '';
    const nextPage = current_page === last_page ? '#' : current_page + 1;
    html += `<li class="page-item ${nextClass}">
        <a class="page-link" href="#" data-page="${nextPage}">
            <i class="bi-chevron-right"></i>
        </a>
    </li>`;

    return html;
}