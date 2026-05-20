// lib/api-client.js
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

/*
export async function apiFetchForm(url, options = {}, csrfToken = null) {
    const csrf = csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // Clonamos las cabeceras para no mutar el objeto original
    const headers = {
        'X-CSRF-TOKEN': csrf,
        'Accept': 'application/json',
        ...options.headers
    };

    // EL TRUCO: Si el cuerpo es FormData, eliminamos manualmente el Content-Type 
    // por si acaso alguien lo pasó por error en options.headers
    if (options.body instanceof FormData) {
        delete headers['Content-Type'];
    }

    const response = await fetch(`${BASE_URL}${url}`, {
        headers: headers,
        ...options
    });

    const data = await response.json();

    return {
        httpOk: response.ok,
        httpStatus: response.status,
        ...data
    };
}
*/