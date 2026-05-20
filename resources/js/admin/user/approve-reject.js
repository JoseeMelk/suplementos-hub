import { update } from './user-service';
import { alert } from '../../lib/alert';

//Funcion temporal por ahora, cuando pueda lo hare con carga dinamica
async function reloadPage() {
    window.location.reload();
}
async function approveUser(userId) {

    const result = await alert.confirm(
        '¿Estás seguro de que deseas aprobar este proveedor?',
        'El proveedor será aprobado y podrá comenzar a operar en la plataforma.',
        'Sí, aprobar'
    );

    if (!result.isConfirmed) return;

    const updateResponse = await update(userId, { status: 'approved' });
    if (updateResponse.httpOk) {
        await alert.success('Proveedor aprobado correctamente.', 'Se le notificará al proveedor');
        await reloadPage();

    } else if (updateResponse.httpStatus === 422) {
        const errorMessage = updateResponse.message ?? 'Error al aprobar proveedor.';
        const firtsError = updateResponse.errors[Object.keys(updateResponse.errors)[0]][0] ?? 'Por favor, inténtalo de nuevo.';
        await alert.error(errorMessage, firtsError);
    }
    else if (updateResponse.httpStatus === 500) {
        await alert.error('Error al aprobar proveedor.', 'Por favor, inténtalo de nuevo.');
    } else {
        await alert.error('Error inesperado.', 'Por favor, inténtalo mas tarde.');
    }

}

async function rejectUser(userId) {
    const result = await alert.confirm(
        '¿Estás seguro de que deseas rechazar este proveedor?',
        'El proveedor será rechazado y no podrá operar en la plataforma.',
        'Sí, rechazar'
    );

    if (!result.isConfirmed) return;
    const updateResponse = await update(userId, { status: 'rejected' });
    if (updateResponse.httpOk) {
        await alert.success('Proveedor rechazado correctamente.', 'Se le notificará al proveedor');
        await reloadPage();
    } else if (updateResponse.httpStatus === 422) {
        const errorMessage = updateResponse.message ?? 'Error al rechazar proveedor.';
        const firtsError = updateResponse.errors[Object.keys(updateResponse.errors)[0]][0] ?? 'Por favor, inténtalo de nuevo.';
        await alert.error(errorMessage, firtsError);
    }
    else if (updateResponse.httpStatus === 500) {
        await alert.error('Error al rechazar proveedor.', 'Por favor, inténtalo de nuevo.');
    } else {
        await alert.error('Error inesperado.', 'Por favor, inténtalo mas tarde.');
    }
}

document.getElementById('pending-users').addEventListener('click', (e) => {
    const btn = e.target.closest('[data-action]');
    if (!btn) return;

    const action = btn.dataset.action;
    const id = btn.dataset.id;

    if (action === 'approve') approveUser(id);
    if (action === 'reject') rejectUser(id);
});