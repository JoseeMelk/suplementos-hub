import { alert } from "../../../lib/alert";
import { storeSlug, regenerateSlug } from "../services/slug-service";
import { handleResponse } from "../../../utils/http-handler";

function updateSlugUI(slug) {
    const catalogUrl = `${window.location.origin}/catalogo/${slug}`;
    
    // Ocultar estado vacío
    const emptyState = document.querySelector('.slug-empty-state');
    if (emptyState) {
        emptyState.style.display = 'none';
    }

    // Mostrar/crear tarjeta activa si no existe
    let activeCard = document.querySelector('.slug-active-card');
    if (!activeCard) {
        const catalogTab = document.getElementById('catalogo');
        if (catalogTab) {
            activeCard = createSlugActiveCard(slug, catalogUrl);
            catalogTab.appendChild(activeCard);
        }
    } else {
        // Actualizar URL en la tarjeta existente
        const urlText = activeCard.querySelector('.slug-url-text span');
        if (urlText) {
            urlText.textContent = catalogUrl;
        }
        
        // Actualizar link de ver catálogo
        const viewCatalogLink = activeCard.querySelector('a[target="_blank"]');
        if (viewCatalogLink) {
            viewCatalogLink.href = catalogUrl;
        }
        
        // Actualizar botón de copiar
        const copyBtn = activeCard.querySelector('.slug-copy-btn');
        if (copyBtn) {
            copyBtn.dataset.catalogUrl = catalogUrl;
        }
        
        activeCard.style.display = 'block';
    }
}

function createSlugActiveCard(slug, catalogUrl) {
    const card = document.createElement('div');
    card.className = 'slug-active-card';
    card.innerHTML = `
        <div class="slug-active-header">
            <div class="slug-check-icon">
                <i class="bi-check2"></i>
            </div>
            <div>
                <p class="slug-active-title">Catálogo activo</p>
                <p class="slug-active-sub">Visible públicamente para tus clientes</p>
            </div>
        </div>

        <div class="slug-url-row">
            <div class="slug-url-text">
                <i class="bi-globe2 me-2 opacity-50" style="font-size: 12px;"></i>
                <span>${catalogUrl}</span>
            </div>
            <button class="slug-copy-btn" id="btnCopyLink" data-catalog-url="${catalogUrl}" title="Copiar enlace">
                <i class="bi-clipboard" id="copyIcon"></i>
            </button>
        </div>

        <div class="slug-actions">
            <a href="${catalogUrl}" target="_blank"
                class="btn btn-sm btn-outline-secondary">
                <i class="bi-box-arrow-up-right me-1"></i>Ver catálogo
            </a>
            <button class="btn btn-sm btn-outline-warning" id="btnRegenerateSlug">
                <i class="bi-arrow-clockwise me-1"></i>Regenerar
            </button>
        </div>
    `;
    return card;
}

function reattachEventListeners() {
    // Re-registrar evento para el botón de copiar
    const btnCopy = document.getElementById('btnCopyLink');
    if (btnCopy) {
        btnCopy.removeEventListener('click', copyLink);
        btnCopy.addEventListener('click', copyLink);
    }
    
    // Re-registrar evento para el botón de regenerar
    const btnRegenerate = document.getElementById('btnRegenerateSlug');
    if (btnRegenerate) {
        btnRegenerate.removeEventListener('click', regenerateSlugHandler);
        btnRegenerate.addEventListener('click', regenerateSlugHandler);
        btnRegenerate.disabled = false;
        btnRegenerate.innerHTML = '<i class="bi-arrow-clockwise me-1"></i>Regenerar';
    }
}

export async function generateSlug() {
    const btnGenerateSlug = document.getElementById('btnGenerateSlug');
    
    btnGenerateSlug.disabled = true;
    btnGenerateSlug.innerHTML = '<i class="bi-hourglass-split me-2"></i>Generando...';
    
    try {
        const response = await storeSlug();
        
        const ok = await handleResponse(response, {
            successMessage: 'Catálogo generado',
            successDescription: 'Tu catálogo público ha sido generado exitosamente.',
            errorMessage: 'Error al generar el catálogo'
        });

        if (ok && response.data?.slug) {
            updateSlugUI(response.data.slug);
            reattachEventListeners();
        } else {
            btnGenerateSlug.disabled = false;
            btnGenerateSlug.innerHTML = '<i class="bi-sparkles me-2"></i>Generar mi catálogo';
        }

    } catch (error) {
        console.error(error);
        alert.error('Error', 'Ocurrió un error al generar el catálogo');
        btnGenerateSlug.disabled = false;
        btnGenerateSlug.innerHTML = '<i class="bi-sparkles me-2"></i>Generar mi catálogo';
    }
}

export async function regenerateSlugHandler() {
    const btnRegenerate = document.getElementById('btnRegenerateSlug');
    
    const confirm = await alert.confirm(
        '¿Regenerar el enlace?',
        'El enlace anterior dejará de funcionar. Se generará un nuevo enlace para tu catálogo.',
        'Sí, regenerar'
    );

    if (!confirm.isConfirmed) return;

    btnRegenerate.disabled = true;
    btnRegenerate.innerHTML = '<i class="bi-hourglass-split me-1"></i>Regenerando...';
    
    try {
        const response = await regenerateSlug();
        
        const ok = await handleResponse(response, {
            successMessage: 'Enlace regenerado',
            successDescription: 'Tu enlace público ha sido regenerado exitosamente.',
            errorMessage: 'Error al regenerar el enlace'
        });

        if (ok && response.data?.slug) {
            updateSlugUI(response.data.slug);
            reattachEventListeners();
        } else {
            btnRegenerate.disabled = false;
            btnRegenerate.innerHTML = '<i class="bi-arrow-clockwise me-1"></i>Regenerar';
        }

    } catch (error) {
        console.error(error);
        alert.error('Error', 'Ocurrió un error al regenerar el catálogo');
        btnRegenerate.disabled = false;
        btnRegenerate.innerHTML = '<i class="bi-arrow-clockwise me-1"></i>Regenerar';
    }
}

export async function copyLink() {
    const btnCopy = document.getElementById('btnCopyLink');
    
    if (!btnCopy) return;

    const url = btnCopy.dataset.catalogUrl;
    
    try {
        await navigator.clipboard.writeText(url);
        const icon = document.getElementById('copyIcon');
        icon.className = 'bi-check2';
        btnCopy.style.background = '#085041';
        
        setTimeout(() => {
            icon.className = 'bi-clipboard';
            btnCopy.style.background = '';
        }, 2000);
    } catch {
        alert.error('Error', 'No se pudo copiar el enlace');
    }
}