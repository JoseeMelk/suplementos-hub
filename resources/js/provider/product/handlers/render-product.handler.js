import { productNotFound } from "../../../components/product-not-found";
import { createProductCard } from "../../../components/product-card";
import { getProducts } from "../services/product-service";
import { getFilters } from "./filter-actions.handler";
import { getCurrentPage, renderPaginationControls } from "./pagination-actions.handler";

export async function renderProductList() {
    const container = document.getElementById('productList');
    if (!container) return;

    const filter = getFilters();
    const currentPage = getCurrentPage();

    // Agregar página y cantidad de productos al filtro
    filter.page = currentPage;
    filter.per_page = 12;

    Object.keys(filter).forEach(key => {
        if (filter[key] === null || filter[key] === '') {
            delete filter[key];
        }
    });

    const res = await getProducts(filter);

    container.innerHTML = '';    

    if (!res.data || res.data.length === 0) {
        container.innerHTML = productNotFound('No se encontraron productos existentes.');
        return;
    }

    res.data.forEach(product => {
        container.appendChild(createProductCard(product));
    });

    // Renderizar controles de paginación si existe meta
    if (res.meta) {
        await renderPaginationControls(res.meta);
    }
}