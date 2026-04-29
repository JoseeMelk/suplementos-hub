export function fillEditForm(product, categories) {
    document.getElementById('editProductId').value = product.id;
    document.getElementById('editName').value = product.name;
    document.getElementById('editPrice').value = product.price;
    document.getElementById('editDescription').value = product.description ?? '';
    const categorySelect = document.getElementById('editCategory');
    categorySelect.innerHTML = '';
    categories.forEach(category => {
        const option = document.createElement('option');
        option.value = category.id;
        option.textContent = category.name;
        if (category.id === product.category_id) {
            option.selected = true;
        }
        categorySelect.appendChild(option);
    });
    document.getElementById('editVisible').checked = product.is_visible == 1;
    document.getElementById('editImagePreview').src = product.image_url;
}