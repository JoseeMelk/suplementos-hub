import { API } from '../config';

async function logout() {
    try {
        const response = await fetch(API.LOGOUT_URL, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        });

        const data = await response.json();

        if (response.status === 200 && data.ok) {
            // Logout exitoso - redirigir a la página de inicio
            window.location.href = '/';
        } else {
            // Error al cerrar sesión
            alert(data.message || 'Error al cerrar sesión');
        }
    } catch (error) {
        console.error('Error en la solicitud:', error);
        alert('Error al procesar la solicitud');
    }
}

document.getElementById('logout-btn').addEventListener('click', async () => {
    await logout();
});

document.getElementById('logout-btn-desktop-sidebar').addEventListener('click', async () => {
    await logout();
});

document.getElementById('logout-btn-mobile-sidebar').addEventListener('click', async () => {
    await logout();
});