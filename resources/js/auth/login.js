import { API } from '../config';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');

    console.log(API);
    

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button[type="submit"]');
        btn.dis

        const formData = new FormData(form);
        
        // Convertir el checkbox a booleano (1 o 0)
        const rememberCheckbox = form.querySelector('input[name="remember"]');
        formData.set('remember', rememberCheckbox.checked ? 1 : 0);
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(API.LOGIN_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.status === 200 && data.ok) {
                // Login exitoso - redirigir al dashboard
                window.location.href = '/';
            } else if (response.status === 422) {
                // Errores de validación
                console.error('Errores de validación:', data.errors);
                showError(Object.values(data.errors).flat()[0]); //el primer mensaje
            } else {
                // Credenciales inválidas u otro error
                showError(data.message || 'Error al iniciar sesión');
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            showError('Error al procesar la solicitud');
        }
    });
});

function showError(message) {
    const alert = document.querySelector('.auth-error');

    alert.textContent = message;
    alert.classList.remove('d-none');
}