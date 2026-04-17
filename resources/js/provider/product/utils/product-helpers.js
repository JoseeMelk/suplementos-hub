export function getFormData(formId) {
    const form = document.getElementById(formId);
    return new FormData(form);
}