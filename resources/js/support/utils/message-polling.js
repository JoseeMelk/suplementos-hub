import { getMessages } from '../services/message.service.js';

// ─────────────────────────────────────────────────────────────────────────────
// POLLING DE MENSAJES
// Comprueba periódicamente si hay mensajes nuevos en una conversación.
// Compatible con provider y admin — solo necesita un conversationId
// y un callback que recibe los mensajes nuevos.
// ─────────────────────────────────────────────────────────────────────────────

let _intervalId   = null;
let _lastMsgId    = null;   // ID del último mensaje conocido
let _convId       = null;   // conversación actualmente vigilada

/**
 * Inicia el polling de mensajes.
 *
 * @param {number|string} conversationId  - ID de la conversación a vigilar
 * @param {number[]}      knownMessages   - Array de mensajes ya renderizados
 *                                          (para calcular el último ID conocido)
 * @param {Function}      onNewMessages   - Callback(newMessages[]) llamado cuando
 *                                          llegan mensajes nuevos
 * @param {number}        intervalMs      - Intervalo en ms (default: 4000)
 */
export function startPolling(conversationId, knownMessages = [], onNewMessages, intervalMs = 4000) {
    stopPolling(); // limpiar cualquier polling previo

    _convId    = conversationId;
    _lastMsgId = knownMessages.length
        ? Math.max(...knownMessages.map(m => m.id))
        : null;

    _intervalId = setInterval(async () => {
        try {
            const response = await getMessages(_convId);
            if (!response.ok) return;

            const all = response.data ?? [];

            // Filtrar solo los que son más nuevos que el último conocido
            const newMsgs = _lastMsgId
                ? all.filter(m => m.id > _lastMsgId)
                : all;

            if (newMsgs.length === 0) return;

            // Actualizar el último ID conocido
            _lastMsgId = Math.max(...newMsgs.map(m => m.id));

            onNewMessages(newMsgs);

        } catch {
            // Silencioso — no interrumpir la UI por errores de red
        }
    }, intervalMs);
}

/**
 * Detiene el polling activo.
 * Llamar al cambiar de conversación, cerrar ticket, o salir de la página.
 */
export function stopPolling() {
    if (_intervalId !== null) {
        clearInterval(_intervalId);
        _intervalId = null;
    }
    _convId    = null;
    _lastMsgId = null;
}

/**
 * Indica si hay un polling activo en este momento.
 */
export function isPolling() {
    return _intervalId !== null;
}

export function updateLastMessageId(messageId) {
    if (!_lastMsgId || messageId > _lastMsgId) {
        _lastMsgId = messageId;
    }
}