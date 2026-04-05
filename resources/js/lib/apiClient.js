// lib/apiClient.js
import { BASE_URL } from '../config';

export async function apiFetch(url, options = {}, csrfToken = null) {
    const csrf = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const response = await fetch(`${BASE_URL}${url}`, {
        headers: {
            'X-CSRF-TOKEN': csrf,
            'Accept': 'application/json',
            ...options.headers
        },
        ...options
    });

    const data = await response.json();

    return {
        httpOk: response.ok,
        httpStatus: response.status,
        ...data
    };
}