import { closeModal } from '../../../utils/modals';
import { setupImagePreview } from '../utils/image-preview';
import { openCreateModal, createProductHandler, openEditModal, editProductHandler, deleteProductHandler } from '../handlers/product-actions.handler';
import { renderProductList } from "../handlers/render-product.handler";
import { renderFilter, getFilters, validateSearchInput, resetFilters } from '../handlers/filter-actions.handler';
import { resetPagination } from '../handlers/pagination-actions.handler';
import { initQuantitySpinners } from '../../../components/quantity-spinner';

export async function initProductPage() {
    await renderProductList(); //Renderizar productos
    await renderFilter(); //Renderizar filtros0

    // ---------- FILTROS ----------
    const btnFilterSubmit = document.getElementById('btnFilterSubmit');
    const btnResetFilters = document.getElementById('resetFilters');

    document.getElementById('searchInput').addEventListener('input', () => {
        validateSearchInput();
    });

    btnFilterSubmit.addEventListener('click', async () => {
        resetPagination(); // Resetear a página 1 cuando se aplican filtros
        await renderProductList();
    });

    btnResetFilters.addEventListener('click', async () => {
        await resetFilters();
        resetPagination(); // Resetear a página 1 cuando se limpian filtros
        await renderProductList();
    });

    // ---------- CREATE MODAL ----------
    const btnOpenCreate = document.getElementById('btnOpenCreateProductModal');
    const btnCloseCreate = document.getElementById('btnCloseCreateProductModal');
    const btnSaveCreate = document.getElementById('saveProductBtn');

    const createPreview = setupImagePreview({
        inputId: 'createImage',
        previewId: 'createNewImagePreview',
        wrapperId: 'createImagePreviewWrapper'
    });

    if (btnOpenCreate && btnSaveCreate) {

        btnOpenCreate.addEventListener('click', async () => {
            await openCreateModal();
            initQuantitySpinners('#createProductForm');
        });

        btnCloseCreate?.addEventListener('click', () => {
            closeModal('createProductModal');
            createPreview.reset();
        });

        btnSaveCreate.addEventListener('click', async (e) => {
            e.preventDefault();
            await createProductHandler();
        });
    }

    // ---------- EDIT MODAL ----------
    const container = document.getElementById('productList');
    const btnCloseEdit = document.getElementById('btnCloseEditProductModal');
    const btnSaveEdit = document.getElementById('updateProductBtn');

    const editPreview = setupImagePreview({
        inputId: 'editImage',
        previewId: 'editNewImagePreview',
        wrapperId: 'editImagePreviewWrapper'
    });

    btnCloseEdit?.addEventListener('click', async () => {
        await closeModal('editProductModal');
        editPreview.reset();
    });

    // ---------- EVENT DELEGATION: EDIT & DELETE ----------
    container?.addEventListener('click', async (e) => {
        const editBtn = e.target.closest('.btn-edit');
        if (editBtn) {
            await openEditModal(editBtn.dataset.id);
            initQuantitySpinners('#editProductForm');
        }

        const deleteBtn = e.target.closest('.btn-delete');
        if (deleteBtn) {
            await deleteProductHandler(deleteBtn.dataset.id);
        }
    });

    btnSaveEdit?.addEventListener('click', async (e) => {
        e.preventDefault();
        const id = document.getElementById('editProductId').value;
        await editProductHandler(id);
    });
}