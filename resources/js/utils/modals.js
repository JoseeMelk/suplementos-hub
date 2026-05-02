// components/modals.js

let activeModal = null;
let backdrop    = null;

const ANIMATION_DURATION = 300; // ms

/*
========================
ABRIR MODAL
========================
*/
export function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    activeModal = modal;

    // Quitar aria-hidden ANTES de mostrar
    modal.removeAttribute('aria-hidden');
    modal.removeAttribute('inert');
    
    modal.style.display = 'block';
    modal.style.opacity = '0';
    modal.style.transform = 'translateY(-12px)';
    modal.style.transition = `opacity ${ANIMATION_DURATION}ms ease, transform ${ANIMATION_DURATION}ms ease`;

    document.body.classList.add('modal-open');
    createBackdrop();

    // Forzar reflow para que la transición arranque
    modal.offsetHeight;

    requestAnimationFrame(() => {
        modal.classList.add('show');
        modal.style.opacity = '1';
        modal.style.transform = 'translateY(0)';

        // Foco después de la animación — ya no hay aria-hidden
        setTimeout(() => focusModal(modal), ANIMATION_DURATION);
    });
}

/*
========================
CERRAR MODAL
========================
*/
export function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    modal.style.opacity = '0';
    modal.style.transform = 'translateY(-12px)';

    setTimeout(() => {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        modal.style.display = 'none';
        modal.style.opacity = '';
        modal.style.transform = '';
        modal.style.transition = '';

        document.body.classList.remove('modal-open');
        removeBackdrop();
        resetModal(modal);

        activeModal = null;
    }, ANIMATION_DURATION);
}

/*
========================
LIMPIAR MODAL (PUBLIC)
========================
*/
export function clearModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;

    const form = modal.querySelector('form');
    if (form) form.reset();

    modal.querySelectorAll('input, textarea, select').forEach(el => {
        switch (el.type) {
            case 'checkbox':
            case 'radio': el.checked = false; break;
            case 'file':  el.value   = '';    break;
            default:      el.value   = '';
        }
    });

    modal.querySelectorAll('img[id*="Preview"]').forEach(img => { img.src = ''; });
    modal.querySelectorAll('[id*="PreviewWrapper"]').forEach(el => { el.classList.add('d-none'); });
    modal.querySelectorAll('.is-invalid, .is-valid').forEach(el => { el.classList.remove('is-invalid', 'is-valid'); });
    modal.querySelectorAll('.invalid-feedback').forEach(el => { el.remove(); });
}

/*
========================
INICIALIZAR EVENTOS GLOBALES
========================
*/
export function initModals() {
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && activeModal) closeModal(activeModal.id);
    });

    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            const isStatic = modal.dataset.backdrop === 'static';

             if (e.target === modal && !isStatic) {
                 closeModal(modal.id);
             }
        });
    });
}

/*
========================
BACKDROP
========================
*/
function createBackdrop() {
    if (backdrop) return;
    backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    document.body.appendChild(backdrop);
}

function removeBackdrop() {
    if (!backdrop) return;
    backdrop.remove();
    backdrop = null;
}

/*
========================
FOCUS — después de que aria-hidden ya no existe
========================
*/
function focusModal(modal) {
    const focusable = modal.querySelector(
        'input:not([type="hidden"]):not([disabled]), select:not([disabled]), textarea:not([disabled]), button:not([disabled])'
    );
    if (focusable) focusable.focus();
}

/*
========================
RESET FORM + PREVIEW
========================
*/
function resetModal(modal) {
    const form = modal.querySelector('form');
    if (form) form.reset();

    modal.querySelectorAll('img[id*="Preview"]').forEach(img => { img.src = ''; });
    modal.querySelectorAll('[id*="PreviewWrapper"]').forEach(el => { el.classList.add('d-none'); });
}