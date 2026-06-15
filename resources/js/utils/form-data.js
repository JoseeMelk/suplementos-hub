export function getFormData(formId, debug = false) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    if (debug) {
        console.log(Object.fromEntries(formData.entries()));
    }
    return formData;
}