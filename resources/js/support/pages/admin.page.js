import { getAdminTickets, acceptTicket, closeTicket } from '../services/ticket.service.js';
import { getMessages, storeMessage } from '../services/message.service.js';
import { getAdminConversations } from '../services/conversation.service.js';
import { handleResponse } from '../../utils/http-handler.js';
import { getInitials } from '../../utils/utlis.js';
import { alert } from '../../lib/alert.js';
import { autoResizeTextarea } from '../../utils/chat-input.js';
import { ticketList, updateTicketRows, updateFilterCounts } from '../components/ticket-list.js';
import { ticketDetail, ticketDetailEmpty } from '../components/ticket-detail.js';
import { chatHeader, chatInput, chatEmpty, renderMessages, chatMessage } from '../components/chat-panel.js';
import { startPolling, stopPolling, updateLastMessageId } from '../utils/message-polling.js';

// ─────────────────────────────────────────────────────────────────────────────
// ESTADO
// ─────────────────────────────────────────────────────────────────────────────

let state = {
    tickets:      [],
    selectedId:   null,
    conversation: null,
    messages:     [],
    filter:       'all',
    search:       '',
    listMounted:  false,
};

// ─────────────────────────────────────────────────────────────────────────────
// RENDERS
// ─────────────────────────────────────────────────────────────────────────────

function renderTicketList() {
    const panel = document.getElementById('ticket-list-panel');
    if (!panel) return;
    
    const filtered = applyFilter(state.tickets, state.filter, state.search);

    if (!state.listMounted) {
        panel.innerHTML = ticketList(filtered, state.selectedId, state.tickets, state.filter);
        state.listMounted = true;
        bindListEvents();
    } else {
        updateTicketRows(filtered, state.selectedId);
        updateFilterCounts(state.tickets);
    }
}

function renderTicketDetail() {
    const panel = document.getElementById('ticket-detail-panel');
    if (!panel) return;

    const ticket = state.tickets.find(t => t.id === state.selectedId);

    if (!ticket) {
        panel.innerHTML = ticketDetailEmpty();
        return;
    }

    panel.innerHTML = ticketDetail(ticket, state.conversation);
    bindDetailEvents(ticket);
}

function renderChat() {
    const chatWrap = document.querySelector('.chat-panel .chat-wrap');
    if (!chatWrap) return;

    // Detener polling anterior antes de re-renderizar el chat
    stopPolling();

    const ticket  = state.tickets.find(t => t.id === state.selectedId);
    const hasChat = ticket?.status === 'in_progress' && state.conversation;

    if (!ticket) {
        chatWrap.innerHTML = [
            chatHeader(),
            chatEmpty('Sin ticket seleccionado', 'Selecciona un ticket de la lista para ver la conversación.')
        ].join('');
        return;
    }

    const initials    = getInitials(ticket.reported_by, false);
    const avatarColor = '#2563eb';

    if (!hasChat && ticket?.status === 'open') {
        chatWrap.innerHTML = [
            chatHeader(ticket.reported_by, initials, avatarColor, ticket.tracking_number),
            chatEmpty('Sin conversación activa', 'Acepta el ticket para iniciar la conversación con el proveedor.')
        ].join('');
        return;
    }
    
    if (!hasChat && ticket?.status === 'closed') {
        chatWrap.innerHTML = [
            chatHeader(ticket.reported_by, initials, avatarColor, ticket.tracking_number),
            chatEmpty('Sin conversación activa', 'El ticket está cerrado.')
        ].join('');
        return;
    }

    chatWrap.innerHTML = [
        chatHeader(ticket.reported_by, initials, avatarColor, ticket.tracking_number),
        `<div class="chat-messages" id="chat-messages">`,
        renderMessages(state.messages ?? [], avatarColor, initials),
        `</div>`,
        chatInput(`Responder a ${ticket.reported_by}…`)
    ].join('');

    requestAnimationFrame(() => {
        const c = document.getElementById('chat-messages');
        if (c) c.scrollTop = c.scrollHeight;
    });

    bindChatEvents(ticket);

    // ── Polling: detectar mensajes nuevos del proveedor ──
    startPolling(state.conversation.id, state.messages ?? [], (newMsgs) => {
        const container = document.getElementById('chat-messages');
        if (!container) {
            stopPolling();
            return;
        }

        newMsgs.forEach(msg => {
            container.insertAdjacentHTML(
                'beforeend',
                chatMessage(msg, avatarColor, initials)
            );
        });

        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;
        });
    });
}

