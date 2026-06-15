export const PROVIDER_SUPPORT_ROUTES = {
    // provider
    CREATE_TICKET: '/api/provider/tickets',
    ACTIVE_TICKET: '/api/provider/tickets/active',
    ACTIVE_CONVERSATION: '/api/provider/conversations/active',

    // MESSAGES: (conversationId) =>
    //     `/api/provider/conversations/${conversationId}/messages`,


};

export const ADMIN_SUPPORT_ROUTES =
{
    // admin
    ADMIN_TICKETS: '/api/admin/tickets',
    ACCEPT_TICKET: (id) => `/api/admin/tickets/${id}`,
    CLOSE_TICKET: (id) => `/api/admin/tickets/${id}/close`,

    CONVERSATIONS: '/api/admin/conversations',
    CONVERSATION:   (id) => `/api/admin/conversations/${id}`,
    
}

export const MESSAGES_ROUTE = {
    MESSAGES: (conversationId) =>
        `/api/conversations/${conversationId}/messages`,
}