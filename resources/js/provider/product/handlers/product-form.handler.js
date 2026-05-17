import { renderCategorySelect } from '../components/category-select';

export function fillEditForm(product, categories) {
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editName').value = product.name;
    document.getElementById('editPrice').value = product.price;
    document.getElementById('editDescription').value = product.description ?? '';
    renderCategorySelect(categories, 'editCategory', product.category_id, false);
    document.getElementById('editVisible').checked = product.is_visible == 1;
    document.getElementById('editImagePreview').src = product.image_url;
}