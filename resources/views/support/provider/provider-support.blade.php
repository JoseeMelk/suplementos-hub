@extends('layouts.provider')

@section('title', 'Soporte')

@push('styles')
    <style>
        :root {
            --brand: #2563eb;
            --brand-light: #eff6ff;
            --brand-dark: #1d4ed8;
            --success: #16a34a;
            --success-bg: #f0fdf4;
            --warning: #d97706;
            --warning-bg: #fffbeb;
            --danger: #dc2626;
            --danger-bg: #fef2f2;
            --surface: #ffffff;
            --border: #e5e7eb;
            --muted: #6b7280;
            --text: #111827;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, .08);
        }

        .support-grid {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 1.25rem;
            min-height: calc(100vh - 165px);
        }

        .panel {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .panel-head {
            padding: .875rem 1.125rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-shrink: 0;
        }

        .panel-head .ptitle {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--muted);
            flex: 1;
        }

        /* Badges */
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            padding: .2rem .6rem;
            border-radius: 99px;
            font-size: .7rem;
            font-weight: 700;
        }

        .badge-status .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .bs-open {
            background: var(--brand-light);
            color: var(--brand);
        }

        .bs-progress {
            background: var(--success-bg);
            color: var(--success);
        }

        .bs-closed {
            background: #f3f4f6;
            color: var(--muted);
        }

        /* Ticket card */
        .ticket-card-body {
            padding: 1.125rem;
        }

        .ticket-tracking {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: .375rem;
        }

        .ticket-title {
            font-size: .9375rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: .5rem;
        }

        .ticket-desc {
            font-size: .84rem;
            color: #374151;
            line-height: 1.6;
            margin-bottom: .875rem;
        }

        .ticket-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .375rem .625rem;
            padding-top: .75rem;
            border-top: 1px solid var(--border);
        }

        .tmg-item label {
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: var(--muted);
            display: block;
            margin-bottom: .1rem;
        }

        .tmg-item span {
            font-size: .8125rem;
            font-weight: 500;
            color: var(--text);
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            text-align: center;
            gap: .625rem;
        }

        .empty-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--brand-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: .25rem;
        }

        .empty-state h6 {
            font-size: .875rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .empty-state p {
            font-size: .8rem;
            color: var(--muted);
            margin: 0;
        }

        /* Conversación item */
        .conv-item {
            padding: .875rem 1.125rem;
        }

        .conv-subject {
            font-size: .875rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: .25rem;
        }

        .conv-meta {
            font-size: .75rem;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        /* Botones */
        .btn-primary-sm {
            display: inline-flex;
            align-items: center;
            gap: .375rem;
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            padding: .45rem 1rem;
            font-size: .8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .12s;
        }

        .btn-primary-sm:hover {
            background: var(--brand-dark);
        }

        .btn-ghost-sm {
            display: inline-flex;
            align-items: center;
            gap: .375rem;
            background: transparent;
            color: var(--muted);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .4rem .875rem;
            font-size: .78rem;
            font-weight: 600;
            cursor: pointer;
            transition: all .12s;
        }

        .btn-ghost-sm:hover {
            border-color: var(--brand);
            color: var(--brand);
        }

        /* Chat */
        .chat-wrap {
            display: flex;
            flex-direction: column;
            height: 78vh;
        }

        .chat-header {
            padding: .875rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-shrink: 0;
            background: var(--surface);
        }

        .chat-av {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .78rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            min-height: 0;
            padding: 1.125rem;
            display: flex;
            flex-direction: column;
            gap: .875rem;
            background: #f9fafb;
        }

        .date-sep {
            text-align: center;
            font-size: .7rem;
            color: var(--muted);
            position: relative;
            margin: .25rem 0;
        }

        .date-sep::before,
        .date-sep::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 56px);
            height: 1px;
            background: var(--border);
        }

        .date-sep::before {
            left: 0;
        }

        .date-sep::after {
            right: 0;
        }

        .msg-row {
            display: flex;
            align-items: flex-end;
            /* avatar se pega al fondo de la burbuja */
            gap: .5rem;
        }

        .msg-row.own {
            flex-direction: row-reverse;
        }

        /* El div interno de cada mensaje */
        .msg-row>div:not(.msg-av) {
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        /* Recv: contenido alineado a la izquierda */
        .msg-row:not(.own)>div:not(.msg-av) {
            align-items: flex-start;
        }

        /* Sent: contenido alineado a la derecha */
        .msg-row.own>div:not(.msg-av) {
            align-items: flex-end;
        }

        .msg-av {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .65rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            /* Pegado al fondo gracias a align-items:flex-end del padre */
            align-self: flex-end;
        }

        .bubble {
            max-width: 70%;
            padding: .6rem .9rem;
            border-radius: 16px;
            font-size: .8375rem;
            line-height: 1.55;
        }

        .bubble.recv {
            background: #fff;
            border: 1px solid var(--border);
            border-bottom-left-radius: 4px;
            color: var(--text);
        }

        .bubble.sent {
            background: var(--brand);
            color: #fff;
            border-bottom-right-radius: 4px;
        }

        .msg-time {
            font-size: .67rem;
            color: var(--muted);
            margin-top: .2rem;
            display: block;
        }

        .msg-row.own .msg-time {
            text-align: right;
        }

        .msg-sender-name {
            font-size: .7rem;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: .15rem;
        }

        /* Input chat */
        .chat-input-area {
            padding: .875rem 1.125rem;
            border-top: 1px solid var(--border);
            display: flex;
            gap: .5rem;
            align-items: flex-end;
            flex-shrink: 0;
            background: var(--surface);
        }

        .chat-ta {
            flex: 1;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .5rem .75rem;
            font-size: .875rem;
            resize: none;
            min-height: 42px;
            max-height: 110px;
            outline: none;
            background: #fafafa;
            color: var(--text);
            transition: border-color .15s;
            font-family: inherit;
            line-height: 1.4;
        }

        .chat-ta:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .1);
            background: #fff;
        }

        .btn-send {
            background: var(--brand);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .12s;
            flex-shrink: 0;
        }

        .btn-send:hover {
            background: var(--brand-dark);
        }

        /* Chat bloqueado */
        .chat-blocked {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: .75rem;
            background: #f9fafb;
            padding: 2rem;
            text-align: center;
        }

        /* Alert inline */
        .alert-inline {
            padding: .625rem .875rem;
            border-radius: var(--radius-sm);
            font-size: .8rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .alert-inline.warn {
            background: var(--warning-bg);
            color: var(--warning);
            border: 1px solid #fde68a;
        }

        /* Modal */
        .modal-content {
            border-radius: var(--radius);
            border: 1px solid var(--border);
        }

        .modal-header {
            border-bottom: 1px solid var(--border);
            padding: 1rem 1.25rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border);
            padding: .75rem 1.25rem;
        }

        .form-label-sm {
            font-size: .8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: .3rem;
        }

        .input-clean {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: .5rem .75rem;
            font-size: .875rem;
            width: 100%;
            background: #fafafa;
            outline: none;
            color: var(--text);
            transition: border-color .15s, box-shadow .15s;
            font-family: inherit;
        }

        .input-clean:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
            background: #fff;
        }

        textarea.input-clean {
            resize: vertical;
            min-height: 90px;
        }

        @media (max-width: 860px) {
            .support-grid {
                grid-template-columns: 1fr;
                height: auto;
            }

            .panel {
                min-height: 0;
            }
        }
    </style>
