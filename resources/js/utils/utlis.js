export function getInitials(name, twoInitials = false) {
    const parts = name?.trim().split(/\s+/) || [];

    if (!parts.length) return '';

    if (!twoInitials) {
        return parts[0][0].toUpperCase();
    }

    if (parts.length === 1) {
        return parts[0][0].toUpperCase();
    }

    return (
        parts[0][0] +
        parts[parts.length - 1][0]
    ).toUpperCase();
}