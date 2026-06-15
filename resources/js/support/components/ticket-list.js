import { timeAgoShort } from '../../utils/date.js';

const STATUS_MAP = {
    open:        { label: 'Abierto',     cls: 'bs-open' },
    in_progress: { label: 'En progreso', cls: 'bs-progress' },
    closed:      { label: 'Cerrado',     cls: 'bs-closed' },
};

const ICON_USER = `
    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
        <circle cx="12" cy="7" r="4"/>
    </svg>
`;

export function ticketRow(ticket, isActive = false) {
    const { label, cls } = STATUS_MAP[ticket.status] ?? STATUS_MAP.open;
    const opacity = ticket.status === 'closed' ? 'opacity:.6;' : '';

    return `
        <div
            class="ticket-row${isActive ? ' active' : ''}"
            data-ticket-id="${ticket.id}"
            style="${opacity}"
        >
            <div class="d-flex align-items-start justify-content-between gap-1 mb-1">
                <p class="tr-subject" title="${ticket.title}">${ticket.title}</p>
                <span class="bs ${cls}">
                    ${ticket.status !== 'closed' ? '<span class="dot"></span>' : ''}
                    ${label}
                </span>
            </div>
            <div class="tr-provider">${ICON_USER} ${ticket.reported_by}</div>
            <div class="tr-meta">
                <span class="tr-tracking">${ticket.tracking_number}</span>
                <span>·</span>
                <span>${timeAgoShort(ticket.opened_at)}</span>
            </div>
        </div>
    `;
}

/**
 * Render inicial completo — incluye buscador, select de filtro y lista.
 * Solo llamar la primera vez o cuando se recarga todo.
 */
export function ticketList(filteredTickets, activeTicketId = null, allTickets = [], activeFilter = 'all') {
    const total       = allTickets.length;
    const openCount   = allTickets.filter(t => t.status === 'open').length;
    const progCount   = allTickets.filter(t => t.status === 'in_progress').length;
    const closedCount = allTickets.filter(t => t.status === 'closed').length;

    const rows = filteredTickets
        .map(t => ticketRow(t, t.id === activeTicketId))
        .join('');

    // Select nativo de Bootstrap — nunca tiene scroll ni overflow issues
    return `
        <div class="search-box">
            <input
                class="search-input"
                id="ticket-search"
                type="text"
                placeholder="Buscar tickets…"
                autocomplete="off"
            >
        </div>

        <div class="filter-box">
            <select class="filter-select" id="ticket-filter">
                <option value="all"        ${activeFilter === 'all'         ? 'selected' : ''}>Todos (${total})</option>
                <option value="open"       ${activeFilter === 'open'        ? 'selected' : ''}>Abiertos (${openCount})</option>
                <option value="in_progress"${activeFilter === 'in_progress' ? 'selected' : ''}>En progreso (${progCount})</option>
                <option value="closed"     ${activeFilter === 'closed'      ? 'selected' : ''}>Cerrados (${closedCount})</option>
            </select>
        </div>

        <div id="ticket-list-body" style="flex:1;overflow-y:auto">
            ${rows || emptyTicketList()}
        </div>
    `;
}

/**
 * Actualiza SOLO las filas, sin tocar el buscador ni el select.
 * Usar en renders posteriores para no perder el foco del input.
 */
export function updateTicketRows(filteredTickets, activeTicketId = null) {
    const body = document.getElementById('ticket-list-body');
    if (!body) return;
    body.innerHTML = filteredTickets.length
        ? filteredTickets.map(t => ticketRow(t, t.id === activeTicketId)).join('')
        : emptyTicketList();
}

/**
 * Actualiza los conteos del select sin re-renderizar nada más.
 */
export function updateFilterCounts(allTickets) {
    const sel = document.getElementById('ticket-filter');
    if (!sel) return;
    const total  = allTickets.length;
    const open   = allTickets.filter(t => t.status === 'open').length;
    const prog   = allTickets.filter(t => t.status === 'in_progress').length;
    const closed = allTickets.filter(t => t.status === 'closed').length;
    sel.options[0].text = `Todos (${total})`;
    sel.options[1].text = `Abiertos (${open})`;
    sel.options[2].text = `En progreso (${prog})`;
    sel.options[3].text = `Cerrados (${closed})`;
}

function emptyTicketList() {
    return `
        <div style="padding:2rem;text-align:center;color:var(--muted);font-size:.85rem">
            No hay tickets disponibles.
        </div>
    `;
}