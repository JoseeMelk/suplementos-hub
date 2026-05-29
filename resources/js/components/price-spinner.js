/**
 * Inicializa los spinners de precio en los formularios
 * @param {string} formSelector - Selector del formulario que contiene los spinners
 */
export function initPriceSpinners(formSelector) {
    const form = document.querySelector(formSelector);
    if (!form) return;

    const spinners = form.querySelectorAll('[data-price-spinner]');

    spinners.forEach((spinner) => {
        const input = spinner.querySelector('input[type="number"]');
        const btnMinus = spinner.querySelector('[data-price-minus]');
        const btnPlus = spinner.querySelector('[data-price-plus]');

        if (!input || !btnMinus || !btnPlus) return;

        // Remover event listeners previos si existen
        const newBtnMinus = btnMinus.cloneNode(true);
        const newBtnPlus = btnPlus.cloneNode(true);
        btnMinus.parentNode.replaceChild(newBtnMinus, btnMinus);
        btnPlus.parentNode.replaceChild(newBtnPlus, btnPlus);

        // Agregar nuevos event listeners
        newBtnMinus.addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseFloat(input.value) || 0;
            const newValue = Math.max(0, currentValue - 0.01);
            input.value = newValue.toFixed(2);
        });

        newBtnPlus.addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseFloat(input.value) || 0;
            const newValue = currentValue + 0.01;
            input.value = newValue.toFixed(2);
        });
    });
}
