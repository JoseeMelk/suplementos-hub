import { createProductCard } from "../components/product-card";
import { getProducts } from "../services/product-service";
import { getFilters } from "./filter-actions.handler";

export async function renderProductList() {
    const container = document.getElementById('productList');
    if (!container) return;

    const filter = getFilters();

    Object.keys(filter).forEach(key => {
        if (filter[key] === null || filter[key] === '') {
            delete filter[key];
        }
    });

    const res = await getProducts(filter);

    container.innerHTML = '';

    if (!res.data) {
        container.innerHTML = '<p class="text-muted">No se encontraron productos.</p>';
        return;
    }
    res.data.forEach(product => {
        container.appendChild(createProductCard(product));
    });
}