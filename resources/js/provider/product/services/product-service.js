import { apiFetch } from '../../../lib/api-client';
import { PRODUCT_ROUTES, CATEGORY_ROUTES } from '../../routes';

//Obtiene todos los productos, por el momento sin paginacion
export async function getProducts() {
    return apiFetch(PRODUCT_ROUTES.API);
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
        method: 'POST',
    });
}

//Funciones de ejemplo sin back por el momento
// Obtener producto por ID
export async function getProductById(productId) {
    return {
        'ok': true,
        'data': {
            'id': productId,
            'name': 'Producto de ejemplo',
            'price': 100,
            'description': 'Descripción de ejemplo',
            'category_id': 1,
            'is_visible': 1,
            'image_url': 'http://localhost:8000/storage/products/59c22090-426c-4977-8bec-67959d2f6bdf.webp'
        }
    };
}

// Actualizar producto
export async function updateProduct(productId, payload) {
    return {
        'ok': true,
        'httpOk': true,
        'httpStatus': 200,
        'data': {
            'id': productId,
            ...payload
        }
    };
}

// Eliminar producto
export async function deleteProduct(productId) {
    return {
        'ok': true,
        'httpOk': true,
        'httpStatus': 200,
        'data': { id: productId }
    }; // solo confirma el ID eliminado
}