// filepath: /home/josee/Documentos/Vorenya/suplementos-hub/resources/js/admin/user/index.js
import {
    fetchUsers,
    //approveUser,
    //rejectUser,
    //toggleCatalogUser,
    //disableProviderUser,
    //deleteUser,
} from './userService';

const TABLE_CONFIG = {
    pending: {
        titleMatch: 'proveedores pendientes',
        emptyText: 'No hay proveedores pendientes.',
    },
    approved: {
        titleMatch: 'proveedores aprobados',
        emptyText: 'No hay proveedores aprobados.',
    },
    rejected: {
        titleMatch: 'proveedores rechazados',
        emptyText: 'No hay proveedores rechazados.',
    },
};

const state = {
    pending: { status: 'pending', search: '', page: 1, per_page: 5, total: 0 },
    approved: { status: 'approved', search: '', page: 1, per_page: 5, total: 0 },
    rejected: { status: 'rejected', search: '', page: 1, per_page: 5, total: 0 },
};

let sectionsRef = null;

// Inicializa tablas, buscadores y eventos al cargar el DOM.
document.addEventListener('DOMContentLoaded', () => {
    const sections = resolveSections();
    sectionsRef = sections;

    if (!sections.pending || !sections.approved || !sections.rejected) return;

    bindSearch(sections.pending, 'pending');
    bindSearch(sections.approved, 'approved');
    bindSearch(sections.rejected, 'rejected');
    bindActions(sections);

    loadSection('pending', sections.pending);
    loadSection('approved', sections.approved);
    loadSection('rejected', sections.rejected);
});

// Ubica cada tarjeta de tabla por su título.
function resolveSections() {
    const cards = [...document.querySelectorAll('.card')];
    const sections = {};

    for (const [status, cfg] of Object.entries(TABLE_CONFIG)) {
        const card = cards.find((c) => {
            const title = c.querySelector('.card-header strong')?.textContent?.trim().toLowerCase();
            return title?.includes(cfg.titleMatch);
        });

        if (!card) continue;

        sections[status] = {
            card,
            tbody: card.querySelector('tbody'),
            searchInput: card.querySelector('.card-header input[type="text"]'),
            footerInfo: card.querySelector('.card-footer small'),
            footerPagination: card.querySelector('.card-footer .d-flex.gap-1'),
        };
    }

    return sections;
}

// Enlaza input de búsqueda con debounce para evitar demasiadas peticiones.
function bindSearch(section, status) {
    if (!section.searchInput) return;

    const handler = debounce((value) => {
        state[status].search = value.trim();
        state[status].page = 1;
        loadSection(status, section);
    }, 350);

    section.searchInput.addEventListener('input', (e) => handler(e.target.value));
}

// Delegación de eventos para botones de acciones dentro de cada tabla.
function bindActions(sections) {
    for (const status of Object.keys(sections)) {
        const section = sections[status];
        section.tbody?.addEventListener('click', async (e) => {
            const btn = e.target.closest('[data-action][data-id]');
            if (!btn) return;

            const action = btn.dataset.action;
            const id = Number(btn.dataset.id);
            if (!action || !id) return;

            btn.disabled = true;
            try {
                await handleAction(action, id);
                await reloadAllSections();
            } catch (err) {
                console.error(`[action:${action}]`, err);
                alert(err?.message || 'No se pudo completar la acción.');
            } finally {
                btn.disabled = false;
            }
        });
    }
}

// Ejecuta la acción contra API según el botón presionado.
async function handleAction(action, userId) {
    switch (action) {
        case 'approve':
            return approveUser(userId);
        case 'reject':
            return rejectUser(userId);
        case 'catalog-on':
            return toggleCatalogUser(userId, true);
        case 'catalog-off':
            return toggleCatalogUser(userId, false);
        case 'disable-provider':
            return disableProviderUser(userId);
        case 'delete':
            return deleteUser(userId);
        default:
            throw new Error('Acción no soportada.');
    }
}

// Recarga las 3 tablas después de una acción.
async function reloadAllSections() {
    if (!sectionsRef) return;
    await Promise.all([
        loadSection('pending', sectionsRef.pending),
        loadSection('approved', sectionsRef.approved),
        loadSection('rejected', sectionsRef.rejected),
    ]);
}

// Carga datos remotos de una sección y pinta filas + footer.
async function loadSection(status, section) {
    renderLoading(section, status);

    try {
        const params = {
            status: state[status].status,
            search: state[status].search,
            page: state[status].page,
            per_page: state[status].per_page,
        };

        const res = await fetchUsers(params);
        if (!res?.ok) throw new Error(res?.message || 'No se pudo cargar la información.');

        // Soporta ambas estructuras: {data:[...],meta:{}} y {data:{data:[...],meta:{}}}
        const rows = Array.isArray(res?.data?.data)
            ? res.data.data
            : Array.isArray(res?.data)
            ? res.data
            : [];

        const meta = res?.data?.meta || res?.meta || {};
        state[status].total = Number(meta.total || 0);

        renderRows(section, status, rows);
        renderFooter(section, status, meta);
        refreshStats();
    } catch (error) {
        renderError(section, status, 'Error cargando proveedores.');
        console.error(`[${status}]`, error);
    }
}

// Renderiza filas de la tabla o estado vacío.
function renderRows(section, status, rows) {
    if (!section.tbody) return;

    if (!rows.length) {
        section.tbody.innerHTML = `
            <tr>
                <td colspan="${status === 'approved' ? 5 : 4}" class="text-center text-muted py-4">
                    ${TABLE_CONFIG[status].emptyText}
                </td>
            </tr>
        `;
        return;
    }

    section.tbody.innerHTML = rows.map((u) => buildRow(status, u)).join('');
}

