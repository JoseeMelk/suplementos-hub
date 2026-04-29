import { openModal, closeModal } from '../../../ui/modals';
import { storeProduct, getCategories } from '../services/product-service';
import { renderCategorySelect } from '../components/category-select';
import { createProduct } from '../handlers/product-actions.handler';
import { setupImagePreview } from '../utils/image-preview';

async function init() {
    const btnOpen = document.getElementById('btnOpenCreateProductModal');
    const btnClose = document.getElementById('btnCloseCreateProductModal');
    const btnSave = document.getElementById('saveProductBtn');

    // Initialize image preview
    const createPreview = setupImagePreview({
        inputId: 'createImage',
        previewId: 'createNewImagePreview',
        wrapperId: 'createImagePreviewWrapper'
    });

    // 🛑 guard clause
    if (!btnOpen || !btnSave) return;

    const categories = await getCategories();

    btnOpen.addEventListener('click', () => {
        renderCategorySelect(categories.data, 'categoryProductCreate');
        openModal('createProductModal');
    });

    btnClose?.addEventListener('click', () => {
        closeModal('createProductModal');
        createPreview.reset();
    });

    btnSave.addEventListener('click', async (e) => {
        e.preventDefault();
        await createProduct();
    });
}

init();