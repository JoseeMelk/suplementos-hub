export function truncateText(text, maxLengthMobile = 70, maxLengthDesktop = 100) {
    if (!text) return '';
    const maxLength = window.innerWidth < 768 ? maxLengthMobile : maxLengthDesktop;
    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
}