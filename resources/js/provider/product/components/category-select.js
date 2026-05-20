// export function renderCategorySelect(categories, selectElementId) {
//     const select = document.getElementById(selectElementId);

//     select.innerHTML = `<option value="">Seleccionar categoría</option>`;

//     categories.forEach(cat => {
//         const option = document.createElement('option');
//         option.value = cat.id;
//         option.textContent = cat.name;

//         select.appendChild(option);
//     });
// }

// category-select.js
export function renderCategorySelect(categories, selectElementId, selectedId = null, overwrite = true) {
    const select = document.getElementById(selectElementId);

    if (overwrite) {
        select.innerHTML = `<option value="">Seleccionar categoría</option>`;
    }

    categories.forEach(cat => {
        // Evitar duplicados
        if (!select.querySelector(`option[value="${cat.id}"]`)) {
            const option = document.createElement('option');
            option.value = cat.id;
            option.textContent = cat.name;
            select.appendChild(option);
        }
    });

    if (selectedId !== null) {
        select.value = selectedId;
    }
}