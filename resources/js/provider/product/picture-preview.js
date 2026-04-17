document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('createProductForm');
    //const btnSave = document.getElementById('saveProductBtn');

    const imageInput = document.getElementById('imageInput');
    const preview = document.getElementById('imagePreview');
    const wrapper = document.getElementById('imagePreviewWrapper');

    let currentURL = null;

    // =========================
    // PREVIEW DE IMAGEN
    // =========================
    imageInput.addEventListener('change', () => {

        const file = imageInput.files[0];

        // Limpiar URL anterior (evita fugas de memoria)
        if (currentURL) {
            URL.revokeObjectURL(currentURL);
            currentURL = null;
        }

        // Si no hay archivo
        if (!file) {
            wrapper.classList.add('d-none');
            preview.src = '';
            return;
        }

        // Validar que sea imagen
        if (!file.type.startsWith('image/')) {
            alert('El archivo debe ser una imagen válida');
            imageInput.value = '';
            wrapper.classList.add('d-none');
            return;
        }

        // Crear preview
        currentURL = URL.createObjectURL(file);
        preview.src = currentURL;
        wrapper.classList.remove('d-none');
    });


    // =========================
    // CAPTURA DE DATOS
    // =========================
    // btnSave.addEventListener('click', (e) => {
    //     e.preventDefault();

    //     const name = form.querySelector('input[name="name"]').value;
    //     const price = form.querySelector('input[name="price"]').value;
    //     const description = form.querySelector('textarea[name="description"]').value;
    //     const isVisible = form.querySelector('input[name="is_visible"]').checked;

    //     const imageFile = imageInput.files.length > 0 ? imageInput.files[0] : null;

    //     const productData = {
    //         name: name,
    //         price: parseFloat(price),
    //         description: description,
    //         image: imageFile,
    //         is_visible: isVisible ? 1 : 0
    //     };

    //     console.log('Producto listo:', productData);

    //     if (imageFile) {
    //         console.log('Archivo:', {
    //             name: imageFile.name,
    //             type: imageFile.type,
    //             size: imageFile.size
    //         });
    //     }

    //     // Aquí después conectas fetch o AJAX
    // });


    // =========================
    // LIMPIAR AL CERRAR MODAL
    // =========================
    const modal = document.getElementById('createProductModal');

    modal.addEventListener('hidden.bs.modal', () => {

        form.reset();

        // Limpiar preview
        if (currentURL) {
            URL.revokeObjectURL(currentURL);
            currentURL = null;
        }

        preview.src = '';
        wrapper.classList.add('d-none');
    });

});