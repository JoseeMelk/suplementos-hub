import { openModal, closeModal } from "../../utils/modals";
import { storeTicket, getActiveTicket } from "../services/ticket.service";
import { getActiveConversation } from "../services/conversation.service.js";
import { getMessages, storeMessage } from "../services/message.service.js";
import { handleResponse } from "../../utils/http-handler";
import { getInitials } from "../../utils/utlis.js";
import { alert } from "../../lib/alert";
import { ticketCard, ticketEmpty } from '../components/ticket-card.js';
import { conversationCard, conversationEmpty } from "../components/conversation-card.js";
import { autoResizeTextarea } from "../../utils/chat-input.js";
import { chatHeader, chatInput, chatBlocked, renderMessages, chatMessage } from '../components/chat-panel.js';
import { startPolling, stopPolling, updateLastMessageId } from '../utils/message-polling.js';

async function createNewTicket(form, btnSubmitNewTicket) {

    const confirm = await alert.confirm(
        '¿Estás seguro de crear ticket?',
        'Los administradores verán el ticket',
        'Sí, crear'
    );

    if (!confirm.isConfirmed) return false;

    btnSubmitNewTicket.disabled = true;

    const formData = new FormData(form);

    try {
        const response = await storeTicket(formData);

        return await handleResponse(response, {
            successMessage: 'Ticket creado',
            successDescription: 'El ticket ha sido creado y está disponible para los administradores.',
            errorMessage: 'Error al crear el ticket'
        });

    } catch (error) {
        alert.error('Error', 'Ocurrió un error al crear el ticket.');
        return false;

    } finally {
        btnSubmitNewTicket.disabled = false;
    }
}

async function sendMessage(conversationId) {
    const chatInput = document.getElementById('chat-input-msg');
    try {
        const payload = {
            'message': chatInput.value.trim()
        }

        const response = await storeMessage(conversationId, payload);
        if (!response.ok) {
            throw new Error("Error al enviar mensaje: " + response.httpStatus);
        }
        updateLastMessageId(response.data.id);

        chatInput.value = '';
        return response.data;
    } catch (error) {
        alert.error('Error', 'Ocurrió un error al enviar el mensaje.');
        return null;
    }
}

function newTicketAcction() {
    const newTicketModalId = 'new-ticket-modal';
    const btnOpenNewTicketModal = document.getElementById('btn-open-new-ticket-modal');
    const btnCloseNewTicketModal = document.getElementById('btn-close-new-ticket-modal');
    const form = document.getElementById('new-ticket-form');

    btnOpenNewTicketModal.addEventListener('click', () => {
        openModal(newTicketModalId);
    });

    btnCloseNewTicketModal.addEventListener('click', () => {
        closeModal(newTicketModalId);
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            form.reportValidity();
            return;
        }

        const btnSubmitNewTicket = document.getElementById('btn-submit-new-ticket');
        const ok = await createNewTicket(form, btnSubmitNewTicket);

        if (ok) {
            form.reset();
            form.classList.remove('was-validated');
            closeModal(newTicketModalId);
            initTicket();
        }
    });
}

async function initTicket() {
    const activeTicket = await getActiveTicket();
    let conversation = null;
    let messages = null;
    let notExistTicket = true;
    let ticketIsOpen = false;
    let ticketIsInProgress = false;

    const ticketElement = document.getElementById('in-progress-ticket');

    // Detener polling anterior antes de re-inicializar
    stopPolling();

    if (!activeTicket.data) {
        ticketElement.innerHTML = ticketEmpty();
        newTicketAcction();
        initConversation(notExistTicket, ticketIsOpen, ticketIsInProgress);
        chatWithNoTicket();
        notExistTicket = true;
    }

    ticketIsOpen = activeTicket.data && activeTicket.data.status === 'open';
    if (ticketIsOpen) {
        notExistTicket = false;
        ticketElement.innerHTML = ticketCard(activeTicket.data);
        initConversation(notExistTicket, ticketIsOpen, ticketIsInProgress);
        chatWithOpenTicket(activeTicket.data.tracking_number);
    }

    ticketIsInProgress = activeTicket.data && activeTicket.data.status === 'in_progress';
    if (ticketIsInProgress) {
        conversation = await getActiveConversation();
        messages = await getMessages(conversation.data.id);

        notExistTicket = false;
        ticketElement.innerHTML = ticketCard(activeTicket.data);
        initConversation(notExistTicket, ticketIsOpen, conversation.data);

        chatWithInProgressTicket(activeTicket.data, messages.data, conversation.data.id);
    }
}

async function initConversation(notExistTicket, ticketIsOpen, conversation = null) {
    const conversationInfoElement = document.getElementById('conversation-info');
    if (notExistTicket) {
        conversationInfoElement.innerHTML = conversationEmpty('Abre un ticket para comunicarte con los administradores.');
        return;
    }
    if (ticketIsOpen) {
        conversationInfoElement.innerHTML = conversationEmpty('La conversacion estara disponible una vez que se le de seguimiento a tu ticket.');
        return;
    }
    if (conversation != null) {
        conversationInfoElement.innerHTML = conversationCard(conversation);
    }
}

function chatWithNoTicket() {
    stopPolling();
    const chatElement = document.getElementById('chat-container');

    const html = [
        chatHeader(),
        chatBlocked('Abre un ticket para comunicarte con los administradores.')
    ].join('');

    chatElement.innerHTML = html;
}

function chatWithOpenTicket(trackingNumber) {
    stopPolling();
    const chatElement = document.getElementById('chat-container');
    const html = [
        chatHeader('Sin asignar', 'SA', '#9ca3af', trackingNumber),
        chatBlocked()
    ].join('');

    chatElement.innerHTML = html;
}

function chatWithInProgressTicket(ticket, messages, conversationId) {
    const chatElement = document.getElementById('chat-container');

    const initials = getInitials(ticket.assigned_to, false);
    const avatarColor = '#198754';

    const html = [
        chatHeader(
            ticket.assigned_to,
            initials,
            avatarColor,
            ticket.ticketRef
        ),
        `<div class="chat-messages" id="chat-messages">`,
        renderMessages(messages, avatarColor, initials),
        `</div>`,
        chatInput('Escribe un mensaje…')
    ].join('');

    chatElement.innerHTML = html;

    // scroll inicial al último mensaje
    requestAnimationFrame(() => {
        const container = document.getElementById('chat-messages');
        container.scrollTop = container.scrollHeight;
    });

    chatElement.addEventListener('input', (e) => {
        if (e.target.classList.contains('chat-ta')) {
            autoResizeTextarea(e.target);
        }
    });

    const btnSendMsg = document.getElementById('btn-send-msg');
    const msgInput = document.getElementById('chat-input-msg');

    const send = async () => {
        const newMessage = await sendMessage(conversationId);

        if (!newMessage) return;

        const container = document.getElementById('chat-messages');

        container.insertAdjacentHTML(
            'beforeend',
            chatMessage(newMessage, avatarColor, getInitials(ticket.assigned_to, false))
        );

        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;
        });
    };

    btnSendMsg.addEventListener('click', send);

    msgInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault(); // evita salto de línea
            send();
        }
    });
    // ── Polling: detectar mensajes nuevos del admin ──
    startPolling(conversationId, messages, (newMsgs) => {
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

async function initProviderSupport() {
    initTicket();
}

initProviderSupport();