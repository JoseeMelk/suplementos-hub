// admin/users/userService.js
import { apiFetch } from '../../lib/apiClient';
import { USER_ROUTES } from '../routes';

export async function fetchUsers(params = {}) {
    const query = new URLSearchParams(params).toString();

    return await apiFetch(`${USER_ROUTES.API}?${query}`);
}