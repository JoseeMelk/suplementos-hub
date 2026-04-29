import { getCategories, getProductById, updateProduct, deleteProduct } from "../services/product-service";
import { fillEditForm } from "./product-form.handler";
import { openModal, closeModal } from "../../../ui/modals";
import { alert } from "../../../lib/alert";
import { handleResponse } from "../../../utils/http-handler";
import { renderProductList } from "./render-product-list";
import { getFormData } from '../utils/product-helpers';

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

export async function editProduct(productId) {
    const formData = getFormData('editProductForm');

    console.log('ID:', productId);
    console.log('FormData:', Object.fromEntries(formData));
    const confirm = await alert.confirm(
        '¿Estás seguro de que deseas actualizar este producto?',
        'Los cambios se guardarán y podrán ser visualizados en la plataforma.',
        'Sí, actualizar'
    );

    if (!confirm.isConfirmed) return;

    try {
        const response = await updateProduct(productId, formData);
        console.log('UPDATE: ', response);
        

        const ok = await handleResponse(response, {
            successMessage: 'Producto actualizado exitosamente',
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

export async function handleDelete(productId) {
    const confirm = await alert.confirm(
        '¿Eliminar producto?',
        'Esta acción no se puede deshacer',
        'Sí, eliminar'
    );

    if (!confirm.isConfirmed) return;

    const response = await deleteProduct(productId);

    const ok = await handleResponse(response, {
        successMessage: 'Producto eliminado',
        successDescription: 'El producto fue eliminado correctamente',
        errorMessage: 'Error al eliminar'
    });

    if (ok) {
        await renderProductList();
    }
}