import { apiFetch } from '../../lib/api-client';
import { MESSAGES_ROUTE } from '../routes';

// listar mensajes
export async function getMessages(conversationId) {
    return apiFetch(MESSAGES_ROUTE.MESSAGES(conversationId), {
        method: 'GET'
    });
}

// enviar mensaje
export async function storeMessage(conversationId, payload) {
    return apiFetch(MESSAGES_ROUTE.MESSAGES(conversationId), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    });
}