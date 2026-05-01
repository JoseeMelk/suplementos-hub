import { renderPaginate } from "../../../components/paginate";
import { renderProductList } from "./render-product.handler";

/**
 * Página actual
 */
let _currentPage = 1;
let _meta = null;

export function setCurrentPage(page) {
    _currentPage = page;
}

export function getCurrentPage() {
    return _currentPage;
}

export function setMeta(meta) {
    _meta = meta;
}

export function getMeta() {
    return _meta;
}

/**
 * Renderizar controles de paginación
 */
export async function renderPaginationControls(meta) {
    if (!meta) return;

    setMeta(meta);
    const paginationWrapper = document.getElementById('paginationWrapper');
    if (!paginationWrapper) return;

    // Actualizar información de paginación
    document.getElementById('paginationFrom').textContent = (meta.current_page - 1) * meta.per_page + 1;
    document.getElementById('paginationTo').textContent = Math.min(meta.current_page * meta.per_page, meta.total);
    document.getElementById('paginationTotal').textContent = meta.total;

    // Renderizar controles de página
    const navElement = paginationWrapper.querySelector('nav ul');
    if (navElement) {
        navElement.innerHTML = renderPaginate(meta);
        
        // Agregar event listeners a los links de paginación
        navElement.addEventListener('click', handlePaginationClick);
    }
}

/**
 * Manejar clics en los controles de paginación
 */
async function handlePaginationClick(e) {
    e.preventDefault();
    
    const link = e.target.closest('a[data-page]');
    if (!link) return;

    const page = parseInt(link.dataset.page);
    if (isNaN(page) || page < 1 || (getMeta() && page > getMeta().last_page)) return;

    setCurrentPage(page);
    await renderProductList();
    
    // Scroll suave al inicio de los productos
    const productList = document.getElementById('productList');
    if (productList) {
        productList.scrollIntoView({ behavior: 'smooth' });
    }
}

/**
 * Resetear paginación
 */
export function resetPagination() {
    setCurrentPage(1);
    setMeta(null);
}
