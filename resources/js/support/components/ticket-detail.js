import { timeAgoShort } from '../../utils/date.js';

// ── Iconos ──────────────────────────────────────────────────────────────────
const ICON_PLUS   = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>`;
const ICON_CHECK  = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/></svg>`;
const ICON_CHAT   = `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>`;

const STATUS_BADGE = {
    open:        `<span class="bs bs-open"><span class="dot"></span>Abierto</span>`,
    in_progress: `<span class="bs bs-progress"><span class="dot"></span>En progreso</span>`,
    closed:      `<span class="bs bs-closed">Cerrado</span>`,
};

/**
 * Panel de detalle del ticket seleccionado
 * @param {Object} ticket       - TicketResource
 * @param {Object} conversation - ConversationResource | null
 */
export function ticketDetail(ticket, conversation = null) {
    const hasConv      = !!conversation;
    const isOpen       = ticket.status === 'open';
    const isInProgress = ticket.status === 'in_progress';
    const isClosed     = ticket.status === 'closed';

    const convStatusHtml = hasConv
        ? `<span style="color:var(--success);font-weight:600">Activa</span>`
        : isOpen
            ? `<span style="color:var(--muted);font-style:italic">Pendiente</span>`
            : `<span style="color:var(--muted)">—</span>`;

    return `
        <div class="detail-header">
            <div class="d-flex align-items-start justify-content-between gap-2 mb-1">
                <h6 class="detail-subject mb-0">${ticket.title}</h6>
                ${STATUS_BADGE[ticket.status] ?? STATUS_BADGE.open}
            </div>
            <span class="detail-tracking">${ticket.tracking_number}</span>

            <div class="meta-grid">
                <div class="mg-item">
                    <label>Proveedor</label>
                    <span>${ticket.reported_by}</span>
                </div>
                <div class="mg-item">
                    <label>Asignado a</label>
                    <span>${ticket.assigned_to ?? '<span style="color:var(--muted);font-style:italic">Sin asignar</span>'}</span>
                </div>
                <div class="mg-item">
                    <label>Conversación</label>
                    ${convStatusHtml}
                </div>
                <div class="mg-item">
                    <label>Abierto</label>
                    <span title="${ticket.opened_at}">${timeAgoShort(ticket.opened_at)}</span>
                </div>
                <div class="mg-item">
                    <label>Aceptado</label>
                    <span>${ticket.accepted_at ? `<span title="${ticket.accepted_at}">${timeAgoShort(ticket.accepted_at)}</span>` : '<span style="color:var(--muted)">—</span>'}</span>
                </div>
                <div class="mg-item">
                    <label>Cerrado</label>
                    <span>${ticket.closed_at ? `<span title="${ticket.closed_at}">${timeAgoShort(ticket.closed_at)}</span>` : '<span style="color:var(--muted)">—</span>'}</span>
                </div>
            </div>
        </div>

        <div class="detail-desc">
            <p class="timeline-label" style="margin-bottom:.375rem">Descripción</p>
            <p>${ticket.description}</p>
        </div>

        <div class="actions-bar">
            ${isOpen ? `
                <button class="btn-act primary" id="btn-accept-ticket" data-ticket-id="${ticket.id}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>
                    </svg>
                    Aceptar ticket
                </button>
            ` : ''}

            ${isInProgress ? `
                <!-- ESTA PARTE ESTA COMENTADO PARA UN FUTURA IMPLEMENTACION
                <button class="btn-act neutral" id="btn-view-chat" data-conversation-id="${conversation?.id ?? ''}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Ver chat
                </button>
                -->
                <button class="btn-act danger" id="btn-close-ticket" data-ticket-id="${ticket.id}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                    Cerrar ticket
                </button>
            ` : ''}

            ${isClosed ? `
                <span style="font-size:.8rem;color:var(--muted);font-style:italic">Ticket cerrado</span>
            ` : ''}
            <!-- ESTA PARTE ESTA COMENTADO PARA UN FUTURA IMPLEMENTACION
            <div class="dropdown ms-auto">
                <button class="btn-act neutral" data-bs-toggle="dropdown">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="5" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="12" cy="19" r="1"/>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" style="font-size:.8rem;border-radius:var(--radius-sm)">
                    <li><a class="dropdown-item" href="#">Reasignar ticket</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="#">Eliminar ticket</a></li>
                </ul>
            </div>
            -->
        </div>

        <div class="close-confirm" id="close-confirm-bar">
            <p>¿Confirmas que el problema fue resuelto y deseas cerrar este ticket?</p>
            <div class="d-flex gap-2">
                <button class="btn-act success" id="btn-confirm-close" style="font-size:.75rem;padding:.35rem .75rem" data-ticket-id="${ticket.id}">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M9 12l2 2 4-4"/>
                    </svg>
                    Sí, cerrar
                </button>
                <button class="btn-act neutral" id="btn-cancel-close" style="font-size:.75rem;padding:.35rem .75rem">
                    Cancelar
                </button>
            </div>
        </div>

        <div class="timeline">
            <p class="timeline-label">Historial de actividad</p>
            ${ticketTimeline(ticket, conversation)}
        </div>
    `;
}

