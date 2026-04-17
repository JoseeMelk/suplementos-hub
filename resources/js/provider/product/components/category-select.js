export function renderCategorySelect(categories, selectElementId) {
    const select = document.getElementById(selectElementId);

    select.innerHTML = `<option value="">Seleccionar categoría</option>`;

    categories.forEach(cat => {
        const option = document.createElement('option');
        option.value = cat.id;
        option.textContent = cat.name;

        select.appendChild(option);
    });
}