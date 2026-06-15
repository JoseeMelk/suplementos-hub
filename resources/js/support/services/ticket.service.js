import { apiFetch } from '../../lib/api-client';
import { PROVIDER_SUPPORT_ROUTES, ADMIN_SUPPORT_ROUTES } from '../routes';

// crear ticket
export async function storeTicket(payload) {
    return apiFetch(PROVIDER_SUPPORT_ROUTES.CREATE_TICKET, {
        method: 'POST',
        body: payload
    });
}

// ticket activo provider
export async function getActiveTicket() {
    return apiFetch(PROVIDER_SUPPORT_ROUTES.ACTIVE_TICKET, {
        method: 'GET'
    });
}

// admin: listar tickets
export async function getAdminTickets() {
    return apiFetch(ADMIN_SUPPORT_ROUTES.ADMIN_TICKETS, {
        method: 'GET'
    });

    console.log();
    
}

// admin: aceptar ticket
export async function acceptTicket(id) {
    return apiFetch(ADMIN_SUPPORT_ROUTES.ACCEPT_TICKET(id), {
        method: 'PATCH'
    });
}

// admin: cerrar ticket
export async function closeTicket(id) {
    return apiFetch(ADMIN_SUPPORT_ROUTES.CLOSE_TICKET(id), {
        method: 'PATCH'
    });
}