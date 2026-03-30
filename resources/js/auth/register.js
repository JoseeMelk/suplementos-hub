import { BASE_URL } from '../config';

const REGISTER_URL = `${BASE_URL}/register`;

console.log(REGISTER_URL);


document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registerForm');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button[type="submit"]');

        // Validar que las contraseñas coincidan
        const password = form.querySelector('input[name="password"]').value;
        const passwordConfirmation = form.querySelector('input[name="password_confirmation"]').value;

        if (password !== passwordConfirmation) {
            showError('Las contraseñas no coinciden');
            return;
        }

        // Bloquear botón
        btn.disabled = true;
        const originalText = btn.textContent;
        btn.textContent = 'Registrando...';

        const formData = new FormData(form);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(REGISTER_URL, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (response.status === 201 && data.ok) {
                // Registro exitoso - mostrar mensaje y redirigir
                showSuccess(data.message);
                setTimeout(() => {
                    window.location.href = '/login';
                }, 2000);
            } else if (response.status === 422) {
                // Errores de validación
                console.error('Errores de validación:', data.errors);
                showError(Object.values(data.errors).flat()[0]); // El primer mensaje
            } else {
                // Otro error
                showError(data.message || 'Error al registrar');
            }
        } catch (error) {
            console.error('Error en la solicitud:', error);
            showError('Error al procesar la solicitud');
        } finally {
            // Reactivar botón
            btn.disabled = false;
            btn.textContent = originalText;
        }
    });
});

function showError(message) {
    let alert = document.querySelector('.auth-error');
    
    if (!alert) {
        alert = document.createElement('div');
        alert.className = 'alert alert-danger auth-error';
        const form = document.getElementById('registerForm');
        form.parentNode.insertBefore(alert, form);
    }
    
    alert.textContent = message;
    alert.classList.remove('d-none');
}

function showSuccess(message) {
    let error = document.querySelector('.auth-error');
    if (error) {
        error.classList.add('d-none');
    }
    let alert = document.querySelector('.auth-success');
    
    if (!alert) {
        alert = document.createElement('div');
        alert.className = 'alert alert-success auth-success';
        const form = document.getElementById('registerForm');
        form.parentNode.insertBefore(alert, form);
    }
    
    alert.textContent = message;
    alert.classList.remove('d-none');
}