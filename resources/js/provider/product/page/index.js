import { createProductCard } from "../components/product-card";
import { getProducts } from "../services/product-service";

async function init() {
    const container = document.getElementById('productList');
    if (!container) return;

    const res = await getProducts();

    container.innerHTML = '';

    res.data.forEach(product => {
        container.appendChild(createProductCard(product));
    });
}

init();