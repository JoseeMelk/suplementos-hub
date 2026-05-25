export function truncateText(text) {
    if (!text) return '';
    const maxLength = window.innerWidth < 768 ? 70 : 100;
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}