/**
 * Timeline de actividad según el estado del ticket
 */
function ticketTimeline(ticket, conversation) {
    const events = [];

    // Siempre: creación
    events.push({
        iconBg:    'var(--brand-light)',
        iconStroke:'var(--brand)',
        icon:      ICON_PLUS,
        text:      `Ticket creado por <strong>${ticket.reported_by}</strong>`,
        time:      ticket.opened_at,
    });

    // Si fue aceptado
    if (ticket.accepted_at && ticket.assigned_to) {
        events.push({
            iconBg:    'var(--success-bg)',
            iconStroke:'var(--success)',
            icon:      ICON_CHECK,
            text:      `Aceptado y asignado a <strong>${ticket.assigned_to}</strong>`,
            time:      ticket.accepted_at,
        });
    }

    // Si tiene conversación
    if (conversation) {
        events.push({
            iconBg:    '#f0f9ff',
            iconStroke:'#0284c7',
            icon:      ICON_CHAT,
            text:      `Conversación iniciada`,
            time:      ticket.accepted_at,
            extra:     conversation.message_count
                ? `<span style="color:var(--muted);font-size:.72rem">${conversation.message_count} mensajes · último hace ${timeAgoShort(conversation.last_message_at)}</span>`
                : null,
        });
    }

    // Si fue cerrado
    if (ticket.closed_at) {
        events.push({
            iconBg:    '#f3f4f6',
            iconStroke:'var(--muted)',
            icon:      `<svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
            text:      `Ticket cerrado`,
            time:      ticket.closed_at,
        });
    }

    return events.map((e, i) => `
        <div class="tl-item">
            <div class="tl-icon" style="background:${e.iconBg}">
                <svg width="10" height="10" fill="none" stroke="${e.iconStroke}" stroke-width="2.5" viewBox="0 0 24 24">
                    ${e.icon.replace(/<svg[^>]*>|<\/svg>/g, '')}
                </svg>
            </div>
            <div>
                <div>${e.text}</div>
                ${e.extra ? e.extra : ''}
                <span class="tl-time" title="${e.time}">${timeAgoShort(e.time)}</span>
            </div>
        </div>
    `).join('');
}

/**
 * Estado vacío: ningún ticket seleccionado
 */
export function ticketDetailEmpty() {
    return `
        <div class="empty-detail">
            <div style="width:48px;height:48px;border-radius:12px;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                <svg width="22" height="22" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
            </div>
            <h6>Ningún ticket seleccionado</h6>
            <p>Haz clic en un ticket de la lista para ver su detalle.</p>
        </div>
    `;
}