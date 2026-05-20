import { generateSlug, regenerateSlugHandler, copyLink } from '../handlers/slug-actions.handler';

export async function initSlugPage() {
    // Segmented control mobile
    const segmentBtns = document.querySelectorAll('.segment-btn');
    const tabPanes = document.querySelectorAll('#profileTabsContent .tab-pane');

    function activateTab(targetId) {
        // Paneles
        tabPanes.forEach(pane => {
            pane.classList.remove('show', 'active');
        });
        const targetPane = document.getElementById(targetId);
        if (targetPane) {
            targetPane.classList.add('show', 'active');
        }

        // Botones desktop (sincronizar)
        document.querySelectorAll('#profileTabs .nav-link').forEach(link => {
            const target = link.getAttribute('data-bs-target')?.replace('#', '');
            link.classList.toggle('active', target === targetId);
            link.setAttribute('aria-selected', target === targetId ? 'true' : 'false');
        });
    }

    // Botones del segmented control mobile
    segmentBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            segmentBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            activateTab(btn.dataset.target);
        });
    });

    // Cuando el usuario usa los tabs desktop → sincronizar mobile
    document.querySelectorAll('#profileTabs .nav-link').forEach(link => {
        link.addEventListener('shown.bs.tab', e => {
            const targetId = e.target.getAttribute('data-bs-target')?.replace('#', '');
            segmentBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.target === targetId);
            });
        });
    });

    // ===== GENERAR SLUG =====
    const btnGenerateSlug = document.getElementById('btnGenerateSlug');
    if (btnGenerateSlug) {
        btnGenerateSlug.addEventListener('click', generateSlug);
    }

    // ===== COPIAR ENLACE =====
    const btnCopy = document.getElementById('btnCopyLink');
    if (btnCopy) {
        btnCopy.addEventListener('click', copyLink);
    }

    // ===== REGENERAR SLUG =====
    const btnRegenerate = document.getElementById('btnRegenerateSlug');
    if (btnRegenerate) {
        btnRegenerate.addEventListener('click', regenerateSlugHandler);
    }
}