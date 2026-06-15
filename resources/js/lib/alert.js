// resources/js/lib/alert.js
import Swal from 'sweetalert2';

const base = {
    confirmButtonColor: '#0F6E56',
    cancelButtonColor:  'transparent',
    cancelButtonText:   'Cancelar',
    customClass: {
        cancelButton:  'btn btn-outline btn-sm',
        confirmButton: 'btn btn-sm',
        popup:         'sh-swal-popup',
    },
    buttonsStyling: false, // usa tus clases, no los estilos de Swal
};

export const alert = {
    confirm: (title, text, confirmText = 'Confirmar') =>
        Swal.fire({ ...base, title, text, icon: 'question', showCancelButton: true, confirmButtonText: confirmText }),

    success: (title, text = '') =>
        Swal.fire({ ...base, title, text, icon: 'success', showCancelButton: false, confirmButtonText: 'Listo' }),

    error: (title, text = '', debug = false, error = null) => {
        if (debug) {
            console.error(error);
        }
        Swal.fire({ ...base, title, text, icon: 'error', showCancelButton: false, confirmButtonText: 'Entendido' });
    },

    warning: (title, text = '', confirmText = 'Continuar') =>
        Swal.fire({ ...base, title, text, icon: 'warning', showCancelButton: true, confirmButtonText: confirmText }),
    message: (title, text = '') =>
        Swal.fire({ ...base, title, text, icon: 'info', showCancelButton: false, confirmButtonText: 'Entendido' })
};