
export const PRODUCT_ROUTES = {
    INDEX: '/provider/products',
    STORE: '/provider/products',
    SHOW: (id) => `/provider/products/${id}`,
    UPDATE: (id) => `/provider/products/${id}`,
    DESTROY: (id) => `/provider/products/${id}`,
    API: '/provider/products/api',
}

export const CATEGORY_ROUTES = {
    API: '/categories/api'
}