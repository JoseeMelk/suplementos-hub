import { openModal, closeModal } from '../../../ui/modals';
import { handleResponse } from '../../../utils/http-handler';
import { storeProduct, getCategories } from '../services/product-service';
import { alert } from '../../../lib/alert';
import { getFormData } from '../utils/product-helpers';
import { renderCategorySelect } from '../components/category-select';
import { renderProductList } from '../handlers/render-product-list';

async function init() {
    const btnOpen = document.getElementById('btnOpenCreateProductModal');
    const btnClose = document.getElementById('btnCloseCreateProductModal');
    const btnSave = document.getElementById('saveProductBtn');

    // 🛑 guard clause
    if (!btnOpen || !btnSave) return;

    const categories = await getCategories();

    btnOpen.addEventListener('click', () => {
        renderCategorySelect(categories.data, 'categoryProductCreate');
        openModal('createProductModal');
    });

    btnClose?.addEventListener('click', () => {
        closeModal('createProductModal');
    });

    btnSave.addEventListener('click', async (e) => {
        e.preventDefault();

        const confirm = await alert.confirm(
            '¿Estás seguro de que deseas crear este producto?',
            'El producto será creado y podrá ser visualizado en la plataforma.',
            'Sí, crear'
        );

        if (!confirm.isConfirmed) return;

        const formData = getFormData('createProductForm');

        try {
            const response = await storeProduct(formData);

            const ok = await handleResponse(response, {
                successMessage: 'Producto creado exitosamente',
                successDescription: 'El producto ha sido creado y está disponible en la plataforma.',
                errorMessage: 'Error al crear el producto'
            });

            if (ok) {
                closeModal('createProductModal');
                await renderProductList(); // Actualizar la lista de productos
            }

        } catch (error) {
            alert.error('Error', 'Ocurrió un error al crear el producto.');
        }
    });
}

init();