function renderCounters() {
    const openEl = document.getElementById('count-open');
    const progEl = document.getElementById('count-progress');
    if (openEl) openEl.textContent = state.tickets.filter(t => t.status === 'open').length;
    if (progEl) progEl.textContent = state.tickets.filter(t => t.status === 'in_progress').length;
}

function renderAll() {
    renderCounters();
    renderTicketList();
    renderTicketDetail();
    renderChat();
}

// ─────────────────────────────────────────────────────────────────────────────
// EVENTOS — Lista (se bindean una sola vez con listMounted)
// ─────────────────────────────────────────────────────────────────────────────

function bindListEvents() {
    const listBody = document.getElementById('ticket-list-body');
    if (listBody) {
        listBody.addEventListener('click', async (e) => {
            const row = e.target.closest('.ticket-row[data-ticket-id]');
            if (!row) return;

            const id = Number(row.dataset.ticketId);
            if (state.selectedId === id) return;

            state.selectedId   = id;
            state.conversation = null;
            state.messages     = [];

            const ticket = state.tickets.find(t => t.id === id);
            if (ticket?.status === 'in_progress') {
                await loadConversationAndMessages(ticket);
            }

            updateTicketRows(applyFilter(state.tickets, state.filter, state.search), state.selectedId);
            renderTicketDetail();
            renderChat();
            renderCounters();
        });
    }

    const filterSelect = document.getElementById('ticket-filter');
    if (filterSelect) {
        filterSelect.addEventListener('change', e => {
            state.filter = e.target.value;
            updateTicketRows(applyFilter(state.tickets, state.filter, state.search), state.selectedId);
        });
    }

    const searchInput = document.getElementById('ticket-search');
    if (searchInput) {
        searchInput.addEventListener('input', e => {
            state.search = e.target.value.toLowerCase();
            updateTicketRows(applyFilter(state.tickets, state.filter, state.search), state.selectedId);
        });
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// EVENTOS — Detalle
// ─────────────────────────────────────────────────────────────────────────────

function bindDetailEvents(ticket) {
    const btnAceptar = document.getElementById('btn-accept-ticket');
    if (btnAceptar) {
        btnAceptar.addEventListener('click', async () => {
            const confirm = await alert.confirm(
                '¿Aceptar este ticket?',
                `Se te asignará "${ticket.title}" y se abrirá una conversación.`,
                'Sí, aceptar'
            );
            if (!confirm.isConfirmed) return;
            btnAceptar.disabled = true;
            try {
                const response = await acceptTicket(ticket.id);
                const ok = await handleResponse(response, {
                    successMessage:     'Ticket aceptado',
                    successDescription: 'El ticket está en progreso y la conversación fue creada.',
                    errorMessage:       'Error al aceptar el ticket'
                });
                if (ok) await loadTickets();
            } finally {
                btnAceptar.disabled = false;
            }
        });
    }

    const btnCerrar = document.getElementById('btn-close-ticket');
    if (btnCerrar) {
        btnCerrar.addEventListener('click', () => {
            const bar = document.getElementById('close-confirm-bar');
            if (bar) bar.style.display = 'block';
        });
    }

    const btnConfirm = document.getElementById('btn-confirm-close');
    if (btnConfirm) {
        btnConfirm.addEventListener('click', async () => {
            btnConfirm.disabled = true;
            try {
                const response = await closeTicket(ticket.id);
                const ok = await handleResponse(response, {
                    successMessage:     'Ticket cerrado',
                    successDescription: 'El ticket fue marcado como resuelto.',
                    errorMessage:       'Error al cerrar el ticket'
                });
                if (ok) {
                    state.conversation = null;
                    state.messages     = [];
                    await loadTickets();
                }
            } finally {
                btnConfirm.disabled = false;
            }
        });
    }

    const btnCancel = document.getElementById('btn-cancel-close');
    if (btnCancel) {
        btnCancel.addEventListener('click', () => {
            const bar = document.getElementById('close-confirm-bar');
            if (bar) bar.style.display = 'none';
        });
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// EVENTOS — Chat
// ─────────────────────────────────────────────────────────────────────────────

function bindChatEvents(ticket) {
    const chatWrap = document.querySelector('.chat-panel .chat-wrap');
    if (!chatWrap) return;

    chatWrap.addEventListener('input', e => {
        if (e.target.classList.contains('chat-ta')) autoResizeTextarea(e.target);
    });

    const btnSend  = document.getElementById('btn-send-msg');
    const msgInput = document.getElementById('chat-input-msg');
    if (!btnSend || !msgInput) return;

    const send = async () => {
        const text = msgInput.value.trim();
        if (!text) return;
        btnSend.disabled = true;
        try {
            const response = await storeMessage(state.conversation.id, { message: text });
            updateLastMessageId(response.data.id);
            if (!response.ok) throw new Error();
            msgInput.value = '';
            msgInput.style.height = 'auto';
            const container = document.getElementById('chat-messages');
            if (container) {
                container.insertAdjacentHTML('beforeend',
                    chatMessage(response.data, '#2563eb', getInitials(ticket.reported_by, false))
                );
                requestAnimationFrame(() => { container.scrollTop = container.scrollHeight; });
            }
            if (state.conversation) state.conversation.last_message_at = new Date().toISOString();
        } catch {
            alert.error('Error', 'Ocurrió un error al enviar el mensaje.');
        } finally {
            btnSend.disabled = false;
        }
    };

    btnSend.addEventListener('click', send);
    msgInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// CARGA DE DATOS
// ─────────────────────────────────────────────────────────────────────────────

async function loadTickets() {
    const response = await getAdminTickets();
    if (!response.ok) { alert.error('Error', 'No se pudieron cargar los tickets.'); return; }

    state.tickets = response.data ?? [];

    if (state.selectedId) {
        const ticket = state.tickets.find(t => t.id === state.selectedId);
        if (ticket?.status === 'in_progress' && !state.conversation) {
            await loadConversationAndMessages(ticket);
        }
        if (ticket?.status === 'closed') {
            state.conversation = null;
            state.messages     = [];
        }
    }

    renderAll();
}

async function loadConversationAndMessages(ticket) {
    try {
        const convResponse = await getAdminConversations();
        if (!convResponse.ok) return;
        const conv = (convResponse.data ?? []).find(c => c.ticket_id === ticket.id);
        if (!conv) return;
        state.conversation = conv;
        const msgResponse  = await getMessages(conv.id);
        state.messages     = msgResponse.ok ? (msgResponse.data ?? []) : [];
    } catch {
        state.conversation = null;
        state.messages     = [];
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// HELPERS
// ─────────────────────────────────────────────────────────────────────────────

function applyFilter(tickets, filter, search) {
    return tickets.filter(t => {
        const matchFilter = filter === 'all' || t.status === filter;
        const matchSearch = !search ||
            t.title.toLowerCase().includes(search) ||
            t.tracking_number.toLowerCase().includes(search) ||
            t.reported_by.toLowerCase().includes(search);
        return matchFilter && matchSearch;
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// INIT
// ─────────────────────────────────────────────────────────────────────────────

async function initAdminSupport() {
    await loadTickets();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAdminSupport);
} else {
    initAdminSupport();
}