@endpush

@section('content')

    {{-- <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-bold mb-0">Soporte</h4>
            <p class="text-muted mb-0" style="font-size:.85rem">
                Comunícate con el equipo de soporte técnico
            </p>
        </div>

        <button class="btn-primary-sm" id="btnNuevoTicket" data-bs-toggle="modal" data-bs-target="#new-ticket-modal">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Nuevo ticket
        </button>
    </div> --}}

    <div class="support-grid">

        {{-- ═══════════════════════════════════════ --}}
        {{-- PANEL IZQUIERDO --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="d-flex flex-column gap-3">

            {{-- TICKET --}}
            <div class="panel">
                <div class="panel-head">
                    <svg width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2.2"
                        viewBox="0 0 24 24">
                        <path
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    <span class="ptitle">Mi ticket activo</span>
                </div>

                {{-- 🔥 JS RENDER --}}
                <div id="in-progress-ticket"></div>
            </div>

            {{-- CONVERSACIÓN --}}
            <div class="panel">
                <div class="panel-head">
                    <svg width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2.2"
                        viewBox="0 0 24 24">
                        <path
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span class="ptitle">Conversación</span>
                </div>

                {{-- 🔥 JS RENDER --}}
                <div id="conversation-info"></div>
            </div>

            <div class="panel">
                <div class="panel-head">
                    <i class="bi bi-info-circle-fill text-success"></i>
                    <span class="ptitle">El chat se penso para computadoras</span>
                </div>
            </div>

        </div>

        {{-- ═══════════════════════════════════════ --}}
        {{-- CHAT --}}
        {{-- ═══════════════════════════════════════ --}}
        <div class="panel">
            <div class="chat-wrap" id="chat-container">
            </div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════ --}}
    {{-- MODAL NUEVO TICKET (SIN CAMBIOS) --}}
    {{-- ═══════════════════════════════════════ --}}
    <div class="modal fade" id="new-ticket-modal" tabindex="-1" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" style="max-width:490px">
            <div class="modal-content">

                <div class="modal-header">
                    <h6 class="modal-title fw-bold mb-0">Abrir ticket de soporte</h6>
                </div>

                <form id="new-ticket-form" class="needs-validation" novalidate>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label-sm">Asunto *</label>
                            <input type="text" name="title" id="newTicketTitle" class="input-clean form-control" required>
                        </div>

                        <div class="mb-1">
                            <label class="form-label-sm">Descripción *</label>
                            <textarea name="description" id="newTicketDesc" class="input-clean form-control" required></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn-ghost-sm" type="button" id="btn-close-new-ticket-modal">Cancelar</button>
                        <button class="btn-primary-sm" type="submit" id="btn-submit-new-ticket">
                            Enviar ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{-- @vite('resources/js/support/provider/provider-tickets.page.js') --}}
    @vite('resources/js/support/pages/provider.page.js')
@endpush
