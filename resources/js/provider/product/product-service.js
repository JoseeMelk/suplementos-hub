import { apiFetch } from '../../lib/api-client';
import { PRODUCT_ROUTES, CATEGORY_ROUTES } from '../routes';

//Recibe un form data como payload
export async function storeProduct(payload) {
    return apiFetch(PRODUCT_ROUTES.STORE, {
        method: 'POST',
        body: payload
    });
}

export async function getCategories() {
    return apiFetch(CATEGORY_ROUTES.API, {
        method: 'POST',
    });
}