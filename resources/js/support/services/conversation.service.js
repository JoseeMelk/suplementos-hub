import { apiFetch } from '../../lib/api-client';
import { PROVIDER_SUPPORT_ROUTES, ADMIN_SUPPORT_ROUTES } from '../routes';

// provider: conversación activa
export async function getActiveConversation() {
    return apiFetch(PROVIDER_SUPPORT_ROUTES.ACTIVE_CONVERSATION, {
        method: 'GET'
    });
}

// mensajes de una conversación (provider)
export async function getConversationMessages(conversationId) {
    return apiFetch(PROVIDER_SUPPORT_ROUTES.MESSAGES(conversationId), {
        method: 'GET'
    });
}
 
// ── Admin ─────────────────────────────────────────────────────────────────────
 
// todas las conversaciones asignadas al admin
export async function getAdminConversations() {
    return apiFetch(ADMIN_SUPPORT_ROUTES.CONVERSATIONS, {
        method: 'GET'
    });
}
 
// detalle de una conversación específica
export async function getAdminConversation(conversationId) {
    return apiFetch(ADMIN_SUPPORT_ROUTES.CONVERSATION(conversationId), {
        method: 'GET'
    });
}