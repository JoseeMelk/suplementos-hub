/**
 * Utilidades de fecha para los componentes de soporte
 */

/**
 * "hace X min / h / días" — versión corta para metadatos
 * Ej: "hace 2 h", "hace 15 min", "hace 3 días"
 */
export function timeAgoShort(dateStr) {
    if (!dateStr) return '—';

    const diff = Date.now() - new Date(dateStr).getTime();

    const minutes = Math.floor(diff / 60000);
    const hours   = Math.floor(diff / 3600000);
    const days    = Math.floor(diff / 86400000);

    if (minutes < 1) return 'Hace un momento';
    if (minutes < 60) return `Hace ${minutes} min`;
    if (hours < 24) return `Hace ${hours} h`;
    if (days < 30) return `Hace ${days} ${days === 1 ? 'día' : 'días'}`;

    return new Date(dateStr).toLocaleDateString('es-MX', {
        day: 'numeric',
        month: 'short',
        year: 'numeric'
    });
}

/**
 * "hace X" — versión más natural para last_message_at
 * Ej: "hace 15 minutos", "hace 2 horas"
 */
export function timeAgo(dateStr) {
    if (!dateStr) return '—';
    const diff = Date.now() - new Date(dateStr).getTime();
    const s = Math.floor(diff / 1000);

    if (s < 60)      return 'Hace un momento';
    if (s < 3600)    return `Hace ${Math.floor(s / 60)} ${Math.floor(s / 60) === 1 ? 'minuto' : 'minutos'}`;
    if (s < 86400)   return `Hace ${Math.floor(s / 3600)} ${Math.floor(s / 3600) === 1 ? 'hora' : 'horas'}`;
    if (s < 2592000) return `Hace ${Math.floor(s / 86400)} ${Math.floor(s / 86400) === 1 ? 'día' : 'días'}`;

    return new Date(dateStr).toLocaleDateString('es-MX', {
        day: 'numeric', month: 'short'
    });
}

/**
 * "10:34 AM" — para el timestamp de cada mensaje
 */
export function formatTime(dateStr) {
    if (!dateStr) return '';
    return new Date(dateStr).toLocaleTimeString('es-MX', {
        hour: '2-digit', minute: '2-digit', hour12: true
    });
}

/**
 * "Hoy, 5 de junio" / "Ayer" / "3 jun 2024" — para los separadores de fecha
 */
export function formatDateSep(dateStr) {
    if (!dateStr) return '';

    const date  = new Date(dateStr);
    const today = new Date();
    const yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);

    const sameDay = (a, b) =>
        a.getDate() === b.getDate() &&
        a.getMonth() === b.getMonth() &&
        a.getFullYear() === b.getFullYear();

    if (sameDay(date, today)) {
        return `Hoy, ${date.toLocaleDateString('es-MX', { day: 'numeric', month: 'long' })}`;
    }
    if (sameDay(date, yesterday)) {
        return 'Ayer';
    }
    return date.toLocaleDateString('es-MX', { day: 'numeric', month: 'short', year: 'numeric' });
}