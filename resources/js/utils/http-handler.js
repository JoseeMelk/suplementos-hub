// resources/js/utils/httpHandler.js

import { alert } from '../lib/alert';

export async function handleResponse(res, {
    successMessage = 'Operación exitosa',
    successDescription = '',
    errorMessage = 'Ocurrió un error',
} = {}) {

    if (res.httpOk) {
        await alert.success(successMessage, successDescription);
        return true;
    }

    if (res.httpStatus === 422) {
        const message = res.message ?? errorMessage;

        const firstError =
            res.errors
                ? Object.values(res.errors)[0][0]
                : 'Datos inválidos';

        await alert.error(message, firstError);
        return false;
    }

    if (res.httpStatus === 419) {
        await alert.error('Sesión expirada', 'Recarga la página');
        return false;
    }

    if(res.httpStatus === 409) {
        await alert.error('Conflicto', res.message ?? 'El recurso ya existe');
        return false;
    }

    if (res.httpStatus === 404) {
        await alert.error('No encontrado', 'El recurso no existe');
        return false;
    }

    if (res.httpStatus === 403) {
        await alert.error('Acceso denegado', res.message ?? '');
        return false;
    }


    if (res.httpStatus >= 500) {
        await alert.error(errorMessage, 'Error interno del servidor');
        return false;
    }

    await alert.error('Error inesperado', 'Inténtalo más tarde');
    return false;
}