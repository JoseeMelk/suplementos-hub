import { timeAgoShort } from '../../utils/date.js';
import { separateCodeNumber } from '../../utils/code-number.js';

/**
 * Tarjeta de ticket activo (status: open o in_progress)
 * @param {Object} ticket - TicketResource
 */
export function ticketCard(ticket) {
    const isOpen       = ticket.status === 'open';
    const isInProgress = ticket.status === 'in_progress';

    const statusColor = isInProgress ? 'var(--success)' : 'var(--brand)';
    const statusLabel = isInProgress ? 'En progreso' : 'Abierto';

    return `
        <div class="ticket-card-body">
            <p class="ticket-tracking">${separateCodeNumber(ticket.tracking_number)}</p>
            <p class="ticket-title">${ticket.title}</p>
            <p class="ticket-desc">${ticket.description}</p>

            <div class="ticket-meta-grid">
                <div class="tmg-item">
                    <label>Asignado a</label>
                    <span>${ticket.assigned_to ?? '<span style="color:var(--muted);font-style:italic">Pendiente…</span>'}</span>
                </div>
                <div class="tmg-item">
                    <label>Estado</label>
                    <span style="color:${statusColor};font-weight:600">${statusLabel}</span>
                </div>
                <div class="tmg-item">
                    <label>Abierto</label>
                    <span title="${ticket.opened_at}">${timeAgoShort(ticket.opened_at)}</span>
                </div>
                <div class="tmg-item">
                    <label>Aceptado</label>
                    <span>${ticket.accepted_at ? `<span title="${ticket.accepted_at}">${timeAgoShort(ticket.accepted_at)}</span>` : '<span style="color:var(--muted)">—</span>'}</span>
                </div>
            </div>
        </div>
    `;
}

/**
 * Estado vacío: sin ticket activo
 * @param {string} title
 * @param {string} message
 * @param {boolean} showButton - mostrar botón "Abrir ticket"
 */
export function ticketEmpty(
    title   = 'Sin ticket activo',
    message = 'Cuando necesites ayuda, abre un ticket y te responderemos pronto.',
    showButton = true
) {
    const btn = showButton ? `
        <button class="btn-primary-sm mt-1" id="btn-open-new-ticket-modal">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Abrir ticket
        </button>
    ` : '';

    return `
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="22" height="22" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <h6>${title}</h6>
            <p>${message}</p>
            ${btn}
        </div>
    `;
}