import { productNotFound } from "../../../components/product-not-found";
import { createProductCard } from "../../../components/product-card";
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
    console.log(res);
    

    if (!res.data) {
        container.innerHTML = productNotFound('No se encontraron productos existentes.');
        return;
    }
    res.data.forEach(product => {
        container.appendChild(createProductCard(product));
    });
}