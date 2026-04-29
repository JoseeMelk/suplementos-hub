import { openModal, closeModal } from '../../../ui/modals';
import { setupImagePreview } from '../utils/image-preview';

//import { fillEditForm } from '../handlers/product-form.handler';
//import { getProductById } from '../services/product-service';

import { openEditModal, editProduct } from '../handlers/product-actions.handler';

async function init() {
    //Botones de acciones del modal
    const container = document.getElementById('productList'); //Se usa para abrir modal editar usando event delegation
    const btnCloseModal = document.getElementById('btnCloseEditProductModal');
    const btnSaveEditProduct = document.getElementById('updateProductBtn');

    // Inicializar preview de imagen
    const editPreview = setupImagePreview({
        inputId: 'editImage',
        previewId: 'editNewImagePreview',
        wrapperId: 'editImagePreviewWrapper'
    });


    btnCloseModal.addEventListener('click', async () => {
        await closeModal('editProductModal');
        editPreview.reset(); // Limpiar preview al cerrar
    });

    //event delegation
    container.addEventListener('click', async (e) => {
        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            const id = editBtn.dataset.id;
            await openEditModal(id);
        }

        const deleteBtn = e.target.closest('.btn-delete');
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            console.log(id);       
            //return handleDelete(deleteBtn.dataset.id);     
        }
    });

    btnSaveEditProduct.addEventListener('click', async (e) => {
        e.preventDefault();
        const id = document.getElementById('editProductId').value;
        await editProduct(id);
    });
}

init();