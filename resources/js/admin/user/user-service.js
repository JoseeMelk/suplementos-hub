// admin/users/user-service.js
import { apiFetch } from '../../lib/api-client';
import { USER_ROUTES } from '../routes';

export async function fetchUsers(params = {}) {
    const query = new URLSearchParams(params).toString();

    return await apiFetch(`${USER_ROUTES.API}?${query}`);
}

export async function update(userId, payload) {
    return await apiFetch(`${USER_ROUTES.UPDATE.replace('{id}', userId)}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    });
}