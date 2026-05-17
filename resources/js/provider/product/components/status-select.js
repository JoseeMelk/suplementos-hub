export function renderStatusSelect(status, selectElementId, selectedId = null, overwrite = true) {
    const select = document.getElementById(selectElementId);

    if (overwrite) {
        select.innerHTML = `<option value="">Seleccionar estado</option>`;
    }

    /**
     * Se espera una estructura
     * status = { 1: 'Visible', 0: 'Oculto' }
     */
    
    Object.keys(status).forEach(key => {
        if (!select.querySelector(`option[value="${key}"]`)) {
            const option = document.createElement('option');
            option.value = key;
            option.textContent = status[key];
            select.appendChild(option);
        }
    });

    if (selectedId !== null) {
        select.value = selectedId;
    }
}