@extends('layouts.admin')

@section('title', 'Soporte — Tickets')

@push('styles')
<style>
    :root {
        --brand:       #2563eb;
        --brand-light: #eff6ff;
        --brand-dark:  #1d4ed8;
        --success:     #16a34a;
        --success-bg:  #f0fdf4;
        --warning:     #d97706;
        --warning-bg:  #fffbeb;
        --danger:      #dc2626;
        --danger-bg:   #fef2f2;
        --surface:     #ffffff;
        --border:      #e5e7eb;
        --muted:       #6b7280;
        --text:        #111827;
        --radius:      12px;
        --radius-sm:   8px;
        --shadow:      0 1px 3px rgba(0,0,0,.08);
    }

    /* ── Layout 3 columnas ── */
    .admin-grid {
        display: grid;
        grid-template-columns: 290px 1fr 362px;
        gap: 1.125rem;
        min-height: calc(100vh - 185px);
    }

    /* ── Panel base ── */
    .panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        overflow: hidden;
        height: 75vh;
    }

    .panel-head {
        padding: .8rem 1.125rem;
        border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: .5rem;
        flex-shrink: 0;
    }
    .panel-head .ptitle {
        font-size: .73rem; font-weight: 700;
        letter-spacing: .06em; text-transform: uppercase;
        color: var(--muted); flex: 1;
    }

    /* ── Badges ── */
    .bs {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .2rem .55rem; border-radius: 99px;
        font-size: .7rem; font-weight: 700;
    }
    .bs .dot { width:6px; height:6px; border-radius:50%; background:currentColor; }
    .bs-open     { background: var(--brand-light); color: var(--brand); }
    .bs-progress { background: var(--success-bg);  color: var(--success); }
    .bs-closed   { background: #f3f4f6;            color: var(--muted); }

    /* ── Buscador (renderizado por JS) ── */
    .search-box {
        padding: .625rem .875rem;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }
    .search-input {
        width: 100%;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: .4rem .7rem .4rem 2rem;
        font-size: .8rem; background: #f9fafb; outline: none; color: var(--text);
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2.2'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: .6rem center;
        transition: border-color .15s; font-family: inherit;
    }
    .search-input:focus { border-color: var(--brand); background-color: #fff; }

    /* ── Filtro (select nativo — sin tabs ni scroll) ── */
    .filter-box {
        padding: .5rem .875rem;
        border-bottom: 1px solid var(--border);
        flex-shrink: 0;
    }
    .filter-select {
        width: 100%;
        border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: .35rem .625rem;
        font-size: .8rem; font-weight: 600;
        background: #fafafa; color: var(--text);
        outline: none; cursor: pointer;
        transition: border-color .15s;
        font-family: inherit;
    }
    .filter-select:focus { border-color: var(--brand); }

    /* ── Ticket rows (renderizados por JS) ── */
    .ticket-row {
        padding: .8rem 1.125rem;
        border-bottom: 1px solid var(--border);
        cursor: pointer; transition: background .1s;
        border-left: 3px solid transparent;
    }
    .ticket-row:hover  { background: #f9fafb; }
    .ticket-row.active { background: var(--brand-light); border-left-color: var(--brand); }

    .tr-provider {
        font-size: .78rem; font-weight: 600; color: #374151;
        display: flex; align-items: center; gap: .3rem; margin-bottom: .2rem;
    }
    .tr-subject {
        font-size: .845rem; font-weight: 600; color: var(--text);
        margin-bottom: .2rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        max-width: 200px;
    }
    .tr-meta {
        font-size: .72rem; color: var(--muted);
        display: flex; align-items: center; gap: .4rem; flex-wrap: wrap;
    }
    .tr-tracking { font-family: monospace; font-size: .72rem; }

    /* ── Detalle ticket col 2 (renderizado por JS) ── */
    .detail-header { padding: 1rem 1.25rem; border-bottom: 1px solid var(--border); flex-shrink: 0; }
    .detail-subject { font-size: 1rem; font-weight: 700; color: var(--text); margin-bottom: .375rem; }
    .detail-tracking { font-family: monospace; font-size: .78rem; color: var(--muted); }

    .meta-grid {
        display: grid; grid-template-columns: repeat(3, 1fr);
        gap: .5rem .875rem; margin-top: .875rem;
    }
    .mg-item label {
        font-size: .67rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--muted); display: block; margin-bottom: .15rem;
    }
    .mg-item span { font-size: .8125rem; font-weight: 500; color: var(--text); }

    .detail-desc {
        padding: .875rem 1.25rem; border-bottom: 1px solid var(--border); flex-shrink: 0;
    }
    .detail-desc p { font-size: .84rem; color: #374151; line-height: 1.65; margin: 0; }

    /* ── Acciones ── */
    .actions-bar {
        padding: .7rem 1.25rem; border-bottom: 1px solid var(--border);
        display: flex; gap: .5rem; flex-wrap: wrap; flex-shrink: 0; align-items: center;
    }
    .btn-act {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .4rem .875rem; border-radius: var(--radius-sm);
        font-size: .78rem; font-weight: 600; cursor: pointer;
        border: 1px solid; transition: all .12s; white-space: nowrap;
    }
    .btn-act.primary { background:var(--brand);     color:#fff;          border-color:var(--brand);   }
    .btn-act.primary:hover { background:var(--brand-dark); }
    .btn-act.success { background:var(--success);   color:#fff;          border-color:var(--success); }
    .btn-act.success:hover { background:#15803d; }
    .btn-act.neutral { background:#fff;             color:#374151;       border-color:var(--border);  }
    .btn-act.neutral:hover { border-color:#9ca3af; }
    .btn-act.danger  { background:var(--danger-bg); color:var(--danger); border-color:#fca5a5; }
    .btn-act.danger:hover  { background:var(--danger); color:#fff; border-color:var(--danger); }

    /* ── Confirmación de cierre ── */
    .close-confirm {
        padding: .75rem 1.25rem; background: var(--danger-bg);
        border-top: 1px solid #fca5a5; flex-shrink: 0;
        display: none;
    }
    .close-confirm p { font-size: .8rem; color: var(--danger); margin: 0 0 .5rem; font-weight: 600; }

    /* ── Timeline ── */
    .timeline { padding: 1rem 1.25rem; flex: 1; overflow-y: auto; }
    .timeline-label {
        font-size: .69rem; font-weight: 700; text-transform: uppercase;
        letter-spacing: .05em; color: var(--muted); margin-bottom: .75rem;
    }
    .tl-item {
        display: flex; gap: .75rem; padding: .4rem 0;
        font-size: .8rem; color: #374151; position: relative;
    }
    .tl-item::before {
        content: ''; position: absolute; left: 11px; top: 26px; bottom: -4px;
        width: 1px; background: var(--border);
    }
    .tl-item:last-child::before { display: none; }
    .tl-icon {
        width: 23px; height: 23px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .tl-time { font-size: .7rem; color: var(--muted); margin-top: .1rem; display: block; }

    /* ── Empty states ── */
    .empty-detail {
        flex: 1; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: .625rem; padding: 2rem; text-align: center;
    }
    .empty-detail h6 { font-size: .875rem; font-weight: 700; color: var(--text); margin: 0; }
    .empty-detail p  { font-size: .8rem; color: var(--muted); margin: 0; }

    /* ── Chat col 3 ── */
    .chat-wrap { display: flex; flex-direction: column; height: 100%; }

    .chat-header {
        padding: .8rem 1.125rem; border-bottom: 1px solid var(--border);
        display: flex; align-items: center; gap: .625rem; flex-shrink: 0;
    }
    .chat-av {
        width: 34px; height: 34px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .75rem; font-weight: 700; color: #fff; flex-shrink: 0;
    }

    .chat-messages {
        flex: 1; overflow-y: auto; padding: 1rem;
        display: flex; flex-direction: column; gap: .75rem; background: #f9fafb;
    }

    .date-sep {
        text-align: center; font-size: .7rem; color: var(--muted);
        position: relative; margin: .25rem 0;
    }
    .date-sep::before, .date-sep::after {
        content: ''; position: absolute; top: 50%;
        width: calc(50% - 52px); height: 1px; background: var(--border);
    }
    .date-sep::before { left: 0; } .date-sep::after { right: 0; }

    /* ── Mensajes ── */
    .msg-row { display: flex; align-items: flex-end; gap: .4rem; }
    .msg-row.own { flex-direction: row-reverse; }

    .msg-row > div:not(.msg-av) {
    display: flex; flex-direction: column;
    min-width: 0;
    max-width: calc(100% - 34px);
}
.msg-row:not(.own) > div:not(.msg-av) { align-items: flex-start; }
.msg-row.own > div:not(.msg-av)       { align-items: flex-end; }

.msg-av {
    width: 26px; height: 26px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .65rem; font-weight: 700; color: #fff;
    flex-shrink: 0; align-self: flex-end;
}
.bubble {
    max-width: 100%; padding: .55rem .825rem; border-radius: 14px;
    font-size: .8375rem; line-height: 1.5;
    word-break: break-word;
    overflow-wrap: break-word;
}
    .bubble.recv { background: #fff; border: 1px solid var(--border); border-bottom-left-radius: 4px; color: var(--text); }
    .bubble.sent { background: var(--brand); color: #fff; border-bottom-right-radius: 4px; }

    .msg-time { font-size: .67rem; color: var(--muted); margin-top: .15rem; display: block; }
    .msg-sender-name { font-size: .69rem; font-weight: 700; color: var(--muted); margin-bottom: .12rem; }

    /* ── Typing dots ── */
    .typing-dots { display: flex; gap: 3px; align-items: center; }
    .typing-dots span {
        width: 6px; height: 6px; border-radius: 50%; background: #9ca3af;
        animation: tdot .8s infinite;
    }
    .typing-dots span:nth-child(2) { animation-delay: .15s; }
    .typing-dots span:nth-child(3) { animation-delay: .3s; }
    @keyframes tdot { 0%,80%,100%{transform:translateY(0)} 40%{transform:translateY(-4px)} }

    /* ── Chat input ── */
    .chat-input-area {
        padding: .75rem 1rem; border-top: 1px solid var(--border);
        display: flex; gap: .5rem; align-items: flex-end; flex-shrink: 0; background: var(--surface);
    }
    .chat-ta {
        flex: 1; border: 1px solid var(--border); border-radius: var(--radius-sm);
        padding: .45rem .7rem; font-size: .8375rem; resize: none;
        min-height: 40px; max-height: 100px; outline: none;
        background: #fafafa; color: var(--text); transition: border-color .15s; font-family: inherit;
    }
    .chat-ta:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(37,99,235,.1); background: #fff; }

    .btn-send {
        background: var(--brand); color: #fff; border: none;
        border-radius: var(--radius-sm); width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: background .12s; flex-shrink: 0;
    }
    .btn-send:hover { background: var(--brand-dark); }

    /* ── Chat vacío ── */
    .chat-empty {
        flex: 1; display: flex; flex-direction: column;
        align-items: center; justify-content: center;
        gap: .625rem; background: #f9fafb; padding: 1.5rem; text-align: center;
    }
    .chat-empty h6 { font-size: .875rem; font-weight: 700; color: var(--text); margin: 0; }
    .chat-empty p  { font-size: .8rem; color: var(--muted); margin: 0; }

    @media (max-width: 1200px) {
        .admin-grid { grid-template-columns: 270px 1fr; }
        .chat-panel { display: none; }
    }
    @media (max-width: 768px) {
        .admin-grid { grid-template-columns: 1fr; height: auto; }
        .panel { min-height: 360px; }
    }
</style>
@endpush

@section('content')

{{-- ── Cabecera ── --}}
<div class="d-flex align-items-center justify-content-between mb-2">
    <div>
        <p class="text-muted mb-0" style="font-size:.85rem">Gestión de tickets y conversaciones</p>
    </div>
    {{-- Contadores: JS escribe en #countOpen y #countProgress --}}
    <div class="d-flex gap-2">
        <span class="bs bs-open"><span class="dot"></span><span id="count-open">0</span> abiertos</span>
        <span class="bs bs-progress"><span class="dot"></span><span id="count-progress">0</span> en progreso</span>
    </div>
</div>

<div class="admin-grid">

    {{-- ══ COLUMNA 1 — Lista de tickets
         Punto de montaje: ticketList() → #ticketListPanel
         Incluye: buscador, tabs y filas (ticketRow)
    ══ --}}
    <div class="panel">
        <div class="panel-head">
            <svg width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2.2" viewBox="0 0 24 24">
                <path d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
            </svg>
            <span class="ptitle">Tickets</span>
        </div>
        {{-- JS inyecta aquí: search + tabs + ticket-rows --}}
        <div id="ticket-list-panel" style="display:contents"></div>
    </div>

    {{-- ══ COLUMNA 2 — Detalle del ticket seleccionado
         Punto de montaje: ticketDetail() o ticketDetailEmpty() → #ticketDetailPanel
         Incluye: header, descripción, acciones, confirmación cierre, timeline
    ══ --}}
    <div class="panel" id="ticket-detail-panel">
        {{-- JS inyecta aquí ticketDetail() o ticketDetailEmpty() --}}
    </div>

    {{-- ══ COLUMNA 3 — Chat
         Header: JS actualiza .chat-av, #chatProviderName, #adminChatTicketRef
         Mensajes: renderMessages() → #adminChatMessages
         Input: visible/oculto según estado del ticket
    ══ --}}
    <div class="panel chat-panel">
        <div class="chat-wrap">

            {{-- Header — actualizado por renderChat() --}}
            <div class="chat-header" id="admin-chat-header">
                <div class="chat-av" style="background:var(--brand)">—</div>
                <div style="flex:1;min-width:0">
                    <p class="mb-0" style="font-size:.875rem;font-weight:700;color:var(--text)">
                        <span id="chat-provider-name">—</span>
                    </p>
                    <span style="font-size:.71rem;color:var(--muted)">
                        <span style="display:inline-block;width:7px;height:7px;border-radius:50%;background:#22c55e;margin-right:3px;vertical-align:middle"></span>
                        En línea &nbsp;·&nbsp; <span id="admin-chat-ticket-ref">—</span>
                    </span>
                </div>
                <span class="bs bs-progress" style="flex-shrink:0"><span class="dot"></span>Activa</span>
            </div>

            {{-- Mensajes — renderMessages() escribe aquí --}}
            <div class="chat-messages d-none" id="admin-chat-messages"></div>

            {{-- Estado vacío — visible cuando no hay conversación activa --}}
            <div class="chat-empty" id="chat-empty">
                <div style="width:44px;height:44px;border-radius:12px;background:var(--brand-light);display:flex;align-items:center;justify-content:center">
                    <svg width="20" height="20" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <h6>Sin conversación activa</h6>
                <p>Acepta un ticket para iniciar el chat con el proveedor.</p>
            </div>

            {{-- Input — visible solo con conversación activa (IN_PROGRESS) --}}
            <div class="chat-input-area d-none" id="admin-chat-input">
                <textarea
                    class="chat-ta"
                    id="admin-msg-input"
                    rows="1"
                    placeholder="Escribe un mensaje… (máx. 2000 caracteres)"
                    maxlength="2000"
                ></textarea>
                <button class="btn-send" id="btn-admin-send" title="Enviar">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
    @vite('resources/js/support/pages/admin.page.js')
@endpush