import { apiFetch } from '../../../lib/api-client';
import { SLUG_ROUTES } from '../../routes';

export async function storeSlug() {
    return apiFetch(SLUG_ROUTES.STORE, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}

export async function regenerateSlug() {
    return apiFetch(SLUG_ROUTES.STORE, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
    });
}