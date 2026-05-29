/**
 * Inicializa los spinners de cantidad en los formularios
 * @param {string} formSelector - Selector del formulario que contiene los spinners
 */
export function initQuantitySpinners(formSelector) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    const spinners = form.querySelectorAll('[data-quantity-spinner]');

    spinners.forEach((spinner) => {
        const input = spinner.querySelector('input[type="number"]');
        const btnMinus = spinner.querySelector('[data-quantity-minus]');
        const btnPlus = spinner.querySelector('[data-quantity-plus]');

        if (!input || !btnMinus || !btnPlus) return;

        // Remover event listeners previos si existen
        const newBtnMinus = btnMinus.cloneNode(true);
        const newBtnPlus = btnPlus.cloneNode(true);
        btnMinus.parentNode.replaceChild(newBtnMinus, btnMinus);
        btnPlus.parentNode.replaceChild(newBtnPlus, btnPlus);

        // Agregar nuevos event listeners
        newBtnMinus.addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseInt(input.value) || 1;
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        });

        newBtnPlus.addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseInt(input.value) || 0;
            input.value = currentValue + 1;
        });
    });
}
