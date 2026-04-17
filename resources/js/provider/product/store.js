import { initModals, openModal, closeModal } from '../../ui/modals'
import { handleResponse } from '../../utils/http-handler'
import { storeProduct, getCategories } from './product-service';
import { alert } from '../../lib/alert';

//Obtener datos del formulario de creación de producto
function getFormData(id) {
    const form = document.getElementById(id);
    return new FormData(form);
}

//Renderiza categorias
function renderCategories(categories, selectElementId) {
    const select = document.getElementById(selectElementId);

    // limpiar excepto el primer option
    select.innerHTML = `<option value="">Seleccionar categoría</option>`;

    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat.id;     // o cat.value si usas Resource
        option.textContent = cat.name; // o cat.label

        select.appendChild(option);
    });
}

//Función para crear un producto
async function createProduct(formData) {

    const response = await storeProduct(formData);

    const ok = await handleResponse(response, {
        successMessage: 'Producto creado exitosamente',
        successDescription: 'El producto ha sido creado y está disponible en la plataforma.',
        errorMessage: 'Error al crear el producto'
    });
    

    return ok;
}

document.addEventListener('DOMContentLoaded', async () => {
    const categories = await getCategories();
    
    initModals();
    const btnSave = document.getElementById('saveProductBtn');

    // Abrir modal crear producto
    document.getElementById('btnOpenCreateProductModal').addEventListener('click', () => {
        renderCategories(categories.data, 'categoryProductCreate');
        openModal('createProductModal');
    });

    // Cerrar modal crear producto
    document.getElementById('btnCloseCreateProductModal').addEventListener('click', () => {
        closeModal('createProductModal');
    });


    btnSave.addEventListener('click', async (e) => {
        e.preventDefault();

        const confirm = await alert.confirm(
            '¿Estás seguro de que deseas crear este producto?',
            'El producto será creado y podrá ser visualizado en la plataforma.',
            'Sí, crear'
        )

        if (!confirm.isConfirmed) return;

        const formData = getFormData('createProductForm');
        
        try {        
            const ok = await createProduct(formData);
            if (ok) {
                closeModal('createProductModal');
            }
        } catch (error) {
            alert.error('Error', 'Ocurrió un error al crear el producto, por favor intenta de nuevo.');
        }

    });

});