import { alert } from "../../../lib/alert";
import { storeSlug, regenerateSlug } from "../services/slug-service";
import { handleResponse } from "../../../utils/http-handler";

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

        if (ok) {
            location.reload();
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

        if (ok) {
            location.reload();
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