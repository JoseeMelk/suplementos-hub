import { timeAgo } from '../../utils/date.js';

/**
 * Tarjeta de conversación activa
 * @param {Object} conversation - ConversationResource
 *   { id, subject, last_message_at, ticket_id }
 */
export function conversationCard(conversation) {
    return `
        <div class="conv-item">
            <p class="conv-subject">${conversation.subject}</p>
            <div class="conv-meta">
                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 6v6l4 2"/>
                </svg>
                Último mensaje:&nbsp;<span>${timeAgo(conversation.last_message_at)}</span>
            </div>
        </div>
    `;
}

/**
 * Estado vacío: sin conversación activa
 * @param {string} message
 */
export function conversationEmpty(
    message = 'El chat estará disponible cuando el equipo de soporte acepte tu ticket.'
) {
    return `
        <div class="empty-state" style="padding:1.25rem;gap:.5rem">
            <svg width="28" height="28" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <p style="font-size:.82rem;color:var(--muted);margin:0;text-align:center">${message}</p>
        </div>
    `;
}