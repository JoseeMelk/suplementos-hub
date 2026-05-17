import { apiFetch } from '../../../lib/api-client';
import { PRODUCT_ROUTES, CATEGORY_ROUTES } from '../../routes';

//Obtiene todos los productos, por el momento sin paginacion
export async function getProducts(params = {}) {

    const query = new URLSearchParams(params);

    return apiFetch(`${PRODUCT_ROUTES.API}?${query}`, {
        method: 'GET',
    });
}

//Recibe un form data como payload
export async function storeProduct(payload) {
    return apiFetch(PRODUCT_ROUTES.STORE, {
        method: 'POST',
        body: payload
    });
}

export async function getCategories() {
    return apiFetch(CATEGORY_ROUTES.API, {
        method: 'GET',
    });
}

//Funciones de ejemplo sin back por el momento
// Obtener producto por ID
export async function getProductById(productId) {
    return apiFetch(PRODUCT_ROUTES.SHOW(productId), {
        method: 'GET'
    });
}

// Actualizar producto
export async function updateProduct(productId, payload) {
    return apiFetch(PRODUCT_ROUTES.UPDATE(productId), {
        method: 'PATCH',
        body: payload
    });
}

// Eliminar producto
export async function destroyProduct(productId) {
    return apiFetch(PRODUCT_ROUTES.DESTROY(productId), {
        method: 'DELETE'
    });
}