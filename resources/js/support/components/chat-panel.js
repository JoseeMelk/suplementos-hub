import { formatTime, formatDateSep } from '../../utils/date.js';

// ─────────────────────────────────────────
// HEADER DEL CHAT
// ─────────────────────────────────────────

/**
 * Header del chat con datos del interlocutor
 * @param {Object} opts
 * @param {string} opts.name          - Nombre del interlocutor (admin o proveedor)
 * @param {string} opts.initials      - Iniciales para el avatar
 * @param {string} opts.avatarColor   - Color de fondo del avatar
 * @param {string} opts.ticketRef     - Ej. "#TKT-2024-087"
 * @param {boolean} opts.online
 */
export function chatHeader(
    name = 'Sin asignar',
    initials = 'SA',
    avatarColor = '#9ca3af',
    ticketRef = null
) {
    return `
        <div class="chat-header" id="chat-header">
            <div class="chat-av" style="background:${avatarColor}">
                ${initials}
            </div>

            <div>
                <p class="mb-0" style="font-size:.875rem;font-weight:700;color:var(--text)">
                    ${name}
                </p>

                ${
                    ticketRef
                        ? `
                            <span style="font-size:.72rem;color:var(--muted)">
                                ${ticketRef}
                            </span>
                        `
                        : ''
                }
            </div>
        </div>
    `;
}

// ─────────────────────────────────────────
// MENSAJES
// ─────────────────────────────────────────

/**
 * Un mensaje individual
 * @param {Object} msg          - MessageResource
 *   { id, message, sender_id, is_mine, sender_name, created_at, created_at_human }
 * @param {boolean} msg.is_mine - true → "sent" (derecha), false → "recv" (izquierda)
 * @param {string}  msg.sender_name
 * @param {string}  avatarColor - color del avatar del interlocutor
 * @param {string}  avatarInitials
 */
export function chatMessage(msg, avatarColor = '#6366f1', avatarInitials = 'A') {
    const time = msg.created_at_human ?? formatTime(msg.created_at);

    if (msg.is_mine) {
        return `
            <div class="msg-row own" data-msg-id="${msg.id}">
                <div class="msg-av" style="background:var(--brand)">Tú</div>
                <div style="display:flex;flex-direction:column;align-items:flex-end">
                    <div class="bubble sent">${escapeHtml(msg.message)}</div>
                    <span class="msg-time">${time}</span>
                </div>
            </div>
        `;
    }

    return `
        <div class="msg-row" data-msg-id="${msg.id}">
            <div class="msg-av" style="background:${avatarColor}">${avatarInitials}</div>
            <div style="display:flex;flex-direction:column;align-items:flex-start">
                <p class="msg-sender-name">${msg.sender_name}</p>
                <div class="bubble recv">${escapeHtml(msg.message)}</div>
                <span class="msg-time">${time}</span>
            </div>
        </div>
    `;
}

/**
 * Separador de fecha entre grupos de mensajes
 * @param {string} dateLabel - Ej. "Hoy, 5 de junio" | "Ayer"
 */
export function dateSeparator(dateLabel) {
    return `<div class="date-sep">${dateLabel}</div>`;
}

/**
 * Renderiza una lista completa de mensajes agrupando por fecha
 * @param {Array}  messages        - Array de MessageResource
 * @param {string} avatarColor
 * @param {string} avatarInitials
 */
export function renderMessages(messages, avatarColor = '#6366f1', avatarInitials = 'A') {
    if (!messages.length) {
        return `
            <div style="flex:1;display:flex;align-items:center;justify-content:center;">
                <p style="font-size:.82rem;color:var(--muted)">Aún no hay mensajes.</p>
            </div>
        `;
    }

    const sortedMessages = [...messages].sort(
        (a, b) => new Date(a.created_at) - new Date(b.created_at)
    );

    let html = '';
    let lastDate = null;

    for (const msg of sortedMessages) {
        const msgDate = formatDateSep(msg.created_at);

        if (msgDate !== lastDate) {
            html += dateSeparator(msgDate);
            lastDate = msgDate;
        }

        html += chatMessage(msg, avatarColor, avatarInitials);
    }

    return html;
}

// ─────────────────────────────────────────
// INPUT DEL CHAT
// ─────────────────────────────────────────

/**
 * Área de input para escribir mensajes
 * @param {string} placeholder
 */
export function chatInput(placeholder = 'Escribe un mensaje…') {
    return `
        <div class="chat-input-area" id="chat-input-area">
            <textarea
                class="chat-ta"
                id="chat-input-msg"
                placeholder="${placeholder} (máx. 1000 caracteres)"
                maxlength="1000"
            ></textarea>
            <button class="btn-send" id="btn-send-msg" title="Enviar">
                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                </svg>
            </button>
        </div>
    `;
}

// ─────────────────────────────────────────
// ESTADOS ESPECIALES
// ─────────────────────────────────────────

/**
 * Chat bloqueado: ticket OPEN, aún sin conversación
 */
export function chatBlocked(message = 'El chat se habilitará cuando el soporte acepte tu ticket.') {
    return `
        <div class="chat-blocked" id="chat-blocked">
            <div class="empty-icon">
                <svg width="22" height="22" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h6 style="font-size:.875rem;font-weight:700;color:var(--text);margin:0">Chat no disponible aún</h6>
            <p style="font-size:.8rem;color:var(--muted);margin:0">${message}</p>
        </div>
    `;
}

/**
 * Chat vacío: sin ticket seleccionado (útil en vista admin)
 * @param {string} title
 * @param {string} message
 */
export function chatEmpty(
    title   = 'Sin conversación activa',
    message = 'Selecciona un ticket para ver la conversación.'
) {
    return `
        <div class="chat-empty" id="chat-empty">
            <div style="width:44px;height:44px;border-radius:12px;background:var(--brand-light);display:flex;align-items:center;justify-content:center;">
                <svg width="20" height="20" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <h6>${title}</h6>
            <p>${message}</p>
        </div>
    `;
}

/**
 * Indicador de "escribiendo..."
 * @param {string} name          - Nombre de quien escribe
 * @param {string} avatarColor
 * @param {string} avatarInitials
 */
export function typingIndicator(name, avatarColor = '#6366f1', avatarInitials = 'A') {
    return `
        <div class="msg-row" id="typing-indicator" style="opacity:.75">
            <div class="msg-av" style="background:${avatarColor}">${avatarInitials}</div>
            <div>
                <p class="msg-sender-name">${name}</p>
                <div class="bubble recv" style="padding:.45rem .7rem">
                    <div class="typing-dots">
                        <span></span><span></span><span></span>
                    </div>
                </div>
                <span class="msg-time">escribiendo…</span>
            </div>
        </div>
    `;
}

// ─────────────────────────────────────────
// UTILIDAD
// ─────────────────────────────────────────

/**
 * Escapa HTML para evitar XSS en los mensajes
 */
function escapeHtml(str = '') {
    return str
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;')
        .replace(/\n/g, '<br>');
}