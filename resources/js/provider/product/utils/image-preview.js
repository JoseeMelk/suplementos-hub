// 📁utils/image-preview.js
export function setupImagePreview({ inputId, previewId, wrapperId }) {
    const imageInput = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const wrapper = document.getElementById(wrapperId);

    if (!imageInput || !preview || !wrapper) return;

    let currentURL = null;

    imageInput.addEventListener('change', () => {
        const file = imageInput.files[0];

        if (currentURL) {
            URL.revokeObjectURL(currentURL);
            currentURL = null;
        }

        if (!file) {
            wrapper.classList.add('d-none');
            preview.src = '';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('El archivo debe ser una imagen válida');
            imageInput.value = '';
            wrapper.classList.add('d-none');
            return;
        }

        currentURL = URL.createObjectURL(file);
        preview.src = currentURL;
        wrapper.classList.remove('d-none');
    });

    return {
        reset: () => {
            if (currentURL) URL.revokeObjectURL(currentURL);
            currentURL = null;
            preview.src = '';
            wrapper.classList.add('d-none');
            imageInput.value = '';
        }
    };
}