import { getCategories, getProductById, storeProduct, updateProduct, destroyProduct } from "../services/product-service";
import { fillEditForm } from "./product-form.handler";
import { renderProductList } from "./render-product.handler";
import { getFormData } from '../utils/product-helpers';
import { renderCategorySelect } from '../components/category-select';
import { openModal, closeModal } from "../../../utils/modals";
import { alert } from "../../../lib/alert";
import { handleResponse } from "../../../utils/http-handler";

export async function openCreateModal() {
    const categories = await getCategories();
    renderCategorySelect(categories.data, 'categoryProductCreate');
    openModal('createProductModal');
}

export async function createProductHandler() {
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
            successMessage: 'Producto creado',
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
}

export async function openEditModal(productId) {
    const categories = await getCategories();
    const product = await getProductById(productId);

    if (!product.ok || !categories.ok) {
        alert.error('Error al cargar el producto', 'No se pudieron cargar los datos del producto, intente nuevamente');
        return;
    }

    fillEditForm(product.data, categories.data);
    openModal('editProductModal');
}

export async function editProductHandler(productId) {
    const formData = getFormData('editProductForm');

    for (const key of formData.keys()) {
        const value = formData.get(key);
        // Elimina campos vacíos (null, '', undefined)
        if (value === '' || value === null || value === undefined) {
            formData.delete(key);
        }
    }

    const imageInput = document.getElementById('editImage');
    if (!imageInput.files || imageInput.files.length === 0) {
        formData.delete('image'); // no enviar clave 'image' si no hay archivo
    }


    const confirm = await alert.confirm(
        '¿Estás seguro de que deseas actualizar este producto?',
        'Los cambios se guardarán y podrán ser visualizados en la plataforma.',
        'Sí, actualizar'
    );

    if (!confirm.isConfirmed) return;

    try {
        const response = await updateProduct(productId, formData);

        const ok = await handleResponse(response, {
            successMessage: 'Producto actualizado',
            successDescription: 'El producto ha sido actualizado y está disponible en la plataforma.',
            errorMessage: 'Error al actualizar el producto'
        });

        if (ok) {
            closeModal('editProductModal');
            await renderProductList(); // Actualizar la lista de productos
        }

    } catch (error) {
        alert.error('Error', 'Ocurrió un error al actualizar el producto.');
    }
}

export async function deleteProductHandler(productId) {
    const confirm = await alert.confirm(
        '¿Eliminar producto?',
        'Esta acción no se puede deshacer',
        'Sí, eliminar'
    );

    if (!confirm.isConfirmed) return;

    const response = await destroyProduct(productId);

    const ok = await handleResponse(response, {
        successMessage: 'Producto eliminado',
        successDescription: 'El producto fue eliminado correctamente',
        errorMessage: 'Error al eliminar'
    });

    if (ok) {
        await renderProductList();
    }
}