// Construye el HTML de cada fila según estado.
function buildRow(status, user) {
    const name = escapeHtml(user.name || '');
    const email = escapeHtml(user.email || '');
    const id = Number(user.id);

    if (status === 'pending') {
        return `
            <tr data-user-id="${id}">
                <td>${name}</td>
                <td class="text-muted small">${email}</td>
                <td><span class="badge bg-warning text-dark">pending</span></td>
                <td class="text-end">
                    <div class="d-flex flex-column flex-md-row gap-1 justify-content-end">
                        <button class="btn btn-sm btn-success" data-action="approve" data-id="${id}">Aprobar</button>
                        <button class="btn btn-sm btn-outline-danger" data-action="reject" data-id="${id}">Rechazar</button>
                    </div>
                </td>
            </tr>
        `;
    }

    if (status === 'approved') {
        const catalogActive = Boolean(user.catalog_active);
        return `
            <tr data-user-id="${id}">
                <td>${name}</td>
                <td class="text-muted small">${email}</td>
                <td>
                    <span class="badge ${catalogActive ? 'bg-success' : 'bg-secondary'}">
                        ${catalogActive ? 'activo' : 'inactivo'}
                    </span>
                </td>
                <td><span class="badge bg-primary">approved</span></td>
                <td class="text-end position-static">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-boundary="viewport">
                            Acciones
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li>
                                <button class="dropdown-item d-flex align-items-center gap-2 ${catalogActive ? 'text-warning' : 'text-success'}"
                                    data-action="${catalogActive ? 'catalog-off' : 'catalog-on'}" data-id="${id}">
                                    <i class="bi ${catalogActive ? 'bi-slash-circle' : 'bi-check-circle'}"></i>
                                    ${catalogActive ? 'Desactivar catálogo' : 'Activar catálogo'}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center gap-2 text-danger" data-action="disable-provider" data-id="${id}">
                                    <i class="bi bi-person-x"></i>
                                    Desactivar proveedor
                                </button>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        `;
    }

    return `
        <tr data-user-id="${id}">
            <td>${name}</td>
            <td class="text-muted small">${email}</td>
            <td><span class="badge bg-danger">rejected</span></td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${id}">
                    Eliminar
                </button>
            </td>
        </tr>
    `;
}

// Renderiza información de paginación y botones por página.
function renderFooter(section, status, meta) {
    const currentPage = Number(meta.current_page || 1);
    const lastPage = Math.max(1, Number(meta.last_page || 1));
    const total = Number(meta.total || 0);
    const perPage = Number(meta.per_page || state[status].per_page);

    const start = total === 0 ? 0 : (currentPage - 1) * perPage + 1;
    const end = Math.min(currentPage * perPage, total);

    if (section.footerInfo) {
        section.footerInfo.textContent = `Mostrando ${start}–${end} de ${total}`;
    }

    if (!section.footerPagination) return;

    section.footerPagination.innerHTML = '';
    for (let page = 1; page <= lastPage; page++) {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = `btn btn-sm ${page === currentPage ? 'btn-success' : 'btn-outline-secondary'}`;
        btn.textContent = String(page);

        btn.addEventListener('click', () => {
            if (state[status].page === page) return;
            state[status].page = page;
            loadSection(status, section);
        });

        section.footerPagination.appendChild(btn);
    }
}

// Estado visual: cargando.
function renderLoading(section, status) {
    if (!section.tbody) return;
    section.tbody.innerHTML = `
        <tr>
            <td colspan="${status === 'approved' ? 5 : 4}" class="text-center text-muted py-4">
                Cargando...
            </td>
        </tr>
    `;
}

// Estado visual: error.
function renderError(section, status, message) {
    if (!section.tbody) return;
    section.tbody.innerHTML = `
        <tr>
            <td colspan="${status === 'approved' ? 5 : 4}" class="text-center text-danger py-4">
                ${escapeHtml(message)}
            </td>
        </tr>
    `;
}

// Actualiza tarjetas de estadísticas y aplica color por tipo.
function refreshStats() {
    const total = state.pending.total + state.approved.total + state.rejected.total;

    const mapping = {
        'total proveedores': total,
        pendientes: state.pending.total,
        aprobados: state.approved.total,
        rechazados: state.rejected.total,
    };

    const classMap = {
        'total proveedores': 'text-success',
        pendientes: 'text-warning',
        aprobados: 'text-primary', // azul
        rechazados: 'text-danger', // rojo
    };

    const statCards = [...document.querySelectorAll('.row.g-3 .card')];
    statCards.forEach((card) => {
        const label = card.querySelector('small')?.textContent?.trim().toLowerCase();
        const valueEl = card.querySelector('h5');
        if (!label || !valueEl) return;

        if (Object.prototype.hasOwnProperty.call(mapping, label)) {
            valueEl.textContent = String(mapping[label]);
            valueEl.classList.remove('text-success', 'text-warning', 'text-primary', 'text-danger');
            if (classMap[label]) valueEl.classList.add(classMap[label]);
        }
    });
}

// Escapa texto para evitar inyección en HTML.
function escapeHtml(str) {
    return String(str)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

// Debounce genérico para inputs.
function debounce(fn, delay = 300) {
    let t;
    return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), delay);
    };
}